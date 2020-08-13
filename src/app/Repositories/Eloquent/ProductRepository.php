<?php

namespace App\Repositories\Eloquent;

use App\Product;
use App\Sale;
use App\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function productAnalyze($products)
    {
        $sales = Sale::all();
        $sold = 0;
        foreach ($products as $uProduct) {
            foreach ($sales as $uSale) {
                if($uSale['id_product'] == $uProduct['id']){
                    $uProduct->sold = 1;
                    $sold = 1;
                } else if ($sold === 0)
                    $uProduct->sold = 0;
            }
            if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin']>=$uProduct['quantity']) )
                $uProduct->alert = 1;
            else 
                $uProduct->alert = 0;
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
            if (isset ($attributes['quantitymin']) && $attributes['quantitymin'] != null) {
                $this->model->where('name',$attributes['name'])->update(['quantitymin' => $attributes['quantitymin']]);
            } 
        } else {
            return $this->model->create($attributes);
        } 
        return response('Produto criado', 200);
    }

    public function show($name)
    {
        $products = $this->model->where('name', 'like', '%'. $name .'%')->get();
        return $this->productAnalyze($products);
    }

    public function update(array $attributes, $id)
    {
        $this->model->where('id',$id)->update([ 'name' => $attributes['name'], 
                                                'quantity' =>  $attributes['quantity'], 
                                                'quantitymin' => $attributes['quantitymin']
                                            ]);
        return response('Produto atualizado', 200);
    }

    public function destroy($id)
    {
        $this->model->destroy($id);
        return response('Produto excluído', 200);
    }

}