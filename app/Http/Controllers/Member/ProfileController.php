<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index() { return view('member.profile.index', ['user' => auth()->user()]); }

    public function update(Request $request)
    {
        $user = auth()->user();
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'institution' => 'nullable|string|max:255',
            'specialty'   => 'nullable|string|max:255',
        ]);
        $user->update(['name' => $data['name']]);
        $user->member?->update([
            'phone'       => $data['phone'],
            'address'     => $data['address'],
            'institution' => $data['institution'],
            'specialty'   => $data['specialty'],
        ]);
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function($attr,$val,$fail) {
                if (!Hash::check($val, auth()->user()->password)) $fail('Password lama salah.');
            }],
            'password' => ['required','confirmed', Password::min(8)],
        ]);
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password berhasil diubah.');
    }
}
