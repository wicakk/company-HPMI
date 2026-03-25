<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()   { return view('auth.login'); }
    public function showRegister(){ return view('auth.register'); }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            return redirect()->intended(
                $user->isAdmin() ? route('admin.dashboard') : route('member.dashboard')
            );
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|min:8|confirmed',
            'phone'       => 'nullable|string|max:20',
            'institution' => 'nullable|string|max:255',
        ]);

        // Buat user dengan role member (gratis, langsung aktif)
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'member', // langsung member, tidak perlu bayar
        ]);

        // Buat record member dengan status free
        Member::create([
            'user_id'     => $user->id,
            'phone'       => $data['phone'] ?? null,
            'institution' => $data['institution'] ?? null,
            'status'      => 'free',  // gratis, bisa upgrade ke premium
            'joined_at'   => now(),
        ]);

        Auth::login($user);

        return redirect()->route('member.dashboard')
            ->with('success', '🎉 Selamat datang di HPMI! Akun Anda berhasil dibuat.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
