<?php

namespace App\Repositories\Eloquent;

use App\Sale;
use App\Product;
use App\Repositories\SaleRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaleRepository implements SaleRepositoryInterface
{
    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        $sales = $this->model->orderBy('id', 'desc')->paginate(12);
        foreach ($sales as $uSale) {
            $uSale->name_product = Product::where('id',$uSale->id_product )->value('name');
        }
        return $sales;
    }

    public function create(array $attributes)
    {
        if (Product::find($attributes['id_product'])->quantity >= $attributes['quantitysale']){
            $this->model->create($attributes);
            $quantity = Product::where('id', $attributes['id_product'])->value('quantity');  
            $newquantity = $quantity - $attributes['quantitysale'];
            Product::where('id',$attributes['id_product'])->update(['quantity' => $newquantity]);

            $message = [
                'message' => 'Venda realizada'
            ];
            $cod = 201;
        } else {
            $message = [
                'quantitysale' => 'Quantidade indisponível'
            ];
            $cod = 422;
        }
        throw new HttpResponseException(response()->json($message,$cod)); 
    }

    public function show($name)
    {
        $sales = $this->model->where('name_client', 'like', $name .'%')
                            ->orwhere('cpf_client', 'like', $name .'%')->get();
        return $sales;
    }
}