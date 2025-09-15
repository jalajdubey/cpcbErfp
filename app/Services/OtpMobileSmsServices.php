<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;


class OtpMobileSmsServices
{
	
	//code for sms.......................................................................

	public function send_sms_otp_direct($mobileno, $otp)
	{

		//$mobileno = $mobile;
		$registerid = "2";
		$otp = '123456';
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
