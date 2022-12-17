<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function userList() {
        $users = User::all();
        $response = [
            'users' => $users,
        ];
        return response($response, 200);
    }

    public function showUser($id) {
        $user = User::findOrFail($id);
        $response = [
            'user' => $user,
        ];
        return response($response, 200);
    }

    public function register(Request $request) {
        $field = $request->validate([
            'username' => 'required|string',
            'fullname' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|confirmed',
        ]);

        $user = User::create([
            'username' => $field['username'],
            'fullname' => $field['fullname'],
            'email' => $field['email'],
            'phone' => $field['phone'],
            'password' => bcrypt($field['password']),
        ]);

        $token = $user->createToken('mbrapitoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request) {
        $field = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        // check email
        $user = User::where('email', $field['email'])->first();

        // check password
        if (!$user || !Hash::check($field['password'], $user->password)) {
            
            return response(['message' => 'Wrong crediential'], 401);

        }

        $token = $user->createToken('mbrapitoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }


    public function logout() {

        auth()->user()->tokens()->delete();

        return [
            'message' => 'User logged out',
        ];

    }
}
