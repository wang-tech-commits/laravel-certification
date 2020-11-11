<?php

namespace MrwangTc\UserCertification\Certification\Controller;

use Illuminate\Routing\Controller;
use Jason\Api;
use Jason\Api\Traits\ApiResponse;
use MrwangTc\UserCertification\Certification\Models\UserCertification;
use MrwangTc\UserCertification\Certification\Requests\UserCertificationRequest;
use MrwangTc\UserCertification\Certification\Resources\CertificationResource;

class UserCertificationController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $user = Api::user();

        return $this->success(new CertificationResource($user->userCertification));
    }

    public function store(UserCertificationRequest $request)
    {
        $user = Api::user();
        if ($user->is_verified) {
            return $this->failed('用户已认证');
        }
        $result = UserCertification::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'name'        => $request->name,
            'id_card'     => $request->id_card,
            'phone'       => $request->phone ?? '',
            'front_card'  => $request->front_card ?? '',
            'back_card'   => $request->back_card ?? '',
        ]);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->failed('操作失败');
        }
    }
}
