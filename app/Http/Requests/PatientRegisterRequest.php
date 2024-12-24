<?php

// app/Http/Requests/PatientRegisterRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRegisterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'email' => 'required|email|unique:patients,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }

    public function authorize()
    {
        return true; // Adjust as needed
    }
}

