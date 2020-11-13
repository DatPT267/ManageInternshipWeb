<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email'=>'required|email',
            'namedotthuctap' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];
    }
    public function messages()
    {
        return [
            'name.required' =>'Bạn chưa nhập tên sinh viên',
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Bạn nhập sai định dạng email',
            'phone_number.max' => 'Số điện thoại phải có độ dài là 10 hoặc 11 số',
            'namedotthuctap.required' => 'Bạn chưa chọn đợt thực tập',
            'image.mimes' => 'Hình ảnh của bạn không hợp lệ. Hình ảnh phải là tệp có loại: JPEG, JPG, PNG, GIF',
            'image.max' => 'Ảnh có kích thước tối đa là 10MB'
        ];
    }
}
