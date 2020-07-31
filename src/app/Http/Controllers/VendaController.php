<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Product;

class VendaController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p = Sale::all();
        return json_encode($p);
        
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

        //          pendências
        
        //selecionar produtos mais vendidos
        //obter produtos em alertas

        if (Product::find($request->input('id_product'))->quantity >= $request->input('quantitysale')){
            $sale = new Sale();
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
            
            return redirect('/sale');

        } else {
            return redirect('/sale/quantityProductIndisponible');
        }

    }



}