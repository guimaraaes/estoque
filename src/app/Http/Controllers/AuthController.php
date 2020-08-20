<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;

use App\Http\Controllers\Controller;

use App\Repositories\AuthRepositoryInterface;


class AuthController extends Controller
{
    private $authRepository;
  
    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    
    public function register(RegisterRequest $request)
    {
        return $this->authRepository->register($request->only('name', 'email', 'password'));
    }
 
    public function login(AuthRequest $request)
    {
        return $this->authRepository->login($request->only('email', 'password'));
    }
 
    public function logout() 
    {
        return $this->authRepository->logout();
    }
 
    public function getAuthUser()
    {
        return $this->authRepository->getAuthUser();
    }
}