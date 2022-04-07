<?php

namespace App\Http\Requests\HelperLists;


use Illuminate\Foundation\Http\FormRequest;

class RankTypesRequest extends FormRequest
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
            'input_rank_name' => 'required',
            'input_list_rank_type' => 'required'
        ];
    }
}
