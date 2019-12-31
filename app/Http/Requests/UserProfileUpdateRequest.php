<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserProfileUpdateRequest extends FormRequest
{
    protected static $rules = [
        'name' => 'required|min:6',
        'first_name' => 'required|min:6',
        'address' => 'required|min:6',
        'phone_number' => 'required',

    ];

    public function __construct()
    {
        parent::__construct();
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
        // Conditionnal rules

        if(request()->has('password') &&
            !empty(request()->get('password')) && request()->get('password') != Auth::user()->password)
        {
            self::$rules['password'] = 'required|min:8|confirmed';
            self::$rules['password_confirmation'] = 'same:password';
        }

        if(request()->has('email') && request()->get('email') != Auth::user()->email)
        {
            self::$rules['email'] = 'required|email|unique:users';
        }

        if(request()->has('username') && request()->get('username') != Auth::user()->username) {
            self::$rules['username'] = 'required|min:6|unique:users';
        }

        if(request()->hasFile('profile'))
        {
//            dd(request()->file('profile'));
            self::$rules['profile'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        return self::$rules;
    }
}
