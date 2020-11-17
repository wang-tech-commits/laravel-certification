<?php

return [

    /**
     * 关联用户模型
     */
    'user_model'     => App\Models\User::class,

    /**
     * 专门用作实名验证的类  eg : 'verified_class' => new UserCertification(),
     */
    'verified_class' => '',

    'verified_default' => 0,

    'open_phone_verified' => 0,

    'open_card_verified' => 0,

    /**
     * 调用阿里云市场个人认证接口的配置信息
     */
    'app_code'           => '',
    'app_url'            => '',

    /**
     * 接口认证要素  2.姓名，身份证号  3.姓名，身份证号，手机号
     */
    'key_element'        => 2,

];
