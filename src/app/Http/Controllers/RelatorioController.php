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
            foreach ($product as $uProduct) {
                if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin']>=$uProduct['quantity']) ){
                    $products_alert = $products_alert + 1;
                }
            }

            $bestsellers_name = [];
            //$bestsellers_total = [];
            $bestsellers = Sale::selectRaw('id_product, sum(quantitysale) as sum')->groupBy('id_product')->get()->take(3);
            foreach ($bestsellers as $uBestsellers) {              
                array_push($bestsellers_name, Product::where('id',$uBestsellers['id_product'] )->value('name'));
                //array_push($bestsellers_total, $uBestsellers['sum']);
            }

            $p->total_products = $total_products;
            $p->total_productstype = $total_productstype;
            $p->total_sales = $total_sales;
            $p->total_users = $total_users;
            $p->total_productssold = $total_productssold;
            $p->products_alert = $products_alert;
            $p->bestsellers_name = array_reverse($bestsellers_name);
        }
        return response()->json([$p->toArray()]);
}
}
