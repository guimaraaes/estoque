<?php

namespace App\Repositories\Eloquent;

use App\Product;
use App\Sale;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Pagination\LengthAwarePaginator ;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function productAnalyze($products)
    {
        $sales = Sale::all();
        foreach ($products as $uProduct) {
            $uProduct['sold'] = 0;
            $uProduct['alert'] = 0;
            foreach ($sales as $uSale) 
                if($uSale['id_product'] == $uProduct['id'])
                    $uProduct['sold'] = 1;
            if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin'] >= $uProduct['quantity']))
                $uProduct['alert'] = 1;                
        }
        return $products;
    }

    public function all()
    {
        $products = $this->model->orderBy('id', 'desc')->paginate(9);
        return $this->productAnalyze($products);
    }

    public function productlist()
    {
        $products = $this->model->orderBy('id', 'desc')->get();
        return $this->productAnalyze($products);
    }

    public function create(array $attributes)
    {
        if ($this->model->where('name', $attributes['name'])->count() == 1){
            $quantity = $this->model->where('name', $attributes['name'])->value('quantity');
            $quantitymin = $this->model->where('name', $attributes['name'])->value('quantitymin');
            $newquantity = $quantity + $attributes['quantity'];
            $this->model->where('name',$attributes['name'])->update(['quantity' => $newquantity]);
            if (isset ($attributes['quantitymin']) && $attributes['quantitymin'] != null) 
                $this->model->where('name',$attributes['name'])->update(['quantitymin' => $attributes['quantitymin']]);
            $message = ['message' => 'Produto já existe. Dados atualizados.'];
        } else {
            $this->model->create($attributes);
            $message = ['message' => 'Produto criado.'];
        }
        throw new HttpResponseException(response()->json($message, 201)); 
    }

    public function show($name)
    {
        $products = $this->model->where('name', 'like', '%'. $name .'%')->paginate(9);
        return $this->productAnalyze($products);
    }

    public function show_products_alert($name)
    {
        $products = $this->model->orderBy('id', 'desc')->get();
        if (isset($name))
            $products = $this->model->where('name', 'like', '%'. $name .'%')->get();

        $product = [];
        foreach ($products as $uProduct) {
            if(($uProduct['quantitymin'] != null) && ($uProduct['quantitymin'] >= $uProduct['quantity']))
                array_push($product, $uProduct);
        }

        return  $this->paginate($this->productAnalyze($product));
    }
    
    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $lap = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        return [
            'current_page' => $lap->currentPage(),
            'data' => $lap ->values(),
            'first_page_url' => $lap ->url(1),
            'from' => $lap->firstItem(),
            'last_page' => $lap->lastPage(),
            'last_page_url' => $lap->url($lap->lastPage()),
            'next_page_url' => $lap->nextPageUrl(),
            'per_page' => $lap->perPage(),
            'prev_page_url' => $lap->previousPageUrl(),
            'to' => $lap->lastItem(),
            'total' => $lap->total(),
        ];
    }

    public function update(array $attributes, $id)
    {
        $this->model->where('id',$id)->update([ 'name' => $attributes['name'], 
                                                'quantity' =>  $attributes['quantity'], 
                                                'quantitymin' => $attributes['quantitymin']
                                            ]);
        $message = ['message' => 'Produto atualizado.'];
        throw new HttpResponseException(response()->json($message, 201)); 
    }

    public function destroy($id)
    {
        $this->model->destroy($id);
        $message = ['message' => 'Produto excluído.'];
        throw new HttpResponseException(response()->json($message, 201));
    }

}