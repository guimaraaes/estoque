<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Product;
use App\User;
use App\Report;

class RelatorioController extends Controller
{

    public function index()
    {
        $p = new Report;
        if ((Product::count() != null) || (Sale::count() != null) || (User::count() != null)){
            $products_alert = 0;
            $total_products = Product::sum('quantity');
            $total_productstype = Product::count();
            $total_sales = Sale::count();
            $total_users = User::count();
            $total_productssold = Sale::sum('quantitysale');

            $product = Product::all();
            //$products_alerttype = [];
            foreach ($product as $u) {
                if(($u['quantitymin'] != null) && ($u['quantitymin']>=$u['quantity']) ){
                    //array_push($products_alerttype, $u->name);
                    $products_alert = $products_alert + 1;
                }
            }
            $products_bestsellers = [];
            $bestsellers = Sale::selectRaw('id_product, sum(quantitysale) as sum')->groupBy('id_product')->get()->take(4);
            foreach ($bestsellers as $b) {
                $name = Product::where('id',$b['id_product'] )->value('name');
                
                array_push($products_bestsellers, $name, $b['sum']);
                
            }
            $p->total_products = $total_products;
            $p->total_productstype = $total_productstype;
            $p->total_sales = $total_sales;
            $p->total_users = $total_users;
            $p->total_productssold = $total_productssold;
            $p->products_alert = $products_alert;
            //$p->products_alerttype = $products_alerttype;
            $p->products_bestsellers = $products_bestsellers;
        }
        return response()->json([$p->toArray()]);
}
}
