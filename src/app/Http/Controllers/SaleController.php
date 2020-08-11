<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\SaleRepositoryInterface;

class SaleController extends Controller
{
    private $saleRepository;
  
    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }
 
    public function index()
    {
        $sales = $this->saleRepository->all();
        return response()->json([$sales->toArray()]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_product' => 'required',
            'name_client' => 'required_without:cpf_client',
            'cpf_client' => 'required_without:name_client|cpf',
            'quantitysale' => 'required|integer|min:1'
        ], [
            'id_product.required' => 'Selecione um produto',
            'name_client.required_without' => 'Insira o nome do cliente ou o cpf',
            'cpf_client.required_without' => 'Insira o nome do cliente ou o cpf',
            'cpf_client.cpf' => 'cpf inválido',
            'quantitysale.required' => 'Insira a quantidade vendida',
            'quantitysale.integer' => 'Quantidade vendida deve ser inteira',
            'quantitysale.min' => 'Quantidade mínima é 1',
        ]);
       
        if($validator->fails())
            return response(['message' => $validator->messages()], 406);
        else 
            return $this->saleRepository->create($request->all());
    }
}