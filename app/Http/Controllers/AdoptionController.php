<?php

namespace App\Http\Controllers;

use App\Models\Adoption;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AdoptionController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'full_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'id_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'income_proof' => 'required|mimes:pdf|max:5120',
            'additional_info' => 'nullable|string|max:1000'
        ]);

        // Store files
        $idProofPath = $request->file('id_proof')->store('adoption/id_proofs', 'public');
        $incomeProofPath = $request->file('income_proof')->store('adoption/income_proofs', 'public');

        // Create adoption record
        $adoption = Adoption::create([
            'pet_id' => $validated['pet_id'],
            'user_id' => Auth::user()->id,
            'full_name' => $validated['full_name'],
            'contact_number' => $validated['contact_number'],
            'address' => $validated['address'],
            'id_proof_path' => $idProofPath,
            'income_proof_path' => $incomeProofPath,
            'additional_info' => $validated['additional_info'] ?? null,
            'status' => 'Pending'
        ]);

        return redirect()->route('pet-adopt')->with('success', 'Adoption application submitted successfully!');
    }


    public function viewAdoptionApplications()
    {
        $user = Auth::user();
        $adoptionApplications = Adoption::where('user_id', $user->id)
            ->with('pet')
            ->latest()
            ->get();

        return view('users.adoption-applications', [
            'applications' => $adoptionApplications
        ]);
    }

    public function manageAdoptions(Request $request)
    {
        $query = Adoption::with(['pet', 'user']);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->whereHas('pet', function ($petQuery) use ($search) {
                    $petQuery->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('full_name', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            });
        }

        $applications = $query->latest()->paginate(10);

        return view('admin.manage-adoptions', [
            'applications' => $applications
        ]);
    }

    public function approveAdoption($id)
    {
        $application = Adoption::findOrFail($id);

        if ($application->pet->status !== 'Pending') {
            return redirect()->back()->with('error', 'This pet is no longer available for adoption.');
        }

        $application->status = 'Approved';
        $application->save();

        $application->pet->update([
            'status' => 'Adopted',
            'approved' => true
        ]);

        return redirect()->back()->with('success', 'Adoption application approved successfully.');
    }

    public function rejectAdoption($id)
    {
        $application = Adoption::findOrFail($id);

        $application->status = 'Rejected';
        $application->save();

        return redirect()->back()->with('success', 'Adoption application rejected.');
    }
}
