<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class api extends CI_Controller{
	const CONTROLLER_DIR = './application/controllers';

	public function __construct(){
		parent::__construct();

		$this->load->helper('url');
	}

	public function index(){

		if($_REQUEST['active_controller'] == 'DEEM'){
			$base_url = 'https://optimus-qa.deemgroundapp.com/';
		}else{
            $base_url = 'http://www.alamo-stage.co.kr/gateApiLive.php/';
		}

        $view_data = array(
            'base_url' => $base_url,
            'api_list' => $this->_get_api_list(),
            'active_controller' => ($_REQUEST['active_controller'] == '') ? 'DEEM' : $_REQUEST['active_controller']
        );
        $view_data['api_detail'] = $this->_get_api_detail($view_data);
        $this->load->view('/plugin/api/api_v', $view_data);
	}

	private function _get_api_list(){
		$controller_arr = array(
			'DEEM' => array(
				'CarSVCAuthorization' => array(
                    'method_name' => 'CarSVCAuthorization',
                    'url_parameter' => '/Token/',
                    'parameter' => array(
                        'ClientIdentifier' => 'Client Identifier',
                        'ClientSecret' => 'Client Secret',
                        'Scopes' => 'ProviderSearch,Booking,Customer',
                        'AccessOrigin' => '*',
                    ),
                    'header' => array(
                    	'Accept' => 'application/vnd.deem.Authorization.v1.1+json',
                        'X-Rearden-SecCtx' => htmlspecialchars('{"sess":{"id":"SessionID"},"eff":{"ref":"auth"},"auth":{"id":"UserID","type":"e","ext":{"s":"EntityCode","p":"EntityCode"}}}'),
						'Accept-Language' => 'en-US',
						'Content-Type' => 'application/json',
						'EntityCode' => 'Entity Code',
						'ClientAppID' => 'Client App ID',
					),
                    'call_type' => 'POST',
                    'description' => 'access token 생성',
				),
				'CarSVCProvider' => array(
                    'method_name' => 'CarSVCProvider',
                    'url_parameter' => '/provider',
                    'parameter' => array(
                        'ServiceClass' => 'SEDAN',
                        'OnDemand' => false,
                        'PickUpLocation' => array(
                        	'IsMeetAndGreet' => false,
                            'PickUpDateTime' => '2019-5-26T14:29-05:00',
                            'LocationType' => 1,
                            'Address' => array(
                                'AddressLine1' => '333 Meadowlands Parkway',
                                'PostalCode' => '07094',
                                'CityName' => 'Secaucus',
                                'StateCode' => 'NJ',
                                'CountryCode' => 'US'
                            ),
                            'Latitude' => 40.790013,
                            'Longitude' => -74.062078
						),
                        'DropOffLocation' => array(
                            'AsDirected' => false,
                            'LocationType' => 1,
                            'Address' => array(
                                'AddressLine1' => '187 Zabriskie St',
                                'PostalCode' => '07307',
                                'CityName' => 'Jersey City',
                                'StateCode' => 'NJ',
                                'CountryCode' => 'US'
                            ),
                            'Latitude' => 40.748176,
                            'Longitude' => -74.058633
                        ),
                        'NumberOfPassengers' => 2,
                        'RequestedHours' => 0
                    ),
                    'header' => array(
                        'Accept' => 'application/vnd.deem.Provider.v1.1+json',
                        'X-Rearden-SecCtx' => htmlspecialchars('{"sess":{"id":"SessionID"},"eff":{"ref":"auth"},"auth":{"id":"UserID","type":"e","ext":{"s":"EntityCode","p":"EntityCode"}}}'),
                        'Accept-Language' => 'en-US',
                        'Content-Type' => 'application/json',
                        'FirstName' => 'Test',
                        'LastName' => 'Reservation',
                        'EntityCode' => 'EntityCode',
                        'ClientAppID' => 'ClientAppID',
                        'Authorization' => 'AccessToken',
                    ),
                    'call_type' => 'POST',
                    'description' => '요금검색(A Street to Street)',
				),
				'CarSVCBooking' => array(
                    'method_name' => 'CarSVCBooking',
                    'url_parameter' => '/Booking',
                    'parameter' => array(
                        'OnDemand' => false,
                        'Booker' => array(
                            'FirstName' => 'Test',
                            'LastName' => 'Booker',
                            'DayPhone' => '010-9582-8912',
                            'DayPhoneExt' => '010-9582-8912',
                            'CellPhone' => '010-9582-8912',
                            'EmailAddress' => 'jiho@alamo.co.kr',
                        ),
                        'Passenger' => array(
                            'FirstName' => 'Test',
                            'LastName' => 'Passenger',
                            'DayPhone' => '010-9582-8912',
                            'DayPhoneExt' => '010-9582-8912',
                            'CellPhone' => '010-9582-8912',
                            'EmailAddress' => 'jiho@alamo.co.kr',
                            'PNRNumber' => 'ABCDE0',
                            'GDSSystem' => 'SABRE'
                        ),
                        'OtherPassengers' => array(
                            0 => array(
                                'FirstName' => 'ADD',
                                'LastName' => 'Passenger 1'
                            ),
                            1 => array(
                                'FirstName' => 'ADD',
                                'LastName' => 'Passenger 2'
                            ),
                        ),
                        'Accounting' => array(
                            'TripReason' => 'Attending Tech Conference',
                            'AccountingFields' => array(
                                0 => array(
                                    'FieldNumber' => 1,
                                    'FieldTypeCode' => 'COST',
                                    'FieldLabel' => 'Cost Center',
                                    'FieldValue' => 'CC450'
                                ),
                                1 => array(
                                    'FieldNumber' => 2,
                                    'FieldTypeCode' => 'DEPT',
                                    'FieldLabel' => 'Dept Code',
                                    'FieldValue' => 'DCS'
                                ),
                            )
                        ),
                        'Billing' => array(
                            'PaymentTypeCode' => 'CC',
                            'CreditCardTypeCode' => 'VI',
                            'AccountNumber' => '4111111111111111',
                            'ExpirationMonth' => '12',
                            'ExpirationYear' => '2020',
                            'FirstNameOnCard' => 'Test',
                            'LastNameOnCard' => 'Passenger',
                            'BillingStreetAddress' => '333 Meadowlands Parkway',
                            'BillingCityName' => 'Secaucus',
                            'BillingStateProvCode' => 'NJ',
                            'BillingPostalCode' => '07094',
                            'BillingCountryCode' => 'US'
                        ),
                        'ProviderSearchId' => 'ProviderSearchID',
                        'SpecialRequests' => 'Test Special Requests',
                        'PickupInstructions' => 'Test Pickup Instructions',
                        'DropOffInstructions' => 'Test Dropoff Instructions'
                    ),
                    'header' => '',
                    'call_type' => 'POST',
                    'description' => '',
				),
				'carSVCCustomer' => array(
                    'method_name' => 'carSVCCustomer',
                    'url_parameter' => '',
                    'parameter' => '',
                    'header' => '',
                    'call_type' => 'POST',
                    'description' => '',
				),
			),
            'ALAMO' => array(
                'OTA_VehAvailRateRQ' => array(
                    'method_name' => 'OTA_VehAvailRateRQ',
                    'url_parameter' => '',
                    'parameter' => array(
                        'pickUpLocation' => 'HNLO71',
                        'returnLocation' => 'HNLO71',
                        'pickUpDateTime' => date('Y-m-d', strtotime( "+1 day" ))  . 'T12:00:00',
                        'returnDateTime' => date('Y-m-d', strtotime( "+2 day" )) . 'T12:00:00',
                        'rateQualifier' => '',
                        'ic' => '300083',
                        'airCode' => '',
                        'airMemId' => '',
                        'emcNo' => '',
                        'promotionCode' => '',
                        'vendor' => 'AL',
                    ),
                    'call_type' => 'POST',
                    'description' => '차량리스트조회',
                ),
                'OTA_VehRetResRQ' => array(
                    'method_name' => 'OTA_VehRetResRQ',
                    'url_parameter' => '',
                    'parameter' => array(
                        'uniqueId' => '',
                        'surname' => '',
                        'givenName' => '',
                        'ic' => '',
                        'pickUpDateTime' => date('Y-m-d') . 'T12:00:00',
                        'pickUpLocation' => '',
                        'vendor' => 'AL'
                    ),
                    'call_type' => 'POST',
                    'description' => '예약조회',
                )
            )
		);

		return $controller_arr;
	}

	private function _get_api_detail($datas){
        $apiLists = $datas['api_list'];
		$apiDetail = array();

		foreach ($apiLists as $apiKey => $apiList) {
			if($datas['active_controller'] != $apiKey) continue;
			foreach ($apiList as $apiFunction) {
                array_push($apiDetail, array(
                    'method_name' => $apiFunction['method_name'],
                    'url_parameter' => $apiFunction['url_parameter'],
                    'parameter' => $apiFunction['parameter'],
                    'header' => $apiFunction['header'],
                    'call_type' => $apiFunction['call_type'],
                    'description' => $apiFunction['description'],
                ));
            }
        }

        //debug($apiDetail);

	    return $apiDetail;
	}


    /**
     * @param $params
     */
    public function call(){
        $url = $_POST['url'];
        $type = ($_POST['type'] == 'POST') ? 1 : 0;
        foreach ($_POST['headers'] as $key => $val){
        	$headers[] = $key . ': ' . $val;
        }
        $parameter = ($_POST['service'] == "DEEM") ? json_encode($_POST['parameter']) : $this->setAlamoParams($_POST['parameter']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, $type); //0이 default 값이며 POST 통신을 위해 1로 설정해야 함
		if($type == 1) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter); //POST로 보낼 데이터 지정하기
        }
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err_no = curl_errno($ch);

        $resultArray = array(
            'res' => $result,
            'req' => $parameter,
            'header' => $headers,
            'info' => $info,
            'err_no' => $err_no,
        );

		if($info['http_code'] != 200){
			$info['err_no'] = $err_no;
            echo json_encode($resultArray);
		}else {
            echo json_encode($resultArray);
        }
	}

    /**
     * @param $parameter
     * @return bool|string
     */
    function setAlamoParams($parameter)
    {
        $this->load->library('api/res');
        $r = New Res();
        $param = (object)$parameter;

        $method = end(explode("/", $_REQUEST['url']));

        if ($method == 'OTA_VehAvailRateRQ') {
            $r->getListOfAvailRate($param);
        } else if($method == 'OTA_VehRetResRQ'){
            $r->getInfoOfReservation($param);
        }
        $body = substr($r->req, strpos($r->req, "<soapenv"));
        return $body;
    }

}

?>
















