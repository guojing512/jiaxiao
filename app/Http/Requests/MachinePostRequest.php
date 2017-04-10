<?php

namespace App\Http\Requests;

use App\Http\Models\Machine;
use App\Http\Requests\Request;

class MachinePostRequest extends Request
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
        $tableName = (new Machine())->getTable();
        $id = $this->get('id');
        return [
            'machine_type' => 'required',
            'machine_num' => 'required|max:50|unique:'.$tableName.',machine_num,'.$id,
            'company_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'machine_type.required' => '设备类型不能为空',
            'machine_num.required' => '设备编号不能为空',
            'machine_num.max' => '设备编号长度不能超过50个字符',
            'machine_num.unique' => '此设备编号已存在',
            'company_id.required' => '所属机构不能为空'
        ];
    }
}
