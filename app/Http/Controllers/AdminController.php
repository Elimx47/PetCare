<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Pet;
use App\Models\Adoption;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $petController = new PetController();
        $petCounts = $petController->countPets();
        $petsPending = $petController->getPendingPets();

        $orderCounts = $this->countOrders();
        $recentOrders = $this->getRecentOrders();

        return view('admin.dashboard', compact(
            'petCounts',
            'petsPending',
            'orderCounts',
            'recentOrders'
        ));
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
    protected function countOrders()
    {
        return [
            'total' => Order::count(),
            'delivered' => Order::where('status', 'completed')->count(),
            'pending' => Order::whereIn('status', ['pending', 'processing'])->count()
        ];
    }

    protected function getRecentOrders()
    {
        return Order::with(['user' => function ($query) {
            $query->select('id', 'name');
        }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get(['id', 'status', 'created_at', 'user_id']);
    }
    public function showUserDetails($id)
    {
        // Find the user or fail (404 if not found)
        $user = User::findOrFail($id);

        return view('admin.user-details', compact('user'));
    }

    public function deleteUser($id)
    {
        // Find the user
        $user = User::findOrFail($id);

        $hasOrders = Order::where('user_id', $user->id)->exists();

        // Check if user has any pets (assuming there's a pets table with user_id)
        $hasPets = Pet::where('user_id', $user->id)->exists();

        // Check if user has any adoptions (assuming there's an adoptions table with user_id)
        $hasAdoptions = Adoption::where('user_id', $user->id)->exists();

        // Prevent deletion if user has any associated records
        if ($hasOrders || $hasPets || $hasAdoptions) {
            return redirect()->route('users-manage')->with('error', 'Cannot delete user with existing orders, pets, or adoptions.');
        }

        // Only allow deleting users with 'user' role
        if ($user->role !== 'user') {
            return redirect()->route('users-manage')->with('error', 'You can only delete user-level accounts.');
        }

        // Delete the user
        $user->delete();

        return redirect()->route('users-manage')->with('success', 'User deleted successfully.');
    }
}
