<?php

namespace App\Services;

use App\Models\User;
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
                $result['access_token'] = $user->createToken('HanaCanKaliNyo3')->plainTextToken;
                $result['refresh_token'] = "testing";
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
            $accessToken = $request->user()->createToken('HanaCanKaliNyo3')->plainTextToken;
            $result['access_token'] = $accessToken;
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
}
