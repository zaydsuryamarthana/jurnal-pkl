<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\VerifyEmail;
use App\Models\Internship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class SignupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $internships = Internship::all();
        return view('verification.signup', compact('internships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                'role' => 'required',
                'nama' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'nisn' => 'required|numeric|digits:10||unique:users,nisn',
                'nis' => 'required|numeric|digits:4|unique:users,nis',
                'password' => 'required|string|min:8',
            ],
            [
                'email.unique' => "Email sudah terdaftar, gunakan email lainnya",
                'password.min' => "Gunakan password lebih dari 8 karakter",
                'nis.digits' => "NIS kamu tidak memenuhi jumlah karakter sebenarnya",
                'nisn.digits' => "NISN kamu tidak memenuhi jumlah karakter sebenarnya",
                'nisn.unique' => "NISN sudah terdaftar, gunakan NISN lainnya",
                'nis.unique' => "NIS sudah terdaftar, gunakan NIS lainnya",
            ]
        );

        $signup = User::create([
            'nisn' => $validated['nisn'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'email' => $validated['email']
        ]);

        Mail::to($signup->email)->send(new VerifyEmail($signup));

        Auth::login($signup);

        return redirect()->route('verification.notice');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
