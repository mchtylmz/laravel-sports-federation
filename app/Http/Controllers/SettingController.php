<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Http\Requests\Setting\FederationSaveRequest;
use App\Models\Federation;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index', [
            'title' => __('settings.general')
        ]);
    }

    public function save()
    {

    }

    public function federation()
    {
        return view('settings.federation', [
            'title' => __('settings.federation'),
            'federations' => Federation::all()
        ]);
    }

    public function federationDetail(Federation $federation)
    {
        return view('settings.federation-detail', [
            'title' => !empty($federation->name) ? __('settings.federation_edit') :  __('settings.federation_add'),
            'federation' => $federation
        ]);
    }

    public function federationSave(FederationSaveRequest $request, Federation $federation)
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
            'redirect' => route('settings.federation')
        ]);
    }

    public function federationDelete(Federation $federation)
    {
        $federation->delete();

        return response()->json([
            'message' => __('settings.federation_delete_success', ['name' => $federation->name]),
            'refresh' => true
        ]);
    }
}
