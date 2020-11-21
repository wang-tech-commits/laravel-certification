<?php

namespace MrwangTc\UserCertification\Certification\Controller;

use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Jason\Api;
use Jason\Api\Traits\ApiResponse;
use MrwangTc\UserCertification\Certification\Contracts\VerifiedCertification;
use MrwangTc\UserCertification\Certification\Models\UserCertification;
use MrwangTc\UserCertification\Certification\Requests\UserCertificationRequest;
use MrwangTc\UserCertification\Certification\Resources\CertificationResource;

class UserCertificationController extends Controller
{

    use ApiResponse;

    public function index()
    {
        $user = Api::user();
        if (!$user->userCertification) {
            return $this->success('暂无认证记录');
        }
        return $this->success(new CertificationResource($user->userCertification));
    }

    public function store(UserCertificationRequest $request)
    {
        $user = Api::user();
        if ($user->is_verified) {
            return $this->failed('用户已认证');
        }
        $apiCheck = config('usercertification.open_api_verify');
        $instance = config('usercertification.verified_class');
        if ($apiCheck === true) {
            if ($instance instanceof VerifiedCertification) {
                $keys = [
                    'name' => $request->name,
                ];
                if (config('usercertification.is_three_key_element') === true) {
                    $keys = Arr::add($keys, 'idcard', $request->id_card);
                    $keys = Arr::add($keys, 'mobile', $request->phone);
                } else {
                    $keys = Arr::add($keys, 'idCard', $request->id_card);
                }
                $verified = $instance->autoVerified($keys);
            } else {
                $verified = config('usercertification.verified_default');
            }
            if (!$verified) {
                return $this->failed($instance->getErrorMessage(), 422);
            }
        } else {
            $verified = 1;
        }

        $result = UserCertification::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'name'       => $request->name,
            'id_card'    => $request->id_card,
            'phone'      => $request->phone ?? '',
            'front_card' => $request->front_card ?? '',
            'back_card'  => $request->back_card ?? '',
            'verified'   => $verified,
        ]);
        if ($result) {
            return $this->success('操作成功');
        } else {
            return $this->failed('操作失败');
        }
    }

}
