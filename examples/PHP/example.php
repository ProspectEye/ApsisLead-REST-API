<?php

	$API_KEY = "ENTER_API_KEY_HERE";
	$ACCOUNT_ID = "ENTER_ACCOUNTID_HERE";

	DEFINE("REST_HOST","http://api.prospecteye.com/rest/");

	$data = getApiKey("your@email.com", "your_account_password_here");
	print_r($data);

	if(isset($data->apikey))
		$API_KEY = $data->apikey;
	
	if(isset($data->accountid))
		$ACCOUNT_ID = $data->accountid;

	$data = getFilter();
	print_r($data);	

	$data = getVisits();
	print_r($data);	

	$data = getCompanyType();
	print_r($data);	

	/* Fetch API-key and AccountId based on your login in ProspectEye */
	function getApiKey($usermail = "", $password = "") {
		return GET("apikey", array("usermail" => $usermail, "password" => $password));
	}

	/* Fetch filters for account */
	function getFilter($filterId = 0) {
		$sUrl = "filter";
		if($filterId > 0) {
			$sUrl .= "/$filterId";
		}

		return GET($sUrl, NULL);
	}

	function getVisits() {
		return GET("visits/aftervisit", array("limit" => 1));
	}

	function getCompanyType() {
		return GET("companytype", NULL);
	}	

	/* Helper function for GET-calls */
	function GET($sUrl, $params = NULL) {
		return request($sUrl, "GET", $params);
	}

	/* Helper function for all reqests (GET; POST; PUT; DELETE) */
	function request($sUrl, $sMethod, $params = NULL) {
		global $API_KEY, $ACCOUNT_ID;
		if($sMethod == "GET" && !is_null($params)) {
			$aParams = array();
			foreach ($params as $key => $value) {
				$aParams[] = "$key=$value";
			}
			if(count($aParams) > 0) {
				$sUrl .= "?" . implode("&", $aParams);
				$params = NULL;
			}
		}

	    $cUrl = curl_init();
	    curl_setopt($cUrl, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($cUrl, CURLOPT_HTTPAUTH,CURLAUTH_BASIC); 
	    curl_setopt($cUrl, CURLOPT_USERPWD, "$ACCOUNT_ID:$API_KEY"); 
	    curl_setopt($cUrl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
		curl_setopt($cUrl, CURLOPT_CUSTOMREQUEST, $sMethod);

		/*if($data != "" && $data != NULL)
			curl_setopt($cUrl, CURLOPT_POSTFIELDS,http_build_query($data));*/

	    curl_setopt($cUrl, CURLOPT_URL, REST_HOST . $sUrl);         
	    $sResponse = curl_exec($cUrl);
	    curl_close($cUrl);   

	    return json_decode($sResponse);
	}

	function printLog($sLog) {
		echo "$sLog\n";
	}

?>