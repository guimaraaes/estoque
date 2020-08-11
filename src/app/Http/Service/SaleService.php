<?php

namespace App\Http\Service;

use App\Sale;
use App\Product;
use Illuminate\Support\Facades\Validator;

class SaleService{
    public static function getSales(){
        //$sales = Sale::orderBy('id', 'desc')->get();
        $sales = Sale::orderBy('id', 'desc')->paginate(10);
        foreach ($sales as $uSale) {
            $uSale->id_product = Product::where('id',$uSale->id_product )->value('name');
        }
        return $sales;
    }

    public static function storeSale($data){
        
        if (Product::find($data->id_product)->quantity >= $data->quantitysale){
            $sale = new Sale();
            $sale->id_product = $data->id_product;
            $sale->name_client = $data->name_client;
            $sale->cpf_client = $data->cpf_client;
            $sale->quantitysale = $data->quantitysale;
            $sale->save();

            $quantity = Product::where('id', $data->id_product)->value('quantity');  
            $newquantity = $quantity - $data->quantitysale;
            Product::where('id',$data->id_product)
                    ->update(['quantity' => $newquantity]);
            
                    return response('Venda realizada', 200);
        } else {
            //return response()->json(['message'=>'quantidade indisponível'], 406);
            return response('Quantidade indisponível', 406);

        }
        
    }


}