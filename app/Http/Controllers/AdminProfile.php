<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminProfile extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/AdminProfile', [
            // 'users' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'profile' => 'nullable|image|mimes:jpg,jpeg,png', // Validate image upload
        ]);
        $user = auth()->user();
        // Update user information
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone')
        ]);
        // Handle profile picture upload
        $profileData = $request->only('phone', 'address');
        if ($request->hasFile('profile')) {
            $profileImage = $request->file('profile')->store('profiles', 'public');
            $profileData['profile'] = $profileImage;
        }
        // Update or create profile data
        $user->profile()->updateOrCreate([], $profileData);
        return redirect()->route('profile.index')->with('success', 'Perfil actualizado exitosamente.');
    }
}
