<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Exceptions\HttpResponseException;
use JWTAuth;
//use Tymon\JWTAuth\Exceptions\JWTException;

use App\Repositories\AuthRepositoryInterface;


class AuthController extends Controller
{
    private $authRepository;
  
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    
    public function register(AuthRequest $request)
    {
        $validator = $request->validated();
        return $this->authRepository->register($request->only('name', 'email', 'password'));
    }
 
    public function login(Request $request)
    {
        $validator = Validator::make($request->only('email', 'password'),[
            'email' => 'required|email',
            'password' => 'required'
        ],[
            'email.required' => 'Insira um e-mail',
            'email.email' => 'Insira o e-mail no formato de email@dominio.com',
            'password.required' => 'Insira uma senha',
        ]);
        
        if($validator->fails())
            throw new HttpResponseException(response()->json(['message' => $validator->errors()->first()], 422)); 
        else 
            return $this->authRepository->login($request->only('email', 'password'));
    }
 
    public function logout() 
    {
        return $this->authRepository->logout();
    }
 
    public function getAuthUser()
    {
        return JWTAuth::parseToken()->authenticate();
    }

  
}