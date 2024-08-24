<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Enums\PeopleType;
use App\Http\Requests\People\SaveRequest;
use App\Http\Resources\PeopleResource;
use App\Models\People;
use App\Models\Punishment;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index()
    {
        return view('peoples.index', [
            'title' => __('peoples.title')
        ]);
    }

    public function pending()
    {
        return view('peoples.index', [
            'title' => __('peoples.pending'),
            'status_type' => 2
        ]);
    }

    public function json(Request $request)
    {
        $people = People::orderBy('name');
        if ($request->has('sort')) {
            $people = People::orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if (hasRole('admin')) {
            $people = $people->where('federation_id', user()->federation()?->id);
            $people = $people->whereIn('type', user()?->federation()->people_types_json ?? []);
        }
        if (hasRole('superadmin') && userPermit(['muafiyet'])) {
            $people = $people->where('type', PeopleType::racer->value);
        }
        if ($search = $request->get('search')) {
            $people->whereAny(
                ['name', 'surname', 'phone', 'email', 'nationality', 'identity', 'license_no'],
                'LIKE',
                '%' . $search . '%'
            );
        }
        if ($type = $request->get('type')) {
            $people->where('type', $type);
        }
        if ($license_no = $request->get('license_no')) {
            $people->where('license_no', 'LIKE', '%' . $license_no . '%');
        }
        if ($club_id = $request->get('club_id')) {
            $people->whereMeta('player_club_id', $club_id)->orWhereMeta('school_club_id', $club_id);
        }
        if ($gender = $request->get('gender')) {
            $people->where('gender', $gender);
        }
        if ($identity = $request->get('identity')) {
            $people->where('identity', $identity);
        }
        if ($status = $request->get('status')) {
            $people->where('status', $status);
        }
        if ($racer_car_no = $request->integer('racer_car_no')) {
            $people->whereMeta('racer_car_no', $racer_car_no);
        }
        if ($status_type = $request->integer('status_type')) {
            $people->whereIn('status', $status_type == 2 ? ['pending'] : ['active', 'passive']);
        }
        if ($request->get('birth_date') && $dates = explode(' - ', $request->get('birth_date'))) {
            $start_date = $dates[0] ?? false;
            $end_date = $dates[1] ?? false;
            $people->whereBetween('birth_date', [$start_date, $end_date]);
        }

        return response()->json([
            'total' => $people->count(),
            'totalNotFiltered' => $people->count(),
            'rows' => PeopleResource::collection($people->page()),
        ]);
    }

    public function detail(People $people)
    {
        if (request()->input('format') == 'json') {
            return response()->json([
                'title' => $people->fullname,
                'people' => $people,
                'body' => view('peoples.offcanvas', [
                    'people' => $people,
                ])->render()
            ]);
        }

        return view('peoples.detail', [
            'title' => !empty($punishment->id) ? __('peoples.edit') :  __('peoples.add'),
            'people' => $people,
        ]);
    }

    public function save(SaveRequest $request, People $people)
    {
        $validated = $request->validated();

        unset($validated['photo']);
        if ($request->hasFile('photo')) {
            $validated['photo'] = UploadFile::image($request->file('photo'));
        }

        if (!$people->id) {
            $people = People::create($validated);
        } else {
            $people->update($validated);
        }

        $people->deleteMeta();
        if ($people->type == PeopleType::player) {
            $metas = [
                'player_club_id' => $request->integer('player_club_id')
            ];
        } elseif ($people->type == PeopleType::referee) {
            $metas = [
                'referee_class' => $request->get('referee_class'),
                'referee_region' => $request->get('referee_region'),
            ];
        } elseif ($people->type == PeopleType::coach) {
            $metas = [
                'coach_class' => $request->get('coach_class'),
                'coach_job' => $request->get('coach_job'),
            ];
        } elseif ($people->type == PeopleType::racer) {
            $metas = [
                'racer_section' => $request->get('racer_section')
            ];
            if (hasRole('superadmin')) {
                $metas['racer_document'] = $request->get('racer_document');
                $metas['racer_car_brand'] = $request->get('racer_car_brand');
                $metas['racer_car_no'] = $request->get('racer_car_no');

                if ($request->hasFile('racer_document_file')) {
                    $metas['racer_document_file'] = UploadFile::file($request->file('racer_document_file'));
                }
            }
        } elseif ($people->type == PeopleType::school) {
            $metas = [
                'school_club_id' => $request->integer('school_club_id'),
                'school_name' => $request->get('racer_section')
            ];
            if ($request->hasFile('school_document')) {
                $metas['school_document'] = UploadFile::file($request->file('school_document'));
            }
        }

        $people->setMeta($metas ?? []);
        customLog('people_meta', $metas ?? [], $people->id);

        return response()->json([
            'message' => __('peoples.save_success', ['fullname' => $people->fullname]),
            'redirect' => route('people.index')
        ]);
    }

    public function delete(People $people)
    {
        $people->delete();

        return response()->json([
            'message' => __('peoples.delete_success', ['fullname' => $people->fullname]),
            'refresh' => true
        ]);
    }

    public function approve(People $people)
    {
        $people->update(['status' => 'active']);

        return response()->json([
            'message' => __('peoples.approve_success', ['name' => $people->fullname]),
            'refresh' => true
        ]);
    }
}
