<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepositoryInterface;

class UserController extends Controller
{
    private $userRepository;
  
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
 
    public function index()
    {
        $users = $this->userRepository->all();
        return response()->json([$users]);      
    }

    public function show($name)
    {
        $users = $this->userRepository->show($name);
        return response()->json([$users]);   
    }

    public function update(AuthRequest $request, $id)
    {
        $validator = $request->validated();
        return $this->userRepository->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->userRepository->destroy($id);
    }

}
