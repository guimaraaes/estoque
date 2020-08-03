<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Product;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p = Sale::all();
        foreach ($p as $u) {
            $name = Product::where('id',$u->id_product )->value('name');
            $u->id_product = $name;
        }

        return response()->json($p->toArray());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_product' => 'required',
            'id_user' => 'required',
            'name_client' => 'required_without:cpf_client',
            'cpf_client' => 'required_without:name_client|cpf',
            'quantitysale' => 'required|integer'
        ]);

        if  (Product::find($request->input('id_product'))->quantity >= $request->input('quantitysale')){
            $sale = new Sale();
            $name = Product::where('id',$b['id_product'] )->value('name');
            $sale->id_product = $request->input('id_product');
            $sale->id_user = $request->input('id_user');
            $sale->name_client = $request->input('name_client');
            $sale->cpf_client = $request->input('cpf_client');
            $sale->quantitysale = $request->input('quantitysale');
            $sale->save();

            $p = Product::find($request->input('id_product'));
            $quantityp = $p->quantity;
            $newquantity = $quantityp - $request->input('quantitysale');
            Product::where('id',$request->input('id_product'))
                    ->update(['quantity' => $newquantity]);
            
        } else {
            return redirect('/sale/quantityProductIndisponible');
        }   

    }



}