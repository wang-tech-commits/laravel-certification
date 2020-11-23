<?php

namespace MrwangTc\UserCertification\Certification\Traits;

use Illuminate\Database\Eloquent\Relations\HasOne;
use MrwangTc\UserCertification\Certification\Models\UserCertification;

trait UserHasCertification
{
    public function userCertification() :HasOne
    {
        return $this->hasOne(UserCertification::class);
    }

    public function getIsVerifiedAttribute()
    {
        return $this->userCertification && ($this->userCertification->verified == 1);
    }

    public function nickname($value)
    {
        $result = $this->info()->update([
            'nickname' => $value,
        ]);
        return $result;
    }
}
