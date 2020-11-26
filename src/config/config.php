<?php

use MrwangTc\UserCertification\Certification\Models\UserCertification;

return [

    /**
     * 关联用户模型
     */
    'user_model'     => App\Models\User::class,

    /**
     * 专门用作实名验证的类  eg : 'verified_class' => new UserCertification(),
     * 默认自动关联阿里云认证接口
     */
    'verified_class' => new UserCertification(),

    'verified_default' => 0,

    'open_phone_verified' => 0,

    'open_card_verified'   => 0,

    /**
     * 开启接口自动验证，为真时才走验证接口
     * 其他默认通过
     */
    'open_api_verify'      => false,

    /**
     * 是否开启OCR认证，接口暂为百度云
     */
    'open_ocr_verify'      => false,
    'open_ocr_appid'       => '',
    'open_ocr_secretkey'   => '',
    'open_ocr_url'         => '',

    /**
     * 调用阿里云市场个人认证接口的配置信息
     */
    'app_code'             => '',
    'app_url'              => '',

    /**
     * 接口认证要素  2要素.姓名，身份证号  3要素.姓名，身份证号，手机号
     * 默认为2要素 为true时开启3要素
     */
    'is_three_key_element' => false,

    /**
     * 接口请求方式
     */
    'request_method'       => 'get',

];
