<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReportRepositoryInterface;

class ReportController extends Controller
{

    private $reportRepository;
  
    public function __construct(ReportRepositoryInterface $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
 
    public function index()
    {
        $reports = $this->reportRepository->all();
        return response()->json([$reports->toArray()]);    
    }

}
