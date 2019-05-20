<?php

namespace App\Http\Controllers;


class LandingController extends Controller
{
    public function index()
    {
        return view('landing.index');
    }

    public function policy()
    {
        return view('policy.index');
    }

    public function summary()
    {
        return view('landing.summary.index');
    }
}
