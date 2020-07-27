<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    //
    private $id_venda;
    private $id_produto;
    private $id_usuario;
    private $quantidade_produto;
    private $nome_cliente;
    private $cpf_cliente;
    private $data_venda;

}
