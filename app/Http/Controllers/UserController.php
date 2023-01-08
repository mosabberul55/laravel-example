<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //fetch all users
    public function index()
    {
        $users = User::has('profile')->with('profile')->get();
        return response()->json([
            'users' => $users
        ], 200);
    }
    //store user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        $data = $request->except('password');
        if ($request->has('password')) {
            $data['password'] = bcrypt($request->password);
        }
        $user = User::create($data);
        //create profile
        $user->profile()->create([
            'phone' => $request->phone,
            'address' => $request->address
        ]);
        return response()->json(['user' => $user->load('profile')], 201);
    }
    //show user
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
}
