<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
        if($this->input('register') == 1){
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed'
            ];
        } 
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages()
    {
        if($this->input('register') == 1){
            return [
                'name.required' => 'Insira um nome',
                'name.max' => 'Senha deve ter no máximo 255 caracteres',
                'email.required' => 'Insira um e-mail',
                'email.email' => 'Insira o e-mail no formato de email@dominio.com',
                'email.max' => 'Senha deve ter no máximo 255 caracteres',
                'email.unique' => 'E-mail já cadastrado',
                'password.required' => 'Insira uma senha',
                'password.min' => 'Senha deve ter pelo menos 8 caracteres',
                'password.confirmed' => 'Senhas devem ser iguais'
            ];
        } 
        return [
            'email.required' => 'Insira um e-mail',
            'email.email' => 'Insira o e-mail no formato de email@dominio.com',
            'password.required' => 'Insira uma senha',
        ];
    }

    protected function failedValidation(Validator $validator) { 
        $erros = [
            'name' => $validator->errors()->first('name'),
            'email' => $validator->errors()->first('email'),
            'password' => $validator->errors()->first('password')
        ];
        throw new HttpResponseException(response()->json($erros, 422)); 
    }   
}
