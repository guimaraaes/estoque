<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Product;
use App\User;
use App\Report;

class RelatorioController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');

    }
    public function index()
    {
        $p = new Report;
        if ((Product::count() != null) && (Sale::count() != null) && (User::count() != null)){
            $total_products = Product::count();
            $total_sales = Sale::count();
            $total_users = User::count();
            //$total_produtosvendidos = Sale::sum('quantitysale');

            $product = Product::all();
            $products_alert = [1, 3];
            foreach ($product as $u) {
                if(($u['quantitymin'] != null) && ($u['quantitymin']>=$u['quantity']) ){
                    array_push($products_alert, $u->id);
                }
            }

            $products_bestsellers = Sale::selectRaw('id_product, sum(ID) as s')->groupBy('id_product')->get()->take(5);
            //  all('id','quantitysale')->groupBy('id_product')->toArray();
         
            $p->total_products = $total_products;
            $p->total_sales = $total_sales;
            $p->total_users = $total_users;
            //$p->total_productssold = $total_productssold;
            $p->products_alert = $products_alert;
            $p->products_bestsellers = $products_bestsellers;

        }
        
       
        return json_encode($p);
    }
}
