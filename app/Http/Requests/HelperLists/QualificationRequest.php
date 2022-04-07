<?php

namespace App\Http\Requests\HelperLists;


use Illuminate\Foundation\Http\FormRequest;

class QualificationRequest extends FormRequest
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
            'input_pos_classification' => 'required',
            'input_qual_type' => 'required',
            'input_req_curclasi' => 'required',
            'input_req_dq' => 'required',
            'input_sequence' => 'required'
        ];
    }
}
