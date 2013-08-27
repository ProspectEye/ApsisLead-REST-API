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

	$userId = 0;
	if(isset($data->userid))
		$userId = $data->userid;

	$data = getSettings($userId);
	print_r($data);

	$data = getFilter();
	print_r($data);

	$data = getVisits();
	print_r($data);	

	$data = getLeads();
	print_r($data);		

	$data = getVisitSearch("ProspectEye AB");
	print_r($data);		

	$data = getCompanyType();
	print_r($data);

	$data = getTriggers(NULL, 4);
	print_r($data);
	exit();

	$data = getTriggers();
	print_r($data);

	$data = getEvents(0/*TriggerId*/,NULL/*EventId*/,0/*bWithPageview*/);
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
		return GET("visits/aftervisit", array("limit" => 1, "step" => 0));
	}

	function getVisitDetails($visitId) {
		return GET("visits/details/$visitId", NULL);
	}

	function getLeads() {
		return GET("visits/lead", NULL);	
	}

	function getVisitSearch($sQuery) {
		return GET("visits/search", array("query" => $sQuery));	
	}

	function getCompanyType() {
		return GET("companytype", NULL);
	}

	function getSettings($userId = 0) {
		$sUrl = "settings";
		if($userId > 0) {
			$sUrl .= "/$userId";
		}

		return GET($sUrl, NULL);
	}

	function getTriggers($triggerId = 0, $type = NULL) {
		$sUrl = "trigger";
		if($triggerId > 0) {
			$sUrl .= "/$triggerId";
		}

		$params = NULL;
		if($type != NULL) {
			$params = array("type" => $type);
		}
		return GET($sUrl, $params);	
	}

	function getEvents($triggerId = 0, $eventId = NULL, $bWithPageview = 0) {
		$sUrl = "event";
		if($triggerId > 0) {
			$sUrl .= "/$triggerId";
		}

		$params = array();
		if($eventId != NULL) {
			$params["eventid"] = $eventId;
		}
		if($bWithPageview != NULL) {
			$params["withpageview"] = $bWithPageview;
		}		
		return GET($sUrl, $params);	
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