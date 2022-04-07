<?php

namespace App\Http\Requests\HelperLists;

use Illuminate\Foundation\Http\FormRequest;

class PositionNamesRequest extends FormRequest
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
            'input_position_name' => 'required',
            'input_position_order' => 'required'
        ];
    }
}
