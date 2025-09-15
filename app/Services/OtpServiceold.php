<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\Mail\OtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    public function generateAndSendOtp($user)
    {
        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,  // Store the OTP directly without encryption
            'otp_expires_at' => now()->addMinutes(10)  // Set expiration time
        ]);
        Mail::to($user->email)->send(new OtpMail($otp));
    }

    public function verifyOtp($user, $inputOtp)
    {
        return $user->otp === $inputOtp && $user->otp_expires_at > now();
    }

    // public function validateOTP(User $user, $otp)
    // {
    //     return $user->otp === $otp && now()->lessThanOrEqualTo($user->otp_expires_at);
    // }
    public function send_sms_otp_direct($mobile, $otp)
    {
        $mobileno = $mobile;
        $registerid = "2";
        $sms_otp = $otp;
        $message = $sms_otp . "  is the one-time password (OTP) for Login on EPR Battery Management Portal https://www.eprbatterycpcb.in/. This OTP is usable only once and is valid for 5 Mins. Regards CPCB";
        $templateid = "1307170575863910203";
        $secure_key = "c85e39a181e7b904f784c018c4042ede";
        $username = "CPCB_IT";
        $password = "Cpcbsms#2020";
        $senderid = "CPCBWM";
        $deptSecureKey = "51920f80-bc87-4d53-adaa-fb0226f47fa4";
        $encryp_password = sha1(trim($password));

        if ($message == "" || $mobile == "" || $templateid == "") {
            return false;
        } else {
            $result = $this->sendSingleSMS($username, $encryp_password, $senderid, $message, $mobileno, $deptSecureKey, $templateid, $sms_otp, $registerid); // calling sendSingleSMS to configuire the sms settings

            return $result;
        }
    }

    function sendSingleSMS($username, $encryp_password, $senderid, $message, $mobileno, $deptSecureKey, $templateid, $sms_otp, $registerid)
    {
        $key = hash('sha512', trim($username) . trim($senderid) . trim($message) . trim($deptSecureKey));
        $data = array(
            "username" => trim($username),
            "password" => trim($encryp_password),
            "senderid" => trim($senderid),
            "content" => trim($message),
            "smsservicetype" => "singlemsg",
            "mobileno" => trim($mobileno),
            "key" => trim($key),
            "templateid" => trim($templateid)
        );
        $dataAPi = $this->post_to_url("https://msdgweb.mgov.gov.in/esms/sendsmsrequestDLT", $data); //calling post_to_url to send sms
        return $dataAPi;
    }

    // function to send sms using by making http connection
    function post_to_url($url, $data)
    {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . urlencode($value) . '&';
        }
        rtrim($fields, '&');
        $post = curl_init();
        curl_setopt($post, CURLOPT_SSLVERSION, 6); // use for systems supporting TLSv1.2 or comment the line
        curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($post); //result from mobile seva server
        curl_close($post);
        return $result;
    }

    // jalaj generate and verify mobilesms otp 02-09-2025
    public function generateMobileOtp(User $user)
    {
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
            'last_otp_sent_at' => Carbon::now(),
        ]);

        return $otp;
    }

    public function verifyMobileOtp(User $user, $otp)
    {
        if ($user->otp === $otp && $user->otp_expires_at > Carbon::now()) {
            // OTP is valid
            $user->update(['otp' => null]); // clear OTP after success
            return true;
        }
        return false;
    }
}
