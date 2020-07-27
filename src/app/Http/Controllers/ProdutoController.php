<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    private $product = [
        ['id_product'=>1, 'name'=>'s1'],
        ['id_product'=>2, 'name'=>'s2'],
        ['id_product'=>3, 'name'=>'s3'],
        ['id_product'=>4, 'name'=>'s4']

    ];

    public function __construct(){
        $product = session('product');
        if (!isset($product))
            session(['product' => $this->product]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = session('product');
        return view('product.index', compact(['product']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');

        //      precisa ter no template
        //{{   action="{{route('product.store')}}" method="POST" }}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_product = $request->id_product;
        $name = $request->name;
        $quantity = $request->quantity;
        $quantityMin = $request->quantityMin;
        $new_product = ["id_product"=>$id_product, "name"=>$name, "quantity"=>$quantity, "quantityMin"=>$quantityMin];
        
        //CADASTRAR
        return redirect()->route('product.index');
    }
  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = session('product');
        $product = $product[$id - 1];
        return view('product.show', compact(['product']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = session('product');
        $product = $product[$id - 1];
        return view('product.edit', compact(['product']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = session('product');
        $product[$id - 1]['name'] = $request->name;
        session(['product' => $product]);
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = session('product');
        $ids = array_column($product, 'id_product');
        $index = array_search($id, $ids);
        array_splice($product,$index,1);
        session(['product' => $product]);
    }
}
