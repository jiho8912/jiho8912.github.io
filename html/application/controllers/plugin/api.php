<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class api extends CI_Controller{
	const CONTROLLER_DIR = './application/controllers';

	public function __construct(){
		parent::__construct();

		$this->load->helper('url');
	}

	public function index(){

        $base_url = $this->setBaseUrl($_REQUEST['active_controller']);

        $view_data = array(
            'base_url' => $base_url,
            'api_list' => $this->getApiList(),
            'active_controller' => ($_REQUEST['active_controller'] == '') ? 'DEEM' : $_REQUEST['active_controller']
        );
        $view_data['api_detail'] = $this->getApiDetail($view_data);
        $this->load->view('/plugin/api/api_v', $view_data);
	}

    private function setBaseUrl($controllerName){
        if($controllerName == 'DEEM'){
            $base_url = 'https://optimus-qa.deemgroundapp.com/';
        }else if($controllerName == 'ALAMO'){
            $base_url = 'http://www.alamo-stage.co.kr/gateApiLive.php/';
        }else{
            $base_url = 'http://localhost/';
        }

        return $base_url;
    }

	private function setDeemHeader($method){
        $header = array(
            'Accept' => 'application/vnd.deem.Authorization.v1.1+json',
            'X-Rearden-SecCtx' => htmlspecialchars('{"sess":{"id":"SessionID"},"eff":{"ref":"auth"},"auth":{"id":"UserID","type":"e","ext":{"s":"EntityCode","p":"EntityCode"}}}'),
            'Accept-Language' => 'en-US',
            'Content-Type' => 'application/json',
            'EntityCode' => 'Entity Code',
            'ClientAppID' => 'Client App ID'
        );

        if($method != 'CarSVCAuthorization'){
            $header['Authorization'] = 'AccessToken from Token response';
        }

        if($method == 'CarSVCProvider'){
            $header['FirstName'] = 'Test';
            $header['LastName'] = 'Reservation';
        }

        return $header;
    }
	
	private function getApiList(){
		$controller_arr = array(
			'DEEM' => array(
				'CarSVCAuthorization' => array(
                    'method_name' => 'CarSVCAuthorization',
                    'url_parameter' => array(
                        'Token' => false
                    ),
                    'parameter' => array(
                        'ClientIdentifier' => 'Client Identifier',
                        'ClientSecret' => 'Client Secret',
                        'Scopes' => 'ProviderSearch,Booking,Customer',
                        'AccessOrigin' => '*',
                    ),
                    'header' => $this->setDeemHeader('CarSVCAuthorization'),
                    'call_type' => 'POST',
                    'description' => 'access token 생성',
				),
				'CarSVCProvider' => array(
                    'method_name' => 'CarSVCProvider',
                    'url_parameter' => array(
                        'provider' => false
                    ),
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
                    'header' => $this->setDeemHeader('CarSVCProvider'),
                    'call_type' => 'POST',
                    'description' => '요금검색(A Street to Street)',
				),
				'CarSVCBooking_POST' => array(
                    'method_name' => 'CarSVCBooking_POST',
                    'url_parameter' => array(
                        'Booking' => false
                    ),
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
                    'header' => $this->setDeemHeader('CarSVCBooking'),
                    'call_type' => 'POST',
                    'description' => '예약하기',
				),
                'CarSVCBooking_PUT' => array(
                    'method_name' => 'CarSVCBooking_PUT',
                    'url_parameter' => array(
                        'Booking' => false,
                        'ReservationID' => true
                    ),
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
                    'header' => $this->setDeemHeader('CarSVCBooking'),
                    'call_type' => 'PUT',
                    'description' => '예약수정',
                ),
                'CarSVCBooking_GET_STATUS' => array(
                    'method_name' => 'CarSVCBooking_GET_STATUS',
                    'url_parameter' => array(
                        'Booking' => false,
                        'ReservationID' => true,
                        'Status' => false
                    ),
                    'header' => $this->setDeemHeader('CarSVCBooking'),
                    'call_type' => 'GET',
                    'description' => '예약,차량 상태확인',
                ),
                'CarSVCBooking_DELETE' => array(
                    'method_name' => 'CarSVCBooking_DELETE',
                    'url_parameter' => array(
                        'Booking' => false,
                        'ReservationID' => true
                    ),
                    'header' => $this->setDeemHeader('CarSVCBooking'),
                    'call_type' => 'DELETE',
                    'description' => '예약 취소',
                ),
                'CarSVCBooking_GET_DETAIL' => array(
                    'method_name' => 'CarSVCBooking_GET_DETAIL',
                    'url_parameter' => array(
                        'Booking' => false,
                        'ReservationID' => true
                    ),
                    'header' => $this->setDeemHeader('CarSVCBooking'),
                    'call_type' => 'GET',
                    'description' => '예약세부정보확인',
                ),
                'CarSVCCustomer' => array(
                    'method_name' => 'CarSVCCustomer',
                    'url_parameter' => array(
                        'Customer' => false,
                        'customerId' => true,
                        'groupId' => true,
                        'providerCode' => true,
                        'billing' => false
                    ),
                    'header' => $this->setDeemHeader('CarSVCCustomer'),
                    'call_type' => 'GET',
                    'description' => '고객API',
                ),
			),
            'ALAMO' => array(
                'VehAvailRateRQ' => array(
                    'method_name' => 'VehAvailRateRQ',
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
                'VehRetResRQ' => array(
                    'method_name' => 'VehRetResRQ',
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
                ),
                'VehLocDetailRQ' => array(
                    'method_name' => 'VehLocDetailRQ',
                    'url_parameter' => '',
                    'parameter' => array(
                        'pickUpLocation' => 'HNLO71',
                        'ic' => '9H',
                        'vendor' => 'AL'
                    ),
                    'call_type' => 'POST',
                    'description' => '지점정보조회',
                )
            ),
            'RCCL' => array(
                'test' => array(
                    'method_name' => 'test',
                    'url_parameter' => '',
                    'parameter' => '',
                    'call_type' => 'POST',
                    'description' => '',
                )
            )
		);

		return $controller_arr;
	}

	private function getApiDetail($datas){
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
        $type = $_POST['type'];
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type); // call 타입 get,post,put,delete
		if(strtoupper($type != 'GET')) {
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

        echo json_encode($resultArray);
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

        if ($method == 'VehAvailRateRQ') {
            $r->getListOfAvailRate($param);
        } else if($method == 'VehRetResRQ'){
            $r->getInfoOfReservation($param);
        } else if($method == 'VehLocDetailRQ'){
            $r->getInfoLocDetail($param);
        }

        $body = substr($r->req, strpos($r->req, "<soapenv"));
        return $body;
    }

}

?>
















