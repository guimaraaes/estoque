<?php

namespace App\Repositories\Eloquent;

use App\Report;
use App\Sale;
use App\Product;
use App\User;
use App\Repositories\ReportRepositoryInterface;

class ReportRepository implements ReportRepositoryInterface
{
    public function __construct(Report $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        if ((Product::count() != null) || (Sale::count() != null) || (User::count() != null)){
            $products_alert = 0;
            $this->model['total_products'] = Product::sum('quantity');
            $this->model['total_productstype'] = Product::count();
            $this->model['total_sales'] = Sale::count();
            $this->model['total_users'] = User::count();
            $this->model['total_productssold'] = Sale::sum('quantitysale');

            $product = Product::all();
            foreach ($product as $uProduct) {
                if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin']>=$uProduct['quantity']) ){
                    $products_alert = $products_alert + 1;
                }
            }
            $this->model['products_alert'] = $products_alert;
            $bestsellers_name = [];
            //$bestsellers_total = [];
            $bestsellers = Sale::selectRaw('id_product, sum(quantitysale) as sum')->groupBy('id_product')->get()->take(3);
            foreach ($bestsellers as $uBestsellers) {              
                array_push($bestsellers_name, Product::where('id',$uBestsellers['id_product'] )->value('name'));
                //array_push($bestsellers_total, $uBestsellers['sum']);
            }
            $this->model['bestsellers_name'] = array_reverse($bestsellers_name);
            $reports = $this->model;
        }
        return $reports;
    }

}