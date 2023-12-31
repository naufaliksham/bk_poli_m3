<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;

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
            $userRole = Auth::user()->role->nama_role;
            if ($userRole == 'admin') {
                return redirect('admin')->with('success', 'Berhasil masuk!');
            }
            if ($userRole == 'dokter') {
                return "Halo dokter!";
            }
            if ($userRole == 'pasien') {
                return redirect('pasien')->with('success', 'Berhasil masuk!');
            }
        }
        // Jika autentikasi gagal
        return back()->withErrors(['email' => 'Gagal masuk!']);
    }

    // app/Http/Controllers/RegisterController.php

    public function showRegistrationForm()
    {
        $roles = Role::orderBy('nama_role')->get();
        return view('auth.register', compact('roles'));
    }      
    
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'no_ktp' => 'required|string|min:12',
            'role' => 'required',
        ]);
    
        // Validasi Nama dan KTP Pasien
        $pasien = Pasien::where('no_ktp', $request->no_ktp)
                        ->where('nama', $request->nama)
                        ->first();

        // Validasi Email dan Nama pada tabel users
        $existingUser = User::where('email', $request->email)
                            ->first();
    
        if ($pasien && !$existingUser) {
            // Membuat user baru
            $user = User::create([
                'nama' => $request->input('nama'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'idRole' => $request->input('role'),
            ]);
    
            // Redirect ke halaman setelah registrasi
            return redirect('/formlogin')->with('success', 'Berhasil mendaftar, silakan coba login!');
        } else {
            return back()->withErrors(['no_ktp' => 'Gagal mendaftar, silahkan hubungi admin!']);
        }
    }
    


    public function logout()
    {
        Auth::logout();
        return redirect('/formlogin');
    }

}