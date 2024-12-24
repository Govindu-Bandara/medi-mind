<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PatientRequest;
use App\Models\Medicine;

class DashboardController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();
        $requests = auth()->user()->requests;

        return view('dashboard', compact('doctors', 'requests'));
    }

    public function doctorIndex()
    {
        $requests = PatientRequest::where('doctor_id', auth()->id())->where('status', 'pending')->get();
        $patients = User::whereHas('requests', function ($query) {
            $query->where('doctor_id', auth()->id())->where('status', 'accepted');
        })->get();

        return view('doctor.dashboard', compact('requests', 'patients'));
    }

    public function searchDoctors(Request $request)
    {
        $query = $request->input('query');
        $doctor = User::where('role', 'doctor')
                        ->where('name', 'LIKE', "%{$query}%")
                        ->orderBy('created_at', 'desc')
                        ->first();

        $requests = auth()->user()->requests;

        return view('dashboard', compact('doctor', 'requests'));
    }

    public function requestDoctor($id)
    {
        $doctor = User::findOrFail($id);

        auth()->user()->requests()->create([
            'doctor_id' => $doctor->id,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Request sent successfully.');
    }

    public function cancelRequest($id)
    {
        $request = auth()->user()->requests()->findOrFail($id);
        $request->delete();

        return redirect()->route('dashboard')->with('success', 'Request cancelled successfully.');
    }

    public function deleteRequest($id)
    {
        // Find the request associated with the authenticated user
        $request = auth()->user()->requests()->findOrFail($id);
    
        // Delete the request
        $request->delete();
    
        // Delete medicines associated with the user
        Medicine::where('user_id', auth()->id())->delete();
    
        return redirect()->route('dashboard')->with('success', 'Request deleted successfully.');
    }
    

    // View Medicines for Patients
    public function viewMedicines()
    {
        // Fetch medicines associated with the logged-in patient user
        $medicines = auth()->user()->medicines()->with('times')->get();

        return view('viewmedicines', compact('medicines')); // Pass medicines data to the view
    }
}
