<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\User;
use App\Enums\TokenAbility;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function userLogin($request)
    {
        $status = false;
        $code = 200;
        $result = [];
        $error = "";
        try {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $getUser = User::select('id', 'email', 'name')->findOrFail($user->id);
                $result['user'] = $getUser;

                $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addSeconds(20));
                $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], Carbon::now()->addYear(1));
                $result['access_token'] = $accessToken->plainTextToken;
                $result['refresh_token'] = $refreshToken->plainTextToken;

                $message = 'Succesfully User Login';
                $status = true;
            } else {
                $message = "incorrect username or password";
                $error = "ERR_INVALID_CREDS";
                $code = 401;
            }
        } catch (\Throwable $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $result = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine()
            ];
        }

        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'error' => $error,
            'result' => $result
        ];
    }

    public function userRefreshToken($request)
    {
        $status = false;
        $code = 200;
        $result = [];
        $error = "";
        try {
            $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], Carbon::now()->addSeconds(20));
            // $accessToken = $request->user->createToken('access_token', ['expires_in' => config('sanctum.expiration')]);
            $result['access_token'] = $accessToken->plainTextToken;
            $message = 'Succesfully Refresh Token';
            $status = true;
        } catch (\Throwable $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $result = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine()
            ];
        }

        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'error' => $error,
            'result' => $result
        ];
    }

    public function userLogout()
    {
        $status = false;
        $code = 200;
        $result = [];
        try {
            $message = "Logout Successfully";
            Auth::user()->tokens()->delete();
            $status = true;
        } catch (\Throwable $e) {
            $code = $e->getCode();
            $message = $e->getMessage();
            $result = [
                'get_file' => $e->getFile(),
                'get_line' => $e->getLine()
            ];
        }

        return [
            'code' => $code,
            'status' => $status,
            'message' => $message,
            'result' => $result
        ];
    }
}
