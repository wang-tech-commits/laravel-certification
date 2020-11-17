<?php

namespace MrwangTc\UserCertification\Certification\Traits;

use GuzzleHttp\Client;

trait CertificationTrait
{
    protected $params = [];

    protected $header = [];

    public function autoVerified($keys)
    {
        $this->check($keys);
    }

    protected function check($keys)
    {
        $apiUrl = config('usercertification.app_url');
        $this->setParams($keys);
        $this->setHeaders();
        $result = $this->dopost($apiUrl);
        try {
            if ($result->code == 0 && $result->message == '成功') {
                if ($result->result->res == 1) {
                    return true;
                } else {
                    return '信息' . $result->result->description;
                }
            } else {
                return '信息' . $result->result->description;
            }
        } catch (\Exception $e) {
            return $result;
        }
    }

    protected function setParams($keys)
    {
        $this->params = $keys;
    }

    protected function setHeaders()
    {
        $this->header = [
            "Authorization" => 'APPCODE ' . config('usercertification.app_code'),
            "Accept"        => "application/json",
        ];
    }

    protected function dopost($url)
    {
        try {
            $Client   = new Client();
            $response = $Client->post($url, ['query' => $this->params, 'headers' => $this->header]);
            $result   = json_decode($response->getBody()->getContents());
            return $result;
        } catch (\Exception $e) {
            preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $e->getmessage(), $cn_name);
            return $cn_name[0][0];
        }
    }
}