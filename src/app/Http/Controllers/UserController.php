<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return response()->json([$users->toArray()]);
    }

    public function destroy($id)
    {
        return $this->userRepository->destroy($id);
    }

}
