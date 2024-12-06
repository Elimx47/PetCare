<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        return 'this is index method from UserController';
    }

    public function create()
    {
        $users = User::all();

        return view('users.user-create', ['name' => 'Lebron'], compact('users'));
    }

    public function contact()
    {
        return view('users.contact');
    }

    public function about()
    {
        return view('users.about');
    }

    public function medicationPage()
    {
        return view('users.medication-page');
    }

    public function welcome()
    {
        if (Auth::check()) {
            if (Auth::user()->role == "admin") {
                return redirect()->route('dashboard');
            }
        }

        return view('welcome');
    }

    public function profile()
    {
        $user = User::find(Auth::id());
        return view('users.user-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('avatar')) {
            $user->updateProfilePhoto($request->file('avatar'));
        }

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ]);

        return redirect()->route('userProfile')->with('success', 'Profile updated successfully');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find(Auth::id());

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('userProfile')->with('errorPassword', 'Current password is wrong!');
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('userProfile')->with('successPassword', 'Password updated successfully');
    }
}
