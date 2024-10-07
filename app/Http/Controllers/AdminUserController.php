<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class AdminUserController extends Controller
{
    public function adminuser()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6',
            'role'      => 'required|in:admin,user',
            'is_active' => 'required|boolean',
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

  
    public function edit($id)
    {
        $editUser = User::findOrFail($id);
        $users = User::all();
        return view('admin.users', compact('users', 'editUser'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'role'      => 'required|in:admin,user',
            'is_active' => 'required|boolean',
        ]);
    
        \Log::info('Updating user:', [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);
    
        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->is_active,
        ]);
    
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }
    

    /**
     * Remove the specified user from storage.
     */

     public function delete($id)
     {
         $deleteUser = User::findOrFail($id);
         $users = User::all();
         return view('admin.users', compact('users', 'deleteUser'));
     }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deletion of self
        if(auth()->id() == $user->id){
            return redirect()->route('users.index')->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

}
