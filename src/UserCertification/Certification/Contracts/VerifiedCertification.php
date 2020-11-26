<?php

namespace MrwangTc\UserCertification\Certification\Contracts;

interface VerifiedCertification
{
    public function autoVerified($keys);

    public function ocrVerified($keys);
}