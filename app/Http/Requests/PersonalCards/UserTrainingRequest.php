<?php

namespace App\Http\Requests\PersonalCards;

use Illuminate\Foundation\Http\FormRequest;

class UserTrainingRequest extends FormRequest
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
            'listTrainingNeed' => 'required',
            'listTrainingNameId' => 'required',
            'listTrainingFormId' => 'required',
            'trainingStartDate' => 'required|date',
            'trainingEndDate' => 'required|date',
            'period' => 'required',
            'listTrainingLocationId' => 'required'
        ];
    }
}
