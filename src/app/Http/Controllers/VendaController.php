<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Product;

class VendaController extends Controller
{
    public function index()
    {
        $p = Sale::all();
        foreach ($p as $uSale) {
            $name = Product::where('id',$uSale->id_product )->value('name');
            $uSale->id_product = $name;
        }
        return response()->json($p->toArray());
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required',
            //'id_user' => 'required',
            'name_client' => 'required_without:cpf_client',
            'cpf_client' => 'required_without:name_client|cpf',
            'quantitysale' => 'required|integer'
        ]);

        if (Product::find($request->input('id_product'))->quantity >= $request->input('quantitysale')){
            $sale = new Sale();
            $sale->id_product = $request->input('id_product');
            //$sale->id_user = $request->input('id_user');
            $sale->name_client = $request->input('name_client');
            $sale->cpf_client = $request->input('cpf_client');
            $sale->quantitysale = $request->input('quantitysale');
            $sale->save();

            $quantity = Product::where('id', $request->input('id_product'))->value('quantity');  
            $newquantity = $quantity - $request->input('quantitysale');
            Product::where('id',$request->input('id_product'))
                    ->update(['quantity' => $newquantity]);
        } else {
            return response()->json(['message'=>'quantidade indisponível'], 422);
        }
    }
}