<?php

namespace App\Http\Controllers;

use App\Actions\UploadFile;
use App\Enums\EventTypeEnum;
use App\Http\Requests\Federation\DirectorSaveRequest;
use App\Http\Requests\Federation\SaveRequest;
use App\Models\Director;
use App\Models\Event;
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
            'title' => 'Belgeler',
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

    public function statuteDelete(Request $request, Federation $federation)
    {
        $newFiles = [];
        $id = $request->integer('id', 0);

        $files = json_decode($federation->getMeta('statute_files') ?? null, true);

        foreach($files as $key => $file) {
            if ($key == $id) {
                continue;
            }
            $newFiles[] = $file;
        }

        $federation->setMeta([
            'statute_files' => json_encode($newFiles)
        ]);

        return response()->json([
            'message' => 'Kayıt başarıyla silindi',
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
            'social_facebook' => $request->string('facebook'),
            'social_x' => $request->string('x'),
            'social_instagram' => $request->string('instagram'),
            'social_youtube' => $request->string('youtube'),
        ]);

        return response()->json([
            'message' => 'Kayıt başarıyla güncellendi',
            'refresh' => true
        ]);
    }

    public function date()
    {
        $dates = user()->events()->where('type', EventTypeEnum::federation_date)->latest()->get();

        return view('federations.info.date', [
            'title' => 'Genel Kurul Tarihleri',
            'dates' => $dates
        ]);
    }

    public function dateSave(Request $request, Federation $federation)
    {
        foreach ($request->get('meet_dates') as $meet_date) {
            list($date, $description, $id) = array_values($meet_date);
            user()->events()->updateOrCreate(
                [
                    'id' => intval($id)
                ],
                [
                    'user_id' => user()->id,
                    'start_date' => date('Y-m-d', strtotime($date)),
                    'end_date' => date('Y-m-d', strtotime($date)),
                    'type' => EventTypeEnum::federation_date,
                    'title' => 'Genel Kurul Tarihi',
                    'content' => $description
                ]
            );
        }

        return response()->json([
            'message' => 'Kayıt başarıyla güncellendi',
            'refresh' => true
        ]);
    }

    public function dateDelete(Request $request)
    {
        $event = Event::find($request->get('id', 0));
        if ($event) {
            $event->delete();
        }

        return response()->json([
            'message' => 'Genel kurul tarihi silindi',
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
