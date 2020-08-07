<?php

namespace App\Http\Service;
use App\Sale;
use App\Product;

class ProductService{
    public static function getProducts(){
        $products = Product::orderBy('id', 'desc')->get();
        //$products = Product::orderBy('id', 'desc')->paginate(1);
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

    public static function storeProduct($data){
        if (Product::where('name', $data->name)->count() == 1){
            $quantity = Product::where('name', $data->name)->value('quantity');
            $quantitymin = Product::where('name', $data->name)->value('quantitymin');
            $newquantity = $quantity + $data->quantity;
            Product::where('name',$data->name)->update(['quantity' => $newquantity]);
            if ($quantitymin != $data->quantitymin && $data->quantitymin != null) {
                Product::where('name',$data->name)->update(['quantitymin' => $data->quantitymin]);
            } 
            
        } else {
            $product = new Product();
            $product->name = $data->name;
            $product->quantity = $data->quantity;
            $product->quantitymin = $data->quantitymin;
            $product->save();
        } 
    }

    public static function updateProduct($data, $id){
        Product::where('id',$id)->update([  'name' => $data->name, 
                                            'quantity' =>  $data->quantity, 
                                            'quantitymin' => $data->quantitymin
                                        ]);
    }

    public static function destroyProduct($id)
    {
        Product::destroy($id);
    }

    


}