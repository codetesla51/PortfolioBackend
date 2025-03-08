<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AdminController extends Controller
{
    use HasApiTokens;

    /**
     * Handle admin login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'admin_key' => 'required|string',
        ]);

        if ($request->admin_key !== env('ADMIN_KEY')) {
            throw ValidationException::withMessages([
                'admin_key' => ['The provided admin key is incorrect.'],
            ]);
        }

        // Generate a Sanctum token
        $token = $request->user()->createToken('admin-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token
        ], 200);
    }
}