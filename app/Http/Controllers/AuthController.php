<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'profileImg' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $file = $request->file('profileImg');
            $path = null;

            if ($file) {
                $path = $file->store('images', 'public');
            }

            $user = new User;
            $user->role = 1;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->avatar = $path;
            $user->password = $request->input('password');
            $user->save();

            return response()->json(['success' => true, 'user' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(Auth::user(), 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => isset($validatedData['password']) ? Hash::make($validatedData['password']) : $user->password,
        ]);

        return response()->json($user, 200);
    }
}
