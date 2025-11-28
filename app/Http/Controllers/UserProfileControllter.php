<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use App\Http\Resources\UserResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\UserInforResource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Order;

class UserProfileControllter extends Controller
{

    public function edit(Request $request)
    {

        $user = $request->user();
        // Build the query
        $query = Order::with(['orderItems.product.category', 'orderItems.product.product_images'])
            ->where('created_by', $user->id);
        // Clone the query for ongoing and completed counts
        $ongoingCount = (clone $query)->where('status', 0)->count();
        $completedCount = (clone $query)->where('status', 1)->count();
        $user = auth()->user()->load('profile');

        return Inertia::render('HomePage/CustomerProfile', [
            'ongoing'=> $ongoingCount,
            'complet'=> $completedCount,
            'users' => $user,
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
        return redirect()->route('Userprofile.edit')->with('success', 'Product updated successfully.');
    }

}
