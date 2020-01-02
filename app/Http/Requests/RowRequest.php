<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RowRequest extends FormRequest
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
                return [
                    'project_id' => ['required', 'integer'],
                    'rowsPos' => ['array'],
                    'rowsPos.*' => ['nullable', 'integer'],
                    'page.targetPageId' => ['required', 'integer'],
                    'rowTargetIndex' => ['required', 'integer'],
                    'rows' => ['required', 'array'],
                    'rows.*.grid' => ['required', 'string'],
                    'rows.*.columns' => ['required', 'array'],
                    'rows.*.columns.*.contents' => ['array'],
                ];
            case 'PUT':
                return [
                    'project_id' => ['required', 'integer'],
                    'rowsPos' => ['array'],
                    'rowsPos.*' => ['nullable', 'integer'],
                    'page.currRowId' => ['required', 'integer'],
                    'page.targetPageId' => ['required', 'integer']
                ];
            case 'PATCH':
            default: break;
        }        
    }
}
