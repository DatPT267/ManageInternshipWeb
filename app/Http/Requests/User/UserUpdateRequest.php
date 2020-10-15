<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'email' => 'email',
            'name' => 'required|regex:/^([aAàÀảẢãÃáÁạẠăĂằẰẳẲẵẴắẮặẶâÂầẦẩẨẫẪấẤậẬbBcCdDđĐeEèÈẻẺẽẼéÉẹẸêÊềỀểỂễỄếẾệỆ
                                fFgGhHiIìÌỉỈĩĨíÍịỊjJkKlLmMnNoOòÒỏỎõÕóÓọỌôÔồỒổỔỗỖốỐộỘơƠờỜởỞỡỠớỚợỢpPqQrRsStTu
                                UùÙủỦũŨúÚụỤưƯừỪửỬữỮứỨựỰvVwWxXyYỳỲỷỶỹỸýÝỵỴzZ\s]*)$/',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:11',
            'address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Email chưa đúng',
            'name.required' => 'Bạn chưa nhập tên',
            'phone.required' => "Bạn chưa nhập số điện thoại",
            'phone.regex' => "Số điện thoại không đúng",
            'name.regex' => "Tên không đúng",
            'phone.min' => 'Số điện thoại từ 10-11 kí tự số.',
            'phone.max' => 'Số điện thoại từ 10-11 kí tự số.',
            'address.required' => 'Bạn chưa nhập địa chỉ.'
        ];
    }
}
