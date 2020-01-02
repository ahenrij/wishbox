<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WishCreateRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:200',
            'description' => 'required|string|min:5|max:500',
//            'filename' => 'file',
            'wish_box_id' => 'required|exists:wish_boxes,id',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}
