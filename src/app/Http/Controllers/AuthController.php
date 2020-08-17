<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;
use JWTAuth;
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
 
    public function login(AuthRequest $request)
    {
        $validator = $request->validated();
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