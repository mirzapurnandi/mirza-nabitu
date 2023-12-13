<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as Controller;

class AuthController extends Controller
{
    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format Email salah',
            'email.exists' => 'Email tidak ditemukan',
            'password.required' => 'Password harus diisi'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation Error.', $validator->errors(), 422);
        }

        $result = $this->authService->userLogin($request);
        if ($result['status'] == false) {
            return $this->errorResponse($result['error'], $result['message'], $result['code']);
        }

        return $this->successResponse($result['result'], $result['code']);
    }

    public function refreshToken(Request $request): JsonResponse
    {
        $result = $this->authService->userRefreshToken($request);
        if ($result['status'] == false) {
            return $this->errorResponse($result['error'], $result['message'], $result['code']);
        }
        return $this->successResponse($result['result'], $result['code']);
    }
}
