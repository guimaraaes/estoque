<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Repositories\ProductRepositoryInterface;

class ProductController extends Controller
{
    private $productRepository;
  
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
 
    public function index()
    {
        $products = $this->productRepository->all();
        return response()->json([$products]);
    }

    public function productlist()
    {
        $products = $this->productRepository->productlist();
        return response()->json($products);
    }

    public function store(ProductRequest $request)
    {
        $validator = $request->validated();
        return $this->productRepository->create($request->all(), 409);
    }

    public function show($name)
    {
        $products = $this->productRepository->show($name);
        return response()->json([$products]);
    }

    public function show_products_alert($name = null)
    {
        $products = $this->productRepository->show_products_alert($name);
        return response()->json([$products]);
    }

    public function update(ProductRequest $request, $id)
    {
        $validator = $request->validated();
        return $this->productRepository->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->productRepository->destroy($id);
    }

}
