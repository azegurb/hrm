<?php

namespace App\Http\Requests\PersonalCards;

use Illuminate\Foundation\Http\FormRequest;

class SpecialWorkGraphicsRequest extends FormRequest
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
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start'
        ];
    }
}
