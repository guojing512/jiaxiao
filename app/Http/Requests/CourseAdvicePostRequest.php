<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CourseAdvicePostRequest extends Request
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
            'course_id' => 'required',
            'advice_content' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'course_id.required' => '课程不能为空',
            'advice_content.required' => '建议内容不能为空'
        ];
    }
}
