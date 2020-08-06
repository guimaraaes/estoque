<?php

namespace App\Http\Service;
use App\Sale;
use App\Product;
use App\User;
use App\Report;


class ReportService{
    public static function getReports(){
        $reports = new Report;
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

            $reports->total_products = $total_products;
            $reports->total_productstype = $total_productstype;
            $reports->total_sales = $total_sales;
            $reports->total_users = $total_users;
            $reports->total_productssold = $total_productssold;
            $reports->products_alert = $products_alert;
            $reports->bestsellers_name = array_reverse($bestsellers_name);
        }
        return $reports;
    }


}
