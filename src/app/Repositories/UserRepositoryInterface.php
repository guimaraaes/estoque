<?php
namespace App\Repositories;

interface UserRepositoryInterface
{
   public function all();
   public function show($name);
   public function destroy($id);

}