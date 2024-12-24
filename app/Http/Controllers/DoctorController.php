<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Request as PatientRequest;

class DoctorController extends Controller
{
    public function acceptRequest($id)
    {
        $request = PatientRequest::findOrFail($id);
        $request->status = 'accepted';
        $request->save();

        return redirect()->route('doctor.dashboard')->with('success', 'Request accepted successfully.');
    }

    public function deleteRequest($id)
    {
        $request = PatientRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('doctor.dashboard')->with('success', 'Request deleted successfully.');
    }
}
