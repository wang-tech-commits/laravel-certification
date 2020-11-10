<?php

namespace MrwangTc\UserCertification\Certification\Controller;

use MrwangTc\UserCertification\Certification\Models\UserCertification;
use MrwangTc\UserCertification\Certification\Requests\UserCertificationRequest;
use Illuminate\Routing\Controller;
use Jason\Api;
use Jason\Api\Traits\ApiResponse;

class UserCertificationController extends Controller
{
    use ApiResponse;

    public function store(UserCertificationRequest $request)
    {
        $result = UserCertification::updateOrCreate([
            'user_id' => Api::id(),
        ], [
            'name'        => $request->name,
            'id_card'     => $request->id_card,
            'front_card'  => $request->front_card,
            'back_card'   => $request->back_card,
        ]);
        if($result){
            return $this->success('操作成功');
        }
    }
}
