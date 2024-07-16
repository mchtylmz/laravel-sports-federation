<?php

namespace App\Http\Controllers;

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

    public function json(Request $request)
    {
        $people = People::orderBy('name');
        if ($request->has('sort')) {
            $people = People::orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if ($search = $request->get('search')) {

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

    public function delete(People $people)
    {
        $people->delete();

        return response()->json([
            'message' => __('peoples.delete_success', ['fullname' => $people->fullname]),
            'refresh' => true
        ]);
    }
}
