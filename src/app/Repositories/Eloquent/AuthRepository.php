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

        $message = [
            'message' => 'Usuário cadastrado.'
        ];
        throw new HttpResponseException(response()->json($message, 201)); 
    }

    public function login(array $attributes)
    {
        $jwt_token = null;
        $email = User::where('email', 'like', $attributes['email'])->value('email');
        if (!$jwt_token = JWTAuth::attempt($attributes)) {
            if ($email == null){
                $message = [
                    'success' => false,
                    'email' => 'E-mail não cadastrado',
                ];
            } else {
                $message = [
                    'success' => false,
                    'password' => 'Senha inválida',
                ];
            }
            $cod = 422;
        } else {              
            $message = [
                'success' => true,
                'token' => $jwt_token,
                'expires_in' => JWTAuth::factory()->getTTL(), 
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

    public function getAuthUser(array $attributes)
    {
        $user = JWTAuth::authenticate($attributes['token']);
        throw new HttpResponseException(response()->json('$user')); 
    }
}

 