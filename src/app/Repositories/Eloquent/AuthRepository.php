<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Repositories\AuthRepositoryInterface;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register(array $attributes)
    {
        $attributes['password'] = bcrypt($attributes['password']);
        return $this->model->create($attributes);
    }

    public function login(array $attributes)
    {
        $jwt_token = null;
        if (!$jwt_token = JWTAuth::attempt($attributes)) {
            return response()->json([
                'success' => false,
                'message' => 'E-mail ou senha inválidos',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'token' => $jwt_token,
        ], 200);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                "status" => "success", 
                "message"=> "User successfully logged out."
            ]);
        } catch (JWTException $e) {
            return response()->json([
                "status" => "error", 
                "message" => "Failed to logout, please try again."
            ], 500);
        }
    }

    public function getAuthUser(array $attributes)
    {
        $user = JWTAuth::authenticate($attributes['token']);
        return response()->json(['user' => $user]);
    }
}

 