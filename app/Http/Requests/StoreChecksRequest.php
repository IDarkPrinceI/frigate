<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreChecksRequest extends FormRequest
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
            'object' => 'required',
            'control' => 'required',
            'date_start' => 'required',
            'date_finish' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'object.required' => 'Название СМП - обязательная графа',
            'control.required' => 'Контролирующий орган - обязательная графа',
            'date_start.required' => 'Дата начала - обязательная графа',
            'date_finish.required' => 'Дата окончания - обязательная графа'
        ];
    }
}
