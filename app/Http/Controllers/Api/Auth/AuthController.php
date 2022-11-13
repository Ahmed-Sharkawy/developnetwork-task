<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\VerifiedCodeRequest;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $verified_code = rand(100000, 999999);
        $user = User::create([
            'verified_code' => $verified_code,
            'password' => Hash::make($request->password)
            ] +
            $request->validated());

        $user['token'] = $user->createToken($user)->plainTextToken;

        return successMessageWithData($user);
    }


    public function login(LoginRequest $request)
    {
        $user = Auth::attempt(['phone' => $request->phone, 'password' => $request->password]);

        if (! $user) {
            return errorMessage('Check the health data', 401);
        }

        $user = Auth::user();
        $user['token'] = $user->createToken($user)->plainTextToken;

        return successMessageWithData($user);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return successMessage('Successfully logged out');
    }

    public function verified(VerifiedCodeRequest $request)
    {
        $user = auth()->user();

        if ($user->verified_code != $request->verified_code)
            return errorMessage('The verification number is incorrect', 401);

        $user->update(['code' => null]);
        return successMessage('The verification number is correct');
    }
}
