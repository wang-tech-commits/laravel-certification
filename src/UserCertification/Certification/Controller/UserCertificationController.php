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
        $apiCheck    = config('usercertification.open_api_verify');
        $instance    = config('usercertification.verified_class');
        $apiOcrCheck = config('usercertification.open_ocr_verify');
        if ($apiOcrCheck === true) {
            if ($instance instanceof VerifiedCertification) {
                $verified = $instance->ocrVerified(\Storage::url($request->front_card), 'front');
                if (!$verified) {
                    return $this->failed($instance->getErrorMessage(), 422);
                } else {
                    if ($verified['words_result']['姓名']['words'] != $request->name) {
                        return $this->failed('图片与填写信息不符');
                    }
                    if ($verified['words_result']['公民身份号码']['words'] != $request->id_card) {
                        return $this->failed('图片与填写信息不符');
                    }
                }
                $verified = $instance->ocrVerified(\Storage::url($request->back_card), 'back');
                if (!$verified) {
                    return $this->failed($instance->getErrorMessage(), 422);
                }
            }
        }
        if ($apiCheck === true) {
            if ($instance instanceof VerifiedCertification) {
                $keys = [
                    'name'   => $request->name,
                    'idcard' => $request->id_card,
                ];
                if (config('usercertification.is_three_key_element') === true) {
                    $keys = Arr::add($keys, 'mobile', $request->phone);
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
            $user->nickname($request->name);

            return $this->success('操作成功');
        } else {
            return $this->failed('操作失败');
        }
    }

}
