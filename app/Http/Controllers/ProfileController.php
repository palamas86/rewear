<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{
    public function show()
    {

        $user = User::find(auth()->id());

        return view('profile.profile', compact('user'));
    }
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);

        $user->update([
            'address' => $request->address,
            'phone' => $request->phone,
            // Update kolom lainnya jika ada
        ]);

        return redirect()->back()->with('message', 'Profile updated successfully.');
    }
}
