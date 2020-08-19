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
        $sales = $this->model->orderBy('id', 'desc')->paginate(17);
        foreach ($sales as $uSale) 
            $uSale->name_product = Product::where('id',$uSale->id_product )->value('name');
        return $sales;
    }

    public function create(array $attributes)
    {
        $message = ['quantitysale' => 'Quantidade indisponível'];
        $cod = 422;
        if (Product::find($attributes['id_product'])->quantity >= $attributes['quantitysale']){
            $this->model->create($attributes);
            $quantity = Product::where('id', $attributes['id_product'])->value('quantity');  
            $newquantity = $quantity - $attributes['quantitysale'];
            Product::where('id',$attributes['id_product'])->update(['quantity' => $newquantity]);
            $message = ['message' => 'Venda realizada'];
            $cod = 201;
        }
        throw new HttpResponseException(response()->json($message, $cod)); 
    }

    public function show($name)
    {
        $sales = $this->model->where('name_client', 'like', '%'. $name .'%')
                            ->orwhere('cpf_client', 'like', '%'. $name .'%')->paginate(17);
        return $sales;
    }

    public function destroy($id)
    {
        $id_product = $this->model->where('id', $id)->value('id_product'); 
        $newquantity = $this->model->where('id', $id)->value('quantitysale')
                         + Product::where('id', $id_product)->value('quantity');  
        Product::where('id', $id_product)->update(['quantity' => $newquantity]); 
        $this->model->destroy($id);
        $message = ['message' => 'Venda excluída.'];

        throw new HttpResponseException(response()->json($message, 201)); 
    }
}