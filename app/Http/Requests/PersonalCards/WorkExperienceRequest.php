<?php

namespace App\Http\Requests\PersonalCards;

use Illuminate\Foundation\Http\FormRequest;

class WorkExperienceRequest extends FormRequest
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
            'differentOrg' => 'required',
            'listOrganizationId' => 'required',
            'differentOrgListContractTypeId' => 'required',
            'listOrderTypeId' => 'required',
            'reasondifferentOrgOrderDate' => 'required|date',
            'differentOrgStartDate' => 'required|date',
            'differentOrgEndDate' => 'required|date',
            'differentOrgOrderNum' => 'required'
        ];
    }
}
