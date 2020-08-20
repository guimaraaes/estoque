<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use JWTAuth;

class UserUpdateRequest extends FormRequest
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
        $user = JWTAuth::parseToken()->authenticate();
         if ($user['email'] != $this->input('email')){
            return [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                //'new_password' => 'required|string|min:8|confirmed',
                'password' => 'required|string|min:8|confirmed'
            ];
        }
        return [
            'name' => 'required|string|max:255',
            //'new_password' => 'required|string|min:8|confirmed',
            'password' => 'required|string|min:8|confirmed'
        ];
        
    }

    public function messages()
    {
        return [
            'name.required' => 'Insira um nome',
            'name.max' => 'Senha deve ter no máximo 255 caracteres',
            'email.email' => 'Insira o e-mail no formato de email@dominio.com',
            'email.max' => 'Senha deve ter no máximo 255 caracteres',
            'email.unique' => 'E-mail já cadastrado',
            // 'new_password.required' => 'Insira a senha antiga',
            // 'new_password.min' => 'Senha antida deve ter pelo menos 8 caracteres',
            //'new_password.confirmed' => 'Senhas devem ser iguais',
            'password.confirmed' => 'Senhas devem ser iguais',
            'password.required' => 'Insira uma senha',
            'password.min' => 'Senha deve ter pelo menos 8 caracteres',
        ];
    }

    protected function failedValidation(Validator $validator) { 
        $erros = [
            'name' => $validator->errors()->first('name'),
            'email' => $validator->errors()->first('email'),
            //'new_password' => $validator->errors()->first('new_password'),
            'password' => $validator->errors()->first('password')
        ];
        throw new HttpResponseException(response()->json($erros, 422)); 
    }   
    
}
