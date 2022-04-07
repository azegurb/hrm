<?php

namespace App\Http\Requests\HelperLists;


use Illuminate\Foundation\Http\FormRequest;

class TrainingNamesRequest extends FormRequest
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
            'input_list_training_type' => 'required',
            'input_training_name' => 'required'
        ];
    }
}
