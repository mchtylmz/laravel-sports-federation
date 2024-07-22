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
}
