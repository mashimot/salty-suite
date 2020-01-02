<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
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
            //
            'id' => ['nullable', 'integer'],
            'contentPos' => ['array'],
            'contentPos.*' => ['nullable', 'integer'],
            'page.currPageId' => ['required', 'integer'],
            'page.currRowId' => ['required', 'integer'],
            'page.currColumnId' => ['required', 'integer']
        ];
    }
}
