<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^0[67][0-9]{8}$/',
            ],
            'type' => ['required', Rule::in(['directeur', 'encadrant', 'stagiare', 'responsable admin'])],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'etablissement' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }


        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'phone' => $request->phone,
            'type' => $request->type,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'etablissement' => $request->etablissement,
            'profile_picture' => $profilePicturePath,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^0[67][0-9]{8}$/',
            ],
            'type' => ['sometimes', 'required', Rule::in(['directeur', 'encadrant', 'stagiare', 'responsable admin'])],
            'email' => 'sometimes|required|string|email|max:255|unique:users,email',
            'password' => 'sometimes|required|string|min:8',
            'etablissement' => 'sometimes|required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $profilePicturePath = $user->profile_picture;
        if ($request->hasFile('profile_picture')) {
            if ($profilePicturePath) {
                Storage::disk('public')->delete($profilePicturePath);
            }
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->update($request->except('password'));

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
