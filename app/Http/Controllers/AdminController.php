<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AdminController extends Controller
{
  public function login(Request $request)
  {
    $request->validate([
      "admin_key" => "required|string",
    ]);

    if ($request->admin_key !== env("ADMIN_KEY")) {
      return response()->json(["message" => "nauthorized"], 401);
    }

    $token = Str::random(80);

    logger("Generated Token: " . $token);

    Cache::put("admin_token:{$token}", true, now()->addHours(12));

    return response()->json([
      "message" => "Login successful",
      "token" => $token,
    ]);
  }
}
