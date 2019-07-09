<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/CruisAPI.php" ; ?>
<?

/** 크루즈 API 요청하는 클래스 **/

if(! class_exists("Req") )	{

	class Req extends CruisApi
	{

		function Req($url)
		{
			$this->CruisApi($url) ;

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


		function getCruiseSailingList($param)
		{
			// Start
			// End
			// Duration
			// Minimum duration
			// Maximum duration
		}



		/***************************************************************************
		 *	제  목 : 크루즈 API - 세일링 리스트 조회
		 *	함수명 : getSailingList
		 *	작성일 : 이홍재
		 *	작성자 :
		 *	설  명 : res, req 포함해서 return
		 *	수  정 :
		 *   PARAM  :
		 '***************************************************************************/
		function getSailingList($param)
		{
			$this->setUrl($this->FITURL.'/SailingList') ;
			$this->putH_Core(
			"getSailingList",$this->interfaceURL."/SailingList","OTA_CruiseSailAvailRQ","10","true","false","1","106597", $param["moreDataEchoToken"]) ;

			$start		= $this->getAttr("Start",$param['sdate'],$param['sdate'] . "-01") ;		// 년월

			$year = substr($param['edate'],0,4);     //ex) 2013
			$month = substr($param['edate'],5,2);  //ex) 09
			$last_day = date("t", mktime(0, 0, 1, $month, 1, $year));

			$end		= $this->getAttr("End",$param['edate'],$param['edate'] . "-".$last_day) ;		// 년월
			$duration	= $this->getAttr("Duration",$param['duration'],$param['duration']) ;	// 일정 2박 3일
			$vendor		= $this->getAttr("VendorCode",$param['vendor'],$param['vendor']) ;		// 선사
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$port		= $this->getAttr("PortCode",$param['port'],$param['port']) ;			// 출발항구
			$regionCode = $this->getAttr("RegionCode",$param['dest'],$param['dest']) ;
			$subRegionCode = $this->getAttr("SubRegionCode",$param['subdest'],$param['subdest']) ;

			//$dest		= $this->getTag("<RegionPref RegionCode=",$param['dest'],$param['dest'],"/>") ;			// 여행지

			$req = '
      		<GuestCounts>
          		<GuestCount Quantity="2"/>
        	</GuestCounts>
			<SailingDateRange ' . $start . $end . $duration  . '/>
			<CruiseLinePrefs>
			<CruiseLinePref ' . $vendor . $ship . ' >
				<SearchQualifiers>
					<Port EmbarkIndicator="true" ' . $port . ' />
				</SearchQualifiers>
			</CruiseLinePref>
			</CruiseLinePrefs>
			<RegionPref ' . $regionCode . $subRegionCode . '/>' . $dest ;


			$this->putB($req) ;

			return $this->get($param) ;
		}

		/***************************************************************************
		 *	제  목 : 크루즈 API - 여행 상세 정보 가져오기
		 *	함수명 : getItineraryDetail
		 *	작성일 : 이홍재
		 *	작성자 :
		 *	설  명 : res, req 포함해서 return
		 *	수  정 :
		 *   PARAM  :
		 '***************************************************************************/
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

		// 세일링과 관련한 패키지 리스트를 가져온다.
		function getPackageDetail($param)
		{
			$this->setUrl($this->FITURL."/PackageDetail") ;
			$this->putH(
					"getPackageDetail ",$this->interfaceURL."/PackageDetail","OTA_CruisePkgAvailRQ","150","","","1","106597") ;

			$start		  = $this->getAttr("Start",$param['date'],$param['date']) ;				// 년월
			$ship		  = $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;					// 배
			$packageCode  = $this->getAttr("CruisePackageCode",$param['packageCode'],$param['packageCode']) ;
			$typeCode	  = $this->getAttr("PackageTypeCode",$param['typeCode'],$param['typeCode']) ;

			$req = '
			<SailingInfo>
				<SelectedSailing ' . $start . '>
					<CruiseLine ' . $ship . ' />
				</SelectedSailing>
			</SailingInfo>
			<PackageOption '.$packageCode.' '.$typeCode.' />' ;

			$this->putB($req) ;

			return $this->get($param) ;

		}

		/***************************************************************************
		*	제  목 : 크루즈 API - Avail Category 조회
		*	함수명 : getCategoryList
		*	작성일 : 2013-07-02
		*	작성자 :
		*	설  명 : LoyaltyMembershipID, PromotionCode 추가된 버전
		*	수  정 : dev.lee 2013-07-02
		'***************************************************************************/
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

			$isSilver = $param[5];

			$getNRD = isset($param[6])?$param[6]:false;

			$guest = '';

			$adSeq = 0 ;

			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$default_age = ($i == 0 && $isSilver == "1") ? "Age=\"55\"" : "Age=\"30\"" ;
				$guest .= sprintf(
							'<Guest %s %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
							, $default_age
							, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
							, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
							) ;

				$adSeq++ ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest .= sprintf(
							'<Guest Age="10" %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
							, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
							, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
							) ;

				$adSeq++ ;
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
			';
if($getNRD)
	$req .='<SelectedFare IncludeNonRefundablePromos="Yes"/>' ;
else
	$req .='<SelectedFare IncludeNonRefundablePromos="No"/>' ;


			$this->putB($req) ;
			//return $this->get($param) ;

		}


		function getCategoryList2($param)
		{
			$this->setUrl($this->FITURL."/CategoryList") ;
			$this->putH(
				"getCategoryList",$this->interfaceURL."/CategoryList","OTA_CruiseCategoryAvailRQ","40","","","1","106597",'2.0') ;

            $start = substr($param[0],6,4)."-".substr($param[0],0,2)."-".substr($param[0],3,2);
							// 년월
			$ship		= $this->getAttr("ShipCode",$param[1],$param[1]) ;			// 배
			$guestCount	= $param[2]+$param[3] ;		// 기본 1개로 세팅
			$adultAmt = $param[2];
			$childAmt = $param[3];

			$isSilver = $param[5];


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
				<SelectedSailing Start="' . $start . '">
					<CruiseLine ' . $ship . '/>
				</SelectedSailing>
			</SailingInfo>

			<SelectedFare IncludeNonRefundablePromos="No"/>' ;

			$this->putB($req) ;

			return $this->get($param) ;

		}



		/***************************************************************************
		*	제  목 : 크루즈 API - 쉽 케빈 리스트 조회
		*	함수명 : getCabinList
		*	작성일 : 2013-07-04
		*	작성자 :
		*	설  명 : LoyaltyMembershipID, PromotionCode 추가된 버전
		*	수  정 : dev.lee 2013-07-04
		'***************************************************************************/
		function getCabinList($param)
		{

 			$this->setUrl($this->FITURL."/CabinList") ;
			$this->putH(
				"getCabinList",$this->interfaceURL."/CabinList","OTA_CruiseCabinAvailRQ","50","true","false","1","106597","1.0","01") ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$adultAmt	= $param['adult_amt'] ;
			$childAmt	= $param['child_amt'] ;
			$guestCount = $param['adult_amt'] + $param['child_amt'] ;

			$price_type = $param['pt'];
			$ppid = $param['ppid'];

			$guest = "" ;

			$adSeq = 0 ;

			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$default_age = ($i == 0 && $_REQUEST["isSilver"] == "1") ? "Age=\"55\"" : "Age=\"30\"" ;

				$guest .= sprintf(
							'<Guest %s %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
							, $default_age
							, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
							, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
							) ;
				$adSeq++ ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest .= sprintf(
							'<Guest Age="10" %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
							, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
							, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
							) ;
				$adSeq++ ;
			}

			$guest .= "<GuestCounts>" ;
			for($i = 0 ; $i < $guestCount ; $i++ )
			{
				$guest .= '<GuestCount Quantity="1" />' ;
			}
			$guest .= "</GuestCounts>" ;

			if($param['floor'] == "All") {
                $req = $guest .
                    '<SailingInfo>
						<SelectedSailing '. $start . '>
							<CruiseLine ' .$ship . '/>
						</SelectedSailing>
					</SailingInfo>
					<SearchQualifiers BerthedCategoryCode="' . $param["cate"] . '" FareCode="'.$param['ppid'].'"/>
					<SelectedFare/>' ;
			// 층별 검색추가 20190529
            }else{
                $req = $guest .
                    '<SailingInfo>
						<SelectedSailing '. $start . '>
							<CruiseLine ' .$ship . '/>
						</SelectedSailing>
					</SailingInfo>
					<SearchQualifiers BerthedCategoryCode="' . $param["cate"] . '" FareCode="'.$param['ppid'].'" DeckNumber="'.$param['floor'].'"/>
					<SelectedFare/>' ;
			}

			$this->putB($req) ;
			return $this->get($param) ;
		}


		function getCabinDetail($param)
		{
			$this->setUrl($this->FITURL."/CabinDetail") ;
			$this->putH(
					"getCabinDetail",$this->interfaceURL."/CabinDetail","OTA_CruiseCabinAvailRQ","50","true","false","1","106597") ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$cabinNumber	= $this->getAttr("CabinNumber",$param['cabinNumber'],$param['cabinNumber']) ;
			$status	= $this->getAttr("Status",$param['status'],$param['status']) ;

			$adultAmt	= $param['adult_amt'] ;
			$childAmt	= $param['child_amt'] ;
			$guestCount = $param['adult_amt'] + $param['child_amt'] ;
			$guest = "" ;

			$adSeq = 0 ;

			/* for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$default_age = ($i == 0 && $_REQUEST["isSilver"] == "1") ? "Age=\"55\"" : "Age=\"30\"" ;

				$guest .= sprintf(
						'<Guest %s %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
						, $default_age
						, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
						, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
						) ;
				$adSeq++ ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest .= sprintf(
						'<Guest Age="10" %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
						, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
						, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
						) ;
				$adSeq++ ;
			} */

			$guest .= "<GuestCounts>" ;
			for($i = 0 ; $i < $guestCount ; $i++ )
			{
				$guest .= '<GuestCount Quantity="1" />' ;
			}
			$guest .= "</GuestCounts>" ;


			$req = $guest .
			'<SailingInfo>
				<SelectedSailing '. $start . '>
				<CruiseLine ' .$ship . '/>
				</SelectedSailing>
				 <SelectedCategory> <SelectedCabin '.$cabinNumber.' '.$status.'/> </SelectedCategory>
			</SailingInfo>
			<SelectedFare/>' ;

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

		function releaseCabin($param)
		{
			$this->setUrl($this->FITURL."/ReleaseCabin") ;
			$this->putH("releaseCabin",$this->interfaceURL."/ReleaseCabin","OTA_CruiseCabinUnholdRQ","","","","1","") ;

			$start				= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월일
			$ship				= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배

			//$amt = $param[adult_amt] + $param[child_amt] ;

			$req ='
			<SelectedSailing ' . $start . $ship . ' >
				<SelectedCabin CabinNumber="' . $param['cabin'] . '"/>
			</SelectedSailing>' ;

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
            $this->setUrl($this->ECCP_FITURL."/Payment") ;
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

		// bookingPrice 테스트
		function getBookingPriceReqTest($param)
		{
			$this->setUrl($this->FITURL."/BookingPrice") ;

			$this->getBookingPriceAPI($param);


			return $this->get($param) ;
		}

		function getBookingPrice($param)
		{
			$this->setUrl($this->FITURL."/BookingPrice") ;
			/*
			$this->putH2(
				"getBookingPrice",$this->interfaceURL."/BookingPrice","OTA_CruisePriceBookingRQ","","","false","1","106597", "RetrievePrice") ;
			*/

			$this->makePOS($this->uniqTerminalId) ;


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
			$is_nrd = false;
            if(isset($param[10]) && $param[10]==true)
            {
                $is_nrd = true;
            }

            //PPGR 에 해당되지 않는 선박 : 아자마라 전 선박 + 셀러브리티 X시리즈
            $PPGR_option_str = '<SelectedOptions OptionCode="PPGR"/>';
            $xSeriesShipCodeArr = array('XE','XO', 'XP','FL');
            if($vendor=="Z"){
                $PPGR_option_str	= '';
            }
            else if(in_array($shipCode, $xSeriesShipCodeArr)){
				$PPGR_option_str	= '';
			}

			if($sitting !="U" ){
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

            $prtDeStr = $prtStr ="";
            if(isset($_REQUEST['PromotionCode']) && ( $_REQUEST['PromotionCode'] != "" && $_REQUEST['PromotionCode'] != "undefined" ))
            {
                $prtStr = "<SelectedPromotions PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />";
                $prtDeStr = "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" ;

            }
            if($pt!= "" && $pt != "undefined" )
            {
                $prtStr = "<SelectedPromotions PromotionCode=\"" . $pt . "\" />";
            }
			$req ='
			<SailingInfo>
			<SelectedSailing Start="'.$start.'">
			<CruiseLine ShipCode="'.$shipCode.'"/>
			</SelectedSailing>
			<InclusivePackageOption CruisePackageCode="'.$curisePackageCode.'"/>
			<SelectedCategory FareCode="'.$pt.'"';

if($is_nrd)
	$req .=' IncludeNonRefundablePromos="Yes" ' ;
else
	$req .=' IncludeNonRefundablePromos="No"' ;

            $req .=' PricedCategoryCode="'.$priceCategoryCode.'" WaitlistIndicator="false" BerthedCategoryCode="'.$priceCategoryCode.'">
			<SelectedCabin CabinNumber="'.$cabinNumber.'" Status="39"/>
            ' . $prtStr . '
			</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>
			<GuestDetails>
			';


			$adSeq = 0 ;

			$guest = '';
			for($i=0; $i<$adultAmt ; $i++)
			{
				$loyDeStr = ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\" />" : "" ;

				$default_age = ($i == 0 && $_REQUEST["isSilver"] == "1") ? "Age=\"55\"" : "Age=\"30\"" ;

				$guest .= sprintf('<GuestDetail>
				<ContactInfo %s ProfileType="1">
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>
				%s
				<SelectedDining Sitting="'.$sitting.'" SittingType="'.$sitType.'" Status="36"/>
				%s
				'
				, $default_age
				, $loyDeStr
				, $prtDeStr
				) ;

                $guest.=$PPGR_option_str;

				//2012-10-09 Sejin.Jang - Assist Card 오류회피
				if($vendor=="R")
				{
					/*
					$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
					$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
					*/
				//	$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="true"/>' ;
				//	$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="true"/>' ;

				}

				$guest .= '<SelectedInsurance InsuranceCode="TIIR" SelectedOptionIndicator="false"/>';

				$guest.='

				</GuestDetail>';

				$adSeq++ ;
			}
			for($i=0; $i<$childAmt ; $i++){

				$loyDeStr = ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\" />" : "" ;

				$guest .= sprintf('
				<GuestDetail>
				<ContactInfo Age="10" ProfileType="1">
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>
				%s
				<SelectedDining Sitting="'.$sitting.'" SittingType="'.$sitType.'" Status="36"/>
				%s
				'
				, $loyDeStr
				, $prtDeStr
				) ;

                $guest.=$PPGR_option_str;

				//2012-10-09 Sejin.Jang - Assist Card 오류회피
				if($vendor=="R")
				{
					/*
					$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
					$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
					*/
				//	$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="true"/>' ;
				//	$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="true"/>' ;

				}

				$guest .= '<SelectedInsurance InsuranceCode="TIIR" SelectedOptionIndicator="false"/>';

				$guest.='


				</GuestDetail>';

				$adSeq++ ;
			}
			$req .= $guest;
			$req .='
			</GuestDetails>
			</ReservationInfo>';

			//echo $this->putB($req)."errorCode=>".$this->get($param) ;
			$this->putB($req);
			return $this->get($param) ;


		}

		function getBookingPrice_bak($param)
		{
			$this->setUrl($this->FITURL."/BookingPrice") ;

			$this->putH2(
				"getBookingPrice",$this->interfaceURL."/BookingPrice","OTA_CruisePriceBookingRQ","","","false","1","106597", "RetrievePrice") ;

			/*
			$this->putH(
				"getBookingPrice",$this->interfaceURL."/BookingPrice","OTA_CruisePriceBookingRQ","","","false","1","106597") ;
			*/


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

            //PPGR 에 해당되지 않는 선박 : 아자마라 전 선박 + 셀러브리티 X시리즈
            $PPGR_option_str = '<SelectedOptions OptionCode="PPGR"/>';
            $xSeriesShipCodeArr = array('XE','XO', 'XP','FL');
            if($vendor=="Z"){
                $PPGR_option_str	= '';
            }

            else if(in_array($shipCode, $xSeriesShipCodeArr)){
				$PPGR_option_str	= '';
			}

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

			$date = date('Y-m-d',time())."T".date('H:i:s',time());



			$req = sprintf('
					<SailingInfo>
					<SelectedSailing Start="'.$start.'">
					<CruiseLine ShipCode="'.$shipCode.'" />
					</SelectedSailing>
					<InclusivePackageOption CruisePackageCode="'.$curisePackageCode.'"  Start="'.$start.'" />
					<SelectedCategory FareCode="'.$pt.'" PricedCategoryCode="'.$priceCategoryCode.'" WaitlistIndicator="false" BerthedCategoryCode="'.$priceCategoryCode.'">
					<SelectedCabin CabinNumber="'.$cabinNumber.'" Status="39" ></SelectedCabin>
					%s
					</SelectedCategory>
					</SailingInfo>
					<ReservationInfo>


					<ReservationID ID="0" LastModifyDateTime="'.$date.'" StatusCode="42" Type="14" />


					<GuestDetails>
			', ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedPromotions PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" ></SelectedPromotions>" : ""
			);
/*
			$prtStr = ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedPromotions PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : "" ;


			<ReservationID ID="0" LastModifyDateTime="'.$date.'" StatusCode="42" Type="14" />


			$req = '
				<SailingInfo>

					<SelectedSailing Start="'.$start.'">
					<CruiseLine ShipCode="'.$shipCode.'" />
					</SelectedSailing>
					<InclusivePackageOption CruisePackageCode="'.$curisePackageCode.'" ></InclusivePackageOption>
					<SelectedCategory FareCode="'.$pt.'" PricedCategoryCode="'.$priceCategoryCode.'" WaitlistIndicator="false" BerthedCategoryCode="'.$priceCategoryCode.'">
					<SelectedCabin CabinNumber="'.$cabinNumber.'" Status="39" />
					' . $prtStr . '
					</SelectedCategory>
					</SailingInfo>
			' ;

			echo $req ;

			exit ;
*/

			$guest = '';
			for($i=0; $i<$adultAmt ; $i++){
				$guest .= sprintf('<GuestDetail>
				<ContactInfo Age="30" ProfileType="1" >
				%s
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>
				%s
				<SelectedDining Sitting="'.$sitting.'" SittingType="'.$sitType.'" Status="36"/>
				'
				, ( $_REQUEST['LoyaltyMembershipID'] != "" ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'] . "\" />" : ""
				, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""  );



                $guest.=$PPGR_option_str;

				//2012-10-09 Sejin.Jang - Assist Card 오류회피
				if($vendor=="R")
				{
					$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
					$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
				}


				$guest.='

				</GuestDetail>';
			}

			for($i=0; $i<$childAmt ; $i++){
				$guest .= sprintf('
				<GuestDetail>
				<ContactInfo Age="10" ProfileType="1" >
				%s
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>
				%s
				<SelectedDining Sitting="'.$sitting.'" SittingType="'.$sitType.'" Status="36"/>
				'
				, ( $_REQUEST['LoyaltyMembershipID'] != "" ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'] . "\" />" : ""
				, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : "" );

                $guest.=$PPGR_option_str;

				//2012-10-09 Sejin.Jang - Assist Card 오류회피
				if($vendor=="R")
				{
					$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
					$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
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



		function retrieveBooking($id, $newTerminalID = "", $isRetrievePriceMode=false)
		{
			$this->setUrl($this->FITURL."/RetrieveBooking");
			$req = '<m0:UniqueID ID="'.$id.'" Type="14"/>';
			$this->putB2($req, 'OTA_ReadRQ', $this->interfaceURL."/RetrieveBooking", 'retrieveBooking', $newTerminalID, $isRetrievePriceMode);
			return $this->get($id) ;

		}

		// confirmBooking 테스트
		function confirmBookingReqTest($param)
		{
			$this->setUrl($this->ECCP_FITURL."/ConfirmBooking") ;

			$this->getConfirmBookingAPI($param);


			return $this->get($param) ;
		}

		function confirmBooking($param, $TransactionActionCode = "Commit", $confirmId = "0", $paymentType = "")
		{
			if($confirmId == "") $confirmId = "0";
			$this->setUrl($this->FITURL."/ConfirmBooking") ;

			$this->putH2("confirmBooking",$this->interfaceURL."/ConfirmBooking","OTA_CruiseBookRQ","","","","1","0",$TransactionActionCode) ;


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
			$dinnerTableSize	= $param[0][18];
			$bedConfigCode		= $param[0][19];
			$linkedBookingConfirmId = $param[0][20];
			$is_nrd = false;
            if(isset($param[0][21]) && $param[0][21]==true)
            {
                $is_nrd = true;
            }
			//$dinnerType = "O";
			$uniqCd = $param[0][15];
			$ss_term = $param[0][16];

            //PPGR 에 해당되지 않는 선박 : 아자마라 전 선박 + 셀러브리티 X시리즈
            $PPGR_option_str = '<SelectedOptions OptionCode="PPGR"/>';
            $xSeriesShipCodeArr = array('XE','XO', 'XP','FL');
            if($vendor=="Z"){
                $PPGR_option_str	= '';
            }

            else if(in_array($shipCd, $xSeriesShipCodeArr)){
				$PPGR_option_str	= '';
			}


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


			$prtStr = ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedPromotions PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : "" ;


			$req = '
			<AgentInfo Contact="'.$this->companyName.'" />
			<SailingInfo>
				<SelectedSailing Duration="P'.$ss_term.'N" Start="'.$start.'" Status="60">
					<CruiseLine ShipCode="'.$shipCd.'" VendorCode="'.$vendor.'" />
				</SelectedSailing>
				<InclusivePackageOption CruisePackageCode="'.$pkgCode.'" />
				<SelectedCategory FareCode="'.$ppid.'"';
            if($is_nrd)
                $req .=' IncludeNonRefundablePromos="Yes" ' ;
            else
                $req .=' IncludeNonRefundablePromos="No" ' ;

            $req .=' PricedCategoryCode="'.$scc.'" WaitlistIndicator="false" BerthedCategoryCode="'.$scc.'">
					<SelectedCabin CabinNumber="'.$cabinNum.'" Status="39" >';

			if($bedConfigCode != ""){//침대형태 선택 추가 - By 유현돈(20180119)
				$req .= '<CabinConfiguration BedConfigurationCode = "'.$bedConfigCode.'"/>';
			}



			$req .= sprintf('</SelectedCabin>
					</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>
				<ReservationID ID="'.$confirmId.'" LastModifyDateTime="'.$date.'" StatusCode="42" Type="14" />
				<GuestDetails>
			 ');


			$prtDeStr = ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : "" ;
			$loyDeStr = ( $_REQUEST['LoyaltyMembershipID'] != "" ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'] . "\" />" : "" ;


			$guest = '';

			$adSeq = 0 ;


			for($i = 0; $i<$adultAmt; $i++){
				if($email[$i]=="@")
				{
					$email[$i] == $email[0];
				}

				$guest .= sprintf('
				<GuestDetail>
					<ContactInfo Age="'.$age[$i].'" ContactType="CNT" Nationality="'.$nation[$i].'" BirthDate="'.$birth[$i].'">
						<PersonName>
							<GivenName>'.$f_name[$i].'</GivenName>
							<Surname>'.$l_name[$i].'</Surname>
							<NameTitle>'.$gender[$i].'</NameTitle>
						</PersonName>
						<Telephone PhoneNumber="'.$phone[$i].'" />
					</ContactInfo>
					<ContactInfo ContactType="EMG"/>
					<ContactInfo ContactType="ALT">
						<Email>'.$email[$i].'</Email>
					</ContactInfo>
					%s
					<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'" TableSize="'.$dinnerTableSize.'"/>
					%s
				'
				, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != ""/*  && $i == 0 */ ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\" />" : ""
				, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
				) ;


                $guest.=$PPGR_option_str;

				//2012-10-09 Sejin.Jang - Assist Card 오류회피
				if($vendor=="R")
				{
				//	$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
				//	$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
				}

				/*
				 * If = False – TIIR won’t be added to the booking.
				 * It is also possible to decline or remove TIIR by not sending a SelectedInsurance element
				 */

				//$guest .= '<SelectedInsurance InsuranceCode="TIIR" SelectedOptionIndicator="false"/>';

				$guest .='</GuestDetail>';

				$adSeq++ ;
			}

			for($i=$adultAmt; $i<$adultAmt+$childAmt; $i++)
			{
				if($email[$i]=="@"){
					$email[$i] == $email[0];
				}

				$guest .= sprintf('
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
						%s
						<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'" TableSize="'.$dinnerTableSize.'"/>
						%s
				'
				, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != ""/*  && $i == 0 */ ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\" />" : ""
				, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
				);


                $guest.=$PPGR_option_str;

				//2012-10-09 Sejin.Jang - Assist Card 오류회피
				if($vendor=="R")
				{
				//	$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
				//	$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
				}

				/*
				 * If = False – TIIR won’t be added to the booking.
				 * It is also possible to decline or remove TIIR by not sending a SelectedInsurance element
				 */
	        	//$guest .= '<SelectedInsurance InsuranceCode="TIIR" SelectedOptionIndicator="false"/>';

				$guest.='</GuestDetail>';

				$adSeq++ ;

			}

			$req .= $guest;

			$req .= '
				</GuestDetails>';

			if($linkedBookingConfirmId == ""){
				$req.=	'<LinkedBookings>
						<LinkedBooking>
						</LinkedBooking>
					</LinkedBookings>'
						;
			}else{
				$req.=	'<LinkedBookings>
                        <LinkedBooking LinkTypeCode="2">
                           <UniqueID ID="'.$linkedBookingConfirmId.'" Type="14"/>
                        </LinkedBooking>
                     </LinkedBookings>
				';
			}

			if($paymentType != "" && $paymentType == "check"){

				$req .= '<PaymentOptions>
	                  <PaymentOption RPH="1">
	                     <BankAcct ChecksAcceptedInd="true"/>
	                     <PaymentAmount Amount="0.00"/>
	                  </PaymentOption>
					  <PaymentOption RPH="2">
	                     <BankAcct ChecksAcceptedInd="true"/>
	                     <PaymentAmount Amount="0.00"/>
	                  </PaymentOption>
	               </PaymentOptions>';
			}

			$req.='</ReservationInfo>
			' ;

			//	echo "\nerror End\n";
			$this->putB($req);

			return $this->get($param) ;
		}


		function login($param)
		{

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

			$this->setUrl($this->ECCP_FITURL."/ConfirmBooking") ;

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

            //PPGR 에 해당되지 않는 선박 : 아자마라 전 선박 + 셀러브리티 X시리즈
            $PPGR_option_str = '<SelectedOptions OptionCode="PPGR"/>';
            $xSeriesShipCodeArr = array('XE','XO', 'XP','FL');
            if($vendor=="Z"){
                $PPGR_option_str	= '';
            }

            else if(in_array($shipCd, $xSeriesShipCodeArr)){
				$PPGR_option_str	= '';
			}




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
				$attrBirth = $this->getAttr("BirthDate", $birth[$i], $birth[$i]) ;
				$attrPhone = $this->getAttr("PhoneNumber", $phone[$i], $phone[$i]) ;

				$guest .= '<GuestDetail>
								<ContactInfo ' . $attrAge . ' ContactType="CNT" Nationality="'.$nation[$i].'">
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
								<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'"/>';


				if( $insu[$i] != "" )
				{
					/*
					 * If = False – TIIR won’t be added to the booking.
					 * It is also possible to decline or remove TIIR by not sending a SelectedInsurance element
					 */
					$guest.='<SelectedInsurance InsuranceCode="' . $insu[$i] . '" SelectedOptionIndicator="true"/>';
				}

                $guest.=$PPGR_option_str;

				//2012-10-09 Sejin.Jang - Assist Card 오류회피
				if($vendor=="R")
				{
				//	$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
				//	$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
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


		function getFareList($param)
		{

			$this->setUrl($this->FITURL."/FareList") ;
			$this->putH(
					"getFareList",$this->interfaceURL."/FareList","OTA_CruiseFareAvailRQ","150","true","false","1","106597") ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$adultAmt	= $param['adultAmt'] ;
			$childAmt	= $param['childAmt'] ;
			$guestCount = $param['adultAmt'] + $param['childAmt'] ;

			$packageCode = $param['packageCode'];
			$status = $param['status'];

			$guest = "" ;

			$adSeq = 0 ;

			for($i = 0 ; $i < $adultAmt ; $i++ )
			{
				$default_age = ($i == 0 && $_REQUEST["isSilver"] == "1") ? "Age=\"55\"" : "Age=\"30\"" ;

				$guest .= sprintf(
						'<Guest %s %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
						, $default_age
						, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
						, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
						) ;
				$adSeq++ ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ )
			{
				$guest .= sprintf(
						'<Guest Age="10" %s>
								<GuestTransportation Mode="29" Status="36">
									<GatewayCity LocationCode="C/O"/>
								</GuestTransportation>
								%s
							</Guest>'
						, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
						, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
						) ;
				$adSeq++ ;
			}

			$guest .= "<GuestCounts>" ;
			for($i = 0 ; $i < $guestCount ; $i++ )
			{
				$guest .= '<GuestCount Quantity="1" />' ;
			}
			$guest .= "</GuestCounts>" ;


			$req = $guest .
			'<SailingInfo>
				<SelectedSailing '. $start . '>
				<CruiseLine ' .$ship . '/>
				</SelectedSailing>
				<InclusivePackageOption CruisePackageCode="'.$packageCode.'"/>
			</SailingInfo>
			<SearchQualifiers>       <Status Status="'.$status.'"/>     </SearchQualifiers>' ;

			$this->putB($req) ;
			return $this->get($param) ;
		}


		function getFareDetail($param)
		{

			$this->setUrl($this->FITURL."/FareDetail") ;
			$this->putH(
					"getFareDetail",$this->interfaceURL."/FareDetail","OTA_CruiseFareAvailRQ","150","true","false","1","106597") ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$fareCode	= $this->getAttr("FareCode",$param['fareCode'],$param['fareCode']) ;

			$adultAmt	= $param['adultAmt'] ;
			$childAmt	= $param['childAmt'] ;
			$guestCount = $param['adultAmt'] + $param['childAmt'] ;

			$guest = "" ;

			$adSeq = 0 ;

			/* for($i = 0 ; $i < $adultAmt ; $i++ )
			 {
			 $default_age = ($i == 0 && $_REQUEST["isSilver"] == "1") ? "Age=\"55\"" : "Age=\"30\"" ;

			 $guest .= sprintf(
			 '<Guest %s %s>
			 <GuestTransportation Mode="29" Status="36">
			 <GatewayCity LocationCode="C/O"/>
			 </GuestTransportation>
			 %s
			 </Guest>'
			 , $default_age
			 , ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
			 , ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
			 ) ;
			 $adSeq++ ;
			 }

			 for($i = 0 ; $i < $childAmt ; $i++ )
			 {
			 $guest .= sprintf(
			 '<Guest Age="10" %s>
			 <GuestTransportation Mode="29" Status="36">
			 <GatewayCity LocationCode="C/O"/>
			 </GuestTransportation>
			 %s
			 </Guest>'
			 , ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != "" ) ? "LoyaltyMembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\"" : ""
			 , ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
			 ) ;
			 $adSeq++ ;
			 } */

			$guest .= "<GuestCounts>" ;
			for($i = 0 ; $i < $guestCount ; $i++ )
			{
				$guest .= '<GuestCount Quantity="1" />' ;
			}
			$guest .= "</GuestCounts>" ;


			$req = $guest .
			'<SailingInfo>
				<SelectedSailing '. $start . '>
				<CruiseLine ' .$ship . '/>
				</SelectedSailing>
			</SailingInfo>
			 <SearchQualifiers '.$fareCode.'/> ' ;

			$this->putB($req) ;
			return $this->get($param) ;
		}

		function getBookingList($param){
			$this->setUrl($this->FITURL."/getBookingList") ;
			$this->putH("getBookingList",$this->interfaceURL."/BookingList","OTA_ReadRQ","150","true","false","1","106597","1.0") ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$vendor		= $this->getAttr("VendorCode",$param['vendor'],$param['vendor']) ;
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$name = $param['surname'];

			$req = '
					<ReadRequests>
						<CruiseReadRequest>
							<SelectedSailing '.$ship.' '.$vendor.'/>
							 <GuestInfo>
								<Surname>'.$name.'</Surname>
							</GuestInfo>
						</CruiseReadRequest>
					</ReadRequests>
				   ';

			$this->putB($req) ;
			return $this->get() ;
		}

		function getPaymentExtension($param){
			$this->setUrl($this->FITURL."/PaymentExtension");
			$req = ' <m0:InformationType>
						<m0:ReservationID ID="'.$param['confirmId'].'" StatusCode="42" Type="14"/>
							<m0:SailingInfo>
								<m0:SelectedSailing Start="'.$param['start'].'">
								<m0:CruiseLine ShipCode="'.$param['ship'].'"/>
							</m0:SelectedSailing>
						</m0:SailingInfo>
					</m0:InformationType> ';
			$this->putB2($req, 'OTA_CruiseInfoRQ', $this->interfaceURL."/PaymentExtension", 'getPaymentExtension');
			return $this->get($id) ;
		}

		function getBookingHistory2($id){
			$this->setUrl($this->FITURL."/BookingHistory") ;
			$this->putH("getBookingHistory",$this->interfaceURL."/BookingHistory","OTA_ReadRQ","120","true","false","1","106597","2.0") ; //Max 120 response on API Doc - 181026 Leone
			$req = '<UniqueID ID="'.$id.'" Type="14"/>';
			$this->putB($req) ;

			return $this->get() ;
		}

		function getTransferList($param){
			$this->setUrl($this->FITURL."/TransferList");

			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$adultAmt = $param['adultAmt'] ;
			$childAmt = $param['childAmt'] ;

			$guest2 = "<m0:GuestCounts>" ;

			for($i = 0 ; $i < $adultAmt ; $i++ ){
				$guest2 .= '<m0:GuestCount Quantity="1"  Age="30"/>' ;
			}

			for($i = 0 ; $i < $childAmt ; $i++ ){
				$guest2 .= '<m0:GuestCount Quantity="1"  Age="10"/>' ;
			}

			$guest2 .= "</m0:GuestCounts>" ;

			$req = $guest2 .
			'<m0:SailingInfo>
				<m0:SelectedSailing ' . $start . '>
					<m0:CruiseLine ' . $ship . '/>
				</m0:SelectedSailing>
			</m0:SailingInfo>
			 <m0:PackageOption PackageTypeCode="0"/> ';

			$this->putB2($req, 'OTA_CruisePkgAvailRQ', $this->interfaceURL."/TransferList", 'getTransferList');
			return $this->get($id) ;
		}

		function getTransferDetail($param){
			$this->setUrl($this->FITURL."/TransferDetail") ;
			$this->putH("getTransferDetail",$this->interfaceURL."/TransferDetail","OTA_CruisePkgAvailRQ","150","true","false","1","106597","1.0", "01") ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$transferPackageCode		= $this->getAttr("CruisePackageCode",$param['transferPackageCode'],$param['transferPackageCode']) ;
			$transferTypeCode		= $this->getAttr("PackageTypeCode",$param['transferTypeCode'],$param['transferTypeCode']) ;
			$req = $guest2 .
			'<SailingInfo>
				<SelectedSailing ' . $start . '>
					<CruiseLine ' . $ship . '/>
				</SelectedSailing>
			</SailingInfo>
			<PackageOption '.$transferPackageCode.' '.$transferTypeCode.'/>';
			$this->putB($req) ;
			return $this->get() ;
		}


		function releaseBooking($param, $newTerminalID = ""){
			$this->setUrl($this->FITURL."/ReleaseBooking") ;
			$this->putH("releaseBooking",$this->interfaceURL."/ReleaseBooking","OTA_ReadRQ","","","","1","","2.0","","test") ;
			$confirmId 	= $this->getAttr("ID",$param['confirmId'],$param['confirmId']) ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배

			$req = '
					<m0:UniqueID '.$confirmId.' Type="14"/>
				   ';
			/*
			 <ReadRequests>
						<CruiseReadRequest>
							<SelectedSailing '.$start.' '.$ship.'/>
						</CruiseReadRequest>
					</ReadRequests>
			 */

			$this->putB2($req, 'OTA_ReadRQ', $this->interfaceURL."/ReleaseBooking", 'releaseBooking', $newTerminalID);
			//$this->putB($req) ;
			return $this->get() ;
		}

		function crossReference($param, $targetConfirmIdArr, $xmlResult = ""){//다이닝 통합
			$this->setUrl($this->FITURL."/LinkedBooking") ;
			$this->putH("validateLinkedBookings",$this->interfaceURL."/LinkedBooking","OTA_CruisePriceBookingRQ","","","false","1","106597","2.0", "") ;
			$baseConfirmId 	= $this->getAttr("ID",$param['baseConfirmId'],$param['baseConfirmId']) ;
			$start		= $this->getAttr("Start",$param['start'],$param['start']) ;				// 년월
			$ship		= $this->getAttr("ShipCode",$param['ship'],$param['ship']) ;			// 배
			$prefixValue = "";
			$req =
			'<'.$prefixValue.'SailingInfo>
				<'.$prefixValue.'SelectedSailing ' . $start . '>
					<'.$prefixValue.'CruiseLine ' . $ship . '/>
				</'.$prefixValue.'SelectedSailing>
			</'.$prefixValue.'SailingInfo>
			<'.$prefixValue.'ReservationInfo>
				<'.$prefixValue.'ReservationID '.$baseConfirmId.' Type="14"/> ';
			$req.='
						<'.$prefixValue.'GuestDetails><'.$prefixValue.'GuestDetail/></'.$prefixValue.'GuestDetails> ';
			/* $req.= $resultXml = str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\"?>", "", str_replace("<", "<m0:", str_replace("</", "</m0:", $xmlResult))); */

			if(sizeof($targetConfirmIdArr) == 0){
				$req.=	'<LinkedBookings>
						<LinkedBooking>
						</LinkedBooking>
					</LinkedBookings>'
						;
			}else{

				$req.='
						<'.$prefixValue.'LinkedBookings>';

				for($i = 0; $i < sizeof($targetConfirmIdArr); $i++){

					$req.=	'<'.$prefixValue.'LinkedBooking LinkTypeCode="2">
						 		<'.$prefixValue.'UniqueID ID="'.$targetConfirmIdArr[$i].'" Type="14"/>
							</'.$prefixValue.'LinkedBooking>';
				}

				$req.= 	'</'.$prefixValue.'LinkedBookings> ';
			}

			$req.= '</'.$prefixValue.'ReservationInfo>';

			//$this->putB2($req, 'OTA_CruisePriceBookingRQ', $this->interfaceURL."/LinkedBooking", 'validateLinkedBookings', "");
			$this->putB($req) ;
			return $this->get() ;
		}

		function ModifyBooking($param, $xmlContent, $TransactionActionCode, $confirmId){
			if($confirmId == "") $confirmId = "0";
			$this->setUrl($this->FITURL."/ConfirmBooking") ;

			$this->putH2("confirmBooking",$this->interfaceURL."/ConfirmBooking","OTA_CruiseBookRQ","","","","1","0",$TransactionActionCode) ;


			if(!empty($xmlContent) && $xmlContent != ""){
				$resultXml = $xmlContent;
				$resultXml = str_replace("<Root>", "", $resultXml);
				$resultXml = str_replace("</Root>", "", $resultXml);
				$resultXml = str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"no\"?>", "", $resultXml);
				$resultXml = str_replace("<?xml version=\"1.0\" encoding=\"utf-8\" standalone=\"no\"?>", "", $resultXml);
				$resultXml = str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\"?>", "", $resultXml);
				$resultXml = str_replace("<?xml version=\"1.0\" encoding=\"utf-8\"?>", "", $resultXml);

				$req = sprintf('<AgentInfo Contact="'.$this->companyName.'" />');
				$req.= $resultXml;
				$this->putB3($req);
			}else{
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
				$dinnerTableSize	= $param[0][18];
				$bedConfigCode		= $param[0][19];
                $is_nrd = false;
                if(isset($param[0][20]) && $param[0][20]==true)
                {
                    $is_nrd = true;
                }
				//$dinnerType = "O";
				$uniqCd = $param[0][15];
				$ss_term = $param[0][16];

                //PPGR 에 해당되지 않는 선박 : 아자마라 전 선박 + 셀러브리티 X시리즈
                $PPGR_option_str = '<SelectedOptions OptionCode="PPGR"/>';
                $xSeriesShipCodeArr = array('XE','XO', 'XP','FL');
                if($vendor=="Z"){
                    $PPGR_option_str	= '';
                }

                else if(in_array($shipCd, $xSeriesShipCodeArr)){
                    $PPGR_option_str	= '';
                }

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


				$prtStr = ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedPromotions PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : "" ;


				$req = '
				<AgentInfo Contact="'.$this->companyName.'" />
				<SailingInfo>
					<SelectedSailing Duration="P'.$ss_term.'N" Start="'.$start.'" Status="60">
						<CruiseLine ShipCode="'.$shipCd.'" VendorCode="'.$vendor.'" />
					</SelectedSailing>
					<InclusivePackageOption CruisePackageCode="'.$pkgCode.'" />
					<SelectedCategory FareCode="'.$ppid.'"';
                    if($is_nrd)
                        $req .=' IncludeNonRefundablePromos="Yes" ' ;
                    else
                        $req .=' IncludeNonRefundablePromos="No"' ;

                    $req .=' PricedCategoryCode="'.$scc.'" WaitlistIndicator="false" BerthedCategoryCode="'.$scc.'">
						<SelectedCabin CabinNumber="'.$cabinNum.'" Status="39" >';

				if($bedConfigCode != ""){
					$req .= '<CabinConfiguration BedConfigurationCode = "'.$bedConfigCode.'"/>';
				}



				$req .= sprintf('</SelectedCabin>
						</SelectedCategory>
				</SailingInfo>
				<ReservationInfo>
					<ReservationID ID="'.$confirmId.'" LastModifyDateTime="'.$date.'" StatusCode="42" Type="14" />
					<GuestDetails>
				 ');


				$prtDeStr = ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : "" ;
				$loyDeStr = ( $_REQUEST['LoyaltyMembershipID'] != "" ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'] . "\" />" : "" ;


				$guest = '';

				$adSeq = 0 ;


				for($i = 0; $i<$adultAmt; $i++){
					if($email[$i]=="@")
					{
						$email[$i] == $email[0];
					}

					$guest .= sprintf('
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
						%s
						<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'" TableSize="'.$dinnerTableSize.'"/>
						%s
					'
							, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != ""/*  && $i == 0 */ ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\" />" : ""
							, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
							) ;


                    $guest.=$PPGR_option_str;

					//2012-10-09 Sejin.Jang - Assist Card 오류회피
					if($vendor=="R")
					{
						//	$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
						//	$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
					}

					/*
					 * If = False – TIIR won’t be added to the booking.
					 * It is also possible to decline or remove TIIR by not sending a SelectedInsurance element
					 */

					//$guest .= '<SelectedInsurance InsuranceCode="TIIR" SelectedOptionIndicator="false"/>';

					$guest .='</GuestDetail>';

					$adSeq++ ;
				}

				for($i=$adultAmt; $i<$adultAmt+$childAmt; $i++)
				{
					if($email[$i]=="@"){
						$email[$i] == $email[0];
					}

					$guest .= sprintf('
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
							%s
							<SelectedDining Status="39" Sitting="'.$dinnerType.'" SittingType="'.$sitType.'" TableSize="'.$dinnerTableSize.'"/>
							%s
					'
							, ( $_REQUEST['LoyaltyMembershipID'][$adSeq] != ""/*  && $i == 0 */ ) ? "<LoyaltyInfo MembershipID=\"" . $_REQUEST['LoyaltyMembershipID'][$adSeq] . "\" />" : ""
							, ( $_REQUEST['PromotionCode'] != "" ) ? "<SelectedOffers PromotionCode=\"" . $_REQUEST['PromotionCode'] . "\" />" : ""
							);


                    $guest.=$PPGR_option_str;

					//2012-10-09 Sejin.Jang - Assist Card 오류회피
					if($vendor=="R")
					{
						//	$guest .= '<SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/>' ;
						//	$guest .= '<SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/>' ;
					}

					/*
					 * If = False – TIIR won’t be added to the booking.
					 * It is also possible to decline or remove TIIR by not sending a SelectedInsurance element
					 */
					//$guest .= '<SelectedInsurance InsuranceCode="TIIR" SelectedOptionIndicator="false"/>';

					$guest.='</GuestDetail>';

					$adSeq++ ;

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

				$this->putB($req);
			}

			//	echo "\nerror End\n";


			return $this->get($param) ;
		}

		//class end
	}
}

?>
