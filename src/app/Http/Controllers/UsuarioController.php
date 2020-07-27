<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private $user = [
        ['id_user'=>1, 'name'=>'s1'],
        ['id_user'=>2, 'name'=>'s2'],
        ['id_user'=>3, 'name'=>'s3'],
        ['id_user'=>4, 'name'=>'s4']

    ];

    public function __construct(){
        $user = session('user');
        if (!isset($user))
            session(['user' => $this->user]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = session('user');
        return view('user.index', compact(['user']));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');

        //      precisa ter no template
        //{{   action="{{route('user.store')}}" method="POST" }}

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $user = session('user');
        $id_user = count($user)+1;
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        $novo_usuario = ["name"=>$name, "email"=>$email, "password"=>$password];
        $user[] = ["id_user"=>$id_user, "name"=>$name];
        //CADASTRAR
        return redirect()->route('user.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = session('user');
        $user = $user[$id - 1];
        return view('user.show', compact(['user']));
        //      precisa ter no template
        //href="{{    route('user.show',    $variavel   )  }}"
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = session('user');
        $user = $user[$id - 1];
        return view('user.edit', compact(['user']));


        //      precisa ter no template
        //@csrf
        //@method = "PUT"
        //action="{{    route('user.update',    $variavel   )  }}" method="POST"
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
        $user = session('user');
        $user[$id - 1]['name'] = $request->name;
        session(['user' => $user]);
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = session('user');
        $ids = array_column($user, 'id_user');
        $index = array_search($id, $ids);
        array_splice($user,$index,1);
        session(['user' => $user]);
    }
}
