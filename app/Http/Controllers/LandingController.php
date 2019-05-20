<?php

namespace App\Http\Controllers;


class LandingController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            return redirect()->route('teams.index');
        }
        return view('landing.index');
    }

    public function policy()
    {
        return view('landing.policy.index');
    }

    public function howtouse()
    {
        return view('landing.howtouse.index');
    }
}
