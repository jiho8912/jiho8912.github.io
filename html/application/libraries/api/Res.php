<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/Req.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ResVehAvailRateBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ResVehResBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ResVehModifyBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ResVehCancelBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ResVehLocDetailBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ItemVehChargeBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ItemFeeBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ItemMsgBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ItemCoverageBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ItemVehBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ItemSpEquipmentBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ResVehRetResBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ErrorBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/comm/DB.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ReqVehAvailRateBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ReqVehResBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ReqVehRetResBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ReqVehModifyBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/beans/ReqVehCancelBean.php" ; ?>
<?
/** 크루즈 API 응답을 처리하는 클래스 **/
if(! class_exists("Res") )	{
	class Res extends Req
	{	

		var $res = "" ;
		var $isError = false ;
		var $isWarning = false;
		var $aWarning = array() ;
		var $aWarningMsg = array(); // warning 메세지만 담는 Array
		var $msg = "";

		var $errorBean = "" ;

		function Res($url)
		{
			$this->Req($url) ;
		}

		// XML 의 속성 값을 가져온다.
		function getA($node,$name)
		{
			$attrMap =  $node->attributes ;

			return ( $node == null ) ? "" : $attrMap->getNamedItem($name)->nodeValue ;
		}

		function getEs($node, $tagName)
		{
		    if($node != null) {
                return $node->getElementsByTagName($tagName);
            }else{
		        return null;
            }
		}

		function getE($node, $tagName)
		{

			$nodes = $this->getEs($node, $tagName) ;

			if( $nodes->length > 0 )
				return $nodes->item(0) ;
			else
				return null ;

		}

		function getEV($node, $tagName)
		{
			return $this->getE($node, $tagName)->nodeValue ;
		}

		function getEA($node, $tagName, $attrName)
		{
			return $this->getA( $this->getE($node, $tagName), $attrName ) ;
		}

		// DOM 리턴하기
		function getDom()
		{
			$dom = new DOMDocument() ;
			return $dom->loadXML($this->res) ;
		}

		// Child 가져오기
		function getChild($parent,$index)
		{
			$nlChild = $parent->childNodes ;

			if( $nlChild->length > $index )
				return $nlChild->item($index) ;
			else
				return null ;
		}
		
		/*
			이용가능한 차량 조회
		*/
		function getListOfAvailRate($param)
		{

			$this->res = parent::getListOfAvailRate($param) ;

			return $this->getListOfAvailRateByRes($this->res) ;
			/*
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$list = array() ;
			$vehAvailList = $this->getEs($dom, "VehAvail") ;


			foreach ($vehAvailList as $node)
			{
				$bean = new ResVehAvailRateBean() ;

				$bean->status = $this->getEA($node, "VehAvailCore", "Status") ;

				$bean->transmissionType = $this->getEA($node, "Vehicle", "TransmissionType") ;
				$bean->airConditionInd = $this->getEA($node, "Vehicle", "AirConditionInd") ;
				$bean->baggageQuantity = $this->getEA($node, "Vehicle", "BaggageQuantity") ;
				$bean->passengerQuantity = $this->getEA($node, "Vehicle", "PassengerQuantity") ;

				//dev lim 추가사항
				$bean->doorCount = $this->getEA($node, "VehType", "DoorCount") ;
				$bean->size = $this->getEA($node, "VehClass", "Size") ;
				$bean->corpDiscountNmbr = $this->getEA($node,"RateQualifier","CorpDiscountNmbr");

				// 수정
				$bean->vehCategory = $this->getEA($node, "VehType", "VehicleCategory") ;


				$bean->name = $this->getEA($node, "VehMakeModel", "Name") ;
				$bean->code = $this->getEA($node, "VehMakeModel", "Code") ;

				$bean->pictureUrl = $this->getEV($node, "PictureURL") ;

				$charge = $this->getEs($node, "VehicleCharge") ;
				foreach($charge as $chargeNode)
				{
					$chargeBean = new ItemVehChargeBean() ;

					$chargeBean->amount = $this->getA($chargeNode, "Amount") ;
					$chargeBean->currencyCode = $this->getA($chargeNode, "CurrencyCode") ;
					$chargeBean->taxInclusive = $this->getA($chargeNode, "TaxInclusive") ;
					$chargeBean->purpose = $this->getA($chargeNode, "Purpose") ;
					$chargeBean->description = $this->getA($chargeNode, "Description") ;

					$chargeBean->unitCharge = $this->getEA($chargeNode, "Calculation", "UnitCharge" ) ;
					$chargeBean->quantity = $this->getEA($chargeNode, "Calculation", "Quantity" ) ;

					array_push($bean->vehCharges, $chargeBean) ;
				}

				$bean->rateTotalAmount = $this->getEA($node, "TotalCharge", "RateTotalAmount") ;
				$bean->estimatedTotalAmount = $this->getEA($node, "TotalCharge", "EstimatedTotalAmount") ;
				$bean->currencyCode = $this->getEA($node, "TotalCharge", "CurrencyCode") ;

				$fee = $this->getEs($node, "Fee") ;
				foreach($fee as $feeNode)
				{
					$feeBean = new ItemFeeBean() ;

					$feeBean->currencyCode = $this->getA($feeNode,"CurrencyCode") ;
					$feeBean->includedInRate = $this->getA($feeNode,"IncludedInRate") ;
					$feeBean->amount = $this->getA($feeNode,"Amount") ;
					$feeBean->description = $this->getA($feeNode,"Description") ;
					$feeBean->purpose = $this->getA($feeNode,"Purpose") ;

					array_push($bean->fees, $feeBean) ;
				}

				$bean->type = $this->getEA($node, "Reference", "Type") ;
				$bean->datetime = $this->getEA($node, "Reference", "DateTime") ;

				array_push($list, $bean) ;
			}

			return $list ;
			*/
		}

		/*
			이용가능한 차량 조회 (RES STRING)
		*/
		function getListOfAvailRateByRes($RES)
		{

			$dom = new DOMDocument() ;
			$dom->loadXML($RES) ;

			$list = array() ;
			$vehAvailList = $this->getEs($dom, "VehAvail") ;
			
			$this->validForError($dom, "VehAvail") ;	// ERROR 또는 WARNING CATCH

			foreach ($vehAvailList as $node) 
			{
				$bean = new ResVehAvailRateBean() ;

				$bean->status = $this->getEA($node, "VehAvailCore", "Status") ;
				
				$bean->transmissionType = $this->getEA($node, "Vehicle", "TransmissionType") ;
				$bean->airConditionInd = $this->getEA($node, "Vehicle", "AirConditionInd") ;
				$bean->baggageQuantity = $this->getEA($node, "Vehicle", "BaggageQuantity") ;
				$bean->passengerQuantity = $this->getEA($node, "Vehicle", "PassengerQuantity") ;
				
				//dev lim 추가사항
				$bean->doorCount = $this->getEA($node, "VehType", "DoorCount") ;
				$bean->size = $this->getEA($node, "VehClass", "Size") ;
				$bean->corpDiscountNmbr = $this->getEA($node,"RateQualifier","CorpDiscountNmbr");

				// 수정
				$bean->vehCategory = $this->getEA($node, "VehType", "VehicleCategory") ;


				$bean->name = $this->getEA($node, "VehMakeModel", "Name") ;
				$bean->code = $this->getEA($node, "VehMakeModel", "Code") ;

				$bean->pictureUrl = str_replace("assets.alamo.com/alamoData", "www.alamo.com/content/alamo/data", $this->getEV($node, "PictureURL")) ;

				$charge = $this->getEs($node, "VehicleCharge") ;
				foreach($charge as $chargeNode)
				{
					$chargeBean = new ItemVehChargeBean() ;

					$chargeBean->amount = $this->getA($chargeNode, "Amount") ;
					$chargeBean->currencyCode = $this->getA($chargeNode, "CurrencyCode") ;
					$chargeBean->taxInclusive = $this->getA($chargeNode, "TaxInclusive") ;
					$chargeBean->purpose = $this->getA($chargeNode, "Purpose") ;
					$chargeBean->description = $this->getA($chargeNode, "Description") ;

					$chargeBean->unitCharge = $this->getEA($chargeNode, "Calculation", "UnitCharge" ) ;
					$chargeBean->quantity = $this->getEA($chargeNode, "Calculation", "Quantity" ) ;

					array_push($bean->vehCharges, $chargeBean) ;
				}

				$bean->rateTotalAmount = $this->getEA($node, "TotalCharge", "RateTotalAmount") ;
				$bean->estimatedTotalAmount = $this->getEA($node, "TotalCharge", "EstimatedTotalAmount") ;
				$bean->currencyCode = $this->getEA($node, "TotalCharge", "CurrencyCode") ;

				$fee = $this->getEs($node, "Fee") ;
				foreach($fee as $feeNode)
				{
					$feeBean = new ItemFeeBean() ;

					$feeBean->currencyCode = $this->getA($feeNode,"CurrencyCode") ;
					$feeBean->includedInRate = $this->getA($feeNode,"IncludedInRate") ;
					$feeBean->amount = $this->getA($feeNode,"Amount") ;
					$feeBean->description = $this->getA($feeNode,"Description") ;
					$feeBean->purpose = $this->getA($feeNode,"Purpose") ;
					
					array_push($bean->fees, $feeBean) ;
				}

				$bean->type = $this->getEA($node, "Reference", "Type") ;
				$bean->datetime = $this->getEA($node, "Reference", "DateTime") ;

				// new api
				$bean->referenceID = $this->getEA($node, "Reference", "ID") ;
				// new api

				array_push($list, $bean) ;
			}

			return $list ;			
		}


		/*
			지역 상세 보기 (SpecialEquipment를 가져오는 부분)
		*/
		function getInfoLocDetail($param)
		{
			$this->res = parent::getInfoLocDetail($param) ;


			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$list = array() ;

			$bean = new ResVehLocDetailBean() ;

			// 지역정보 부분
			$locNode = $this->getE($dom, "LocationDetail") ;
			$bean->pickUpLocation = $this->getA($locNode, "Code") ;
			$bean->atAirport	  = $this->getA($locNode, "AtAirport") ; 
			$bean->name			  = $this->getA($locNode, "Name") ;

			// 주소부분
			$addrNodeList = $this->getEs($locNode, "AddressLine") ;
			foreach($addrNodeList as $addrNode)
			{
				array_push($bean->addressLine, $addrNode->nodeValue)	;	// addressLine
			}

			// 전화번호 부분
			$telNodeList	= $this->getEs($locNode, "Telephone") ;
			foreach($telNodeList as $telNode)
			{
				array_push($bean->phoneNumber, $this->getA($telNode,"PhoneNumber")) ;
			}

			// 차량 정보 담는 부분 - 사실상 AvailRate에서 조회한 내역이라서.. 중복됨(일단 담아둠)
			$vehNodeList = $this->getEs($dom, "Vehicle") ;
			foreach($vehNodeList as $vehNode)
			{
				$vehBean = new ItemVehBean() ;
				$vehBean->baggageQuantity	= $this->getA($vehNode,"BaggageQuantity") ;
				$vehBean->passengerQuantity = $this->getA($vehNode,"PassengerQuantity") ;
				$vehBean->airConditionInd	= $this->getA($vehNode,"AirConditionInd") ;
				$vehBean->transmissionType	= $this->getA($vehNode,"TransmissionType") ;

				$vehBean->category	= $this->getEA($vehNode, "VehType", "VehicleCategory") ;
				$vehBean->doorCount	= $this->getEA($vehNode, "VehType", "DoorCount") ;

				$vehBean->size		= $this->getEA($vehNode, "VehClass", "Size") ;
				$vehBean->name		= $this->getEA($vehNode, "VehMakeModel", "Name") ;
				$vehBean->code		= $this->getEA($vehNode, "VehMakeModel", "Code") ;

				$vehBean->pictureUrl = str_replace("assets.alamo.com/alamoData", "www.alamo.com/content/alamo/data", $this->getEV($vehNode, "PictureURL")) ;				

			}
			
			// SpecialEquipment 담는 부분
			$spNodeList = $this->getEs($dom, "SpecialEquipment") ;
			foreach($spNodeList as $spNode)
			{
				$spBean = new ItemSpEquipmentBean() ;
				$spBean->type			 = $this->getA($spNode,"Type") ;
				$spBean->guaranteedInd	 = $this->getEA($spNode, "EquipCharge", "GuaranteedInd") ;
				$spBean->includedInRate	 = $this->getEA($spNode, "EquipCharge", "IncludedInRate") ;
				$spBean->currencyCode	 = $this->getEA($spNode, "EquipCharge", "CurrencyCode") ;

				$calNodeList = $this->getEs($spNode, "Calculation") ;

				foreach($calNodeList as $calNode)
				{
					$unitName = $this->getA($calNode,"UnitName") ;
					$unitCharge = $this->getA($calNode,"UnitCharge") ;

					array_push($spBean->unitName, $unitName) ;
					array_push($spBean->unitCharge, $unitCharge) ;
				}


				array_push($bean->specialEquipments, $spBean) ;
			}

			array_push($list, $bean) ;

			return $list ;
		}

		/*
			렌터카 예약하기
		*/
		function insertReservation($param)
		{
			$this->res = parent::insertReservation($param) ;			
			$this->replaceFee($this->res,$param->rateQualifier,$param->pickUpLocation); //하와이 도심 요금 10불 인상

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$list = array() ;
			
			$vehResList = $this->getEs($dom, "VehReservation") ;

			$this->validForError($dom, "insertReservation") ;	// ERROR 또는 WARNING CATCH			

			foreach ($vehResList as $node) 
			{
				$bean = new ResVehResBean() ;

				$bean->givenName	= $this->getEV($node, "GivenName") ;
				$bean->surname		= $this->getEV($node, "Surname") ;
				$bean->phoneNumber	= $this->getEA($node, "Telephone", "PhoneNumber") ;
				$bean->email		= $this->getEV($node, "Email") ;
				$bean->type			= $this->getEA($node, "ConfID", "Type") ;
				$bean->Id			= $this->getEA($node, "ConfID", "ID") ;
				$bean->vendor		= $this->getEA($node, "Vendor", "Code") ;

				$bean->pickUpDateTime	= $this->getEA($node, "VehRentalCore", "PickUpDateTime") ;
				$bean->returnDateTime	= $this->getEA($node, "VehRentalCore", "ReturnDateTime") ;
				$bean->pickUpLocation	= $this->getEA($node, "PickUpLocation", "LocationCode") ;
				$bean->returnLocation	= $this->getEA($node, "ReturnLocation", "LocationCode") ;
				
				$bean->airConditionIdn	= $this->getEA($node, "Vehicle", "AirConditionInd") ;				
				$bean->transmissionType = $this->getEA($node, "Vehicle", "TransmissionType") ;
				$bean->baggageQuantity	= $this->getEA($node, "Vehicle", "BaggageQuantity") ;
				$bean->passengerQuantity = $this->getEA($node, "Vehicle", "PassengerQuantity") ;
				$bean->vehCategory		= $this->getEA($node, "VehType", "VehicleCategory") ;
				$bean->doorCount		= $this->getEA($node, "VehType", "DoorCount") ;
				$bean->size				= $this->getEA($node, "VehClass", "Size") ;
				$bean->code				= $this->getEA($node, "VehMakeModel", "Code") ;
				$bean->name				= $this->getEA($node, "VehMakeModel", "Name") ;
				$bean->pictureUrl = str_replace("assets.alamo.com/alamoData", "www.alamo.com/content/alamo/data", $this->getEV($node, "PictureURL")) ;

				$bean->vehiclePeriodUnitName	= $this->getEA($node, "RateDistance", "VehiclePeriodUnitName") ;
				$bean->distUnitName				= $this->getEA($node, "RateDistance", "DistUnitName") ;
				$bean->unlimited				= $this->getEA($node, "RateDistance", "Unlimited") ;
				
				$bean->arrivalNumber	= $this->getEA($node, "ArrivalDetails", "Number") ;
				$bean->arrivalCode	= $this->getEA($node, "OperatingCompany", "Code") ;

				$charge = $this->getEs($node, "VehicleCharge") ;
				foreach($charge as $chargeNode)
				{
					$chargeBean = new ItemVehChargeBean() ;

					$chargeBean->amount = $this->getA($chargeNode,  "Amount") ;
					$chargeBean->currencyCode = $this->getA($chargeNode,  "CurrencyCode") ;
					$chargeBean->taxInclusive = $this->getA($chargeNode,  "TaxInclusive") ;
					$chargeBean->purpose = $this->getA($chargeNode,  "Purpose") ;
					$chargeBean->description = $this->getA($chargeNode,  "Description") ;

					$chargeBean->unitCharge = $this->getEA($chargeNode, "Calculation", "UnitCharge" ) ;
					$chargeBean->quantity = $this->getEA($chargeNode, "Calculation", "Quantity" ) ;

					array_push($bean->vehCharges, $chargeBean) ;
				}

				$bean->rateQualifier = $this->getEA($node, "RateQualifier", "RateQualifier") ;
				
				
				// PricedEquip 담는 부분
				$spNodeList = $this->getEs($node, "PricedEquip") ;
				foreach($spNodeList as $spNode)
				{
					$spBean = new ItemSpEquipmentBean() ;
					$spBean->type			= $this->getEA($spNode, "Equipment", "EquipType") ;
					$spBean->quantity		= $this->getEA($spNode, "Equipment", "Quantity") ;
						
					$spBean->amount			 = $this->getEA($spNode, "Charge", "Amount") ;
					$spBean->guaranteedInd	 = $this->getEA($spNode, "Charge", "GuaranteedInd") ;
					$spBean->includedInRate	 = $this->getEA($spNode, "Charge", "IncludedInRate") ;
					$spBean->currencyCode	 = $this->getEA($spNode, "Charge", "CurrencyCode") ;
				
					array_push($bean->specialEquipments, $spBean) ;
				}

				$fee = $this->getEs($node, "Fee") ;
				foreach($fee as $feeNode)
				{
					$feeBean = new ItemFeeBean() ;

					$feeBean->currencyCode = $this->getA($feeNode,"CurrencyCode") ;
					$feeBean->includedInRate = $this->getA($feeNode,"IncludedInRate") ;
					$feeBean->amount = $this->getA($feeNode,"Amount") ;
					$feeBean->description = $this->getA($feeNode,"Description") ;
					$feeBean->purpose = $this->getA($feeNode,"Purpose") ;
					
					array_push($bean->fees, $feeBean) ;
				}

				$bean->rateTotalAmount = $this->getEA($node, "TotalCharge", "RateTotalAmount") ;
				$bean->estimatedTotalAmount = $this->getEA($node, "TotalCharge", "EstimatedTotalAmount") ;
				$bean->currencyCode = $this->getEA($node, "TotalCharge", "CurrencyCode") ;
				
				$msg = $this->getEs($node, "VendorMessage") ;
				foreach($msg as $msgNode)
				{
					$msgBean = new ItemMsgBean() ;

					$msgBean->title = $this->getA($msgNode, "Title") ;
					$msgBean->text = $this->getEV($msgNode,"Text") ;

					array_push($bean->msgs, $msgBean) ;
				}
				
				// 추가옵션 보험여부 확인 by woo
				$coverage = $this->getEs($node, "PricedCoverage") ;
				foreach($coverage as $coverageNode)
				{
					$chargeBean = new ItemCoverageBean() ;
				
					$chargeBean->required = $this->getA($coverageNode,  "Required") ;
				
					$chargeBean->code = $this->getEA($coverageNode, "Coverage", "Code" ) ;
				
					array_push($bean->coverages, $chargeBean) ;
				}

				array_push($list, $bean) ;				
			}

			return $list ;
		}

		/*
			예약 확인 하기
		*/
		function getInfoOfReservation($param, $retrieve = "")
		{
			$this->res = parent::getInfoOfReservation($param) ;
			$this->replaceFee($this->res,$param->rateQualifier,$param->pickUpLocation); //하와이 도심 요금 10불 인상

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$list = array() ;

			$vehResList = $this->getEs($dom, "VehReservation") ;
			

			$this->validForError($dom, "getInfoOfReservation", $retrieve) ;	// ERROR 또는 WARNING CATCH LIMHC  추가

			foreach ($vehResList as $node) 
			{
				$bean = new ResVehRetResBean() ;

				$bean->givenName	= $this->getEV($node, "GivenName") ;
				$bean->surname		= $this->getEV($node, "Surname") ;
				$bean->phoneNumber	= $this->getEA($node, "Telephone", "PhoneNumber") ;
				$bean->email		= $this->getEV($node, "Email") ;
				$bean->type			= $this->getEA($node, "ConfID", "Type") ;
				$bean->Id			= $this->getEA($node, "ConfID", "ID") ;
				$bean->vendor		= $this->getEA($node, "Vendor", "Code") ;

				$bean->pickUpDateTime	= $this->getEA($node, "VehRentalCore", "PickUpDateTime") ;
				$bean->returnDateTime	= $this->getEA($node, "VehRentalCore", "ReturnDateTime") ;
				$bean->pickUpLocation	= $this->getEA($node, "PickUpLocation", "LocationCode") ;
				$bean->returnLocation	= $this->getEA($node, "ReturnLocation", "LocationCode") ;
				
				$bean->airConditionIdn	= $this->getEA($node, "Vehicle", "AirConditionInd") ;				
				$bean->transmissionType = $this->getEA($node, "Vehicle", "TransmissionType") ;
				$bean->baggageQuantity	= $this->getEA($node, "Vehicle", "BaggageQuantity") ;
				$bean->passengerQuantity = $this->getEA($node, "Vehicle", "PassengerQuantity") ;
				$bean->vehCategory		= $this->getEA($node, "VehType", "VehicleCategory") ;
				$bean->doorCount		= $this->getEA($node, "VehType", "DoorCount") ;
				$bean->size				= $this->getEA($node, "VehClass", "Size") ;
				$bean->code				= $this->getEA($node, "VehMakeModel", "Code") ;
				$bean->name				= $this->getEA($node, "VehMakeModel", "Name") ;
				$bean->pictureUrl 		= str_replace("assets.alamo.com/alamoData", "www.alamo.com/content/alamo/data", $this->getEV($node, "PictureURL")) ;

				$bean->vehiclePeriodUnitName	= $this->getEA($node, "RateDistance", "VehiclePeriodUnitName") ;
				$bean->distUnitName				= $this->getEA($node, "RateDistance", "DistUnitName") ;
				$bean->unlimited				= $this->getEA($node, "RateDistance", "Unlimited") ;

				$charge = $this->getEs($node, "VehicleCharge") ;
				foreach($charge as $chargeNode)
				{
					$chargeBean = new ItemVehChargeBean() ;

					$chargeBean->amount = $this->getA($chargeNode,  "Amount") ;
					$chargeBean->currencyCode = $this->getA($chargeNode,  "CurrencyCode") ;
					$chargeBean->taxInclusive = $this->getA($chargeNode,  "TaxInclusive") ;
					$chargeBean->purpose = $this->getA($chargeNode,  "Purpose") ;
					$chargeBean->description = $this->getA($chargeNode,  "Description") ;

					$chargeBean->unitCharge = $this->getEA($chargeNode, "Calculation", "UnitCharge" ) ;
					$chargeBean->quantity = $this->getEA($chargeNode, "Calculation", "Quantity" ) ;

					array_push($bean->vehCharges, $chargeBean) ;
				}

				$bean->rateQualifier = $this->getEA($node, "RateQualifier", "RateQualifier") ;
				
				
				// PricedEquip 담는 부분
				$spNodeList = $this->getEs($node, "PricedEquip") ;
				foreach($spNodeList as $spNode)
				{
					$spBean = new ItemSpEquipmentBean() ;
					$spBean->type			= $this->getEA($spNode, "Equipment", "EquipType") ;
					$spBean->quantity		= $this->getEA($spNode, "Equipment", "Quantity") ;					
					
					$spBean->amount			 = $this->getEA($spNode, "Charge", "Amount") ;
					$spBean->guaranteedInd	 = $this->getEA($spNode, "Charge", "GuaranteedInd") ;
					$spBean->includedInRate	 = $this->getEA($spNode, "Charge", "IncludedInRate") ;
					$spBean->currencyCode	 = $this->getEA($spNode, "Charge", "CurrencyCode") ;
					
					// JP1026 요금제 추가옵션때문에
					if($bean->rateQualifier == "JP1026") {
						if($spBean->includedInRate == "true") continue;
						
						array_push($bean->specialEquipments, $spBean) ;
					}
					else {
						array_push($bean->specialEquipments, $spBean) ;
					}
					
				}


				$fee = $this->getEs($node, "Fee") ;
				foreach($fee as $feeNode)
				{
					$feeBean = new ItemFeeBean() ;

					$feeBean->currencyCode = $this->getA($feeNode,"CurrencyCode") ;
					$feeBean->includedInRate = $this->getA($feeNode,"IncludedInRate") ;
					$feeBean->amount = $this->getA($feeNode,"Amount") ;
					$feeBean->description = $this->getA($feeNode,"Description") ;
					$feeBean->purpose = $this->getA($feeNode,"Purpose") ;
					
					array_push($bean->fees, $feeBean) ;
				}

				$bean->rateTotalAmount = $this->getEA($node, "TotalCharge", "RateTotalAmount") ;
				$bean->estimatedTotalAmount = $this->getEA($node, "TotalCharge", "EstimatedTotalAmount") ;
				$bean->currencyCode = $this->getEA($node, "TotalCharge", "CurrencyCode") ;
				
				$msg = $this->getEs($node, "VendorMessage") ;
				foreach($msg as $msgNode)
				{
					$msgBean = new ItemMsgBean() ;

					$msgBean->title = $this->getA($msgNode,  "Title") ;
					$msgBean->text = $this->getEV($msgNode,"Text") ;

					array_push($bean->msgs, $msgBean) ;
				}

				array_push($list, $bean) ;				
			}

			return $list ;
		}
		
		
		/*
			예약 확인 하기 (RES)
		*/
		function getInfoOfReservationByRes($RES)
		{
			$list = array() ;		

			//xml이 없을 경우 페이지 에러 표출되어 없을 경우 예외처리 dev.na 2014-01-09
			if($RES == null || $RES == "")
			{
				return $list;
			}

			$dom = new DOMDocument() ;
			$dom->loadXML($RES) ;


			$vehResList = $this->getEs($dom, "VehReservation") ;

			$this->validForError($dom, "getInfoOfReservationByRes") ;	// ERROR 또는 WARNING CATCH LIMHC  추가

			foreach ($vehResList as $node) 
			{
				$bean = new ResVehRetResBean() ;

				$bean->givenName	= $this->getEV($node, "GivenName") ;
				$bean->surname		= $this->getEV($node, "Surname") ;
				$bean->phoneNumber	= $this->getEA($node, "Telephone", "PhoneNumber") ;
				$bean->email		= $this->getEV($node, "Email") ;
				$bean->type			= $this->getEA($node, "ConfID", "Type") ;
				$bean->Id			= $this->getEA($node, "ConfID", "ID") ;
				$bean->vendor		= $this->getEA($node, "Vendor", "Code") ;

				$bean->pickUpDateTime	= $this->getEA($node, "VehRentalCore", "PickUpDateTime") ;
				$bean->returnDateTime	= $this->getEA($node, "VehRentalCore", "ReturnDateTime") ;
				$bean->pickUpLocation	= $this->getEA($node, "PickUpLocation", "LocationCode") ;
				$bean->returnLocation	= $this->getEA($node, "ReturnLocation", "LocationCode") ;
				
				$bean->airConditionIdn	= $this->getEA($node, "Vehicle", "AirConditionInd") ;				
				$bean->transmissionType = $this->getEA($node, "Vehicle", "TransmissionType") ;
				$bean->baggageQuantity	= $this->getEA($node, "Vehicle", "BaggageQuantity") ;
				$bean->passengerQuantity = $this->getEA($node, "Vehicle", "PassengerQuantity") ;
				$bean->vehCategory		= $this->getEA($node, "VehType", "VehicleCategory") ;
				$bean->doorCount		= $this->getEA($node, "VehType", "DoorCount") ;
				$bean->size				= $this->getEA($node, "VehClass", "Size") ;
				$bean->code				= $this->getEA($node, "VehMakeModel", "Code") ;
				$bean->name				= $this->getEA($node, "VehMakeModel", "Name") ;
				$bean->pictureUrl 		= str_replace("assets.alamo.com/alamoData", "www.alamo.com/content/alamo/data", $this->getEV($node, "PictureURL")) ;

				$bean->vehiclePeriodUnitName	= $this->getEA($node, "RateDistance", "VehiclePeriodUnitName") ;
				$bean->distUnitName				= $this->getEA($node, "RateDistance", "DistUnitName") ;
				$bean->unlimited				= $this->getEA($node, "RateDistance", "Unlimited") ;

				$charge = $this->getEs($node, "VehicleCharge") ;
				foreach($charge as $chargeNode)
				{
					$chargeBean = new ItemVehChargeBean() ;

					$chargeBean->amount			= $this->getA($chargeNode,  "Amount") ;
					$chargeBean->currencyCode = $this->getA($chargeNode,  "CurrencyCode") ;
					$chargeBean->taxInclusive = $this->getA($chargeNode,  "TaxInclusive") ;
					$chargeBean->purpose = $this->getA($chargeNode,  "Purpose") ;
					$chargeBean->description = $this->getA($chargeNode,  "Description") ;



					$chargeBean->unitCharge = $this->getEA($chargeNode, "Calculation", "UnitCharge" ) ;
					$chargeBean->quantity = $this->getEA($chargeNode, "Calculation", "Quantity" ) ;

					array_push($bean->vehCharges, $chargeBean) ;
				}

				$bean->rateQualifier = $this->getEA($node, "RateQualifier", "RateQualifier") ;
				
				
				// PricedEquip 담는 부분
				$spNodeList = $this->getEs($node, "PricedEquip") ;
				foreach($spNodeList as $spNode)
				{
					$spBean = new ItemSpEquipmentBean() ;
					$spBean->type			= $this->getEA($spNode, "Equipment", "EquipType") ;
					$spBean->quantity		= $this->getEA($spNode, "Equipment", "Quantity") ;					
					
					$spBean->amount			 = $this->getEA($spNode, "Charge", "Amount") ;
					$spBean->guaranteedInd	 = $this->getEA($spNode, "Charge", "GuaranteedInd") ;
					$spBean->includedInRate	 = $this->getEA($spNode, "Charge", "IncludedInRate") ;
					$spBean->currencyCode	 = $this->getEA($spNode, "Charge", "CurrencyCode") ;

					array_push($bean->specialEquipments, $spBean) ;
				}


				$fee = $this->getEs($node, "Fee") ;
				foreach($fee as $feeNode)
				{
					$feeBean = new ItemFeeBean() ;

					$feeBean->currencyCode = $this->getA($feeNode,"CurrencyCode") ;
					$feeBean->includedInRate = $this->getA($feeNode,"IncludedInRate") ;
					$feeBean->amount = $this->getA($feeNode,"Amount") ;
					$feeBean->description = $this->getA($feeNode,"Description") ;
					$feeBean->purpose = $this->getA($feeNode,"Purpose") ;
					
					array_push($bean->fees, $feeBean) ;
				}

				$bean->rateTotalAmount = $this->getEA($node, "TotalCharge", "RateTotalAmount") ;
				$bean->estimatedTotalAmount = $this->getEA($node, "TotalCharge", "EstimatedTotalAmount") ;
				$bean->currencyCode = $this->getEA($node, "TotalCharge", "CurrencyCode") ;
				
				$msg = $this->getEs($node, "VendorMessage") ;
				foreach($msg as $msgNode)
				{
					$msgBean = new ItemMsgBean() ;

					$msgBean->title = $this->getA($msgNode,  "Title") ;
					$msgBean->text = $this->getEV($msgNode,"Text") ;

					array_push($bean->msgs, $msgBean) ;
				}

				array_push($list, $bean) ;				
			}

			return $list ;
		}
		
		/*
			에약 수정 하기
		*/
		function modifyReservation($param)
		{
			$this->res = parent::modifyReservation($param) ;
			$this->replaceFee($this->res,$param->rateQualifier,$param->pickUpLocation); //하와이 도심 요금 10불 인상
			
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$list = array() ;
			
			$vehResList = $this->getEs($dom, "VehReservation") ;
			
			$this->validForError($dom, "modifyReservation") ;	// ERROR 또는 WARNING CATCH

			foreach ($vehResList as $node) 
			{
				$bean = new ResVehModifyBean() ;

				$bean->givenName	= $this->getEV($node, "GivenName") ;
				$bean->surname		= $this->getEV($node, "Surname") ;
				$bean->phoneNumber	= $this->getEA($node, "Telephone", "PhoneNumber") ;
				$bean->email		= $this->getEV($node, "Email") ;
				$bean->type			= $this->getEA($node, "ConfID", "Type") ;
				$bean->Id			= $this->getEA($node, "ConfID", "ID") ;
				$bean->vendor		= $this->getEA($node, "Vendor", "Code") ;

				$bean->pickUpDateTime	= $this->getEA($node, "VehRentalCore", "PickUpDateTime") ;
				$bean->returnDateTime	= $this->getEA($node, "VehRentalCore", "ReturnDateTime") ;
				$bean->pickUpLocation	= $this->getEA($node, "PickUpLocation", "LocationCode") ;
				$bean->returnLocation	= $this->getEA($node, "ReturnLocation", "LocationCode") ;
				
				$bean->airConditionIdn	= $this->getEA($node, "Vehicle", "AirConditionInd") ;				
				$bean->transmissionType = $this->getEA($node, "Vehicle", "TransmissionType") ;
				$bean->baggageQuantity	= $this->getEA($node, "Vehicle", "BaggageQuantity") ;
				$bean->passengerQuantity = $this->getEA($node, "Vehicle", "PassengerQuantity") ;
				$bean->vehCategory		= $this->getEA($node, "VehType", "VehicleCategory") ;
				$bean->doorCount		= $this->getEA($node, "VehType", "DoorCount") ;
				$bean->size				= $this->getEA($node, "VehClass", "Size") ;
				$bean->code				= $this->getEA($node, "VehMakeModel", "Code") ;
				$bean->name				= $this->getEA($node, "VehMakeModel", "Name") ;
				$bean->pictureUrl 		= str_replace("assets.alamo.com/alamoData", "www.alamo.com/content/alamo/data", $this->getEV($node, "PictureURL")) ;

				$bean->vehiclePeriodUnitName	= $this->getEA($node, "RateDistance", "VehiclePeriodUnitName") ;
				$bean->distUnitName				= $this->getEA($node, "RateDistance", "DistUnitName") ;
				$bean->unlimited				= $this->getEA($node, "RateDistance", "Unlimited") ;
				
				$bean->arrivalNumber	= $this->getEA($node, "ArrivalDetails", "Number") ;
				$bean->arrivalCode	= $this->getEA($node, "OperatingCompany", "Code") ;

				$charge = $this->getEs($node, "VehicleCharge") ;
				foreach($charge as $chargeNode)
				{
					$chargeBean = new ItemVehChargeBean() ;

					$chargeBean->amount = $this->getA($chargeNode,  "Amount") ;
					$chargeBean->currencyCode = $this->getA($chargeNode,  "CurrencyCode") ;
					$chargeBean->taxInclusive = $this->getA($chargeNode,  "TaxInclusive") ;
					$chargeBean->purpose = $this->getA($chargeNode,  "Purpose") ;
					$chargeBean->description = $this->getA($chargeNode,  "Description") ;

					$chargeBean->unitCharge = $this->getEA($chargeNode, "Calculation", "UnitCharge" ) ;
					$chargeBean->quantity = $this->getEA($chargeNode, "Calculation", "Quantity" ) ;

					array_push($bean->vehCharges, $chargeBean) ;
				}

				$bean->rateQualifier = $this->getEA($node, "RateQualifier", "RateQualifier") ;
				
				// PricedEquip 담는 부분
				$spNodeList = $this->getEs($node, "PricedEquip") ;
				foreach($spNodeList as $spNode)
				{
					$spBean = new ItemSpEquipmentBean() ;
					$spBean->type			= $this->getEA($spNode, "Equipment", "EquipType") ;
					$spBean->quantity		= $this->getEA($spNode, "Equipment", "Quantity") ;
						
					$spBean->amount			 = $this->getEA($spNode, "Charge", "Amount") ;
					$spBean->guaranteedInd	 = $this->getEA($spNode, "Charge", "GuaranteedInd") ;
					$spBean->includedInRate	 = $this->getEA($spNode, "Charge", "IncludedInRate") ;
					$spBean->currencyCode	 = $this->getEA($spNode, "Charge", "CurrencyCode") ;
					
// 					JP1026 요금제 추가옵션때문에
					if($bean->rateQualifier == "JP1026") {
						if($spBean->includedInRate == "true") continue;
						
						array_push($bean->specialEquipments, $spBean) ;
					}
					else{
						array_push($bean->specialEquipments, $spBean) ;
					}
					
					
				}

				$fee = $this->getEs($node, "Fee") ;
				foreach($fee as $feeNode)
				{
					$feeBean = new ItemFeeBean() ;

					$feeBean->currencyCode = $this->getA($feeNode,"CurrencyCode") ;
					$feeBean->includedInRate = $this->getA($feeNode,"IncludedInRate") ;
					$feeBean->amount = $this->getA($feeNode,"Amount") ;
					$feeBean->description = $this->getA($feeNode,"Description") ;
					$feeBean->purpose = $this->getA($feeNode,"Purpose") ;
					
					array_push($bean->fees, $feeBean) ;
				}

				$bean->rateTotalAmount = $this->getEA($node, "TotalCharge", "RateTotalAmount") ;
				$bean->estimatedTotalAmount = $this->getEA($node, "TotalCharge", "EstimatedTotalAmount") ;
				$bean->currencyCode = $this->getEA($node, "TotalCharge", "CurrencyCode") ;
				
				$msg = $this->getEs($node, "VendorMessage") ;
				foreach($msg as $msgNode)
				{
					$msgBean = new ItemMsgBean() ;

					$msgBean->title = $this->getA($msgNode, "Title") ;
					$msgBean->text = $this->getEV($msgNode,"Text") ;

					array_push($bean->msgs, $msgBean) ;
				}
				
				$coverage = $this->getEs($node, "PricedCoverage") ;
				foreach($coverage as $coverageNode)
				{
					$chargeBean = new ItemCoverageBean() ;
				
					$chargeBean->required = $this->getA($coverageNode,  "Required") ;
				
					$chargeBean->code = $this->getEA($coverageNode, "Coverage", "Code" ) ;
				
					array_push($bean->coverages, $chargeBean) ;
				}
				
				array_push($list, $bean) ;
			}

			return $list ;
		}
		
		/*
			에약 취소 하기
		*/
		function cancelReservation($param)
		{
			$this->res = parent::cancelReservation($param) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$list = array() ;
				
			$this->validForError($dom, "VehCancelRSCore") ;	// ERROR 또는 WARNING CATCH

			/*
			$node = $this->getE($dom, "VehCancelRSCore") ;

			$bean = new ResVehCancelBean() ;

			$bean->cancelStatus = $this->getA($node, "CancelStatus") ;
			$bean->Id			= $this->getEA($node, "UniqueID", "ID") ;

			array_push($list, $bean) ;
*/
			return $list ;
		}

		function validForError($dom, $step, $retrieve = "")
		{
			$warningNodeList  = $this->getEs($dom, "Warning") ;
			$errorNodeList    = $this->getEs($dom, "Error") ;

			if( $warningNodeList->length > 0 )
			{
				foreach($warningNodeList as $warningNode)
				{
					$str = "" ;

					$str .= "[Type:" . $this->getA($warningNode, "Type") . "]" ;
					$str .= "[Code:" . $this->getA($warningNode, "Code") . "]" ;
					$str .= "[Msg:" . $warningNode->nodeValue . "]" ;					

					array_push($this->aWarning, $str) ;
					array_push($this->aWarningMsg, $warningNode->nodeValue );
					
					// retrieve를 위한 적업 by woo
					if($this->getA($warningNode, "Code") == "95" && $warningNode->nodeValue == "BOOKING ALREADY CANCELLED" && $retrieve == "true") {
						
						// temp table db insert (insert and update)
						$rsv_res_code = str_replace("COUNT", "", $this->getEA($dom, "ConfID", "ID"));
						
						$dbAssoc = Array(
						"rsv_res_code"		=> $rsv_res_code,
						"rsv_xml"	=> bin2hex($this->res),
						"time"		=> "now()"
						);
						
						$db = new DB(); 
						
						$db->techOfInsertForUpdate("rc_temp_retrieve", $dbAssoc);
						
						// 직접 예약확인시 
						$sql = "SELECT rsv_seri_code FROM rc_reservation WHERE rsv_res_code = '{$rsv_res_code}'";
						$pending_result = $db->getRow($sql);
						
						if($pending_result['rsv_seri_code'] == "")
							$pendingType = "N";
						else
							$pendingType = "F";
						
						$sql = "UPDATE rc_reservation SET rsv_status = 'C' WHERE rsv_res_code = '{$rsv_res_code}'";
						$db->update($sql);
						
						// retrivew 처리된 내역 일괄 메일 발송
						$sendMailUrl = "http://www.alamo.co.kr/reserv/reservMailForm.php?rsv_res_code=".$rsv_res_code."&pendingType=".$pendingType."&retrieve=Y&vendor=".SITECODE_VENDOR."";
						
						$curl_obj = curl_init();
						curl_setopt ($curl_obj, CURLOPT_URL, $sendMailUrl);
						curl_setopt ($curl_obj, CURLOPT_SSL_VERIFYPEER, FALSE);
						curl_setopt ($curl_obj, CURLOPT_SSL_VERIFYHOST, FALSE);
						curl_setopt ($curl_obj, CURLOPT_SSLVERSION,1);
						curl_setopt ($curl_obj, CURLOPT_HEADER, 0);
						curl_setopt ($curl_obj, CURLOPT_TIMEOUT, 10);
						curl_setopt ($curl_obj, CURLOPT_RETURNTRANSFER, TRUE);
						$sendMailResult = curl_exec($curl_obj);
						
						curl_close($curl_obj);
						
					}
					
				}
				$this->isWarning = true ;
			}

			if( $errorNodeList->length > 0 )
			{
				foreach($errorNodeList as $errorNode)
				{
					$this->errorBean = new ErrorBean() ;
					
					$this->errorBean->err_type = $this->getA($errorNode, "Type") ;
					$this->errorBean->err_code = $this->getA($errorNode, "Code") ;
					$this->errorBean->err_msg  = $errorNode->nodeValue ;
					$this->errorBean->err_step = $step ;
					$this->errorBean->err_xml  = bin2hex($this->res) ;
					$this->errorBean->err_xml_req  = bin2hex($this->req) ;

				}

				$this->isError = true ;						
			}
		}

		function replaceFee(&$txt,$rc,$loc) {
			/***
			하와이 시내 지점에서 1일 대여시 기존 요금 대비 $10 씩 인상 
			> 호놀룰루 
			 아울라니 디즈니 리조트 HNLR72
			와이키키 비치 센트럴 HNLR73 
			와이키키 비치 웨스트 HNLR71

			> 코나
			 힐튼 와이콜로아 KOAR71
			*/
			
			/*
			preg_match('/ PickUpDateTime\=(\'|\")?([A-Z0-9.\-\:]+)(\'|\")?/i', $txt, $matches);
			$PickUpDateTime = substr($matches[2],0,10);	
			preg_match('/ ReturnDateTime\=(\'|\")?([A-Z0-9.\-\:]+)(\'|\")?/i', $txt, $matches);
			$ReturnDateTime = substr($matches[2],0,10);	
			
			$datetime1 = date_create($PickUpDateTime);
			$datetime2 = date_create($ReturnDateTime);
			$interval = date_diff($datetime1, $datetime2);
			$qty = $interval->format('%a');
	
			if($rc == "TMK" && $qty == 1 && ($loc == "HNLR72" || $loc == "HNLR73" || $loc == "HNLR71" || $loc == "KOAR71")) {
				$txt = preg_replace_callback('/ Amount\=(\'|\")?([0-9.]+)(\'|\")?/i', function($match) { return " Amount='".sprintf('%01.2f', (($match[2] == 0)? $match[2] : $match[2]+10))."'"; }, $txt);
				$txt = preg_replace_callback('/ UnitCharge\=(\'|\")?([0-9.]+)(\'|\")?/i', function($match) { return " UnitCharge='".sprintf('%01.2f', (($match[2] == 0)? $match[2] : $match[2]+10))."'"; }, $txt);
				$txt = preg_replace_callback('/ RateTotalAmount\=(\'|\")?([0-9.]+)(\'|\")?/i', function($match) { return " RateTotalAmount='".sprintf('%01.2f', (($match[2] == 0)? $match[2] : $match[2]+10))."'"; }, $txt);
				$txt = preg_replace_callback('/ EstimatedTotalAmount\=(\'|\")?([0-9.]+)(\'|\")?/i', function($match) { return " EstimatedTotalAmount='".sprintf('%01.2f', (($match[2] == 0)? $match[2] : $match[2]+10))."'"; }, $txt);
			}
			 * 
			 */
			return $txt ;		
		}
		
		/* ping test */
		function getPingTest($param) {
			$this->res = parent::getPingTest($param) ;
		
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
				
			$list = array() ;
				
			array_push($list, $this->res) ;
		
			return $list ;
		}
		

// class end 

	}



}
?>