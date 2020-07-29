<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendaController extends Controller
{
    private $sale = [
        ['id_sale'=>1, 'name'=>'s1'],
        ['id_sale'=>2, 'name'=>'s2'],
        ['id_sale'=>3, 'name'=>'s3'],
        ['id_sale'=>4, 'name'=>'s4']

    ];

    public function __construct(){
        //$this->middleware('auth');
        $sale = session('sale');
        if (!isset($sale))
            session(['sale' => $this->sale]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $sale = session('sale');
        return view('welcome', compact(['sale']))->with('data', json_encode($sale));
        
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sale.create');

        //      precisa ter no template
        //{{   action="{{route('sale.store')}}" method="POST" }}

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
            'name_client' => 'required',
            'cpf_client' => 'required',
            'quantitySale' => 'required'
        ]);

        $id_product = $request->id_product;
        $id_user = $request->id_user;
        $name_client = $request->name_client;
        $cpf_client = $request->cpf_client;
        $quantitySale = $request->quantitySale;
        $new_sale = ["id_product"=>$id_product, "id_user"=>$id_user, "name_client"=>$name_client, "cpf_client"=>$cpf_client, "quantitySale"=>$quantitySale];
        
        //CADASTRAR
        return redirect()->route('sale.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = session('sale');
        $sale = $sale[$id - 1];
        return view('sale.show', compact(['sale']));
        //      precisa ter no template
        //href="{{    route('sale.show',    $variavel   )  }}"
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = session('sale');
        $sale = $sale[$id - 1];
        return view('sale.edit', compact(['sale']));

        //      precisa ter no template
        //@csrf
        //@method = "PUT"
        //action="{{    route('sale.update',    $variavel   )  }}" method="POST"
        //name = "name" value="{{     $varialvel['name']  }}"
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
        $sale = session('sale');
        $sale[$id - 1]['name'] = $request->name;
        session(['sale' => $sale]);
        return redirect()->route('sale.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = session('sale');
        $ids = array_column($sale, 'id_sale');
        $index = array_search($id, $ids);
        array_splice($sale,$index,1);
        session(['sale' => $sale]);
    }
}
