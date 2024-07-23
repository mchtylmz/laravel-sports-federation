<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Http\Requests\Federation\DirectorSaveRequest;
use App\Http\Requests\Federation\SaveRequest;
use App\Models\Director;
use App\Models\Federation;
use Illuminate\Http\Request;

class FederationInfoController extends Controller
{
    public function directories()
    {
        $directors = user()?->federation()?->directors()?->paginate();
        if (!$directors) {
            abort(404);
        }

        return view('federations.info.directories', [
            'title' => 'Yönetim Kurulu',
            'directors' => $directors
        ]);
    }

    public function directorSave(DirectorSaveRequest $request, Director $director)
    {
        $validated = $request->validated();
        $validated['federation_id'] = user()?->federation()?->id ?? 0;

        if (!$director->id) {
            Director::create($validated);
        } else {
            $director->update($validated);
        }

        return response()->json([
            'message' => 'Başarıyla kayıt edildi',
            'refresh' => true
        ]);
    }

    public function directorDelete(Director $director)
    {
        $director->delete();

        return response()->json([
            'message' => 'Kayıt başarıyla silindi',
            'refresh' => true
        ]);
    }

    public function statute()
    {
        $federation = Federation::findOrFail(user()?->federation()?->id);

        return view('federations.info.statute', [
            'title' => 'Tüzük',
            'federation' => $federation
        ]);
    }

    public function contact()
    {
        $federation = Federation::findOrFail(user()?->federation()?->id);

        return view('federations.info.contact', [
            'title' => 'İleitşim Bilgileri',
            'federation' => $federation
        ]);
    }

    public function statuteSave(Request $request, Federation $federation)
    {
        $files = [];
        if ($metaFiles = json_decode($federation->getMeta('statute_files'), true)) {
            $files = $metaFiles;
        }
        foreach ($request->file('file') as $file) {
            $files[] = UploadFile::file($file);
        }

        $federation->setMeta([
            'statute_files' => json_encode($files)
        ]);

        return response()->json([
            'message' => 'Kayıt başarıyla güncellendi',
            'refresh' => true
        ]);
    }

    public function contactSave(Request $request, Federation $federation)
    {
        $federation->setMeta([
            'fullname' => $request->string('fullname'),
            'phone' => $request->string('phone'),
            'email' => $request->string('email'),
            'fax' => $request->string('fax'),
            'website' => $request->string('website'),
        ]);

        return response()->json([
            'message' => 'Kayıt başarıyla güncellendi',
            'refresh' => true
        ]);
    }

    public function date()
    {
        $federation = Federation::findOrFail(user()?->federation()?->id);

        return view('federations.info.date', [
            'title' => 'Genel Kurul Tarihleri',
            'federation' => $federation
        ]);
    }

    public function dateSave(Request $request, Federation $federation)
    {
        $federation->setMeta([
            'meet_dates' => json_encode($request->get('meet_dates'))
        ]);

        return response()->json([
            'message' => 'Kayıt başarıyla güncellendi',
            'refresh' => true
        ]);
    }

    public function members()
    {
        $federation = Federation::findOrFail(user()?->federation()?->id);

        return view('federations.info.members', [
            'title' => 'Üye olunan kuruluşlar',
            'federation' => $federation
        ]);
    }

    public function membersSave(Request $request, Federation $federation)
    {
        $federation->setMeta([
            'members' => json_encode($request->get('members'))
        ]);

        return response()->json([
            'message' => 'Kayıt başarıyla güncellendi',
            'refresh' => true
        ]);
    }

    public function clubs()
    {
        return view('federations.info.clubs', [
            'title' => 'Kulüpler',
            'clubs' => federation_clubs(user()?->federation()?->id ?? 0)
        ]);
    }
}
