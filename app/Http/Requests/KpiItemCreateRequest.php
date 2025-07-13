<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class KpiItemCreateRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kpi_type_id' => 'required',
            'valor' => 'required',
            'variacao_percentual' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kpi_type_id.required' => 'Tipo Kpi é requerido',
            'valor.required' => 'Valor é requerido',
            'variacao_percentual.required' => 'Variação Percentual é requerido',
        ];
    }

}
