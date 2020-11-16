<?php

namespace App\Http\Requests\InternshipClass;

use Illuminate\Foundation\Http\FormRequest;

class InternshipClassUpdateRequest extends FormRequest
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
            'start_day'=>'required|date|before:end_day',
            'end_day'=>'required|date',
        ];
    }

    public function messages()
    {
        return [
            'name.required' =>'Bạn chưa nhập tên đợt thực tập',
            'start_day.required' => 'Bạn chưa nhập ngày bắt đầu',
            'end_day.required' => 'Bạn chưa nhập ngày kết thúc',
            'start_day.before' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu'
        ];
    }
}
