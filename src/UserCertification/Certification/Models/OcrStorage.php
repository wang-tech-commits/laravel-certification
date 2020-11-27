<?php

namespace MrwangTc\UserCertification\Certification\Models;

use Illuminate\Database\Eloquent\Model;

class OcrStorage extends Model
{

    protected $casts = [
        'results' => 'array',
    ];

}