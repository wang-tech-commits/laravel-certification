<?php

namespace MrwangTc\UserCertification\Certification\Traits;

use GuzzleHttp\Client;

trait CertificationTrait
{
    protected $params = [];

    protected $header = [];

    protected $errorMessage = '';

    public function autoVerified($keys)
    {
        return $this->check($keys);
    }

    protected function check($keys)
    {
        $apiUrl = config('usercertification.app_url');
        if (empty($apiUrl)) {
            $this->setErrorMessage('请配置接口地址');
            return false;
        }
        $apiCode = config('usercertification.app_code');
        if (empty($apiCode)) {
            $this->setErrorMessage('请配置接口Code');
            return false;
        }
        if (config('usercertification.is_three_key_element') === true) {
            if (count($keys) != 3) {
                $this->setErrorMessage('要素不匹配');
                return false;
            }
        }
        $this->setParams($keys);
        $this->setHeaders();
        $result = $this->dopost($apiUrl);
        try {
            if (config('usercertification.is_three_key_element') === true) {
                if ($result->code == 0 && $result->message == '成功') {
                    if ($result->result->res == 1) {
                        return true;
                    } else {
                        $this->setErrorMessage('信息' . $result->result->description);
                        return false;
                    }
                } else {
                    $this->setErrorMessage('信息' . $result->result->description);
                    return false;
                }
            } else {
                if ($result->code == 200 && $result->success === true) {
                    if ($result->data->result == 0) {
                        return true;
                    } else {
                        $this->setErrorMessage($result->data->desc);
                        return false;
                    }
                } else {
                    $this->setErrorMessage($result->msg);
                    return false;
                }
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
            $Client = new Client();
            switch (config('usercertification.request_method')) {
                case 'get':
                    $response = $Client->get($url, ['query' => $this->params, 'headers' => $this->header]);
                    break;
                case 'post':
                    $response = $Client->post($url, ['query' => $this->params, 'headers' => $this->header]);
                    break;
                default:
                    $this->setErrorMessage('不允许的请求方式');
                    return false;
                    break;
            }
            $result = json_decode($response->getBody()->getContents());
            return $result;
        } catch (\Exception $e) {
            preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $e->getmessage(), $cn_name);
            $this->setErrorMessage($cn_name[0][0]);
            return false;
        }
    }

    protected function setErrorMessage($message)
    {
        $this->errorMessage = $message;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}