<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::id()) {
            $userRole = Auth::user()->role;

            if ($userRole == 'user') {
                return Redirect()->route('welcome');
            } else if ($userRole = 'admin') {
                return Redirect()->route('dashboard');
            } else {
                return redirect()->back();
            }
        }
    }
}
