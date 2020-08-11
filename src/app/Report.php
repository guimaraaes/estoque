<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [ 'total_products', 'total_productstype', 'total_sales', 
                            'total_users', 'total_productssold', 'products_alert', 'bestsellers_name'] ;
}


