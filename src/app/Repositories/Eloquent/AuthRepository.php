<?php

namespace App\Repositories\Eloquent;

use App\User;
use App\Repositories\AuthRepositoryInterface;
use JWTAuth;
use Illuminate\Support\Facades\Auth;

use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRepository implements AuthRepositoryInterface
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function register(array $attributes)
    {
        $attributes['password'] = bcrypt($attributes['password']);
        $this->model->create($attributes);
        $message = ['message' => 'Usuário cadastrado.'];
        throw new HttpResponseException(response()->json($message, 201)); 
    }

    public function login(array $attributes)
    {
        $jwt_token = null;
        $cod = 422;
        if (User::where('email', 'like', $attributes['email'])->value('email') == null)
            $message = ['message' => 'E-mail não cadastrado'];
        else if (!$jwt_token = JWTAuth::attempt($attributes)) 
            $message = ['password' => 'Senha inválida'];
        else {              
            $message = [
                'token' => $jwt_token,
                'expires_in' => JWTAuth::factory()->getTTL()
            ];
            $cod = 202;
        }
        throw new HttpResponseException(response()->json($message, $cod)); 
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

    public function getAuthUser()
    {
        $user = JWTAuth::parseToken()->authenticate();
        throw new HttpResponseException(response()->json($user)); 
    }
}

 