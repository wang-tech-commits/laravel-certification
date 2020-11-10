<?php

namespace MrwangTc\UserCertification\Certification\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCertificationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'       => 'required|min:2|max:5',
            'id_card'    => ['required', new IdCardRule()],
            'front_card' => 'required',
            'back_card'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => '认证用户姓名必须填写',
            'name.min'         => '认证用户姓名至少:min个字符',
            'name.max'         => '认证用户姓名最多:max个字符',
            'id_card.required' => '身份证号必须填写',
            'front_card.required' => '身份证正面图片必须上传',
            'back_card.required' => '身份证背面图片必须上传',
        ];
    }
}