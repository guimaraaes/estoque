<?php

namespace App\Repositories\Eloquent;

use App\Product;
use App\Sale;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function productAnalyze($products)
    {
        $sales = Sale::all();
        foreach ($products as $uProduct) {
            $uProduct['sold'] = 0;
            $uProduct['alert'] = 0;
            foreach ($sales as $uSale) 
                if($uSale['id_product'] == $uProduct['id'])
                    $uProduct['sold'] = 1;
            if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin'] >= $uProduct['quantity']))
                $uProduct['alert'] = 1;                
        }
        return $products;
    }

    public function all()
    {
        $products = $this->model->orderBy('id', 'desc')->paginate(9);
        return $this->productAnalyze($products);
    }

    public function productlist()
    {
        $products = $this->model->orderBy('id', 'desc')->get();
        return $this->productAnalyze($products);
    }

    public function create(array $attributes)
    {
        if ($this->model->where('name', $attributes['name'])->count() == 1){
            $quantity = $this->model->where('name', $attributes['name'])->value('quantity');
            $quantitymin = $this->model->where('name', $attributes['name'])->value('quantitymin');
            $newquantity = $quantity + $attributes['quantity'];
            $this->model->where('name',$attributes['name'])->update(['quantity' => $newquantity]);
            if (isset ($attributes['quantitymin']) && $attributes['quantitymin'] != null) 
                $this->model->where('name',$attributes['name'])->update(['quantitymin' => $attributes['quantitymin']]);
            $message = ['message' => 'Produto já existe. Dados atualizados.'];
        } else {
            $this->model->create($attributes);
            $message = ['message' => 'Produto criado.'];
        }
        throw new HttpResponseException(response()->json($message, 201)); 
    }

    public function show($name)
    {
        $products = $this->model->where('name', 'like', $name .'%')->get();
        return $this->productAnalyze($products);
    }

    public function update(array $attributes, $id)
    {
        $this->model->where('id',$id)->update([ 'name' => $attributes['name'], 
                                                'quantity' =>  $attributes['quantity'], 
                                                'quantitymin' => $attributes['quantitymin']
                                            ]);
        $message = ['message' => 'Produto atualizado.'];
        throw new HttpResponseException(response()->json($message, 201)); 
    }

    public function destroy($id)
    {
        $this->model->destroy($id);
        $message = ['message' => 'Produto excluído.'];
        throw new HttpResponseException(response()->json($message, 201));
    }

}