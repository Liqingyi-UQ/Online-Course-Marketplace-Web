<?php

namespace App\ThirdParty;

class Recaptcha
{
    //Reference; WingZero, "Natural Language Processing Notes" 2020. [Online].
    // Available: https://tools.wingzero.tw/article/sn/489. Accessed: Apr. 27, 2023.
    //Using API recaptcha API to check the robot or not
    public function check_Response($response)
    {
        $key = '6Lc_faElAAAAAJyP6Izf8sD5u026T4T76LPuhkV3';
        $recaptchaURL = 'https://www.google.com/recaptcha/api/siteverify';
        $Userresponse = json_decode(file_get_contents($recaptchaURL . '?secret=' . $key . '&response=' . $response));
        return $Userresponse->success;
    }
}