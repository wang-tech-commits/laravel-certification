<?php

namespace MrwangTc\UserCertification\Certification\Requests;

use Illuminate\Contracts\Validation\Rule;

class IdCardRule implements Rule
{
    public function passes($attribute, $value)
    {
        if (strlen($value) !== 18) {
            return false;
        }

        return $this->isIdCard($value);
    }

    private function isIdCard($id)
    {
        $id        = strtoupper($id);
        $regx      = "/(^\d{17}([0-9]|X)$)/";
        $arr_split = [];
        if (!preg_match($regx, $id)) {
            return false;
        }

        $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
        @preg_match($regx, $id, $arr_split);
        $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
        if (!strtotime($dtm_birth)) {
            return false;
        }

        $arr_int = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
        $arr_ch  = ['1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'];
        $sign    = 0;
        for ($i = 0; $i < 17; $i++) {
            $b    = (int)$id{$i};
            $w    = $arr_int[$i];
            $sign += $b * $w;
        }
        $n       = $sign % 11;
        $val_num = $arr_ch[$n];

        return !($val_num !== substr($id, 17, 1));
    }

    /**
     * 获取校验错误信息
     * @return string
     */
    public function message()
    {
        return '身份证号码校验错误';
    }
}
