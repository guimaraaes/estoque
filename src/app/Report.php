<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [ 'total_products', 'total_productstype', 'total_sales', 
                            'total_users', 'total_productssold', 'total_products_alert',
                            'products_alert', 'bestsellers_name', 'bestsellers_total', 'Bestsellers'] ;
}


