<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller

{

public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'user'    => $request->user(),
        ], 200);
    }


   public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name'     => 'required|string|max:255',
        'email'    => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'success'      => true,
        'message'      => 'تم إنشاء الحساب بنجاح',
        'access_token' => $token,
        'token_type'   => 'Bearer',
        'user'         => $user,
    ], 201);
}

 public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    // 1. البحث عن المستخدم بالبريد
    $user = User::where('email', $request->email)->first();

    // 2. التحقق من كلمة المرور بدون تفعيل Sessions
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized / Invalid Credentials'
        ], 401);
    }

    // 3. إنشاء التوكن الخاص بـ Sanctum
    $token = $user->createToken('ApiAccessToken')->plainTextToken;

    return response()->json([
        'success' => true,
        'message' => 'User logged in successfully',
        'token'   => $token,
        'user'    => $user,
    ], 200);
}

public function index()
{
    $users = User::all();

    return response()->json([
        'success' => true,
        'users'   => $users,
    ], 200);
}

public function logout(Request $request)
{
    // حذف التوكن الحالي الخاص بالمستخدم في Sanctum
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'success' => true,
        'message' => 'Successfully logged out',
    ], 200);
}
}
