<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $petController = new PetController();
        $petCounts = $petController->countPets();
        $petsPending = $petController->getPendingPets();

        return view('admin.dashboard', compact('petCounts', 'petsPending'));
    }

    public function manageMedication()
    {
        return view('admin.manage-medication');
    }


    public function manageUsers()
    {
        $users = User::all();
        return view('admin.manage-users', compact('users'));
    }
}
