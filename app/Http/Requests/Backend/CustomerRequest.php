<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        switch ($this->method()){
            case 'POST':
            {
                return[
                    'first_name'    => 'required',
                    'last_name'     => 'required',
                    'username'      => 'required|max:50|unique:users',
                    'email'         => 'required|email|max:255|unique:users',
                    'mobile'        => 'required|numeric|unique:users',
                    'status'        => 'required',
                    'password'      => 'nullable|min:8',
                    'user_image'    => 'required|mimes:png,jpg,jpeg,svg|max:5048'
                ];
            }

            case 'PUT':

            case 'PATCH':
            {
                return[
                    'first_name'    => 'required',
                    'last_name'     => 'required',
                    'username'      => 'required|max:50|unique:users,username,'.$this->route()->customer->id,
                    'email'         => 'required|email|max:255|unique:users,email,'.$this->route()->customer->id,
                    'mobile'        => 'required|numeric|unique:users,mobile,'.$this->route()->customer->id,
                    'status'        => 'required',
                    'password'      => 'nullable|min:8',
                    'user_image'    => 'required|mimes:png,jpg,jpeg,svg|max:5048'
                ];
            }

            default: break;
        }

    }
}
