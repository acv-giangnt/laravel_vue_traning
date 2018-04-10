<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        "ho" => "required",
                        "ten" => "required",
                        "dia_chi" => "required",
                        "tai_khoan" => "required | unique:nguoi_dung,tai_khoan",
                        "password" => "required| confirmed"
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        "ho" => "required",
                        "ten" => "required",
                        "dia_chi" => "required",
                        "trang_thai" => "required"
                    ];
                }
            default:break;
        }

    }
    public function messages()
    {
        return [
            "ho" => "Can nhap tai khoan",
            "ten" => "required",
            "dia_chi" => "required",
            "tai_khoan.unique" => "false",
            "password.confirmed" => "false"
        ];
    }

}
