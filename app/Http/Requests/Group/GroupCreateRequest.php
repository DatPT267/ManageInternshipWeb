<?php

namespace App\Http\Requests\Group;

use Illuminate\Foundation\Http\FormRequest;

class GroupCreateRequest extends FormRequest
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
            'name' => 'required|unique:group,name',
            'topic' => 'required',
            'internshipclass' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Tên nhóm đã tồn tại',
            'name.required' =>'Bạn chưa nhập tên nhóm',
            'topic.required' => 'Bạn chưa nhập đề tài của nhóm',
            'internshipclass.required' => 'Bạn chưa chọn đợt thực tập cho nhóm',
        ];
    }
}
