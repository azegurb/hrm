<?php

namespace App\Http\Requests\PersonalCards;

use Illuminate\Foundation\Http\FormRequest;

class UserAcademicDegreeRequest extends FormRequest
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
            'giver' => 'required',
            'filenumberdate' => 'required',
            'education' => 'required',
            'educationdegree' => 'required',
            'graduatedate'      => 'date'
        ];
    }
}
