<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ColumnRequest extends FormRequest
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
        switch($this->method()) {
            case 'GET':
            case 'DELETE':
                return [];
            case 'POST':
            case 'PUT':
                return [
                    'project_id' => ['required', 'integer'],
                    'page.currRowId' => ['required', 'integer'],
                    'newGrid' => ['required', 'string'],
                    'columnPos' => ['array'],
                    'columnPos.*' => ['nullable', 'integer'],
                ];
            case 'PATCH':
            default: break;
        }        
    }
}
