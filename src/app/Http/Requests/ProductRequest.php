<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'quantity' => 'required|integer|min:0',
            'quantitymin' => 'nullable|integer|min:0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Insira um nome',
            'quantity.required' => 'Insira uma quantidade',
            'quantity.integer' => 'Quantidade deve ser inteira',
            'quantity.min' => 'Quantidade deve ser positiva',
            'quantitymin.integer' => 'Quantidade mínima deve ser inteira',
            'quantitymin.min' => 'Quantidade mínima deve ser positiva',
        ];
    }

    protected function failedValidation(Validator $validator) { 
        $erros = [
            'name' => $validator->errors()->first('name'),
            'quantity' => $validator->errors()->first('quantity'),
            'quantitymin' => $validator->errors()->first('quantitymin')
        ];
        throw new HttpResponseException(response()->json($erros, 422)); 
    }   
    
}
