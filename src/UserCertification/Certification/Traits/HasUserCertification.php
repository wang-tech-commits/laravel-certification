<?php

namespace MrwangTc\UserCertification\Certification\Traits;

use MrwangTc\UserCertification\Certification\Models\UserCertification;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasUserCertification
{
    public function userCertification() :HasOne
    {
        return $this->hasOne(UserCertification::class);
    }

    public function getIsUserCertificationAttribute()
    {
        if ($this->userCertification && $this->userCertification->verified == 1) {
            return true;
        } else {
            return false;
        }
    }
}
