<?php

namespace App\Http\Requests\PersonalCards;

use Illuminate\Foundation\Http\FormRequest;

class UserDocumentRequest extends FormRequest
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
            'docnum' => 'required',
            'docIssueDate' => 'required|date',
            'doctype' => 'required',
            'file' => 'mimetypes:image/jpg,image/jpeg,image/png,image/gif,image/bmp,application/psd,application/pdf,application/docx,application/msaccess,application/x-msaccess,application/vnd.msaccess,application/vnd.ms-access,application/mdb,application/mdbx,application/x-mdb,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.wordprocessingml.template,fileContentTypes.add("application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.openxmlformats-officedocument.spreadsheetml.template,application/vnd.ms-excel.sheet.macroEnabled.12,application/vnd.ms-excel.template.macroEnabled.12,application/vnd.ms-excel.addin.macroEnabled.12,application/vnd.ms-excel.sheet.binary.macroEnabled.12,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.openxmlformats-officedocument.presentationml.template,application/vnd.openxmlformats-officedocument.presentationml.slideshow,application/vnd.ms-powerpoint.addin.macroEnabled.12,application/vnd.ms-powerpoint.presentation.macroEnabled.12,application/vnd.ms-powerpoint.slideshow.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.oasis.opendocument.text-template,application/vnd.oasis.opendocument.text-web,application/vnd.oasis.opendocument.text-master,application/vnd.oasis.opendocument.graphics,application/vnd.oasis.opendocument.graphics-template,application/vnd.oasis.opendocument.presentation,application/vnd.oasis.opendocument.graphics-template,application/vnd.oasis.opendocument.presentation,application/vnd.oasis.opendocument.presentation-template,application/vnd.oasis.opendocument.spreadsheet,application/vnd.oasis.opendocument.presentation-template,application/vnd.oasis.opendocument.spreadsheet-template,application/vnd.oasis.opendocument.chart,application/vnd.oasis.opendocument.formula,application/vnd.oasis.opendocument.image,application/vnd.openofficeorg.extension'
        ];
    }
}
