<?php
namespace App\Repositories;

interface ProductRepositoryInterface
{
   public function all();
   public function productAnalyze($products);
   public function productlist();
   public function create(array $attributes);
   public function update(array $attributes, $id);
   public function show($name);
   public function show_products_alert($name);
   public function paginate($items, $perPage, $page, $options);
   public function destroy($id);
   
}