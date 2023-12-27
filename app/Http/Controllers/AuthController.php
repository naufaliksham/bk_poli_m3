<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Role;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika autentikasi berhasil
            if (Auth::user()->role->nama == "admin") {
                return redirect('obat');
            }
            if (Auth::user()->role->nama == "dokter") {
                return redirect('periksa');
            }
        }
        // Jika autentikasi gagal
        return back()->withErrors(['email' => 'Gagal masuk!']);
    }

    // app/Http/Controllers/RegisterController.php


    public function showRegistrationForm()
    {
        $roles = Role::all(); // Ambil semua role untuk ditampilkan di form registrasi
        return view('auth.register', compact('roles'));
    }
    
public function register(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:8',
        'role_id' => 'required|exists:roles,id',
    ]);

    // Membuat user baru
    $user = User::create([
        'nama' => $request->input('nama'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
        'role_id' => $request->input('role_id'),
    ]);

    // Redirect ke halaman setelah registrasi
    return redirect('/formlogin');
}


    public function logout()
    {
        Auth::logout();
        return redirect('/formlogin');
    }

}