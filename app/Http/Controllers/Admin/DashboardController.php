<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Make sure to import the User model
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with a list of all users.
     */
    public function __invoke()
    {
        // Fetch all users to be managed by the admin
        $users = User::where('id', '!=', auth()->id())->latest()->get();

        // You will need to create this Blade file next
        return view('admin.dashboard', ['users' => $users]);
    }
}