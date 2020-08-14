<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['id_product', 'name_product', 'name_client', 'cpf_client', 'quantitysale'];
}
    