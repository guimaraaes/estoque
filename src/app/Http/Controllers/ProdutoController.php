<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProdutoController extends Controller
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
        //$product = session('product');
        $p = Product::all();

        return redirect()->route('/produto', compact['p'])->with('ps', json_encode($p));

        //return view('welcome', compact(['p']));
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
            'name' => 'required',
            'quantity' => 'required',
            'quantityMin' => 'required'
        ]);
        $product = new Product();
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->quantitymin = $request->input('quantitymin');

        //$product->id_product = $request->input('id_product');
        // $product->name = 'dove';
        // $product->quantity = 10;
        // $product->quantitymin = 1;

        $product->save();
        return redirect('/product');
    }
  

    public function update(Request $request, $id)
    {
        Product::where('id_product',$id)
        ->update(['name' => $request->input('name'), 'quantity' => $request->input('quantity'), 'quantityMin' => $request->input('quantityMin')]);
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/product');
    }
}
