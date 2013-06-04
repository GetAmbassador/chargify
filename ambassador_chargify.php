<?php

class Ambassador_chargify {

	private
		$debug          = false,
		$api_url        = '',
		$username		= '',	// ENTER YOUR USERNAME HERE
		$api_key		= '',	// ENTER YOUR API_KEY HERE
		$campaign_uid	= '';	// ENTER YOUR CAMPAIGN UID HERE

	public function __construct($debug = false, $campaign_uid = null) {

		if (!function_exists('curl_init')) {
			echo 'Error: CURL PHP extension is required';
		}

		if (!function_exists('json_decode')) {
			echo 'Error: JSON PHP extension is required.';
		}

		$this->debug = $debug;

		if (!is_null($campaign_uid)) {
			$this->campaign_uid = $campaign_uid;
		}

		if (!empty($this->username) && !empty($this->api_key)) {
			$this->api_url = "https://getambassador.com/api/v2/$this->username/$this->api_key/json/";
		}
	}

	public function renewal($payload = null, $event = null) {

		if (is_null($payload)) {

			if (isset($_POST['payload'])) {

				$payload = $_POST['payload'];
			}
		}

		if (is_null($event)) {

			if (isset($_POST['event'])) {
				
				$event = $_POST['event'];
			}
		}

		if ($event === 'renewal_success') {

			$data = array(
				'campaign_uid' => $this->campaign_uid,
				'revenue' => $payload['subscription']['balance_in_cents']/100,
				'email'	=> $payload['subscription']['customer']['email'],
				'first_name' => $payload['subscription']['customer']['first_name'],
				'last_name' => $payload['subscription']['customer']['last_name'],
				'auto_create' => 0
			);
			
			$data = http_build_query($data);

			$curl_handle = curl_init();
			curl_setopt($curl_handle, CURLOPT_URL, $this->api_url.'event/record');
			curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
			$result = curl_exec($curl_handle);
			curl_close($curl_handle);

			if ($this->debug) {
				$result = json_decode($result, true);
				var_dump($result);
			}
		}
	}
}

?>
