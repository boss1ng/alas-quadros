<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.user-management', compact('users'));
    }

    public function newUser()
    {
        return view('user.user-add');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string',
            'role' => 'required|string'
        ]);

        // Hash the password before storing it in the database
        $hashedPassword = Hash::make($request->input('password'));

        // Create the user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $hashedPassword,
            'role' => $request->input('role')
        ]);

        // Redirect back with success message
        return redirect()->route('user-management')->with('success', 'User created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);
        return view('user.user-edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);

        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'string',
            'role' => 'required|string'
        ]);

        // Prepare data for update
        $updatedData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
        ];

        // Update the order with the new data
        $user->update($updatedData);

        // Redirect back to the Order page with a success message
        return redirect()->route('user-management')->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);

        $user->delete();

        // Redirect back to the previous page
        return back()->with('success', 'User deleted successfully!');
    }
}
