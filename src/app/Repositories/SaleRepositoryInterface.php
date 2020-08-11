<?php
namespace App\Repositories;

interface SaleRepositoryInterface
{
   public function all();
   public function create(array $attributes);

}