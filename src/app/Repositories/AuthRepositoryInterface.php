<?php
namespace App\Repositories;

interface AuthRepositoryInterface
{
   public function register(array $attributes);
   public function login(array $attributes);
   public function logout();
   public function getAuthUser(array $attributes);

}