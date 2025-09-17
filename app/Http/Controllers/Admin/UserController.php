<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // return view('admin.users.index',compact("users"));
        return response()->json($users);
    }

    public function store(RegisterRequest $request)
    {

        \Log::info($request->all()); // check what frontend sends

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // hash password
        ]);

        return response()->json([
            'message' => 'User registered successfully!',
            'user' => $user,
        ], 201);
    }
}
