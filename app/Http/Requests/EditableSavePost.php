<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EditableSavePost
 *
 * @package App\Http\Requests
 */
class EditableSavePost extends FormRequest
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
            'content'   => 'required',
            'fieldname' => 'required',
            'tableid'   => 'required',
            'tablename' => 'required_without:model',
            'model'     => 'required_without:tablename',
        ];
    }
}
