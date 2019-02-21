<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/AlamoAPI.php" ; ?>
<?

/** 크루즈 API 요청하는 클래스 **/

if(! class_exists("Req") )	{

	class Req extends AlamoApi
	{	

		function Req($url)
		{
			$this->AlamoApi($url) ;

		}

		function getAttr($name,$input,$makeInput) 
		{
			if( $input != "" )
				return ' ' . $name . '="' . $makeInput . '" ' ;
			else
				return  "" ;
		}

		function getTag($prefix,$input,$makeInput,$postfix) 
		{
			if( $input != "" )
				return $prefix . '"' . $makeInput . '" ' . $postfix  ;
			else
				return  "" ;
		}

		function getTags($prefix, $makeInputArr, $postfix)
		{
			$makeInput = " " ;
			foreach($makeInputArr as $value)
			{
				$data = explode(":", $value) ;
				$makeInput .= trim($data[0]) . '="' . trim($data[1]) . '" ' ;
			}

			return $prefix . $makeInput . $postfix  ;
		}

        function getMulti($req)
        {
            $obj = new AlamoFront();
            $this->setUrl($this->SERVICE_URL) ;	// URL SETTING

            $multiReq = array();

            foreach ($req as $key => $val) {
                $body = substr($val, strpos($val, "<soapenv"));
                $headers = array(
                    "POST ".$this->_uri." HTTP/1.1",
                    "Host: " . $this->_host,
                    "Accept-Encoding: gzip,deflate",
                    "User-Agent: RPT-HTTPClient/0.3-3",
                    "Content-type: text/xml;charset=UTF-8",
                    'Authorization: Basic ' . $this->Authorization,
                    "Content-length: " . strlen($body)
                ); //SOAPAction: your op URL

                $multiReq[$key]['body'] = $body;
                $multiReq[$key]['headers'] = $headers;

                //$obj->debug($body);
            }

            $curl_arr = array();
            $master = curl_multi_init();

            foreach($multiReq as $key => $val)
            {
                $curl_arr[$key] = curl_init($this->SERVICE_URL);
                curl_setopt($curl_arr[$key], CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl_arr[$key], CURLOPT_SSLVERSION, 6);
                curl_setopt($curl_arr[$key], CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl_arr[$key], CURLOPT_TIMEOUT, 30);
                curl_setopt($curl_arr[$key], CURLOPT_POST, true);
                curl_setopt($curl_arr[$key], CURLOPT_POSTFIELDS, $val['body']); // the SOAP request
                curl_setopt($curl_arr[$key], CURLOPT_HTTPHEADER, $val['headers']);
                curl_multi_add_handle($master, $curl_arr[$key]);
            }
            do {
                curl_multi_exec($master,$running);
            } while($running);


            foreach($multiReq as $key => $val)
            {
                $results[$key] = $this->decode(curl_multi_getcontent($curl_arr[$key]));
                //$results[$key]['info'] = curl_getinfo($curl_arr[$key]);
            }
            curl_multi_close($master);

            //for debug
            //$obj->debug($results);
            return $results;
        }

		/*
			이용가능한 차량 조회
		*/
		function getListOfAvailRate($param)
		{
			$this->setUrl($this->SERVICE_URL) ;	// URL SETTING
			
			$this->putH("OTA_VehAvailRateRQ", "30", "1", "100000001") ;
			
			$this->makePOS($param->ic, $param->vendor) ;

			$this->initSetSOAPData("OTA_VehAvailRateRQ", $param->vendor) ;

			
			// array_push($list, $bean) ;
			// 항공사 멤버쉽 
			$airData = Array(
				"ProgramID : ". $param->airCode ,
				"MembershipID : " . $param->airMemId ,
				"TravelSector : 1"
			) ;
			// 에메랄드 클럽 멤버쉽 
			$emcData = Array(
				"ProgramID : " . $param->vendor,
				"MembershipID : " . $param->emcNo ,
				"TravelSector : 2"
			) ;

			$airCode = ($param->airCode != "" && $param->airMemId != "")? $this->getTags("<CustLoyalty", $airData, " />") : "" ;
			$emcNo = ($param->emcNo != "") ? $this->getTags("<CustLoyalty", $emcData, " />") : "" ;
			
			$pickUpDateTime = $this->getAttr("PickUpDateTime",	$param->pickUpDateTime,	$param->pickUpDateTime) ;
			$returnDateTime = $this->getAttr("ReturnDateTime",	$param->returnDateTime,	$param->returnDateTime) ;
			
			$pickUpLocation = $this->getTag("<PickUpLocation LocationCode=",	$param->pickUpLocation,	$param->pickUpLocation, " />") ;
			$returnLocation = $this->getTag("<ReturnLocation LocationCode=",	$param->returnLocation,	$param->returnLocation, " />") ;
			
			$vendor = $this->getTag("<VendorPref Code=", $param->vendor,	$param->vendor, " />") ;

			$rateQualifier = $this->getAttr("RateQualifier",	$param->rateQualifier,	$param->rateQualifier) ;
			$promotionCode = $this->getAttr("PromotionCode",	$param->promotionCode,	$param->promotionCode) ;
			// $corpDiscountNmbr = $this->getAttr("CorpDiscountNmbr", $param->contactId,	$param->contactId) ;
			// $corpDiscountNmbr = $this->getAttr("CorpDiscountNmbr", $param->ic,	$param->ic) ;
			// $corpDiscountNmbr 요금제에 매핑되어 있음.
			$corpDiscountNmbr = $this->getAttr("CorpDiscountNmbr", $this->corpDiscountNumber,	$this->corpDiscountNumber) ;
			
			$driverType = $param->underAge == "1" ? '<DriverType Age="17" />' : '<DriverType Age="25" />';
			if($param->driverAge != "")
			{
				$driverType = $this->getTag("<DriverType Age=", $param->driverAge,	$param->driverAge, " />") ;
			}

			$req= '
				<VehAvailRQCore Status="Available" >
					<VehRentalCore ' . $pickUpDateTime . $returnDateTime . '  >
				' . $pickUpLocation . $returnLocation . '
					</VehRentalCore>
					<VendorPrefs>
					' . $vendor . '
					</VendorPrefs>'
					
					 . $driverType .
					
					'<RateQualifier ' . $rateQualifier . $promotionCode . $corpDiscountNmbr . ' />
					<TPA_Extensions>
						<TPA_Extension_Flags EnhancedTotalPrice="true" />
					</TPA_Extensions>

				</VehAvailRQCore>
				<VehAvailRQInfo>
					<Customer>
						<Primary>
							' . $airCode . '
							' . $emcNo . '
						</Primary>
					</Customer>
				</VehAvailRQInfo>

			' ;
						
			$this->putB($req) ;
		}
		
		/*
			지역 상세 보기 (SpecialEquipment를 가져오는 부분)
		*/
		function getInfoLocDetail($param)
		{
			$this->setUrl($this->SERVICE_URL) ;	// URL SETTING
			
			$this->putH("OTA_VehLocDetailRQ", "20", "1", "100000001") ;
			
			$this->makePOS($param->ic, $param->vendor) ;

			$this->initSetSOAPData("OTA_VehLocDetailRQ", $param->vendor) ;

			$pickUpLocation = $this->getTag("<Location LocationCode=",	$param->pickUpLocation,	$param->pickUpLocation, " />") ;
			$vendorCode = $this->getTag("<Vendor Code=", $param->vendor, $param->vendor, " />") ;

			$req= $pickUpLocation . ' ' . $vendorCode ;
			
			//echo "RRRRRREEEEEQQQQ:".$req;
			$this->putB($req) ;

			return $this->get() ;
		}
		
		
		/*
			렌터카 예약하기
		*/
		function insertReservation($param)
		{
			$this->setUrl($this->SERVICE_URL) ;	// URL SETTING

			$this->putH("OTA_VehResRQ", "20", "1", "100000001") ;

			$this->makePOS($param->ic, $param->vendor) ;

			$this->initSetSOAPData("OTA_VehResRQ", $param->vendor) ;

			// array_push($list, $bean) ;
			// 항공사 멤버쉽 
			$airData = Array(
				"ProgramID : ". $param->airCode ,
				"MembershipID : " . $param->airMemId ,
				"TravelSector : 1"
			) ;
			// 에메랄드 클럽 멤버쉽 
			$emcData = Array(
				"ProgramID : " . $param->vendor,
				"MembershipID : " . $param->emcNo ,
				"TravelSector : 2"
			) ;

			$airCode = ($param->airCode != "" && $param->airMemId != "")? $this->getTags("<CustLoyalty", $airData, " />") : "" ;
			$emcNo = ($param->emcNo != "") ? $this->getTags("<CustLoyalty", $emcData, " />") : "" ;


			$specialEquipPref = "";
			$equipTypeArr = $param->equipType ; 
			$quantityArr = $param->quantity ;
			for($i = 0 ; $i < sizeof($equipTypeArr) ; $i++)
			{
				if($quantityArr[$i] != "0")
				{
					$equipData = Array(
						"EquipType : " . $equipTypeArr[$i] ,
						"Quantity : " . $quantityArr[$i]
					) ;
					$specialEquipPref .= $this->getTags("<SpecialEquipPref", $equipData, " />") ;
				}
			}


			$pickUpDateTime = $this->getAttr("PickUpDateTime",	$param->pickUpDateTime,	$param->pickUpDateTime) ;
			$returnDateTime = $this->getAttr("ReturnDateTime",	$param->returnDateTime,	$param->returnDateTime) ;
			
			$pickUpLocation = $this->getTag("<PickUpLocation LocationCode=",	$param->pickUpLocation,	$param->pickUpLocation, " />") ;
			$returnLocation = $this->getTag("<ReturnLocation LocationCode=",	$param->returnLocation,	$param->returnLocation, " />") ;

			$areaCityCode = $this->getAttr("AreaCityCode", $param->areaCityCode, $param->areaCityCode) ;
			$phoneNumber = $this->getAttr("PhoneNumber", $param->phoneNumber, $param->phoneNumber) ;
			
			$vendor = $this->getTag("<VendorPref Code=", $param->vendor,	$param->vendor, " />") ;

			$airConditionIdn = $this->getAttr("AirConditionInd", $param->airConditionIdn, $param->airConditionIdn) ;
			$transmissionType = $this->getAttr("TransmissionType", $param->transmissionType, $param->transmissionType) ;
			$fuelType = $this->getAttr("FuelType", $param->fuelType, $param->fuelType) ;

			$vehCategory = $this->getAttr("VehicleCategory", $param->vehCategory, $param->vehCategory) ;
			$doorCount = $this->getAttr("DoorCount", $param->doorCount, $param->doorCount) ;

			$size = $this->getTag("<VehClass Size=", $param->size,	$param->size, " />") ;	
			
			// $rateQualifier = $this->getAttr("RateQualifier",	$param->rateQualifier,	$param->rateQualifier) ;
			$rateQualifier = $this->getAttr("RateQualifier",	$param->referenceID,	$param->referenceID) ;
			$promotionCode = $this->getAttr("PromotionCode",	$param->promotionCode,	$param->promotionCode) ;			
			// $corpDiscountNmbr = $this->getAttr("CorpDiscountNmbr", $param->ic,	$param->ic) ;
			// $corpDiscountNmbr 요금제에 매핑되어 있음.
			$corpDiscountNmbr = $this->getAttr("CorpDiscountNmbr", $this->corpDiscountNumber,	$this->corpDiscountNumber) ;

			
			$type = $this->getAttr("Type", $param->type, $param->type) ;
			$datetime = $this->getAttr("DateTime", $param->datetime, $param->datetime) ;
			
			$param->code = ($param->rateQualifier == "TMK") ? "CORP" : $param->code ;		// 프리페이드 일경우 CORP 로 고정

			// $id = $this->getAttr("ID", $param->code, $param->code) ;
			// $id = $this->getAttr("ID", $param->rateQualifier, $param->rateQualifier) ;

			// 2014.02.21 선택한 차량의 reference ID로 매핑되도록 수정 
			$id = $this->getAttr("ID", $param->referenceID, $param->referenceID) ;
			
			$seriesCode = "" ;
			if($param->seriesCode != "")
			{
				$seriesCode .= "<RentalPaymentPref>" ;
				$seriesCode .= $this->getTag("<Voucher SeriesCode=", $param->seriesCode,	$param->seriesCode, " />") ;
				$seriesCode .= "</RentalPaymentPref>" ;
			}

			//항공편 코드 셋팅 add by dev.na 2014-08-29
			$planeCode = "";
			if($param->planeCode != "")
			{
				$planeCode .= "<ArrivalDetails " . $this->getAttr("TransportationCode","14","14") . " " . $this->getAttr("Number",$param->planeCode, $param->planeCode) . ">";
				$planeCode .= $this->getTag("<OperationCompany Code=", $param->planeCode, substr($param->planeCode, 0, 2), "/>") ;
				$planeCode .= "</ArrivalDetails>";
			}

			//드라이버 나이 셋팅 add by dev.na 2014-08-29
			$driverType = '<DriverType Age="25" />';
			if($param->driverAge != "")
			{
				$driverType = $this->getTag("<DriverType Age=", $param->driverAge,	$param->driverAge, " />") ;
			}

			$telephone = '<Telephone PhoneUseType="3" ' . $areaCityCode . $phoneNumber . '/>';
			// 2014-03-03
			// 전화번호가 없으면 TAG 생성하지 않습니다.
			if($phoneNumber == "")
				$telephone = '';

			/*
			$req = '
				<VehResRQCore Status="Available">
					<VehRentalCore ' . $pickUpDateTime . $returnDateTime . '  >
				' . $pickUpLocation . $returnLocation . '
					</VehRentalCore>
					<Customer>
						<Primary>
							<PersonName>
								<GivenName>' . $param->givenName . '</GivenName>
								<Surname>' . $param->surname . '</Surname>
							</PersonName>
							<Telephone PhoneUseType="3" ' . $areaCityCode . $phoneNumber . '/>
							<Email>' . $param->email . '</Email>
							' . $airCode . '
							' . $emcNo . '
						</Primary>
					</Customer>
					' . $vendor . '					
					<VehPref ' . $airConditionIdn . $transmissionType . ' >
						<VehType ' . $vehCategory . $doorCount . ' />
						' . $size . '
					</VehPref>					
					<RateQualifier ' . $rateQualifier . $promotionCode . $corpDiscountNmbr . ' />
					<SpecialEquipPrefs>
					' . $specialEquipPref . '
					</SpecialEquipPrefs>
					<TPA_Extensions>
						<TPA_Extension_Flags EnhancedTotalPrice="true" />
					</TPA_Extensions>
				</VehResRQCore>
				<VehResRQInfo>		
					' . $seriesCode . '
					<Reference ' . $type . $datetime . $id . ' />
				</VehResRQInfo>
			' ;
			*/

			$req = '
				<VehResRQCore Status="Available">
					<VehRentalCore ' . $pickUpDateTime . $returnDateTime . '  >
				' . $pickUpLocation . $returnLocation . '
					</VehRentalCore>
					<Customer>
						<Primary>
							<PersonName>
								<GivenName>' . $param->givenName . '</GivenName>
								<Surname>' . $param->surname . '</Surname>
							</PersonName>
							' . $telephone. '
							<Email>' . $param->email . '</Email>
							' . $airCode . '
							' . $emcNo . '
						</Primary>
					</Customer>
					' . $vendor . '					
					<VehPref ' . $airConditionIdn . $transmissionType . $fuelType .' >
						<VehType ' . $vehCategory . $doorCount . ' />
						' . $size . '
					</VehPref>
					' . $driverType . '
					<RateQualifier ' . $rateQualifier . $promotionCode . $corpDiscountNmbr . ' />
					<SpecialEquipPrefs>
					' . $specialEquipPref . '
					</SpecialEquipPrefs>
					<TPA_Extensions>
						<TPA_Extension_Flags EnhancedTotalPrice="true" />
					</TPA_Extensions>
				</VehResRQCore>
				<VehResRQInfo>		
					' . $planeCode . '
					' . $seriesCode . '
					<Reference ' . $type . $datetime . $id . ' />
				</VehResRQInfo>
			' ;
			
			$this->putB($req) ;

			return $this->get() ;
		}

		
		/*
			예약 확인 하기
		*/
		function getInfoOfReservation($param)
		{
			$this->setUrl($this->SERVICE_URL) ;	// URL SETTING

			$this->putH("OTA_VehRetResRQ", "", "1", "100000002") ;

			$this->makePOS($param->ic, $param->vendor) ;

			$this->initSetSOAPData("OTA_VehRetResRQ", $param->vendor) ;

			
			
			$id = $this->getAttr("ID", $param->uniqueId, $param->uniqueId . "COUNT") ;
			$type = $this->getAttr("Type", "14", "14") ;

			$vendorCode = $this->getTag("<Vendor Code=", $param->vendor, $param->vendor, " />") ;
			
	 		$pickUpDateTime = $this->getAttr("PickUpDateTime",	$param->pickUpDateTime,	$param->pickUpDateTime) ;
 			$pickUpLocation = $this->getTag("<PickUpLocation LocationCode=",	$param->pickUpLocation,	$param->pickUpLocation, " />") ;

			$req = '
				<VehRetResRQCore>
					<UniqueID ' . $id . $type . ' />
					<PersonName>
						<GivenName>' . $param->givenName . '</GivenName>
						<Surname>' . $param->surname . '</Surname>
					</PersonName>				
					<TPA_Extensions>
						<TPA_Extension_Flags EnhancedTotalPrice="true" />
					</TPA_Extensions>
				</VehRetResRQCore>
				<VehRetResRQInfo ' . $pickUpDateTime . '>
				' . $pickUpLocation . '
				' . $vendorCode . '
				</VehRetResRQInfo>

			' ;

			$this->putB($req) ;

			//return $this->get() ;
		}


		/*
			예약 수정 하기
			SpecialEquipPrefs 이슈사항있음....
			옵션 추가 , 교체, 삭제 등등...
		*/
		function modifyReservation($param)
		{
			$this->setUrl($this->SERVICE_URL) ;	// URL SETTING

			$this->putH("OTA_VehModifyRQ", "", "1", "100000001") ;

			$this->makePOS($param->contactId,$param->vendor) ;

			$this->initSetSOAPData("OTA_VehModifyRQ", $param->vendor) ;

			$id = $this->getAttr("ID", $param->uniqueId, $param->uniqueId . "COUNT") ;
			$type = $this->getAttr("Type", "14", "14") ;

			$pickUpDateTime = $this->getAttr("PickUpDateTime",	$param->pickUpDateTime,	$param->pickUpDateTime) ;
			$returnDateTime = $this->getAttr("ReturnDateTime",	$param->returnDateTime,	$param->returnDateTime) ;
			
			$pickUpLocation = $this->getTag("<PickUpLocation LocationCode=",	$param->pickUpLocation,	$param->pickUpLocation, " />") ;
			$returnLocation = $this->getTag("<ReturnLocation LocationCode=",	$param->returnLocation,	$param->returnLocation, " />") ;

			$areaCityCode = $this->getAttr("AreaCityCode", $param->areaCityCode, $param->areaCityCode) ;
			$phoneNumber = $this->getAttr("PhoneNumber", $param->phoneNumber, $param->phoneNumber) ;
			
			$vendor = $this->getTag("<VendorPref Code=", $param->vendor,	$param->vendor, " />") ;
			
			$airConditionIdn = $this->getAttr("AirConditionInd", $param->airConditionIdn, $param->airConditionIdn) ;
			$transmissionType = $this->getAttr("TransmissionType", $param->transmissionType, $param->transmissionType) ;
			$fuelType = $this->getAttr("FuelType", $param->fuelType, $param->fuelType) ;

			$vehCategory = $this->getAttr("VehicleCategory", $param->vehCategory, $param->vehCategory) ;
			$doorCount = $this->getAttr("DoorCount", $param->doorCount, $param->doorCount) ;

			$size = $this->getTag("<VehClass Size=", $param->size,	$param->size, " />") ;	

			$rateQualifier = $this->getAttr("RateQualifier",	$param->rateQualifier,	$param->rateQualifier) ;
			$promotionCode = $this->getAttr("PromotionCode",	$param->promotionCode,	$param->promotionCode) ;
			$corpDiscountNmbr = $this->getAttr("CorpDiscountNmbr", $param->ic,	$param->ic) ;			
			
			$refType = $this->getAttr("Type", $param->type, $param->type) ;
			$datetime = $this->getAttr("DateTime", $param->datetime, $param->datetime) ;
			$refId = $this->getAttr("ID", $param->rateQualifier, $param->rateQualifier) ;


			// array_push($list, $bean) ;
			// 항공사 멤버쉽 
			$airData = Array(
				"ProgramID : ". $param->airCode ,
				"MembershipID : " . $param->airMemId ,
				"TravelSector : 1"
			) ;
			// 에메랄드 클럽 멤버쉽 
			$emcData = Array(
				"ProgramID : " . $param->vendor,
				"MembershipID : " . $param->emcNo ,
				"TravelSector : 2"
			) ;

			$airCode = ($param->airCode != "" && $param->airMemId != "")? $this->getTags("<CustLoyalty", $airData, " />") : "" ;
			$emcNo = ($param->emcNo != "") ? $this->getTags("<CustLoyalty", $emcData, " />") : "" ;

			$specialEquipPref = "";
			$equipTypeArr = $param->equipType ; 
			$quantityArr = $param->quantity ;
			$actionArr = $param->action ;
	
			for($i = 0 ; $i < sizeof($equipTypeArr) ; $i++)
			{
				if($quantityArr[$i] != "0" || $actionArr[$i] == "Cancel")
				{
					$equipData = Array(
						"EquipType : " . $equipTypeArr[$i] ,
						"Quantity : " . $quantityArr[$i],
						"Action : " . $actionArr[$i]
					) ;
					$specialEquipPref .= $this->getTags("<SpecialEquipPref", $equipData, " />") ;
				}
			}

			//항공편 코드 셋팅 add by dev.na 2014-08-29
			$planeCode = "";
			if($param->planeCode != "")
			{
				$planeCode .= "<ArrivalDetails " . $this->getAttr("TransportationCode","14","14") . " " . $this->getAttr("Number",$param->planeCode, $param->planeCode) . ">";
				$planeCode .= $this->getTag("<OperationCompany Code=", $param->planeCode, substr($param->planeCode, 0, 2), "/>") ;
				$planeCode .= "</ArrivalDetails>";
			}

			//드라이버 나이 셋팅 add by dev.na 2014-08-29
			$driverType = '<DriverType Age="25" />';
			if($param->driverAge != "")
			{
				$driverType = $this->getTag("<DriverType Age=", $param->driverAge,	$param->driverAge, " />") ;
			}

			$telephone = '<Telephone PhoneUseType="3" ' . $areaCityCode . $phoneNumber . '/>';
			// 2014-03-03
			// 전화번호가 없으면 TAG 생성하지 않습니다.
			if($phoneNumber == "")
				$telephone = '';

			$req = '
				<VehModifyRQCore ModifyType="Modify" Status="Available">
					<UniqueID ' . $id . $type . ' />
					<VehRentalCore ' . $pickUpDateTime . $returnDateTime . '  >
				' . $pickUpLocation . $returnLocation . '
					</VehRentalCore>
					<Customer>
						<Primary>
							<PersonName>
								<GivenName>' . $param->givenName . '</GivenName>
								<Surname>' . $param->surname . '</Surname>
							</PersonName>
							<Telephone PhoneUseType="3" ' . $areaCityCode . $phoneNumber . '/>
							<Email>' . $param->email . '</Email>
							' . $airCode . '
							' . $emcNo . '							
						</Primary>
					</Customer>
					' . $vendor . '
					<VehPref ' . $airConditionIdn . $transmissionType . $fuelType .' >
						<VehType ' . $vehCategory . $doorCount . ' />
						' . $size . '
					</VehPref>
					' . $driverType . '
					<RateQualifier ' . $rateQualifier . $promotionCode . ' />
					<SpecialEquipPrefs>
						' . $specialEquipPref . '
					</SpecialEquipPrefs>
					<TPA_Extensions>
						<TPA_Extension_Flags EnhancedTotalPrice="true" />
					</TPA_Extensions>				
				</VehModifyRQCore>
				<VehModifyRQInfo>
					' . $planeCode . '
					<Reference ' . $refType . $datetime . $refId . ' />
				</VehModifyRQInfo>
			' ;

			$this->putB($req) ;

			return $this->get() ;

		}
		
		/*
			예약 취소 하기
		*/
		function cancelReservation($param)
		{
			$this->setUrl($this->SERVICE_URL) ;	// URL SETTING
			
			$this->putH("OTA_VehCancelRQ", "", "1", "100000001") ;

			$this->makePOS("",$param->vendor) ;

			$this->initSetSOAPData("OTA_VehCancelRQ", $param->vendor) ;

			$id = $this->getAttr("ID", $param->uniqueId, $param->uniqueId . "COUNT") ;
			$type = $this->getAttr("Type", "14", "14") ;
			$vendor = $this->getTag("<Vendor Code=", $param->vendor,	$param->vendor, " />") ;

			$req = '
				<VehCancelRQCore CancelType="Cancel">
					<UniqueID ' . $id . $type . ' />
					<PersonName>
						<GivenName>' . $param->givenName . '</GivenName>
						<Surname>' . $param->surname . '</Surname>
					</PersonName>
				</VehCancelRQCore>
				
				<VehCancelRQInfo>
				' . $vendor . '
				</VehCancelRQInfo>			
			' ;
			
			$this->putB($req) ;

			return $this->get() ;
		}
	



























		// 세일링 리스트를 요청한다.
		function getSailingList($param)
		{
			$this->setUrl($this->FITURL.'/SailingList') ;
			$this->putH(
			"getSailingList",$this->interfaceURL."/SailingList","OTA_CruiseSailAvailRQ","40","true","false","1","106597") ;
			
			$start		= $this->getAttr("Start",$param['date'],$param['date'] . "-01") ;		// 년월
			$duration	= $this->getAttr("Duration",$param['duration'],$param['duration']) ;	// 일정 2박 3일
			$vendor		= $this->getAttr("VendorCode",$param['vendor'],$param['vendor']) ;		// 선사
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$port		= $this->getAttr("PortCode",$param['port'],$param['port']) ;			// 출발항구

			$dest		= $this->getTag("<RegionPref RegionCode=",$param['dest'],$param['dest']," />") ;			// 여행지

			$req = '	
      <GuestCounts>
          <GuestCount Quantity="1"/>
          <GuestCount Quantity="1"/>
        </GuestCounts>			
			<SailingDateRange ' . $start . $duration  . '/>
			<CruiseLinePrefs>
			<CruiseLinePref ' . $vendor . $ship . ' >
				<SearchQualifiers>
					<Port EmbarkIndicator="true" ' . $port . ' />
				</SearchQualifiers>
			</CruiseLinePref>
			</CruiseLinePrefs>' . $dest ;


			$this->putB($req) ;

			return $this->get($param) ;			
		}

		// 세일링과 관련한 패키지 리스트를 가져온다.
		function getPackageList($param)
		{
			$this->setUrl($this->FITURL."/PackageList") ;
			$this->putH(
				"getPackageList",$this->interfaceURL."/PackageList","OTA_CruisePkgAvailRQ","40","","","1","106597") ;

			$start		= $this->getAttr("Start",$param['date'],$param['date'] . "-01") ;				// 년월
			$vendor		= $this->getAttr("VendorCode",$param['vendor'],$param['vendor']) ;				// 선사
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;					// 배
			$dest		= $this->getTag("<Region RegionCode=",$param['dest'],$param['dest']," />") ;	// 여행지

			$req = '
			<GuestInfos>
				<GuestInfo>
					<GuestTransportation Mode="29" Status="36" >
						<GatewayCity CodeContext="IATA" LocationCode="C/O" />
					</GuestTransportation >
				</GuestInfo>
			</GuestInfos>
			<SailingInfo>
				<SelectedSailing ' . $start . '>
					<CruiseLine ' . $vendor . $ship . ' /> '
					. $dest . '
				</SelectedSailing>
			</SailingInfo>
			<PackageOption PackageTypeCode="1" />' ;

			$this->putB($req) ;

			return $this->get($param) ;

		}


		function getCategoryList($param)
		{
			$this->setUrl($this->FITURL."/CategoryList") ;
			$this->putH(
				"getCategoryList",$this->interfaceURL."/CategoryList","OTA_CruiseCategoryAvailRQ","40","","","1","106597") ;
			
		/*
			$start		= $this->getAttr("Start",$param['date'],$param['date']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$guestCount	= $param['adult_amt']+$param['child_amt'] ;		// 기본 1개로 세팅
		*/
			$saildate = substr($param[0],6,4)."-".substr($param[0],0,2)."-".substr($param[0],3,2);
							// 년월
			$ship		= $this->getAttr("ShipCode",$param[1],$param[1]) ;			// 배
			$guestCount	= $param[2]+$param[3] ;		// 기본 1개로 세팅
			$adultAmt = $param[2];
			$childAmt = $param[3];
			$guest = '';
			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$guest .= '<Guest Age="30" >
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
								</GuestTransportation>
							</Guest>' ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest .= '<Guest Age="10" >
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
								</GuestTransportation>
							</Guest>' ;
			}
			$req = $guest ; 
			$req .='

			<GuestCounts>
			<GuestCount Quantity="' . $guestCount . '" />
			</GuestCounts>
			
			<SailingInfo>
				<SelectedSailing Start ="' . $saildate . '">
					<CruiseLine ' . $ship . '/>
				</SelectedSailing>
			</SailingInfo>

			<SelectedFare/>' ;
		 

			$this->putB($req) ;

			return $this->get($param) ;
				
		}

		function getCategoryList2($param)
		{
			$this->setUrl($this->FITURL."/CategoryList") ;
			$this->putH(
				"getCategoryList",$this->interfaceURL."/CategoryList","OTA_CruiseCategoryAvailRQ","40","","","1","106597") ;
			
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배

			$adultAmt = $param['adult_amt'] ;
			$childAmt = $param['child_amt'] ;

			$guest = "" ;
			$guest2 = "<GuestCounts>" ;

			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$guest .= '<Guest Age="30" >
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
								</GuestTransportation>
							</Guest>' ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest .= '<Guest Age="10" >
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
								</GuestTransportation>
							</Guest>' ;
			}

			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$guest2 .= '<GuestCount Quantity="1" />' ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest2 .= '<GuestCount Quantity="1" />' ;
			}

			$guest2 .= "</GuestCounts>" ;

			
			$req = $guest . $guest2 .

			'<SailingInfo>
				<SelectedSailing ' . $start . '>
					<CruiseLine ' . $ship . '/>
				</SelectedSailing>
			</SailingInfo>

			<SelectedFare/>' ;

			$this->putB($req) ;

			return $this->get($param) ;
				
		}

	


		function getCabinList($param)
		{

 			$this->setUrl($this->FITURL."/CabinList") ;
			$this->putH(
				"getCabinList",$this->interfaceURL."/CabinList","OTA_CruiseCabinAvailRQ","50","true","false","1","106597") ;		
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$adultAmt	= $param['adult_amt'] ;
			$childAmt	= $param['child_amt'] ;
			$price_type = $param['pt'];
			$ppid = $param['ppid'];

			$guest = "" ;
			$guest2 = "<GuestCounts>" ;

			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$guest .= '<Guest Age="30" >
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
								</GuestTransportation>
							</Guest>' ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest .= '<Guest Age="10" >
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
								</GuestTransportation>
							</Guest>' ;
			}

			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$guest2 .= '<GuestCount Quantity="1" />' ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest2 .= '<GuestCount Quantity="1" />' ;
			}

			$guest2 .= "</GuestCounts>" ;

			
			$req = $guest . $guest2 .		
			'<SailingInfo>
				<SelectedSailing '. $start . '>
				<CruiseLine ' .$ship . '/>
				</SelectedSailing>
			</SailingInfo>
			<SearchQualifiers BerthedCategoryCode="' . $param["cate"] . '" FareCode="'.$param['ppid'].'"/>
			<SelectedFare/>' ;
		
/*LAF 여야 되네 FareCode 가 ㅡ.ㅡ 흠..*/
			$this->putB($req) ;
			return $this->get($param) ;

		}

		/** 여행 상세 정보 가져오기 **/
		function getItineraryDetail($param)
		{

			$this->setUrl($this->FITURL."/ItineraryDetail") ;
			$this->putH(
				"getItineraryDetail",$this->interfaceURL."/ItineraryDetail","OTA_CruiseItineraryDescRQ","","","","1","") ;		


			$start				= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월일
			$ship				= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$cruisePackageCode	= $this->getAttr("CruisePackageCode",$param['cpc'],$param['cpc']) ;		// 크루즈 패키지 코드

			$req ='
			<SelectedSailing ' . $ship . $start . '/>
	        <PackageOption ' . $cruisePackageCode  . '/>' ;

			$this->putB($req) ;

			return $this->get($param) ;
		

		}

		function holdCabin($param)
		{
			$this->setUrl($this->FITURL."/HoldCabin") ;
			$this->putH(
				"holdCabin",$this->interfaceURL."/HoldCabin","OTA_CruiseCabinHoldRQ","","","","1","") ;		


			$start				= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월일
			$ship				= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			

			$amt = $param[adult_amt] + $param[child_amt] ;

			$req ='
			<GuestCounts>
				<GuestCount Quantity="' . $amt . '"/>
			</GuestCounts>
			<SelectedSailing ' . $start . $ship . ' >
			<SelectedFare FareCode="'.$param[ppid].'"/>
				<SelectedCategory PricedCategoryCode="' . $param[cate] . '">
				<SelectedCabin CabinNumber="' . $param[cabin] . '"/>
			</SelectedCategory>
			</SelectedSailing>
			<SearchQualifiers/>' ;

			$this->putB($req) ;

			return $this->get($param) ;			

		}

		// 저녁식사 리스트 가져오기
		function getDinningList($start,$sc,$persion_amt,$scc,$fareCode)
		{
			$this->setUrl($this->FITURL."/DiningList") ;
			$this->putH(
				"getDiningList",$this->interfaceURL."/DiningList","OTA_CruiseDiningAvailRQ","","","false","1","") ;		

// RetransmissionIndicator="false" SequenceNmbr="1" TimeStamp="2009-02-02T16:01:31.299Z" TransactionIdentifier="000156393" Version="1.0" 

			$guest = "<GuestCounts>" ;
			
			for($i = 0 ; $i < $persion_amt ; $i++ )
			{
				$guest .= '<GuestCount Quantity="1"/>' ;
			}

			$guest .= '</GuestCounts>' ;

			$req = $guest . 
			'<SailingInfo>
				<SelectedSailing ListOfSailingDescriptionCode="" Start="' . $start . '">
					<CruiseLine ShipCode="' . $sc . '"/>
				</SelectedSailing>
			<SelectedCategory BerthedCategoryCode="' . $scc . '" FareCode="' . $fareCode . '" PricedCategoryCode="' . $scc . '"/>
			</SailingInfo>
			<SelectedFare/>' ;

			$this->putB($req) ;
			
			return $this->get($param) ;		

		}

		function getBookingHistory($id){
			$this->setUrl($this->FITURL."/BookingHistory");

			$this->putH("getBookingHistory",$this->interfaceURL."/BookingHistory","OTA_ReadRQ","40","","","1","Start");

			$req = '<UniqueID ID="'.$id.'" Type="14"/>';

			$this->putB($req);
			return $this->get($param) ;
		
		}

		function makePayment($param)
		{
			//url setting
			$this->setUrl($this->FITURL."/Payment") ;
			$this->putH("makePayment",$this->interfaceURL."/Payment","OTA_CruisePaymentRQ","","","false","1","106597") ;	

			$id					= $param[0] ;			//ID : 예약번호
			$cardCode			= $param[6] ;			//CardCode :카드종류
			$cardNumber			= $param[1];			//CardNumber : 카드번호(str)
			$expireDate			= $param[2];			//ExpireDate : 카드 유효기간
			$cardHorderName		= strtoupper($param[3]);			//CardHorderName : 입금자명
			$amount				= number_format($param[4],2);		//Amount : 입금액
			$amount = str_replace(',','',$amount);
		//	$amount = $amount * 10 ; 
			//$amount = 1.00;	//testMode 
			$cardHorderName2 = strtoupper($param[5]);		
		$date = date('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))); 
		//	$date = gmdate('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))-(3600*12)-(3000));

			$req ='
			<ReservationPayment>
				<ReservationID ID="'.$id.'" SyncDateTime="'.$date.'" Type="14" />
				<PaymentDetail>
					<PaymentCard CardCode="'.$cardCode.'" CardNumber="'.$cardNumber.'" ExpireDate="'.$expireDate.'">
					<CardHolderName>'.$cardHorderName2.','.$cardHorderName.'</CardHolderName>			
					</PaymentCard>
					<PaymentAmount Amount="'.$amount.'" CurrencyCode="USD" />
				</PaymentDetail>
			</ReservationPayment>
			<AgentInfo Contact="'.$this->companyName.'" />' ;

			
			$this->putB3($req);
			return $this->get($param) ;
		

		}


		
		function getBookingPrice($param)
		{
			$this->setUrl($this->FITURL."/BookingPrice") ;
			$this->putH(
				"getBookingPrice",$this->interfaceURL."/BookingPrice","OTA_CruisePriceBookingRQ","","","false","1","106597") ;		


			$start				= $param[0] ;			
			$priceCategoryCode	= $param[1]	;	
			$pt					= $param[2]	; 
			$shipCode			= $param[3]	;
			$cabinNumber		= $param[4]	;
			$sitting			= $param[5]	;
			$curisePackageCode	= $param[6] ;
			$adultAmt = $param[7];
			$childAmt = $param[8];
			$vendor = $param[9];

			if($sitting!="U"){
				if($sitting=="O")
				{
					$sitType =  "Open";
				}
				else
				{
					$sitType = "Traditional";

				}
				
			}else{
				$sitType = "Undecided";
				$sitting = "U";
			}

			$req ='
			<SailingInfo>
			<SelectedSailing Start="'.$start.'">
			<CruiseLine ShipCode="'.$shipCode.'"/>
			</SelectedSailing>
			<InclusivePackageOption CruisePackageCode="'.$curisePackageCode.'"/>
			<SelectedCategory FareCode="'.$pt.'" PricedCategoryCode="'.$priceCategoryCode.'" WaitlistIndicator="false" BerthedCategoryCode="'.$priceCategoryCode.'">
			<SelectedCabin CabinNumber="'.$cabinNumber.'" Status="39"/>
			</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>
			<GuestDetails>
			';

			$guest = '';
			for($i=0; $i<$adultAmt ; $i++){
				$guest .= '<GuestDetail>
				<ContactInfo Age="30"/>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>
				<SelectedDining Sitting="'.$sitting.'" SittingType="'.$sitType.'" Status="36"/>
				
				';
				if($vendor!="Z"){
					$guest.='<SelectedOptions OptionCode="PPGR"/>';
				}
				$guest.='
			
				</GuestDetail>';
			}
			for($i=0; $i<$childAmt ; $i++){
				$guest .= '
				<GuestDetail>
				<ContactInfo Age="10"/>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>
				<SelectedDining Sitting="'.$sitting.'" SittingType="'.$sitType.'" Status="36"/>
				';
				if($vendor!="Z"){
					$guest.='<SelectedOptions OptionCode="PPGR"/>';
				}
				
				$guest.='
				
			
				</GuestDetail>';
			}
			$req .= $guest;
			$req .='
			</GuestDetails>
			</ReservationInfo>';

			
			//echo $this->putB($req)."errorCode=>".$this->get($param) ;
			$this->putB($req);
			return $this->get($param) ;


		}

		function retrieveBooking($id)
		{	
			
			$this->setUrl($this->FITURL."/RetrieveBooking");

			
			$req = '<m0:UniqueID ID="'.$id.'" Type="14"/>';
			
			
			 $this->putB2($req);


			 return $this->get($id) ;

		}
		

		function confirmBooking($param)
		{
			
			$this->setUrl($this->FITURL."/ConfirmBooking") ;
						
			$this->putH2("confirmBooking",$this->interfaceURL."/ConfirmBooking","OTA_CruiseBookRQ","","","","1","0","Commit") ;		


			$start				= date("Y-m-d",strtotime($param[0][0]));			
			$scc				= $param[0][1];	
			$shipCd				= $param[0][2]; 
			$ppid				= $param[0][3];
			$temp				= $param[0][4];
			$vendor				= $param[0][5]; 
			$amount				= $param[0][6];
			$cardNumber			= $param[0][7];	
			$expireDate			= $param[0][8]; 
			$cardHorderName		= strtoupper($param[0][9]);
			$cardHorderName2	= strtoupper($param[0][10]);
			$pkgCode			= $param[0][11];
			$cabinNum			= $param[0][12];
			$adultAmt			= $param[0][13];
			$childAmt			= $param[0][14];
			$dinnerType			= $param[0][17];
			//$dinnerType = "O";
			$uniqCd = $param[0][15];
			$ss_term = $param[0][16];
			
			for($i =0; $i<$adultAmt+$childAmt ; $i++){
				$l_name[$i]		= $param[1][$i][0];
				$f_name[$i]		= $param[1][$i][1];
				$phone[$i]		= $param[1][$i][2];
				$email[$i]		= $param[1][$i][3];
				$gender[$i]		= $param[1][$i][4];
				$birth[$i]		= $param[1][$i][5];
				$age[$i]		= $param[1][$i][6];
				$nation[$i]		= $param[1][$i][7];
				
			}
			if($dinnerType!="U"){
				if($dinnerType=="O")
				{
					$sitType =  "Open";
				}
				else
				{
					$sitType = "Traditional";

				}
				
			}else{
				$sitType = "Undecided";
				$dinnerType = "U";
			}

		

			$date = date('Y-m-d',time())."T".date('H:i:s',time());
			

//WaitlistIndicator =true error=> PROMO CODE INVALID WITH WLT CABIN


$req ='
<AgentInfo Contact="'.$this->companyName.'" /> 
<SailingInfo>
	<SelectedSailing Duration="P'.$ss_term.'N" Start="'.$start.'" Status="60">
		<CruiseLine ShipCode="'.$shipCd.'" VendorCode="'.$vendor.'" /> 
	</SelectedSailing>
	<InclusivePackageOption CruisePackageCode="'.$pkgCode.'" /> 
	<SelectedCategory FareCode="'.$ppid.'" PricedCategoryCode="'.$scc.'" WaitlistIndicator="false" BerthedCategoryCode="'.$scc.'">
		<SelectedCabin CabinNumber="'.$cabinNum.'" Status="39" /> 
	</SelectedCategory>
</SailingInfo>
<ReservationInfo>
	<ReservationID ID="0" LastModifyDateTime="'.$date.'" StatusCode="42" Type="14" /> 
	<GuestDetails>
 ';
 $guest = '';
 for($i = 0; $i<$adultAmt; $i++){
	 if($email[$i]=="@"){
		$email[$i] == $email[0];
	 }
 $guest .= '
		<GuestDetail>
			<ContactInfo Age="'.$age[$i].'" ContactType="CNT" Nationality="'.$nation[$i].'" BirthDate="'.$birth[$i].'">
				<PersonName>
					<GivenName>'.$f_name[$i].'</GivenName> 
					<Surname>'.$l_name[$i].'</Surname> 
					<NameTitle>'.$gender[$i].'</NameTitle> 
				</PersonName>
				<Telephone PhoneNumber="'.$phone[$i].'" /> 
			</ContactInfo>
			<ContactInfo ContactType="ALT">
				<Email>'.$email[$i].'</Email> 
			</ContactInfo>
			<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'" />
			';
		
		
		if($vendor!="Z"){
			$guest.='
			<SelectedOptions OptionCode="PPGR"/>';
		} 
			
			
	$guest .='</GuestDetail>';
 }
 for($i=$adultAmt; $i<$adultAmt+$childAmt; $i++){
	  if($email[$i]=="@"){
		$email[$i] == $email[0];
	 }
	$guest .= '
  		<GuestDetail>
			<ContactInfo Age="'.$age[$i].'" ContactType="CNT" Nationality="'.$nation[$i].'" BirthDate="'.$birth[$i].'">
				<PersonName>
					<GivenName>'.$f_name[$i].'</GivenName> 
					<Surname>'.$l_name[$i].'</Surname> 
					<NameTitle>'.$gender[$i].'</NameTitle> 
				</PersonName>
				<Telephone PhoneNumber="'.$phone[$i].'" /> 
			</ContactInfo>
			<ContactInfo ContactType="ALT">
				<Email>'.$email[$i].'</Email> 
			</ContactInfo>
			<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'" />
			';
	if($vendor!="Z"){
		$guest.='
				<SelectedOptions OptionCode="PPGR"/>';
	} 
	$guest.='</GuestDetail>';
 
 }
 $req .= $guest;
 
 $req .= '
	</GuestDetails>
	<LinkedBookings>
		<LinkedBooking>
		</LinkedBooking>
	</LinkedBookings>
</ReservationInfo>
' ;


			//	echo "\nerror End\n";
			$this->putB($req);
			return $this->get($param) ;
			
		}


		function login($param){
		
			$this->setUrl($this->FITURL."/Login") ;

			$this->apiLogin($param);
			return $this->get($param) ;
		
		}

		function service($param){
		
			$this->setUrl($this->FITURL."/OptionDetail") ;

			$this->getListOfService($param);
			return $this->get($param) ;
		
		}



		//TMK Admin에 의해 새로 생긴 Method 2012-01-02 jang//
		function holdCabinForAdmin($param)
		{
			$this->setUrl($this->FITURL."/HoldCabin") ;
			$this->putH(
				"holdCabin",$this->interfaceURL."/HoldCabin","OTA_CruiseCabinHoldRQ","","","","1","") ;		


			$start				= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월일
			$ship				= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			

			$amt = $param[adult_amt] + $param[child_amt] ;

			$req ='
			<GuestCounts>
				<GuestCount Quantity="' . $amt . '"/>
			</GuestCounts>
			<SelectedSailing ' . $start . $ship . ' >
			<SelectedFare FareCode="'.$param[ppid].'"/>
				<SelectedCategory PricedCategoryCode="' . $param[cate] . '">
				<SelectedCabin CabinNumber="' . $param[cabin] . '"/>
			</SelectedCategory>
			</SelectedSailing>
			<SearchQualifiers/>' ;

			$this->putB($req) ;

			return $this->get($param) ;			

		}

		//관리자를 위한 confirmBooking api
		function confirmBookingForAdmin($param)
		{
			
			$this->setUrl($this->FITURL."/ConfirmBooking") ;
						
			$this->putH2("confirmBooking",$this->interfaceURL."/ConfirmBooking","OTA_CruiseBookRQ","","","","1","0","Commit") ;		

			$cabinParam = $param[0] ;
			$cusParam	= $param[1] ;


			$start				= date("Y-m-d",strtotime($cabinParam[0]));	//sail_date
			$scc				= $cabinParam[1];	//scc_cd
			$shipCd				= $cabinParam[2];	//ship_cd
			$ppid				= $cabinParam[3];	//pt_cd
			$temp				= $cabinParam[4];	//ship_cd
			$vendor				= $cabinParam[5]; 	//sunsa_cd
			$amount				= $cabinParam[6];	//total_amt
			$cardNumber			= $cabinParam[7];	//cardNumber
			$expireDate			= $cabinParam[8];	//expireDate
			$cardHorderName		= strtoupper($cabinParam[9]);	//cardHorderName
			$cardHorderName2	= strtoupper($cabinParam[10]);	//cardHorderName2
			$pkgCode			= $cabinParam[11];	//package_id
			$cabinNum			= $cabinParam[12];	//stateroom_cd
			$adultAmt			= $cabinParam[13];	//adult_person
			$childAmt			= $cabinParam[14];	//child_person
			$uniqCd				= $cabinParam[15];	//rsv_no
			$ss_term			= $cabinParam[16];	//ss_term
			$dinnerType			= $cabinParam[17];	//dinning_info



			$date = date('Y-m-d',time())."T".date('H:i:s',time());
			


			$req = '<AgentInfo Contact="'.$this->companyName.'" /> 
						<SailingInfo>
							<SelectedSailing Duration="P'.$ss_term.'N" Start="'.$start.'" Status="60">
								<CruiseLine ShipCode="'.$shipCd.'" VendorCode="'.$vendor.'" /> 
							</SelectedSailing>
							<InclusivePackageOption CruisePackageCode="'.$pkgCode.'" /> 
							<SelectedCategory FareCode="'.$ppid.'" PricedCategoryCode="'.$scc.'" WaitlistIndicator="false" BerthedCategoryCode="'.$scc.'">
								<SelectedCabin CabinNumber="'.$cabinNum.'" Status="39" /> 
							</SelectedCategory>
						</SailingInfo>
						<ReservationInfo>
							<ReservationID ID="0" LastModifyDateTime="'.$date.'" StatusCode="42" Type="14" /> 
						<GuestDetails>';



			//Guest
			if( $dinnerType != "U" )
			{
				if( $dinnerType == "O" )
				{
					$sitType =  "Open";
				}
				else
				{
					$sitType = "Traditional";
				}
				
			}
			else
			{
				$sitType = "Undecided";
				$dinnerType = "U";
			}

			$guest = '';

			for( $i = 0 ; $i < sizeof($cusParam) ; $i++ )
			{
				$f_name[$i]		= $cusParam[$i][0];
				$l_name[$i]		= $cusParam[$i][1];
				$phone[$i]		= $cusParam[$i][2];
				$email[$i]		= $cusParam[$i][3];
				$gender[$i]		= $cusParam[$i][4];
				$birth[$i]		= $cusParam[$i][5];
				$age[$i]		= $cusParam[$i][6];
				$nation[$i]		= $cusParam[$i][7];
				$insu[$i]		= $cusParam[$i][8];


				//$attrAge = $this->getAttr("Age", $age[$i], $age[$i]) ;
				$attrAge = ' Age="30" ' ;
				//$attrBirth = $this->getAttr("BirthDate", $birth[$i], $birth[$i]) ;
				$attrPhone = $this->getAttr("PhoneNumber", $phone[$i], $phone[$i]) ;

				$guest .= '<GuestDetail>
								<ContactInfo ' . $attrAge . ' ContactType="CNT" Nationality="'.$nation[$i].'" ' . $attrBirth . '>
									<PersonName>
										<GivenName>'.$f_name[$i].'</GivenName> 
										<Surname>'.$l_name[$i].'</Surname> 
										<NameTitle>'.$gender[$i].'</NameTitle> 
									</PersonName>
									<Telephone ' . $attrPhone . ' /> 
								</ContactInfo>
								<ContactInfo ContactType="ALT">
									<Email>'.$email[$i].'</Email> 
								</ContactInfo>
								<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'" />';
				
				
				if( $insu[$i] != "" )
				{
					$guest.='<SelectedInsurance InsuranceCode = "' . $insu[$i] . '" SelectedOptionIndicator = "true"/ >';
				}
			
				if($vendor!="Z"){
					$guest .= '<SelectedOptions OptionCode="PPGR"/>';
				} 
				
				
				$guest .='</GuestDetail>';
			}

			
			$req .= $guest;
	 
			$req .= '	</GuestDetails>
						<LinkedBookings>
							<LinkedBooking>
							</LinkedBooking>
						</LinkedBookings>
					</ReservationInfo>' ;

		
			$this->putB($req);
			return $this->get() ;
			
		}
		
		/* ping test */
		function getPingTest() {
			$this->setUrl($this->SERVICE_URL) ;	// URL SETTING
		
			$this->putH("OTA_PingRQ", "", "3", "100000002") ;
				
			$this->initSetSOAPData("OTA_PingRQ", "AL") ;
		
			$req = '<EchoData>THIS IS A PING TEST</EchoData>';
				
			$this->putB($req) ;
		
			return $this->get() ;
		}


		//class end
	}
}

?>