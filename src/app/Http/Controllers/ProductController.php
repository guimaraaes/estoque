<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        return response()->json([$products->toArray()]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'quantity' => 'required|integer|min:0'
        ], [
            'name.required' => 'Insira um nome',
            'quantity.required' => 'Insira uma quantidade',
            'quantity.integer' => 'Quantidade deve ser inteira',
            'quantity.min' => 'Quantidade deve ser positiva',
        ]);

        if($validator->fails())
            return response(['message' => $validator->messages(), 406]);
        else 
            return $this->productRepository->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'quantity' => 'required|integer|min:0'
        ], [
            'name.required' => 'Insira um nome',
            'quantity.required' => 'Insira uma quantidade',
            'quantity.integer' => 'Quantidade deve ser inteira',
            'quantity.min' => 'Quantidade deve ser positiva',
        ]);

        if($validator->fails())
            return response()->json($validator->messages(), 406);
            //return response($validator->messages(), 406);
        else 
            return $this->productRepository->update($request->all(), $id);
    }

    public function destroy($id)
    {
        return $this->productRepository->destroy($id);
    }

}
