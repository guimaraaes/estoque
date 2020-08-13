<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\Controller;

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
 
    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
        return $this->authRepository->getAuthUser($request->only('token'));
    }
}