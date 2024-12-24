<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\User;

class MedicineController extends Controller
{
    public function create($patient_id)
    {
        $patient = User::findOrFail($patient_id);
        $medicines = $patient->medicines()->with('times')->get();
        return view('addmedicine', compact('medicines', 'patient'));
    }

    public function store(Request $request, $patient_id)
    {
        // Validate and store the medicine
        $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'times' => 'required|array',
            'times.*' => 'required|date_format:H:i',
        ]);

        $patient = User::findOrFail($patient_id);

        $medicine = $patient->medicines()->create([
            'name' => $request->name,
            'dosage' => $request->dosage,
        ]);

        foreach ($request->times as $time) {
            $medicine->times()->create(['time' => $time]);
        }

        return redirect()->route('view.medicine', ['patient_id' => $patient_id])->with('success', 'Medicine added successfully.');
    }

    public function index($patient_id)
    {
        $patient = User::findOrFail($patient_id);
        $medicines = $patient->medicines()->with('times')->get();
        return view('viewmedicine', compact('medicines', 'patient')); // Pass medicines data to the view
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('editmedicine', compact('medicine')); // Ensure 'editmedicine.blade.php' exists in the resources/views folder
    }

    public function update(Request $request, $id)
    {
        // Validate and update the medicine
        $request->validate([
            'name' => 'required|string|max:255',
            'dosage' => 'required|string|max:255',
            'times' => 'required|array',
            'times.*' => 'required|date_format:H:i',
        ]);

        $medicine = Medicine::findOrFail($id);
        $medicine->update([
            'name' => $request->name,
            'dosage' => $request->dosage,
        ]);

        $medicine->times()->delete();
        foreach ($request->times as $time) {
            $medicine->times()->create(['time' => $time]);
        }

        return redirect()->route('view.medicine', ['patient_id' => $medicine->user_id])->with('success', 'Medicine updated successfully.');
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect()->route('view.medicine', ['patient_id' => $medicine->user_id])->with('success', 'Medicine deleted successfully.');
    }
}