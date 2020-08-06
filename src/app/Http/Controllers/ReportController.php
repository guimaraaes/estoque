<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Service\ReportService;

class ReportController extends Controller
{
    public function index()
    {
        $p = ReportService::getReports();
        return response()->json([$p->toArray()]);
}
}
