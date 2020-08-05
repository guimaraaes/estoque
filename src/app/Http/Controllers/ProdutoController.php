<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProdutoController extends Controller
{
    public function index()
    {
        $p = Product::all();
        
        foreach ($p as $uProduct) {
            if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin']>=$uProduct['quantity']) ){
                $uProduct->alert = 1;
            } else {
                $uProduct->alert = 0;
            }
        }
        return response()->json($p->toArray());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]);
        if (Product::where('name', $request->input('name'))->count() == 1){
            $quantity = Product::where('name', $request->input('name'))->value('quantity');
            $quantitymin = Product::where('name', $request->input('name'))->value('quantitymin');
            $newquantity = $quantity + $request->input('quantity');
            Product::where('name',$request->input('name'))->update(['quantity' => $newquantity]);
            if ($quantitymin != $request->input('quantitymin') && $request->input('quantitymin') != null) {
                Product::where('name',$request->input('name'))
                        ->update(['quantitymin' => $request->input('quantitymin')]);
            } 
        } else {
            $product = new Product();
            $product->name = $request->input('name');
            $product->quantity = $request->input('quantity');
            $product->quantitymin = $request->input('quantitymin');
            $product->save();
        }   
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'quantity' => 'required'
        ]); 
        Product::where('id',$id)
                ->update([  'name' => $request->input('name'), 
                            'quantity' =>  $request->input('quantity'), 
                            'quantitymin' => $request->input('quantitymin')
                        ]);
    }

    public function destroy($id)
    {
        Product::destroy($id);
    }
}
