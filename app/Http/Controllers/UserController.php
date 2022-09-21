<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles:id,name')->latest('id')->get();
        $roles = Role::latest('id')->select(['id', 'name'])->get();

        return Inertia::render('Admin/Users', [
            'users' => $users,
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'email' => 'required|string|email|max:100|unique:users',
            'username' => 'required|string|max:50',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'role_id' => 'required|numeric',
        ]);

        $user = User::create([
            ...$validated,
            'password' => Hash::make('password123')
        ]);

        $user->roles()->attach($request->role_id);

        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return Inertia::render('User/Show', [
            'user' => $user->only(
                'id',
                'username',
                'email'
            )
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50',
            'first_name' => 'string|max:50',
            'last_name' => 'string|max:50',
            // 'role_id' => 'numeric',
            // 'email' => 'required|string|email|max:100'
        ]);

        // dd($validated);

        $user->update($validated);
        $user->roles()->detach();
        $user->roles()->attach($request->role_id);

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
