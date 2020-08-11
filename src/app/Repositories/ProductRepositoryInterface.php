<?php
namespace App\Repositories;

interface ProductRepositoryInterface
{
   public function all();
   public function create(array $attributes);
   public function update(array $attributes, $id);
   public function destroy($id);

}