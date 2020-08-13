<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SaleRequest extends FormRequest
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
            'id_product' => 'required',
            'name_client' => 'required_without:cpf_client',
            'cpf_client' => 'required_without:name_client|cpf',
            'quantitysale' => 'required|integer|min:1'
        ];
    }

    public function messages()
    {
        return [
            'id_product.required' => 'Selecione um produto',
            'name_client.required_without' => 'Insira o nome do cliente ou o cpf',
            'cpf_client.required_without' => 'Insira o nome do cliente ou o cpf',
            'cpf_client.cpf' => 'cpf inválido',
            'quantitysale.required' => 'Insira a quantidade vendida',
            'quantitysale.integer' => 'Quantidade vendida deve ser inteira',
            'quantitysale.min' => 'Quantidade mínima é 1',
        ];
    }

    protected function failedValidation(Validator $validator) { 
        $erros = [
            'id_product' => $validator->errors()->first('id_product'),
            'name_client' => $validator->errors()->first('name_client'),
            'cpf_client' => $validator->errors()->first('cpf_client'),
            'quantitysale' => $validator->errors()->first('quantitysale')
        ];
        throw new HttpResponseException(response()->json($erros, 422)); 
    }   
}
