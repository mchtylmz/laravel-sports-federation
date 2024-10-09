<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::where(function (Builder $query) {
            $query->where('start_date', '>=', now()->format('Y-m-d'))
            ->where('start_date', '<=', now()->addDays(7)->format('Y-m-d'));

            if (!hasRole('superadmin')) {
                $query->where('user_id', request()->user()->id);
            }
        })
        ->orWhere(function (Builder $query) {
            $query->where('start_date', '<', now()->format('Y-m-d'))
            ->where('end_date', '>=', now()->format('Y-m-d'));

            if (!hasRole('superadmin')) {
                $query->where('user_id', request()->user()->id);
            }
        })
        ->orderBy('start_date');

        return view('home.index', [
            'title' => __('home.title'),
            'events' => $events->get()
        ]);
    }

    public function calendar()
    {
        return view('home.calendar', [
            'title' => 'Takvim'
        ]);
    }

    public function myNotes()
    {
        $notes = user()->federation()?->notes()->latest()->take(30)->get();

        return view('home.my-notes', [
            'title' => 'Notlarım',
            'notes' => $notes ?? []
        ]);
    }
}
