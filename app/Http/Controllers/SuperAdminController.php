<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SuperAdminController extends Controller
{
    /**
     * Display super admin dashboard.
     */
    public function index(): View
    {
        return view('super-admin.dashboard');
    }
}
