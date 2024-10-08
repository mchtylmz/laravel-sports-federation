<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Http\Requests\Federation\SaveRequest;
use App\Http\Resources\FederationResource;
use App\Models\Federation;
use App\Models\Note;
use Illuminate\Http\Request;

class FederationController extends Controller
{
    public function index()
    {
        return view('federations.index', [
            'title' => __('federations.title')
        ]);
    }

    public function json(Request $request)
    {
        $federation = Federation::orderBy('name');
        if ($request->has('sort')) {
            $federation = Federation::orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if ($request->has('search')) {
            $federation->whereAny(['name', 'document_number'], 'LIKE', '%' . $request->get('search'). '%');
        }

        return response()->json([
            'total' => $federation->count(),
            'totalNotFiltered' => $federation->count(),
            'rows' => FederationResource::collection($federation->page()),
        ]);
    }

    public function detail(Federation $federation)
    {
        if (request()->input('format') == 'json') {
            return response()->json([
                'title' => $federation->name,
                'federation' => $federation,
                'body' => view('federations.offcanvas', [
                    'federation' => $federation
                ])->render()
            ]);
        }

        return view('federations.detail', [
            'title' => !empty($federation->name) ? __('settings.federation_edit') :  __('settings.federation_add'),
            'federation' => $federation
        ]);
    }

    public function save(SaveRequest $request, Federation $federation)
    {
        $validated = $request->validated();
        if ($request->hasFile('logo')) {
            $validated['logo'] = UploadFile::image($request->file('logo'));
        }
        $validated['people_types'] = json_encode($request->get('people_types'));

        if (!$federation->id) {
            $federation = Federation::create($validated);
        } else {
            $federation->update($validated);
        }

        return response()->json([
            'message' => __('settings.federation_save_success', ['name' => $federation->name]),
            'redirect' => route('federation.index')
        ]);
    }

    public function delete(Federation $federation)
    {
        $federation->delete();

        return response()->json([
            'message' => __('settings.federation_delete_success', ['name' => $federation->name]),
            'refresh' => true
        ]);
    }

    public function notes(Federation $federation)
    {
        return response()->json([
            'title' => $federation->name . ' - Notlar',
            'notes' => $federation->notes,
            'federation' => $federation,
            'body' => view('federations.note_offcanvas', [
                'notes' => $federation->notes()->latest()->take(12)->get(),
                'federation' => $federation,
            ])->render()
        ]);
    }

    public function noteSave(Request $request, Federation $federation)
    {
        $federation->notes()->create([
            'title' => $request->string('title'),
            'content' => $request->string('content'),
        ]);
        cache()->clear();

        return response()->json([
            'message' => 'Not Gönderildi',
            'refresh' => true,
            'title' => $federation->name . ' - Notlar',
            'body' => view('federations.note_offcanvas', [
                'notes' => $federation->notes()->latest()->take(12)->get(),
                'federation' => $federation,
            ])->render()
        ]);
    }

    public function noteDelete(Note $note)
    {
        $note->delete();
        cache()->clear();

        return response()->json([
            'message' => 'Not silindi',
            'refresh' => true,
            'offcanvas' => true,
        ]);
    }

    public function select(Request $request)
    {
        $federation = Federation::find($request->integer('id'));
        if (empty($federation)) {
            return response()->json([
                'status' => 'error'
            ], 404);
        }

        $peopleTypes = [];
        foreach (\App\Enums\PeopleType::titles() as $key => $value) {
            if (in_array($key, $federation->people_types_json ?? [])) {
                $peopleTypes[] = [
                    'value' => $key,
                    'text' => $value
                ];
            }
        }

        return response()->json([
            'status' => 'success',
            'types' => $peopleTypes,
            'clubs' => federation_clubs($federation->id, ['id', 'name'])
        ]);
    }
}
