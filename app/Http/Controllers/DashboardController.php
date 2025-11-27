<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
      public function index()
      {
            $user = Auth::user();

            // Redirect to appropriate dashboard based on role
            if ($user->isSuperAdmin()) {
                  return redirect()->route('super.dashboard');
            } elseif ($user->isAdmin()) {
                  return redirect()->route('admin.dashboard');
            } else {
                  return redirect()->route('user.dashboard');
            }
      }

      public function contoh()
      {
            return view('admin.contoh');
      }
}
