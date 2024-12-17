<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PetController extends Controller
{

    public function index()
    {
        $pets = Pet::latest()->where('approved', 1)
            ->where('status', 'Pending')
            ->paginate(6);

        $userId = Auth::id();

        $pets->getCollection()->transform(function ($pet) use ($userId) {
            $pet->hasApplied = $userId ? $pet->adoptions()->where('user_id', $userId)->exists() : false;
            $pet->isUploadedByCurrentUser = $pet->user_id === $userId;
            return $pet;
        });

        return view('users.adopt-pet', compact('pets'));
    }

    public function show($id)
    {
        $pets = Pet::find($id);

        if (!$pets) {
            abort(404);
        }

        $userId = Auth::id();
        $pets->hasApplied = $userId ? $pets->adoptions()->where('user_id', $userId)->exists() : false;
        $pets->isUploadedByCurrentUser = $pets->user_id === $userId;

        return view('users.pet-details', compact('pets'));
    }

    public function adminShow($id)
    {
        $pets = Pet::withTrashed()->findOrFail($id);

        if (!$pets) {
            abort(404);
        }


        return view('admin.admin-pet-details', compact('pets'));
    }

    public function manage(Request $request)
    {

        $search = $request->input('search');


        $pets = Pet::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('breed', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        })
            ->latest()
            ->paginate(7);

        return view('admin.manage-pet', compact('pets', 'search'));
    }

    public function userAdd()
    {
        return view('users.user-add-pet');
    }

    public function adminAdd()
    {
        return view('admin.admin-add-pet');
    }

    public function adminEdit($id)
    {
        $pets = Pet::find($id);

        if (!$pets) {
            abort(404);
        }

        return view('admin.admin-edit-pet', compact('pets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|not_regex:/^\s*$/u',  // Prevent whitespace-only input
            'type' => 'required|string|max:255|not_regex:/^\s*$/u',
            'breed' => 'required|string|max:255|not_regex:/^\s*$/u',
            'age' => 'required|integer|min:0|max:30',
            'gender' => 'required|string|in:Male,Female',
            'health' => 'required|string|max:500|not_regex:/^\s*$/u',
            'description' => 'required|min:10|max:1000|not_regex:/^\s*$/u',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Please add Pet name',
            'type.required' => 'Please select the pet type',
            'breed.required' => 'Please select a breed',
            'age.required' => 'Input the age of the pet',
            'health.required' => 'Please provide pet health details (e.g., Vaccinated, Spayed)',
            'description.min' => 'The description must be at least 10 characters long',
            'image.image' => 'The uploaded file must be a valid image (jpeg, png, jpg, gif).',
            'name.not_regex' => 'The pet name cannot contain only spaces.',
            'type.not_regex' => 'The pet type cannot contain only spaces.',
            'breed.not_regex' => 'The breed cannot contain only spaces.',
            'health.not_regex' => 'Health details cannot contain only spaces.',
            'description.not_regex' => 'The description cannot contain only spaces.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pets', 'public');
        }

        Pet::insert([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'breed' => $validated['breed'],
            'age' => $validated['age'],
            'description' => $validated['description'],
            'gender' => $validated['gender'],
            'image' => $imagePath,
            'health' => $validated['health'],
            'user_id' => Auth::user()->id,
            'status' => 'Pending',
            'approved' => Auth::user()->role === 'admin' ? 1 : 0,
            'created_at' => Carbon::now(),
        ]);



        if (Auth::user()->role === 'admin') {
            return Redirect()->route('pet-manage')->with('success', 'A new pet for adoption has been inserted successfully!');
        } else {
            return Redirect()->route('pet-adopt')->with('success', 'A new pet for adoption has been inserted successfully! Please wait for an admin to approve');
        }
    }


    public function destroy($id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return Redirect()->route('pet-manage')->with('error', 'Pet not found!');
        }

        $pet->delete();

        return Redirect()->route('pet-manage')->with('success', 'Pet record has been archived successfully!');
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'required|string|max:255',
            'age' => 'required|integer|min:0|max:30',
            'gender' => 'required|string|in:Male,Female',
            'health' => 'required|string|max:500',
            'description' => 'required|string|min:10|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:Pending,Adopted',
        ]);

        try {

            $pet = Pet::findOrFail($id);


            $changes = false;
            foreach ($validated as $key => $value) {
                if ($pet->$key != $value) {
                    $changes = true;
                    break;
                }
            }


            $newApprovalStatus = $request->has('approval') ? 1 : 0;
            if ($pet->approved != $newApprovalStatus) {
                $changes = true;
            }


            if ($request->hasFile('image')) {
                $changes = true;
            }


            if (!$changes) {
                return redirect()->route('adminEditPet', ['id' => $id])->with('info', 'No changes were made to the pet information.');
            }


            $pet->fill($validated);


            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('pets', 'public');
                $pet->image = $imagePath;
            }


            $pet->approved = $newApprovalStatus;

            $pet->save();

            return redirect()->route('pet-manage')->with('success', 'Pet information updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update pet information: ' . $e->getMessage());
        }
    }


    public function countPets()
    {
        $totalPets = Pet::count();
        $pendingPets = Pet::where('status', 'Pending')->count();
        $approvedPets = Pet::where('approved', 1)->count();
        $adoptedPets = Pet::where('status', 'Adopted')->count();

        return [
            'totalPets' => $totalPets,
            'pendingPets' => $pendingPets,
            'approvedPets' => $approvedPets,
            'adoptedPets' => $adoptedPets,
        ];
    }

    public function getPendingPets()
    {
        $Pending = Pet::where('status', 'Pending')->latest()->get();

        return $Pending;
    }

    public function archivedPets()
    {
        $archivedPets = Pet::onlyTrashed()->latest()->paginate(10);
        return view('admin.archived-pets', compact('archivedPets'));
    }

    public function restorePet($id)
    {
        $pet = Pet::withTrashed()->findOrFail($id);
        $pet->restore();
        return redirect()->route('archivedPets')->with('success', 'Pet restored successfully.');
    }

    public function permanentDeletePet($id)
    {
        $pet = Pet::withTrashed()->findOrFail($id);
        $pet->forceDelete();
        return redirect()->route('archivedPets')->with('success', 'Pet permanently deleted.');
    }

    public function userPets()
    {
        $pets = Pet::where('user_id', Auth::user()->id)
            ->latest()
            ->paginate(6);

        return view('users.user-pets', compact('pets'));
    }
    public function userEdit($id)
    {
        $pets = Pet::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$pets) {
            abort(403, 'Unauthorized action.');
        }

        return view('users.user-edit-pet', compact('pets'));
    }

    public function userUpdate(Request $request, $id)
    {
        $pet = Pet::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (!$pet) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|not_regex:/^\s*$/u',
            'type' => 'required|string|max:255|not_regex:/^\s*$/u',
            'breed' => 'required|string|max:255|not_regex:/^\s*$/u',
            'age' => 'required|integer|min:0|max:30',
            'gender' => 'required|string|in:Male,Female',
            'health' => 'required|string|max:500|not_regex:/^\s*$/u',
            'description' => 'required|min:10|max:1000|not_regex:/^\s*$/u',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pets', 'public');
            $validated['image'] = $imagePath;
        }

        $validated['approved'] = 0;;

        $pet->update($validated);

        return redirect()->route('userPets')->with('success', 'Pet details updated successfully');
    }

    public function approvePet($id)
    {
        try {
            $pet = Pet::findOrFail($id);

            // Check if the pet is already approved
            if ($pet->approved == 1) {
                return redirect()->route('pet-manage')
                    ->with('info', 'Pet is already approved.');
            }

            // Update the pet's approval status
            $pet->approved = 1;
            $pet->save();

            return redirect()->route('pet-manage')
                ->with('success', "Pet '{$pet->name}' has been approved successfully.");
        } catch (\Exception $e) {
            return redirect()->route('pet-manage')
                ->with('error', 'Failed to approve pet: ' . $e->getMessage());
        }
    }

    public function rejectPet($id)
    {
        try {
            $pet = Pet::findOrFail($id);

            // Check if the pet is already rejected (unapproved)
            if ($pet->approved == 0) {
                return redirect()->route('pet-manage')
                    ->with('info', 'Pet is already unapproved.');
            }

            // Update the pet's approval status
            $pet->approved = 0;
            $pet->save();

            return redirect()->route('pet-manage')
                ->with('success', "Pet '{$pet->name}' has been rejected.");
        } catch (\Exception $e) {
            return redirect()->route('pet-manage')
                ->with('error', 'Failed to reject pet: ' . $e->getMessage());
        }
    }
}
