<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Service\SaleService;

class SaleController extends Controller
{
    public function index()
    {
        $p = SaleService::getSales();
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

        return SaleService::storeSale($request);
    }
}