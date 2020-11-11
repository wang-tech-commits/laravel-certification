<?php

return [

    /**
     * 关联用户模型
     */
    'user_model' => App\Models\User::class,

    /**
     * 专门用作实名验证的类  eg : 'verified_class' => new UserCertification(),
     */
    'verified_class' => '',

    'verified_default' => 0,

    'open_phone_verified' => 0,

    'open_card_verified' => 0,

];
