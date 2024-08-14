<?php

namespace App\Http\Controllers;

use App\Http\Requests\Punishment\SaveRequest;
use App\Http\Resources\PunishmentResource;
use App\Models\People;
use App\Models\Punishment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class PunishmentController extends Controller
{
    public function index()
    {
        return view('punishments.index', [
            'title' => __('punishments.title')
        ]);
    }

    public function json(Request $request)
    {
        $punishment = Punishment::orderBy('reason');
        if ($request->has('sort')) {
            $punishment = Punishment::orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if (hasRole('admin')) {
            $punishment = $punishment->whereIn(
                'people_id', People::where('federation_id', user()->federation()?->id)->pluck('id')->toArray()
            );
        }
        if ($search = $request->get('search')) {
            $punishment->whereAny(['reason', 'description'], 'LIKE', '%' . $search . '%')
                ->whereHas('people', function (Builder $query) use($search) {
                    $query->whereAny(['name', 'surname', 'phone', 'email'], 'LIKE', '%' . $search . '%');
                });
        }

        return response()->json([
            'total' => $punishment->count(),
            'totalNotFiltered' => $punishment->count(),
            'rows' => PunishmentResource::collection($punishment->page()),
        ]);
    }

    public function detail(Punishment $punishment)
    {
        if (request()->input('format') == 'json') {
            return response()->json([
                'title' => $punishment->reason,
                'punishment' => $punishment,
                'body' => view('punishments.offcanvas', [
                    'punishment' => $punishment,
                ])->render()
            ]);
        }

        return view('punishments.detail', [
            'title' => !empty($punishment->id) ? __('punishments.edit') :  __('punishments.add'),
            'punishment' => $punishment,
        ]);
    }

    public function save(SaveRequest $request, Punishment $punishment)
    {
        $validated = $request->validated();
        if (!$punishment->id) {
            $punishment = Punishment::create($validated);
        } else {
            $punishment->update($validated);
        }

        return response()->json([
            'message' => __('punishments.save_success', ['reason' => $punishment->reason]),
            'redirect' => route('punishment.index')
        ]);
    }

    public function delete(Punishment $punishment)
    {
        $punishment->delete();

        return response()->json([
            'message' => __('punishments.delete_success', ['reason' => $punishment->reason]),
            'refresh' => true
        ]);
    }
}
