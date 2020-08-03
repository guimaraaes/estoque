<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $p = Product::all();
        
        foreach ($p as $u) {
            if(($u['quantitymin'] != null) && ($u['quantitymin']>=$u['quantity']) ){
                $u->alert = 1;
            } else {
                $u->alert = 0;
            }
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
            'name' => 'required',
            'quantity' => 'required'
        ]);
        // $validator = Validator::make($request, [
        //     'name' => ['required'],
        //     'quantity' => ['required']
        //     ]);
        
    
        
        // return response()->json('ok');

        if (Product::where('name', $request->input('name'))->count() == 1){
            $p = Product::where('name', $request->input('name'))->value('quantity');
            $newquantity = $p + $request->input('quantity');
            Product::where('name',$request->input('name'))
                    ->update(['quantity' => $newquantity]);
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
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
    }
}
