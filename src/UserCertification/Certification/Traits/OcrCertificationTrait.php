<?php

namespace MrwangTc\UserCertification\Certification\Traits;

use GuzzleHttp\Client;

trait OcrCertificationTrait
{

    public function ocrVerified($image, $type)
    {
        $apiUrl    = config('usercertification.open_ocr_url');
        $AppID     = config('usercertification.open_ocr_appid');
        $SecretKey = config('usercertification.open_ocr_secretkey');
        if (empty($apiUrl)) {
            $this->setErrorMessage('请配置接口地址');

            return false;
        }
        if (empty($AppID)) {
            $this->setErrorMessage('请配置接口AppID');

            return false;
        }
        if (empty($SecretKey)) {
            $this->setErrorMessage('请配置接口SecretKey');

            return false;
        }
        $access = $this->getAccess($AppID, $SecretKey);
        if ($access === false) {
            $this->setErrorMessage('access_token不正确');

            return false;
        }
        $token  = $access->access_token;
        $result = $this->getOcr($apiUrl, $token, $image, $type);
        if (($result['error_code'] ?? 0) == 100) {
            $this->setErrorMessage($result['error_msg'] ?? '未知错误');

            return false;
        } else {
            return $result;
        }
    }

    protected function getAccess($AppID, $SecretKey)
    {
        $authUrl = 'https://aip.baidubce.com/oauth/2.0/token';
        try {
            $Client   = new Client();
            $response = $Client->post($authUrl, [
                'query' => [
                    'grant_type'    => 'client_credentials',
                    'client_id'     => $AppID,
                    'client_secret' => $SecretKey,
                ],
            ]);
            $result   = json_decode($response->getBody()->getContents());

            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function getOcr($url, $token, $image, $type)
    {
        $url    = $url . '?access_token=' . $token;
        $params = [
            'url'          => $image,
            'id_card_side' => $type,
        ];
        try {
            $Client   = new Client();
            $response = $Client->post($url, ['form_params' => $params]);
            $result   = json_decode($response->getBody()->getContents(), true);

            return $result;
        } catch (\Exception $e) {
            return false;
        }
    }

}