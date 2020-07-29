<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProdutoController extends Controller
{
    // private $product = [
    //     ['id_product'=>1, 'name'=>'s1'],
    //     ['id_product'=>2, 'name'=>'s2'],
    //     ['id_product'=>3, 'name'=>'s3'],
    //     ['id_product'=>4, 'name'=>'s4']

    // ];

    public function __construct(){
        //$this->middleware('auth');
        // $product = session('product');
        // if (!isset($product))
        //     session(['product' => $this->product]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$product = session('product');
        $product = Product::all();
        return view('welcome', compact(['product']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('product.create');

    //     //      precisa ter no template
    //     //{{   action="{{route('product.store')}}" method="POST" }}
    // }

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
        
        //$product->id_product = $request->input('id_product');
        $product->name = $request->input('name');
        $product->quantity = $request->input('quantity');
        $product->quantityMin = $request->input('quantityMin');
        $product->save();
        //$new_product = ["id_product"=>$id_product, "name"=>$name, "quantity"=>$quantity, "quantityMin"=>$quantityMin];
        
        return redirect('/product');
    }
  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     $product = session('product');
    //     $product = $product[$id - 1];

    //     //return view('product.show', compact(['product']));
    //     return redirect('/product');
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $product = session('product');
    //     $product = $product[$id - 1];
    //     return view('product.edit', compact(['product']));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        Product::where('id_product',$id)
        ->update(['name' => $request->input('name'), 'quantity' => $request->input('quantity'), 'quantityMin' => $request->input('quantityMin')]);
        
        
        // $product[$id - 1]['name'] = $request->name;
        // session(['product' => $product]);
        // return redirect()->route('product.index');
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
        // $product = session('product');
        // $ids = array_column($product, 'id_product');
        // $index = array_search($id, $ids);
        // array_splice($product,$index,1);
        // session(['product' => $product]);
    }
}
