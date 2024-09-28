<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth:api', except: ['login']),
        ];
    }

    /**
     * Login valid user and return token.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:200',
            'password' => 'required|string|max:20|min:6',
        ]);

        if ($validator->fails()) {
            return $this->response(false, 'Please provide valid data!', 400, $validator->errors());
        }
        try {
            $credential = $request->only('email', 'password');
            if (!$data['token'] = JWTAuth::attempt($credential)) {
                throw new \Exception('Wrong email or password!', 401);
            }
            $data['user'] = auth()->user()->only(['id', 'name', 'email', 'email_verified_at']);

            return $this->response(true, 'Login successfully.', 200, $data);
        } catch (\Exception $e) {
            return $this->response(false, $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Logout authenticated user.
     */
    public function logout(): JsonResponse
    {
        try {
            auth()->logout(true);
            return $this->response(true, 'Logout successfully.');
        } catch (\Exception $e) {
            return $this->response(false, $e->getMessage(), $e->getCode());
        }
    }
}
