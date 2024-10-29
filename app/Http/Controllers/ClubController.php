<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Http\Requests\Club\SaveRequest;
use App\Http\Resources\ClubResource;
use App\Http\Resources\EventResource;
use App\Models\Club;
use App\Models\Federation;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        return view('clubs.index', [
            'title' => __('clubs.title')
        ]);
    }

    public function detail(Club $club)
    {
        if (request()->input('format') !== 'json' && !hasRole(['superadmin', 'admin'])) {
            abort(403);
        }

        if (request()->input('format') == 'json') {
            $federations = Federation::whereIn('id', explode(',', $club->federation_id))->get();

            return response()->json([
                'title' => $club->name,
                'club' => $club,
                'federations' => $federations,
                'body' => view('clubs.offcanvas', [
                    'club' => $club,
                    'federations' => $federations,
                ])->render()
            ]);
        }

        return view('clubs.detail', [
            'title' => !empty($club->name) ? __('clubs.update') :  __('clubs.create'),
            'club' => $club
        ]);
    }

    public function json(Request $request)
    {
        $club = Club::query();
        if (hasRole('admin')) {
            $club = $club->whereRaw(sprintf("FIND_IN_SET('%s', federation_id) > 0", user()->federation()?->id));
        }

        if ($federation_id = $request->get('federation_id')) {
            $club = $club->whereRaw(sprintf("FIND_IN_SET('%s', federation_id) > 0", $federation_id));
        }
        if ($request->has('sort')) {
            $club = $club->orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if ($request->get('search')) {
            $club->whereAny(['title', 'content', 'location', 'end_notes'], 'LIKE', '%' . $request->get('search'). '%');
        }

        return response()->json([
            'total' => $club->count(),
            'totalNotFiltered' => $club->count(),
            'rows' => ClubResource::collection($club->get()),
        ]);
    }

    public function save(SaveRequest $request, Club $club)
    {
        if (!hasRole('superadmin', 'admin')) {
            abort(403);
        }

        $validated = $request->validated();
        if (array_key_exists('federation_id', $validated)) {
            $validated['federation_id'] = implode(',', $validated['federation_id']);
        }

        if ($tombala = $request->get('tombala')) {
            if ($tombala == 'Evet' && $request->hasFile('tombala_file')) {
                $validated['tombala_file'] = UploadFile::file($request->file('tombala_file'));
            }
            elseif ($tombala == 'Hayır') {
                $validated['tombala_file'] = null;
            }
        }
        if ($request->hasFile('file_1')) {
            $validated['file_1'] = UploadFile::file($request->file('file_1'));
        }
        if ($request->hasFile('file_2')) {
            $validated['file_2'] = UploadFile::file($request->file('file_2'));
        }

        if (!$club->id) {
            $club = Club::create($validated);
        } else {
            $club->update($validated);
        }

        return response()->json([
            'message' => __('clubs.save_success', ['name' => $club->name]),
            'redirect' => route('club.index')
        ]);
    }

    public function selected(Request $request, Club $club)
    {
        if (!hasRole( 'admin')) {
            abort(403);
        }

        $club->update([
            'selected' => $club->selected ? 0 : 1,
            'selected_at' => now()
        ]);

        return response()->json([
            'message' => __(':name kulübü tescil bilgisi güncellendi', ['name' => $club->name]),
            'refresh' => true
        ]);
    }

    public function delete(Club $club)
    {
        if (!hasRole('superadmin')) {
            return response()->json([
                'message' => __('clubs.not_edit')
            ], 400);
        }

        $club->delete();

        return response()->json([
            'message' => __('clubs.delete_success', ['name' => $club->name]),
            'refresh' => true
        ]);
    }
}
