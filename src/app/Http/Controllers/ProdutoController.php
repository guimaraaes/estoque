<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProdutoController extends Controller
{
    public function __construct(){
        //  $this->middleware('auth');
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p = Product::all();
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
            'name' => 'required',
            'quantity' => 'required'
        ]);
        if (Product::where('name', $request->input('name'))->count() == 1){
            $p = Product::where('name', $request->input('name'))->value('quantity');
            $newquantity = $p + $request->input('quantity');
            Product::where('name',$request->input('name'))
                ->update(['quantity' => $newquantity, 'quantitymin' => $request->input('quantitymin')]);
        } else {
            $product = new Product();
            $product->name = $request->input('name');
            $product->quantity = $request->input('quantity');
            $product->quantitymin = $request->input('quantitymin');
            $product->save();
        }   
        //return response()->json(['ok'], 200);
        return redirect('/product');
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
        //return response()->json(['ok'], 200);
        return redirect('/product');
    }
}
