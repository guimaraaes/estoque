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
            $this->model['total_products'] = Product::sum('quantity');
            $this->model['total_productstype'] = Product::count();
            $this->model['total_sales'] = Sale::count();
            $this->model['total_users'] = User::count();
            $this->model['total_productssold'] = Sale::sum('quantitysale');
            $products = Product::all();
            $total_products_alert = 0;
            //$products_alert=[];
            foreach ($products as $uProduct) 
                if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin']>=$uProduct['quantity']))
                {
                    //array_push($products_alert, $uProduct['name']);
                    $total_products_alert ++;
                }
            //$this->model['products_alert'] = $products_alert;
            $this->model['total_products_alert'] = $total_products_alert;
            $bestsellers_name = [];
            $bestsellers_total = [];
            $bestsellers = Sale::selectRaw('id_product , sum(quantitysale) as sum')->groupBy('id_product')->get();
            foreach ($bestsellers as $uBestsellers) {  
                array_push($bestsellers_name, Product::where('id',$uBestsellers['id_product'] )->value('name'));
                array_push($bestsellers_total, $uBestsellers['sum']);
            }

            array_multisort($bestsellers_total, $bestsellers_name);
            $this->model['bestsellers_name'] = array_slice(array_reverse($bestsellers_name),0,3);
            $this->model['bestsellers_total'] = array_slice(array_reverse($bestsellers_total),0,3);
            
            $this->model['Bestsellers'] = [ 'product1' => $this->model['bestsellers_name'][0],
                                            'total1' => $this->model['bestsellers_total'][0],
                                            'product2' => $this->model['bestsellers_name'][1],
                                            'total2' => $this->model['bestsellers_total'][1],
                                            'product3' => $this->model['bestsellers_name'][2],
                                            'total3' => $this->model['bestsellers_total'][2],
                                        ];
            
            $reports = $this->model;
        }
        return $reports;
    }
}