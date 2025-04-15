<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    //
    public  function index(){  
        
        $users = User::with('roles')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create(User $user){
        $roles = Role::all();
        return view('users.create', compact('user', 'roles'));
    }

    public function store(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:8'],
            'roles' => ['required','array'],      
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('users.index')->with([
            'message' => 'User created successfully',
            'alert-type' => 'success'
        ]);
        
    }

    public function show(User $user){

        $roles = Role::all();
        return view('users.show', compact('user', 'roles'));
    }

    public function edit(User $user){
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'roles' => ['required','array'],      
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if($request->password){
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $user->syncRoles($request->roles);

        return redirect()->route('users.index')->with([
            'message' => 'User updated successfully',
            'alert-type' => 'success'
        ]);
    }

    public function destroy(User $user){

        $user->delete();
        return redirect()->route('users.index')->with([
            'message' => 'User deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}