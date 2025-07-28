<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // We need to create this view next
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $user->update(['name' => $request->name]);
        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
    }

    /**
     * Deactivate (delete) the specified user.
     */
    public function destroy(User $user)
    {
        // For simplicity, we delete the user. In a real app, you might
        // set an 'is_active' flag to false instead (soft delete).
        $user->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deactivated successfully.');
    }
}
