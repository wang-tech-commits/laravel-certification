<?php

namespace MrwangTc\UserCertification\Certification\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class UserCertification extends Model
{
    use DefaultDatetimeFormat;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($certification) {
            $certification->verified = 1;
        });
    }
    public function user()
    {
        return $this->belongsTo(config('usercertification.user_model'));
    }
}
