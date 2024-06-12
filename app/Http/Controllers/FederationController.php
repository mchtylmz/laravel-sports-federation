<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Http\Requests\Federation\SaveRequest;
use App\Http\Resources\FederationResource;
use App\Models\Federation;
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
}
