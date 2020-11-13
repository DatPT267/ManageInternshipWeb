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
            'phone' => 'max:11',
            'image' => 'mimes:png,jpg,gif,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'email.email' => 'Email chưa đúng',
            'name.required' => 'Bạn chưa nhập tên',
            'name.regex' => "Tên không đúng",
            'phone.max' => 'Số điện thoại từ 10-11 kí tự số.',
            'image.mimes' => "Bạn chỉ được chọn file có đuổi png, jpg, jpeg, gif",
        ];
    }
}
