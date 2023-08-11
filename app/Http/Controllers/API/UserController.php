<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:6',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('blogs/images');
        $user->image = $imagePath;
    }

    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json(['user' => $user, 'token' => $token], 201);
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken('api_token')->plainTextToken;

    return response()->json(['user' => $user, 'token' => $token], 200);
}
public function updateProfile(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'name' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        throw ValidationException::withMessages([
            'email' => ['User not found with the provided email.'],
        ]);
    }

    $user->name = $request->name;

    if ($request->hasFile('image')) {
        // Delete the old profile image, if it exists
        if ($user->profile_image) {
            Storage::delete('users/images/' . basename($user->profile_image));
        }

        $imagePath = $request->file('image')->store('public/users/images');
        $user->profile_image = str_replace('public/', '', $imagePath);
    }

    $user->save();

    return response()->json($user, 200);
}
}