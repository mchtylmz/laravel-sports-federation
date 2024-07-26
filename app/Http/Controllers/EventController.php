<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use App\Http\Requests\Event\SaveRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\Federation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'title' => __('events.title')
        ]);
    }

    public function json(Request $request, bool $filtered = true)
    {
        $event = user()->events()->orderBy('start_date', 'DESC')->orderBy('start_time');
        if ($request->get('sort')) {
            $event = $event->orderBy($request->get('sort'), $request->get('order', 'ASC'));
        }
        if ($request->get('search')) {
            $event->whereAny(['title', 'content', 'location', 'end_notes'], 'LIKE', '%' . $request->get('search'). '%');
        }

        if (!$filtered) {
            return $event->get();
        }

        return response()->json([
            'total' => $event->count(),
            'totalNotFiltered' => $event->count(),
            'rows' => EventResource::collection($event->page()),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $events = $this->json($request, false);

        return Pdf::loadView('pdf.events', [
            'events' => $events,
            'federation' => user()?->federation()
        ])->stream('events2.pdf');
    }

    public function exportExcel(Request $request)
    {
        $events = $this->json($request, false);

        return Excel::download(
            new EventExport($events),
            sprintf('etkinlikler_%s.xlsx', date('Ymd_Hi'))
        );
    }

    public function calendar(Request $request)
    {
        $start = Carbon::parse($request->get('start', now()));
        $end = Carbon::parse($request->get('end', now()));

        $events = Event::whereBetween('start_date', [$start->startOfDay(), $end->endOfDay()]);
        if (in_array(user()?->role, ['admin', 'manager'])) {
            $events->where('user_id', auth()->id());
        }

        return response()->json(
            EventResource::collection($events->get())
        );
    }

    public function detail(Event $event)
    {
        if (request()->input('format') == 'json') {
            return response()->json([
                'title' => $event->title,
                'event' => $event,
                'body' => view('events.offcanvas', [
                    'event' => $event
                ])->render()
            ]);
        }

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
            /*if ($event->isPassed()) {
                return response()->json([
                    'message' => __('events.not_edit')
                ], 400);
            }*/

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
