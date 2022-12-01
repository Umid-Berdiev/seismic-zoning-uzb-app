<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use InvalidArgumentException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role_slug === 'admin') {
            $users = User::with('roles:id,name')->latest('id')->get();
            $roles = Role::latest('id')->where('slug', '<>', 'admin')->get();

            return Inertia::render('Admin/Users', [
                'users' => $users,
                'roles' => $roles
            ]);
        } else return redirect('/');
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'role_id' => 'required|numeric',
            'password' => 'required|string',
            'is_active' => 'bool',
        ]);

        if ($request->default_pwd) {
            $user = User::create([
                ...$validated,
                'password' => Hash::make($request->default_pwd)
            ]);
        }

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
        return Inertia::render('Admin/Profile', [
            'user' => $user->only(
                'email',
                'id',
                'is_active',
                'first_name',
                'last_name',
                'username',
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
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'is_active' => 'bool',
            // 'role_id' => 'numeric',
            // 'email' => 'required|string|email|max:100'
        ]);

        // dd($validated);

        $user->update($validated);

        if ($request->has('role_id')) {
            $user->roles()->detach();
            $user->roles()->attach($request->role_id);
        }

        return redirect(route('users.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:50',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            // 'role_id' => 'numeric',
            // 'email' => 'required|string|email|max:100'
        ]);

        // dd($validated);

        $user = User::find(auth()->id());
        $user->update($validated);

        return redirect(route('profile'));
    }

    /**
     * Update profile password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string',
            'confirm_password' => 'required|string',
        ]);

        $user = User::find(auth()->id());

        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => "Hozirgi parol foydalanuvchi paroli bn mos kelmadi!",
            ]);
        }

        if ($request->new_password !== $request->confirm_password) {
            throw ValidationException::withMessages([
                'confirm_password' => "Yangi parol bn tasdiq paroli mos kelmadi!",
            ]);
        }

        $user->update(['password' => Hash::make($request->confirm_password)]);

        return redirect(route('profile-password'));
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
