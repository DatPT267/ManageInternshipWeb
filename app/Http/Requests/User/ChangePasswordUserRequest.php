<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordUserRequest extends FormRequest
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
            'oldPassword' => 'required',
            'newPassword' => 'required|min:6|max:50',
            'confirm_newPassword'=> 'required|same:newPassword',
        ];
    }

    public function messages()
    {
        return [
            'oldPassword.required' => 'Bạn chưa nhập mật khẩu cũ',
            'newPassword.required' => 'Bạn chưa nhập mật khẩu mới',
            'newPassword.min' => 'Mật khẩu ít nhất phải có 6 kí tự',
            'newPassword.max' => 'Mật khẩu nhiều nhất chỉ có 50 kí tự',
            'confirm_newPassword.required' => 'Bạn chưa xác nhận mật khẩu',
            'confirm_newPassword.min' => 'Mật khẩu ít nhất phải có 6 kí tự',
            'confirm_newPassword.max' => 'Mật khẩu nhiều nhất chỉ có 50 kí tự',
            'confirm_newPassword.same'=>  'Mật khẩu mới không khớp',
        ];
    }
}
