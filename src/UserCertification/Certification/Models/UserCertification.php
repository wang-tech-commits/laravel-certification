<?php

namespace MrwangTc\UserCertification\Certification\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use MrwangTc\UserCertification\Certification\Contracts\VerifiedCertification;
use MrwangTc\UserCertification\Certification\Traits\CertificationTrait;

class UserCertification extends Model implements VerifiedCertification
{
    use CertificationTrait,
        DefaultDatetimeFormat;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($certification) {
            $instance = config('usercertification.verified_class');
            if ($instance instanceof VerifiedCertification) {
                $certification->verified = $instance->autoVerified();
            } else {
                $certification->verified = config('usercertification.verified_default');
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(config('usercertification.user_model'));
    }
}
