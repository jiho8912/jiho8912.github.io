<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class api extends CI_Controller{
	const CONTROLLER_DIR = './application/controllers';
    var $session_id;
    var $EntityCode = '32967';
    var $ClientAppID = 'TMKOREA.T';
    var $ClientIdentifier = 'FHSJ3VPZ-KG5M-VWZD-PGU8-R36KF2LMQFNQ';
    var $ClientSecret = 'bSG6W88mCxf4gAwTREmSzHAU';
    var $UserID = 'TMK';

	public function __construct(){
		parent::__construct();

		$this->load->helper('url');
        $this->load->library('session');
	}

	public function index(){

        $this->session_id = $this->session->userdata('session_id');

        if($this->input->get('active_controller') == ''){
            $active_controller = 'RCCL';
        }else{
            $active_controller = $this->input->get('active_controller');
        }

        $base_url = $this->setBaseUrl($active_controller);

        $view_data = array(
            'base_url' => $base_url,
            'api_list' => $this->getApiList(),
            'active_controller' => $active_controller
        );
        $view_data['api_detail'] = $this->getApiDetail($view_data);
        $this->load->view('/plugin/api/api_v', $view_data);
	}

    private function setBaseUrl($controllerName){

        $url_Array = array(
            'DEEM' => 'https://optimus-qa.deemgroundapp.com/',
            'ALAMO' => 'http://www.alamo-stage.co.kr/gateApiLive.php/',
            'RCCL' => 'http://www.rccl-stage.co.kr/gateApiLive.php?act=/',
            'KaKao' => 'https://kapi.kakao.com/v1/push/'
        );

        $base_url = $url_Array[$controllerName];

        return $base_url;
    }

	private function setDeemHeader($method){

	    $SecCtx = array(
            'sess' => array(
                'id' => $this->session_id
            ),
            'eff' => array(
                'ref' => 'auth'
            ),
            'auth' => array(
                'id' => $this->UserID,
                'type' => 'e',
                'ext' => array(
                    's' => $this->EntityCode,
                    'p' => $this->EntityCode
                )
            )
        );

        $Accept = str_replace('carsvc' ,'', strtolower($method));
        $Accept = 'application/vnd.deem.' . $Accept . '.v1.1+json';

        $header = array(
            'Accept' => $Accept,
            'X-Rearden-SecCtx' => htmlspecialchars(json_encode($SecCtx)),
            'Accept-Language' => 'en-US',
            'Content-Type' => 'application/json',
            'EntityCode' => $this->EntityCode,
            'ClientAppID' => $this->ClientAppID
        );

        if($method != 'CarSVCAuthorization'){
            $header['Authorization'] = '';
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
                        'ClientIdentifier' => 'FHSJ3VPZ-KG5M-VWZD-PGU8-R36KF2LMQFNQ',
                        'ClientSecret' => 'bSG6W88mCxf4gAwTREmSzHAU',
                        'Scopes' => 'ProviderSearch,Booking,Customer',
                        'AccessOrigin' => '*',
                    ),
                    'header' => $this->setDeemHeader('CarSVCAuthorization'),
                    'call_type' => 'POST',
                    'description' => 'access token 생성',
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/CarSVCAuthorization/Help'
				),
				'CarSVCprovider' => array(
                    'method_name' => 'CarSVCprovider',
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
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/CarSVCProvider/Help'
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
                            'DayPhoneExt' => '12345',
                            'CellPhone' => '010-9582-8912',
                            'EmailAddress' => 'jiho@alamo.co.kr',
                        ),
                        'Passenger' => array(
                            'FirstName' => 'Test',
                            'LastName' => 'Passenger',
                            'DayPhone' => '010-9582-8912',
                            'DayPhoneExt' => '12345',
                            'CellPhone' => '010-9582-8912',
                            'EmailAddress' => 'jiho@alamo.co.kr',
                            'PNRNumber' => 'ABCDE0',
                            'GDSSystem' => 'SABRE'
                        ),
                        'OtherPassengers' => array(
                            array(
                                'FirstName' => 'Add',
                                'LastName' => 'Passenger 1'
                            ),
                            array(
                                'FirstName' => 'Add',
                                'LastName' => 'Passenger 2'
                            ),
                        ),
                        'Accounting' => array(
                            'TripReason' => 'Attending Tech Conference',
                            'AccountingFields' => array(
                                array(
                                    'FieldNumber' => 1,
                                    'FieldTypeCode' => 'COST',
                                    'FieldLabel' => 'Cost Center',
                                    'FieldValue' => 'CC450'
                                ),
                                array(
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
                        'ProviderSearchId' => '462A-073A209-1076-003E-01',
                        'SpecialRequests' => 'Test Special Requests',
                        'PickupInstructions' => 'Test Pickup Instructions',
                        'DropOffInstructions' => 'Test Dropoff Instructions'
                    ),
                    'header' => $this->setDeemHeader('CarSVCBooking'),
                    'call_type' => 'POST',
                    'description' => '예약하기',
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/CarSVCBooking/Help/Api/POST-Booking'
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
                            'DayPhoneExt' => '12345',
                            'CellPhone' => '010-9582-8912',
                            'EmailAddress' => 'jiho@alamo.co.kr',
                        ),
                        'Passenger' => array(
                            'FirstName' => 'Test',
                            'LastName' => 'Passenger',
                            'DayPhone' => '010-9582-8912',
                            'DayPhoneExt' => '12345',
                            'CellPhone' => '010-9582-8912',
                            'EmailAddress' => 'jiho@alamo.co.kr',
                            'PNRNumber' => 'ABCDE0',
                            'GDSSystem' => 'SABRE'
                        ),
                        'OtherPassengers' => array(
                            array(
                                'FirstName' => 'ADD',
                                'LastName' => 'Passenger 1'
                            ),
                            array(
                                'FirstName' => 'ADD',
                                'LastName' => 'Passenger 2'
                            ),
                        ),
                        'Accounting' => array(
                            'TripReason' => 'Attending Tech Conference',
                            'AccountingFields' => array(
                                array(
                                    'FieldNumber' => 1,
                                    'FieldTypeCode' => 'COST',
                                    'FieldLabel' => 'Cost Center',
                                    'FieldValue' => 'CC450'
                                ),
                                array(
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
                        'ProviderSearchId' => '462A-073A209-1076-003E-01',
                        'SpecialRequests' => 'Test Special Requests',
                        'PickupInstructions' => 'Test Pickup Instructions',
                        'DropOffInstructions' => 'Test Dropoff Instructions'
                    ),
                    'header' => $this->setDeemHeader('CarSVCBooking'),
                    'call_type' => 'PUT',
                    'description' => '예약수정',
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/CarSVCBooking/Help/Api/PUT-Booking-reservationId'
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
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/CarSVCBooking/Help/Api/GET-Booking-reservationId-Status'
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
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/CarSVCBooking/Help/Api/DELETE-Booking-reservationId'
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
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/CarSVCBooking/Help/Api/GET-Booking-reservationId'
                ),
                'CarSVCCustomer' => array(
                    'method_name' => 'CarSVCCustomer',
                    'url_parameter' => array(
                        'Customer' => false,
                        'customerId' => true,
                        'groupId' => true,
                        'providerCode' => 'EHI',
                        'billing' => false
                    ),
                    'header' => $this->setDeemHeader('CarSVCCustomer'),
                    'call_type' => 'GET',
                    'description' => '고객API',
                    'help_url' => 'https://optimus-qa.deemgroundapp.com/carSVCCustomer/Help'
                ),
			),
            'ALAMO' => array(
                'PingRQ' => array(
                    'method_name' => 'PingRQ',
                    'url_parameter' => '',
                    'parameter' => array(
                        'EchoData' => 'THIS IS A PING TEST'
                    ),
                    'call_type' => 'POST',
                    'description' => '핑테스트',
                ),
                'VehAvailRateRQ' => array(
                    'method_name' => 'VehAvailRateRQ',
                    'url_parameter' => '',
                    'parameter' => array(
                        'pickUpLocation' => 'HNLO71',
                        'returnLocation' => 'HNLO71',
                        'pickUpDateTime' => date('Y-m-d', strtotime( "+1 day" ))  . 'T12:00:00',
                        'returnDateTime' => date('Y-m-d', strtotime( "+2 day" )) . 'T12:00:00',
                        'rateQualifier' => 'AL : 300083 , NL : 5030370',
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
                'CruiseCategoryAvailRQ' => array(
                    'method_name' => 'CategoryList',
                    'url_parameter' => '',
                    'parameter' => array(
                        'sailDate' => '03/01/2020',
                        'packageId' => 'EC14F089',
                        'adultAmt' => '1',
                        'childAmt' => '0',
                        'cabinType' => '2',
                        'silver' => '0',
                        'isNRD' => false
                    ),
                    'call_type' => 'POST',
                    'description' => '크루즈 가격 리스트 요청',
                    'help_url' => '/plugin/api/viewManual?fileName=RCL Cruise FIT Spec 5.2.pdf#page=86'
                ),
                'CruisePriceBookingRQ' => array(
                    'method_name' => 'BookingPrice',
                    'url_parameter' => '',
                    'parameter' => array(
                        'sailDate' => '03/01/2020',
                        'categoryCode' => 'c1',
                        'fareCode' => 'F4890114',
                        'shipCode' => 'EC',
                        'cabinNumber' => '',
                        'packageId' => 'EC14F089',
                        'adultAmt' => '1',
                        'childAmt' => '0',
                        'isNRD' => false,
                        'promotionCode' => ''
                    ),
                    'call_type' => 'POST',
                    'description' => '크루즈 예약 가격 요청',
                    'help_url' => '/plugin/api/viewManual?fileName=RCL Cruise FIT Spec 5.2.pdf#page=158'
                ),
                'CruiseFareAvailRQ' => array(
                    'method_name' => 'FareList',
                    'url_parameter' => '',
                    'parameter' => array(
                        'Start' => '03/01/2020',
                        'ShipCode' => 'EC',
                        'adultAmt' => '1',
                        'childAmt' => '0',
                        'packageCode' => 'EC14F089',
                    ),
                    'call_type' => 'POST',
                    'description' => '크루즈 프로모션 리스트 요청',
                    'help_url' => '/plugin/api/viewManual?fileName=RCL Cruise FIT Spec 5.2.pdf#page=144'
                )
            )
            /*
            'KaKao' => array(
                'register' => array(
                    'method_name' => 'register',
                    'url_parameter' => '',
                    'parameter' => array(
                        'uuid' => '',
                        'device_id' => '',
                        'push_type' => '',
                        'push_token' => ''
                    ),
                    'call_type' => 'POST',
                    'description' => '푸시 토큰 등록',
                    'header' => array(
                        'Authorization' => 'KaKaoAK cb6cf9726679d522b858f5a8f1d27f5d'
                    ),
                )
            )
            */
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
                    'help_url' => $apiFunction['help_url']
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
        $url = $this->input->post('url');
        $type = $this->input->post('type');
        foreach ($this->input->post('headers') as $key => $val){
        	$headers[] = $key . ': ' . $val;
        }

        if($this->input->post('service') == 'DEEM'){
            $parameter = $this->input->post('parameter');
        }else if($this->input->post('service') == 'ALAMO'){
            $parameter = $this->setAlamoParams(json_decode($this->input->post('parameter')));
        }else{ // RCCL
            $parameter = $this->setRcclParams(json_decode($this->input->post('parameter')));
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type); // call 타입 get,post,put,delete
		if(strtoupper($type != 'GET')) {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $parameter); //POST로 보낼 데이터 지정하기
        }
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
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
        } else if($method == 'PingRQ'){
            $r->getPingTest($param);
        }

        $body = substr($r->req, strpos($r->req, "<soapenv"));
        return $body;
    }

    /**
     * @param $parameter
     * @return bool|string
     */
    function setRcclParams($parameter)
    {
        $this->load->library('rcclApi/res');
        $this->load->library('rcclApi/Common');
        $r = New Res();
        $param = (array)$parameter;

        $method = end(explode("/", $_REQUEST['url']));
        if ($method == 'CategoryList') {
            $params = Array(
                $param['sailDate'],
                $param['packageId'],
                $param['adultAmt'],
                $param['childAmt'],
                $param['cabinType'],
                $param['silver'],
                $param['isNRD']
            );
            $r->getCategoryList($params);
        }else if($method == 'BookingPrice'){
            $params = Array(
                $param['sailDate'],
                $param['categoryCode'],
                $param['fareCode'],
                $param['shipCode'],
                $param['cabinNumber'],
                '',
                $param['packageId'],
                $param['adultAmt'],
                $param['childAmt'],
                '',
                $param['isNRD'],
                $param['promotionCode']
            );
            $r->getBookingPrice($params);
        }else if($method == 'FareList'){
            $r->getFareList($param);
        }

        $body = substr($r->req, strpos($r->req, "<soapenv"));
        return $body;
    }

    function viewManual()
    {
        $filePath = $_SERVER['DOCUMENT_ROOT'] .'/upload/';
        $fileName = $this->input->get('fileName');
        if(file_exists($filePath . $fileName))
        {
            header("Content-type:application/pdf");
            header("Content-Transfer-Encoding: binary") ;
            Header("Content-Length: ".(string)(filesize($filePath . $fileName))) ;
            header("Cache-Control: no-cache, must-revalidate");
            header('Pragma: no-cache');
            header("Expires: 0");
            ob_clean();
            flush();
            readfile($filePath . $fileName);
        }else{
            echo 'exist no file';
        }
    }


}

?>
















