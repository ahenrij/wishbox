<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WishBoxUpdateRequest extends FormRequest
{
    protected static $rules = [
        'title' => 'required|min:5',
    ];

    public function __construct()
    {
        parent::__construct();
        self::$rules['deadline'] = 'after:' . date('Y-m-d');
    }

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
        $id = $this->segment(2);
        self::$rules['title'] = 'required|min:5|unique:wish_boxes,title,'.$id;
        return self::$rules;
    }
}
