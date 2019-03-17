<?php

namespace App\Http\Controllers;


class TeamController extends Controller
{
    use \App\Traits\Datable;

    public function index()
    {
        $sideNav = \App\Services\Navigations::sideNav();
        return view('teams/index', $sideNav);
    }
}
