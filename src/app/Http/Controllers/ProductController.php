<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Service\ProductService;

class ProductController extends Controller
{
    public function index()
    {
        $p = ProductService::getProducts();
        return response()->json($p->toArray());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]);
        return ProductService::storeProduct($request);  
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]); 
        return ProductService::updateProduct($request, $id);  

    }

    public function destroy($id)
    {
        ProductService::destroyProduct($id);
    }
}
