<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Request;


class OtpService
{
    // public function generateAndSendOtp($user)
    // {
    //     $otp = rand(100000, 999999);
    //     $user->update([
    //         'otp' => $otp,  // Store the OTP directly without encryption
    //         'otp_expires_at' => now()->addMinutes(10)  // Set expiration time
    //     ]);
    //    Mail::to($user->email)->send(new OtpMail($otp));
      
    // }


//     public function generateAndSendOtp($user)
// {
//     // Generate random 6-digit OTP
//     $otp = rand(100000, 999999);
//     $mobileno=$user->mobile_no;
//     // Save OTP & expiry in DB
//     $user->update([
//         'otp' => $otp,
//         'otp_expires_at' => now()->addMinutes(10),
//     ]);

//     // 1. Send OTP on Email
//     try {
//         Mail::to($user->email)->send(new OtpMail($otp));
//     } catch (\Exception $e) {
//         Log::error("Failed to send OTP Email: ".$e->getMessage());
//     }

//     // 2. Send OTP on Mobile using your existing function
//     try {
//         $this->send_sms_otp_direct($mobileno, $otp);
//     } catch (\Exception $e) {
//         Log::error("Failed to send OTP SMS: ".$e->getMessage());
//     }

//     return true;
// }


public function RegGenerateAndSendOtp($mobile_no, $email, $policy)
{
    // Generate random 6-digit OTP
    $otp = rand(100000, 999999);
    // $mobileno=$mobile_no;

	 $cacheKey = "otp_" . md5($mobile_no . $email . $policy);

     // Encrypt OTP before storing in DB
     $encryptedOtp = Crypt::encryptString($otp);
    // Store OTP in cache for 5 minutes
    Cache::put($cacheKey, $encryptedOtp, now()->addMinutes(5));

    // Save encrypted OTP & expiry
    // $user->update([
    //     'otp' => $encryptedOtp,
    //     'otp_expires_at' => now()->addMinutes(10),
    // ]);

    // 1. Send OTP on Email (plain)
    // try {
    //     Mail::to($user->email)->send(new OtpMail($otp));
    // } catch (\Exception $e) {
    //     Log::error("Failed to send OTP Email: " . $e->getMessage());
    // }

    // 2. Send OTP on Mobile (plain)
    try {
		if(isset($mobile_no)&& $mobile_no!=''){
			$this->send_sms_otp_direct( $mobile_no, $otp);
			return true;
		}else{
			return false;
		}
    } catch (\Exception $e) {
        Log::error("Failed to send OTP SMS: " . $e->getMessage());
		return false;
    }

    
}
public function RegverifyOtp(Request $request){
       $otp     = $request->input('otp');
        $mobile  = $request->input('mobile');
        $email   = $request->input('email');
        $policy  = $request->input('policy');

        $cacheKey = "otp_" . md5($mobile . $email . $policy);

        $cachedOtp = Cache::get($cacheKey);

        if (!$cachedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired or not found'
            ]);
        }

        if ($otp == $cachedOtp) {
            // OTP is correct → mark as verified
            Cache::forget($cacheKey); // remove OTP after successful verification

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP'
        ]);
    }
    // }

public function generateAndSendOtp($user)
{
    // Generate random 6-digit OTP
    $otp = rand(100000, 999999);
    $mobileno=$user->mobile_no;
    // Encrypt OTP before storing in DB
    $encryptedOtp = Crypt::encryptString($otp);

    // Save encrypted OTP & expiry
    $user->update([
        'otp' => $encryptedOtp,
        'otp_expires_at' => now()->addMinutes(10),
    ]);

    // 1. Send OTP on Email (plain)
    try {
        Mail::to($user->email)->send(new OtpMail($otp));
    } catch (\Exception $e) {
        Log::error("Failed to send OTP Email: " . $e->getMessage());
    }

    // 2. Send OTP on Mobile (plain)
    try {
        $this->send_sms_otp_direct( $mobileno, $otp);
    } catch (\Exception $e) {
        Log::error("Failed to send OTP SMS: " . $e->getMessage());
    }

    return true;
}



//     public function verifyOtp($user, $inputOtp)
// {

//     return $user->otp === $inputOtp && $user->otp_expires_at > now();
// }

public function verifyOtp($user, $inputOtp)
{
    if (!$user->otp || !$user->otp_expires_at) {
        return false; // No OTP generated
    }

    // Check expiry
    if (now()->greaterThan($user->otp_expires_at)) {
        return false; // OTP expired
    }

    // Decrypt stored OTP
    $storedOtp = Crypt::decryptString($user->otp);

    // Compare with user input
    return $storedOtp == $inputOtp;
}



    // public function validateOTP(User $user, $otp)
    // {
    //     return $user->otp === $otp && now()->lessThanOrEqualTo($user->otp_expires_at);
    // }
    public function send_sms_otp_direct($mobileno, $otp)
	{

		//$mobileno = $mobile;
		$registerid = "2";
		
		$message = "Dear User, Your OTP for signing up on the ELV EPR Portal is " . $otp . ". Please enter this code to proceed with the signup process. Do not share this OTP with anyone. Regards, CPCB.";
		$templateid = "1307175188767634262";
		$secure_key = "c85e39a181e7b904f784c018c4042ede";
		$entity_id = "1301158798803147760";
		$username = "CPCB_IT";
		$password = "Cpcbsms#2020";
		$senderid = "CPCBEL";
		//$deptSecureKey = "51920f80-bc87-4d53-adaa-fb0226f47fa4";
		$deptSecureKey = "106a9ed9-00c4-442d-a857-3447d308c9d9";
		$encryp_password = sha1(trim($password));

		if ($message == "" || $mobileno == "" || $templateid == "") {

			// $this->session->set_flashdata('error', 'All the fields are mandatory.');
			return false;
		} else {

			$result = $this->sendSingleSMS($username, $encryp_password, $senderid, $message, $mobileno, $deptSecureKey, $templateid, $otp, $registerid, $entity_id); // calling sendSingleSMS to configuire the sms settings
			return $result;
		}
	}

	public function send_sms_otp_direct_edit($mobileno, $otp)
	{
		$registerid = "2";
		$message = "Dear User, Your OTP for signing up on the ELV EPR Portal is " . $otp . ". Please enter this code to proceed with the signup process. Do not share this OTP with anyone. Regards, CPCB.";
		$templateid = "1307175188767634262";
		$entity_id = "1301158798803147760";
		$secure_key = "c85e39a181e7b904f784c018c4042ede";
		$username = "CPCB_IT";
		$password = "Cpcbsms#2020";
		$senderid = "CPCBEL";
		// $dept_secure_key = "106a9ed9-00c4-442d-a857-3447d308c9d9"
		$deptSecureKey = "106a9ed9-00c4-442d-a857-3447d308c9d9";
		$encryp_password = sha1(trim($password));

		if ($message == "" || $mobileno == "" || $templateid == "") {
			return false;
		} else {
			$result = $this->sendSingleSMS($username, $encryp_password, $senderid, $message, $mobileno, $deptSecureKey, $templateid, $otp, $registerid, $entity_id);
			return $result;
		}
	}

	// Function to send single sms
	function sendSingleSMS($username, $encryp_password, $senderid, $message, $mobileno, $deptSecureKey, $templateid, $otp, $registerid, $entity_id)
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
		// $user = User::where('mobile','=',$req->mobile)->update(['otp' => $otp]);
		//   $updated = $this->login_model->updateOtpLogin($update_data, $registerid);

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
		//curl_setopt($post, CURLOPT_SSLVERSION, 5); // uncomment for systems supporting TLSv1.1 only
		curl_setopt($post, CURLOPT_SSLVERSION, 6); // use for systems supporting TLSv1.2 or comment the line
		curl_setopt($post, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($post, CURLOPT_URL, $url);
		curl_setopt($post, CURLOPT_POST, count($data));
		curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
		curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($post); //result from mobile seva server
		//   $this->db->insert('sms_log', array('sms_result' => $result));

		// print_r($result); //output from server displayed
		curl_close($post);
		return $result;
	}



}
