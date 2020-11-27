<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class StoreLecturerRequest extends FormRequest
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
            'name' =>'required',
            'email'=>'required|email|unique:users,email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'Bạn chưa nhập tên sinh viên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn nhập sai định dạng email',
            'email.unique' => 'Email đã được sử dụng'
        ];
    }
}
