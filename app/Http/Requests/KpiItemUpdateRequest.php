<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class KpiItemUpdateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'valor' => 'required',
            'variacao_percentual' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'valor.required' => 'Valor é requerido',
            'variacao_percentual.required' => 'Variação Percentual é requerido',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'data' => $validator->errors()
        ], 422));
    }

}
