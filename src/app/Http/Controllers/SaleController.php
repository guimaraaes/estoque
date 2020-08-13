<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
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
        return response()->json([$sales]);       
    }

    public function store(SaleRequest $request)
    {
        $validator = $request->validated();
        return $this->saleRepository->create($request->all());
    }

    public function show($name)
    {
        $sales = $this->saleRepository->show($name);
        return response()->json($sales);    
    }
}