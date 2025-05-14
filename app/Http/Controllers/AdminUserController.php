<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AdminUserController extends Controller
{
    // List all users except the current admin
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->get();
        return view('admin.users', compact('users'));
    }

    // Delete a user by ID
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Prevent admin from deleting themselves or other admins
        if ($user->role === 'admin') {
            return Redirect::back()->with('error', 'Cannot delete admin users.');
        }
        $user->delete();
        return Redirect::back()->with('success', 'User deleted successfully.');
    }
}
