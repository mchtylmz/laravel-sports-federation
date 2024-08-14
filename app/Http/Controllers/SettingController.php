<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index', [
            'title' => __('settings.general')
        ]);
    }

    public function save(Request $request)
    {
        $data = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $data[$key] = UploadFile::image($image);
            }
        }

        foreach ($request->get('settings') as $key => $value) {
            $data[$key] = trim($value);
        }

        if (!empty($data)) {
            settings()->set($data);
            settings()->save();

            customLog('settings', $data);
        }

        return response()->json([
            'message' => __('settings.general_save_success'),
            'redirect' => route('settings.index')
        ]);
    }
}
