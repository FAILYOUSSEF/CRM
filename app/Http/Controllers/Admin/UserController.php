<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }
    public function create() {
        return view('admin.users.create');
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users',
            'password'         => 'required|min:8|confirmed',
            'phone'            => 'nullable|string',
            'cin'              => 'nullable|string',
            'salaire'          => 'nullable|numeric',
            'date_naissance'   => 'nullable|date',
            'date_embauche'    => 'nullable|date',
            'rib'              => 'nullable|string',
            'addresse'         => 'nullable|string',
            'status'           => 'required|in:active,inactive',
            'type_contrat'     => 'nullable|string',
            'ville'            => 'nullable|string',
            'type_client'      => 'required|in:admin,employee,client',
            'fichier_de_contrat' => 'nullable|file|max:10240',
        ]);
        $data['password'] = Hash::make($data['password']);
        if ($request->hasFile('fichier_de_contrat')) {
            $data['fichier_de_contrat'] = $request->file('fichier_de_contrat')->store('contracts','public');
        }
        User::create($data);
        return redirect()->route('admin.users.index')->with('success','User created.');
    }
    public function show(User $user) {
        return view('admin.users.show', compact('user'));
    }
    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }
    public function update(Request $request, User $user) {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,'.$user->id,
            'phone'          => 'nullable|string',
            'cin'            => 'nullable|string',
            'salaire'        => 'nullable|numeric',
            'status'         => 'required|in:active,inactive',
            'type_contrat'   => 'nullable|string',
            'ville'          => 'nullable|string',
            'type_client'    => 'required|in:admin,employee,client',
        ]);
        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','User updated.');
    }
    public function destroy(User $user) {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted.');
    }
}