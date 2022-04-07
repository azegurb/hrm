<?php

namespace App\Http\Requests\PersonalCards;

use Illuminate\Foundation\Http\FormRequest;

class UserQualificationDegreeRequest extends FormRequest
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
            'listpositionclassification' => 'required',
            'listqualificationtype' => 'required',
            'startdate' => 'required|date',
            'docinfo' => 'required',
            'docdate' => 'required|date'
        ];
    }
}
