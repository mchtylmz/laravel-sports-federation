<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\SaveRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Federation;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'title' => __('events.title')
        ]);
    }

    public function json(Request $request)
    {
        $event = user()->events()->orderBy('start_date', 'DESC')->orderBy('start_time');
        if ($request->has('sort')) {
            $event = $event->orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if ($request->has('search')) {
            $event->whereAny(['title', 'content', 'location', 'end_notes'], 'LIKE', '%' . $request->get('search'). '%');
        }

        return response()->json([
            'total' => $event->count(),
            'totalNotFiltered' => $event->count(),
            'rows' => EventResource::collection($event->page()),
        ]);
    }

    public function detail(Event $event)
    {
        return view('events.detail', [
            'title' => !empty($event->title) ? __('events.update') :  __('events.create'),
            'event' => $event
        ]);
    }

    public function save(SaveRequest $request, Event $event)
    {
        $validated = $request->validated();

        if (!$event->id) {
            $event = user()->events()->create($validated);
        } else {
            if ($event->isPassed()) {
                return response()->json([
                    'message' => __('events.not_edit')
                ], 400);
            }

            $event->update($validated);
        }

        return response()->json([
            'message' => __('events.save_success', ['title' => $event->title]),
            'redirect' => route('event.index')
        ]);
    }

    public function delete(Event $event)
    {
        if ($event->isPassed()) {
            return response()->json([
                'message' => __('events.not_edit')
            ], 400);
        }

        $event->delete();

        return response()->json([
            'message' => __('events.delete_success', ['title' => $event->title]),
            'refresh' => true
        ]);
    }
}
