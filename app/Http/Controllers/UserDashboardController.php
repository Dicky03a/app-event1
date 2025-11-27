<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UserDashboardController extends Controller
{
    /**
     * Display user dashboard.
     */
    public function index(): View
    {
        return view('user.dashboard');
    }

    /**
     * Display user profile.
     */
    public function profile(): View
    {
        return view('user.profile');
    }
}
