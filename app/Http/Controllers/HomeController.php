<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'title' => __('home.title')
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
