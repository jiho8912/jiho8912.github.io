<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/Req.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/SailBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/SailOptionBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/PkgBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/CategoryBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/CategoryOptionBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/PriceInfoBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/CabinBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/CabinOptionBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/ItinInfoBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/PaymentBean.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/BookingPriceBean.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/EtcBean.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/PromotionPriceBean.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/FareBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/FareOptionBean.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/XML2Array.php" ; ?>
<?
/** 크루즈 API 응답을 처리하는 클래스 **/
if(! class_exists("Res") )	{

	class Res extends Req
	{

		var $res = "" ;

		var $isError = false ;

		var $aWarning = array() ;

		var $msg = "";

		var $errorMsg = "" ;		// add by dev.lee 결제 실패시 디비에 기록하기 위한 message

		function Res($url='')
		{
			$this->Req($url) ;
		}

		// XML 의 속성 값을 가져온다.
		function getA($attrMap,$name)
		{
			return $attrMap->getNamedItem($name)->nodeValue  ;
		}

		function getEs($node, $tagName)
		{
			return $node->getElementsByTagName($tagName) ;
		}

		// XML 의 속성 값을 가져온다.
		function getA2($node,$name)
		{
			$attrMap =  $node->attributes ;

			return $this->getA($attrMap,$name) ;
		}

		// 부모 노드로 부터 속성값을 가져온다.
		function getA3($parent,$childIndex,$name)
		{
			$nlChild = $parent->childNodes ;

			if( $nlChild->length > $childIndex )
			{
				$nChild = $nlChild->item($childIndex) ;

				return $this->getA2($nChild,$name) ;
			}

			return "NONE" ;
		}

		// 증부모 노드로 부터 속성값을 가져온다.
		function getA4($parent,$childIndex,$foreChildIndex,$name)
		{
			$nlChild = $parent->childNodes ;

			if( $nlChild->length > $childIndex )
			{
				$nlForeChild = $nlChild->item($childIndex) ;

				return $this->getA3($nlForeChild,$foreChildIndex,$name) ;
			}

			return "NONE" ;
		}

		// 부모 노드로 부터 특정 속성값으로 검색하여 속성값을 가져온다.
		function getA5($parent, $searchName, $matchValue ,$name)
		{
			foreach($parent as $node)
			{
				if( $this->getA2($node, $searchName) == $matchValue )
				{
					return $this->getA2($node, $name) ;
				}
			}

			return "NONE" ;
		}

		// 부모 노드로 부터 특정 속성값으로 검색하여 속성값을 모두 가져온다.
		function getA6($parent, $searchName, $matchValue ,$name)
		{
			$arrValue = Array() ;

			foreach($parent as $node)
			{
				if( $this->getA2($node, $searchName) == $matchValue )
				{
					array_push($arrValue, $this->getA2($node, $name)) ;
				}
			}

			return $arrValue ;
		}

		function getA6ExtSum($parent, $searchName, $matchValue ,$name)
		{
			$arr = $this->getA6($parent, $searchName, $matchValue ,$name) ;

			$val = 0 ;
			for( $i = 0 ; $i < sizeof($arr) ; $i++ )
				$val += $arr[$i] ;

			return $val ;
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
			$list = array() ;

			$this->res = parent::getSailingList($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$nlist 			= $dom->getElementsByTagName("SailingOption") ;

			$baseNodeList 	= $dom->getElementsByTagName("OTA_CruiseSailAvailRS") ;

			$sailBean = new SailBean() ;

			foreach ($nlist as $node) {

				$nnlist = $node->childNodes ;

				if( $nnlist->length > 0 )
				{
					$bean = new SailOptionBean() ;

					$nSelectedSailing = $nnlist->item(0) ;
					$attr = $nSelectedSailing->attributes ;

					$bean->start	= $this->getA($attr,"Start")					;	// 시작일
					$bean->duration	= $this->getA($attr,"Duration")					;	// 기간
					$bean->portCall	= $this->getA($attr,"PortsOfCallQuantity")		;	// 항구에 들리는 횟수
					$bean->status	= $this->getA($attr,"Status")					;	// 상태

					$nnnlist = $nSelectedSailing->childNodes ;

					$bean->shipCode			= $this->getA($nnnlist->item(0)->attributes,"ShipCode") ;		// 배코드
					$bean->vendorCode		= $this->getA($nnnlist->item(0)->attributes,"VendorCode") ;		// 벤더코드
					$bean->regionCode		= $this->getA($nnnlist->item(1)->attributes,"RegionCode") ;		// 지역코드
					$bean->subRegionCode	= $this->getA($nnnlist->item(1)->attributes,"SubRegionCode") ;	// 세부지역코드
					$bean->dePort			= $this->getA($nnnlist->item(2)->attributes,"LocationCode") ;	// 출발항구
					$bean->arPort			= $this->getA($nnnlist->item(3)->attributes,"LocationCode") ;	// 도착항구

				}

				if( $nnlist->length > 1 )
				{
					$nInclusivePackageOption = $nnlist->item(1)  ;

					$bean->cruisePkCode	=
						$this->getA($nInclusivePackageOption->attributes,"CruisePackageCode") ;		// 크루즈패키지코드
					$bean->inclusiveIndicator	=
						$this->getA($nInclusivePackageOption->attributes,"InclusiveIndicator") ;	//

				}

				array_push($sailBean->sailOptions, $bean) ;
			}

			// ADD BASE ATTRIBUTE
			if($baseNodeList->length > 0)
			{
				$sailBean->maxResponses 		=	$this->getA($baseNodeList->item(0)->attributes,"MaxResponses") ;
				$sailBean->moreDataEchoToken 	= 	$this->getA($baseNodeList->item(0)->attributes,"MoreDataEchoToken") ;
				$sailBean->moreIndicator 		= 	$this->getA($baseNodeList->item(0)->attributes,"MoreIndicator") ;
			}

			return $sailBean ;
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
			$this->res	= parent::getItineraryDetail($param) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$list = array() ;

			$nlInfo = $dom->getElementsByTagName("CruiseItinInfo")	;

			foreach ($nlInfo as $node)
			{
				$bean = new ItinInfoBean() ;

				$bean->portName = $this->getA2($node,"PortName")			;
				$bean->portCode = $this->getA2($node,"PortCode")			;

				$nText = $node->childNodes->item($node->childNodes->length - 1 )->firstChild ;
				$bean->text = $nText->nodeValue ;

				$nlItinTime = $node->childNodes	;

				// DateTimeDescription
				foreach($nlItinTime as $nItin )
				{
					$dateTimeDetails	= $this->getA2($nItin,"DateTimeDetails") ;
					$dateTimeQualifier	= $this->getA2($nItin,"DateTimeQualifier") ;
					$dayOfWeek			= $this->getA2($nItin,"DayOfWeek") ;

					if($dateTimeDetails != null && $dateTimeQualifier != null)
						array_push($bean->itinTimes,array( $dateTimeDetails , $dateTimeQualifier , $dayOfWeek )) ;
				}

				if( $bean->text != ""  )
					array_push($list,$bean) ;

			}

			return $list ;
		}

		// 세일링과 관련한 패키지 리스트를 가져온다.
		function getPackageList($param)
		{

			$list = array() ;

			$this->res = parent::getPackageList($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$nlist = $dom->getElementsByTagName("SailingInfo") ;

			foreach ($nlist as $node) {

				$bean = new PkgBean() ;

				$nnlist = $node->childNodes ;

				if( $nnlist->length > 0 )
				{
					$nSelectedSailing = $nnlist->item(0) ;

					$bean->start	= $this->getA2($nSelectedSailing,"Start")					;	// 세일링 시작일
					$bean->status	= $this->getA2($nSelectedSailing,"Status")					;	// 세일링 상태

					$bean->shipCode			= $this->getA3($nSelectedSailing,0,"ShipCode")		;	// 배코드
					$bean->vendorCode		= $this->getA3($nSelectedSailing,0,"VendorCode")	;	// 선사코드
					$bean->regionCode		= $this->getA3($nSelectedSailing,1,"RegionCode")	;	// 지역코드
					$bean->subRegionCode	= $this->getA3($nSelectedSailing,1,"SubRegionCode")	;	// 상세지역코드
					$bean->dePort			= $this->getA3($nSelectedSailing,2,"LocationCode")	;	// 출발항구
				}

				if( $nnlist->length > 1 )
				{
					$nInclusivePackageOption = $nnlist->item(1) ;
					$bean->cruisePkCode = $this->getA2($nInclusivePackageOption,"CruisePackageCode") ;
				}

				if( $nnlist->length > 2 )
				{
					$nCruisPackages = $nnlist->item(2) ;

					$bean->cruisePkCodeReal = $this->getA3($nCruisPackages,0,"CruisePackageCode")	;
					$bean->pkgDuration		= $this->getA3($nCruisPackages,0,"Duration")			;
					$bean->pkgEnd			= $this->getA3($nCruisPackages,0,"End")					;
					$bean->pkgTypeCode		= $this->getA3($nCruisPackages,0,"PackageTypeCode")		;
					$bean->pkgStart			= $this->getA3($nCruisPackages,0,"Start")				;
					$bean->pkgDescription	= $this->getA3($nCruisPackages,0,"Description")			;
				}

				array_push($list,$bean) ;

			}

			return $list ;
		}

		// 세일링과 관련한 패키지 리스트를 가져온다.
		function getPackageDetail($param)
		{

			$list = array() ;

			$this->res = parent::getPackageDetail($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$nlist = $dom->getElementsByTagName("TextScreen") ;

			/* foreach ($nlist as $node) {

				$bean = array();

				$nnlist = $node->childNodes ;

				if( $nnlist->length > 0 )
				{
					$nSelectedSailing = $nnlist->item(0) ;

					$bean->start	= $this->getA2($nSelectedSailing,"Start")					;	// 세일링 시작일
					$bean->status	= $this->getA2($nSelectedSailing,"Status")					;	// 세일링 상태

					$bean->shipCode			= $this->getA3($nSelectedSailing,0,"ShipCode")		;	// 배코드
					$bean->vendorCode		= $this->getA3($nSelectedSailing,0,"VendorCode")	;	// 선사코드
					$bean->regionCode		= $this->getA3($nSelectedSailing,1,"RegionCode")	;	// 지역코드
					$bean->subRegionCode	= $this->getA3($nSelectedSailing,1,"SubRegionCode")	;	// 상세지역코드
					$bean->dePort			= $this->getA3($nSelectedSailing,2,"LocationCode")	;	// 출발항구
				}

				if( $nnlist->length > 1 )
				{
					$nInclusivePackageOption = $nnlist->item(1) ;
					$bean->cruisePkCode = $this->getA2($nInclusivePackageOption,"CruisePackageCode") ;
				}

				if( $nnlist->length > 2 )
				{
					$nCruisPackages = $nnlist->item(2) ;

					$bean->cruisePkCodeReal = $this->getA3($nCruisPackages,0,"CruisePackageCode")	;
					$bean->pkgDuration		= $this->getA3($nCruisPackages,0,"Duration")			;
					$bean->pkgEnd			= $this->getA3($nCruisPackages,0,"End")					;
					$bean->pkgTypeCode		= $this->getA3($nCruisPackages,0,"PackageTypeCode")		;
					$bean->pkgStart			= $this->getA3($nCruisPackages,0,"Start")				;
					$bean->pkgDescription	= $this->getA3($nCruisPackages,0,"Description")			;
				}

				array_push($list,$bean) ;

			} */

			return $list ;
		}


		/***************************************************************************
		*	제  목 : 크루즈 API - Category xml 을 bean 객체로 추출
		*	함수명 : makeCategoryBean
		*	작성일 : 2013-07-05
		*	작성자 :
		*	설  명 : 카테고리 조회 및 예약 flow에서 사용
		*	수  정 : dev.lee 2013-07-05
		'***************************************************************************/
		function makeCategoryBean(&$xml)
		{
			$dom = new DOMDocument() ;
			$dom->loadXML($xml) ;

            $nWarning	= $dom->getElementsByTagName("Warning") ;
            if( $nWarning->length > 0 ) {
                foreach ($nWarning as $node) {
                    $wShortText = $this->getA2($node, "ShortText");
                    $wType = $this->getA2($node, "Type");
                    $wText = $node->nodeValue;
                    if($wShortText != "") {
                        $this->aWarning = array("short" => $wShortText, "type" => $wType, "text" => $wText);
                    }
                }
            }

			$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;
			$ctBean = new CategoryBean() ;

			$ctBean->duration		= $this->getA3($nSailingInfo,0,"Duration")			;
			$ctBean->regionCode		= $this->getA4($nSailingInfo,0,1,"RegionCode")		;
			$ctBean->cruisePkCode	= $this->getA3($nSailingInfo,1,"CruisePackageCode")	;

			$nlCategoryOption = $dom->getElementsByTagName("CategoryOption") ;

			foreach ($nlCategoryOption as $node) {

				$coBean = new CategoryOptionBean() ;

				$coBean->categoryLocation		=	$this->getA2($node,"CategoryLocation")		;
				$coBean->pricedCategoryCode		=	$this->getA2($node,"PricedCategoryCode")	;

				if( ($nTmp = $this->getChild($node,0)) == null )
					return null ;

				$nlPriceInfo = $nTmp->childNodes ;			// 가격정보 리스트 노드


				$coValidCheck = true;
				foreach( $nlPriceInfo as $nPriceInfo ) {

					$piBean = new PriceInfoBean() ;

					$piBean->amount			= $this->getA2($nPriceInfo,"Amount") ;
					$piBean->breakdownType	= $this->getA2($nPriceInfo,"BreakdownType") ;
					$piBean->fareCode		= $this->getA2($nPriceInfo,"FareCode")		;

					$piBean->promotionAmount = $this->getA2($nPriceInfo,"PromotionAmount")		;
					$piBean->valueAddAmount = $this->getA2($nPriceInfo,"ValueAddAmount")		;
					$piBean->promotionDesc = $this->getA2($nPriceInfo,"PromotionDescription")		;
//debug_var($_REQUEST['sunsa_no']);debug_var($piBean->promotionDesc);
                    if($_REQUEST['sunsa_no']==1 && stripos($piBean->promotionDesc, ' NRD')!==FALSE)
                        $coValidCheck=false;
					$piBean->promotionClass = $this->getA2($nPriceInfo,"PromotionClass")		;
					$piBean->promotionTypes = $this->getA2($nPriceInfo,"PromotionTypes")		;

					$piBean->nccfAmount = $this->getA2($nPriceInfo,"NCCFAmount")		;
					$piBean->nonRefundableType = $this->getA2($nPriceInfo,"NonRefundableType")		;

					array_push($coBean->priceInfos,$piBean) ;
				}
				if($coValidCheck){
					array_push($ctBean->categoryOptions,$coBean) ;
				}
			}

			$nTaxes = $dom->getElementsByTagName("Tax") ;
			foreach($nTaxes as $node){
				$nEtcBean = new EtcBean() ;

				$nEtcBean->nccFee = $this->getA2($node,"Amount") ;

				array_push($ctBean->etcFee,$nEtcBean);
			}

			unset($dom);
			return $ctBean ;
		}



		/***************************************************************************
		*	제  목 : 크루즈 API - StartDate 와 ShipCode 를 가지고 Category 정보를 가져온다
		*	함수명 : getCategoryList
		*	작성일 : 2013-07-02
		*	작성자 :
		*	설  명 : promotionAmount, valueAddAmount 데이터 추가된 버전
		*	수  정 : dev.lee 2013-07-02
		'***************************************************************************/
		function getCategoryList($param)
		{
			$this->res	= parent::getCategoryList($param) ;

			//echo "<!--" . $this->res . "-->" ;

			return $this->makeCategoryBean($this->res) ;
		}

		function getCategoryList2($param)
		{
			$this->res	= parent::getCategoryList2($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;


			$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;

			$ctBean = new CategoryBean() ;

			$ctBean->duration		= $this->getA3($nSailingInfo,0,"Duration")			;
			$ctBean->regionCode		= $this->getA4($nSailingInfo,0,1,"RegionCode")		;
			$ctBean->cruisePkCode	= $this->getA3($nSailingInfo,1,"CruisePackageCode")	;

			$nlCategoryOption = $dom->getElementsByTagName("CategoryOption") ;

			foreach ($nlCategoryOption as $node) {
				$coBean = new CategoryOptionBean() ;

				$coBean->categoryLocation		=	$this->getA2($node,"CategoryLocation")		;
				$coBean->pricedCategoryCode		=	$this->getA2($node,"PricedCategoryCode")	;
				if( ($nTmp = $this->getChild($node,0)) == null )
					return null ;

				$nlPriceInfo = $nTmp->childNodes ;			// 가격정보 리스트 노드
				foreach( $nlPriceInfo as $nPriceInfo ) {
                    //debug_var($dom->saveXML($nPriceInfo));
                    $fareCode = $this->getA2($nPriceInfo,"FareCode")		;
                    $promotionDesc = $this->getA2($nPriceInfo,"PromotionDescription")		;
                    $nonRefundableType = $this->getA2($nPriceInfo,"NonRefundableType")		;
                    $priceBreakDownsNode = $nPriceInfo->getElementsByTagName("PriceBreakDowns")->item(0);
                    $status = $this->getA2($priceBreakDownsNode,"Status") ;
                    foreach( $priceBreakDownsNode->childNodes as $priceBreakDownNode )
                    {
                        //debug_var($dom->saveXML($priceBreakDownNode));
                        $piBean = new PriceInfoBean2() ;
                        $piBean->amount			= $this->getA2($priceBreakDownNode,"Amount") ;
                        $piBean->nccfAmount			= $this->getA2($priceBreakDownNode,"NCCFAmount") ;
                        $piBean->status	= $status;
                        $piBean->fareCode		= $fareCode;
                        $piBean->breakdownType	= $status=='36'?'A':'W';
                        $piBean->promotionAmount = $this->getA2($priceBreakDownNode,"PromotionAmount")		;
                        $piBean->valueAddAmount = $this->getA2($priceBreakDownNode,"ValueAddAmount")		;
                        $piBean->promotionDesc = $promotionDesc;
                        $piBean->promotionTypes = $this->getA2($priceBreakDownNode,"DiscountTypes")		;
                        $piBean->nonRefundableType = $nonRefundableType;

                        array_push($coBean->priceInfos,$piBean) ;
                    }
				}
				array_push($ctBean->categoryOptions,$coBean) ;
			}

            $nTaxes = $dom->getElementsByTagName("Tax") ;
            for($i=0;$i<$nTaxes->length;$i++)
            {
				$nEtcBean = new EtcBean() ;
				$nEtcBean->nccFee = $this->getA2($nTaxes->item($i),"Amount") ;
				array_push($ctBean->etcFee,$nEtcBean);
			}

			unset($dom);
	//		$nTaxes = $nSailingInfo->nextSibling->nextSibling ;		// Tax

	//		if( sizeof($nTaxes->nextSibling->childNodes) > 0 )
	//			$nFee	= $nTaxes->nextSibling->childNodes->item(0) ;	// Fee

	//		$nInfo	= $nTaxes->nextSibling->nextSibling ;			// Info

			return $ctBean ;
		}

		// 최저가격 가져오는 메뉴
		function getListOfLowPriceForCategory($bean)
		{
			$data = array() ;

			$data['Deluxe']		= 99999999 ;
			$data['Balcony']	= 99999999 ;
			$data['Outside']	= 99999999 ;
			$data['Inside']		= 99999999 ;

			$cateList = $bean->categoryOptions ;

			for($i = 0 ; $i < sizeof($cateList) ; $i++ )
			{
				$priceList = $cateList[$i]->priceInfos ;

				$minAmt = 99999999 ;

				for($j = 0 ; $j < sizeof($priceList) ; $j++ )
				{
					if( $priceList[$j]->fareCode != "FIT" )
					{
						$cntAmt = $priceList[$j]->amount ;

						if( $cntAmt != "" && $cntAmt != "0" )
						{
							if( $minAmt > $cntAmt )
								$minAmt = $cntAmt ;
						}


					}
				}

				$cateList[$i]->lowPrice = $minAmt ;

			}


			for($i = 0 ; $i < sizeof($cateList) ; $i++ )
			{
				$location	= $cateList[$i]->categoryLocation	;
				$lowAmt		= $cateList[$i]->lowPrice			;

				if( $data[$location] > $lowAmt )
					$data[$location] = $lowAmt ;
			}


			for($i = 0 ; $i < sizeof($data) ; $i++ )
			{
				if( $data[$i] == 99999999 )
					$data[$i] = "N/A" ;
			}

			return $data ;

		}

		function checkWarning($dom)
		{
			$this->isWarning = false ;

			$nWarning	= $dom->getElementsByTagName("Warning") ;

			if( $nWarning->length > 0 )
			{
				foreach ($nWarning as $node)
				{

					$wShortText = $this->getA2($node,"ShortText")	;
					$wType = $this->getA2($node,"Type")				;
					$wText = $node->nodeValue 						;

					// warning code 가 CSW로 시작하면 information 성격이고, CSE로 시작하면 ERROR 임
					// EDIT BY DEV.LEE 2013-11-04
					$wCode = substr($wShortText, 0, 3) ;

					array_push($this->aWarning,array( "short" => $wShortText , "type" => $wType , "text" => $wText )) ;

					if( $wShortText == "" ||  $wShortText == "CSW0706")
					{
						$this->isWarning = false ;
						return ;
					}
					else
					{
						// CSW 는 인폼 성격
						if($wCode == "CSW" && $wText != "ASSIST CARD OPTION HAS BEEN ADDED TO YOUR RESERVATION"
						&& strpos($_SERVER['REQUEST_URI'], "/cruiseonly/step8.php") === false && strpos($_SERVER['REQUEST_URI'], "/back_office/") === false)
						{
                            //if($wShortText == "CSW0706")
                            //{
                            //    $wText = str_replace("W-DEPOSIT IS NON REFUNDABLE", "경고 : 신청금 환불 불가 조건 프로모션입니다. 일정 변경시 1인당", $wText);
                            //    $wText = str_replace("CHANGE FEE PER GUEST", "의 변경 신청금이 부과됩니다.", $wText);
                            //}
							echo(
							'<html>
								<head>
								<title> :: 크루즈 여행의 모든것, 로얄캐리비안/셀러브리티/아자마라크루즈 :: </title>
								 <META HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
								<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
								</head>
								<body>
									<script>
										alert("[메세지'.$wShortText.']'.$wText.'") ;
									</script>
								</body>
							</html>') ;

							$this->isWarning = false ;
							return ;
						}
						else if($wCode == "CSE")
						{
                            $paramArray = array(
                                'sailYm',
                                'product_type',
                                'product_sday',
                                'local_no',
                                'sub_no',
                                'sHangu_no',
                                'searchSunsa',
                                'searchShipNo',
                                'searchMonth',
                                'monthType',
                                'nAdult_amt',
                                'nChild_amt',
                                'startHangu_no',
                                'search_sunsa',
                                'search_ship',
                                'search_adult_count'
                            );

                            $addParamArray = array();
                            foreach ($paramArray as $getParam){
                                $addParamArray[$getParam] = $_REQUEST[$getParam];
                                if($getParam == 'product_sday'){
                                    $addParamArray['sailYm'] = $_REQUEST[$getParam];
                                }
                            }
                            $urlParams_4_cruise_only_list = http_build_query($addParamArray);

							//백오피스 예약 시 예외일 경우 이전페이지 url 분기 - By 유현돈
							$locationUrl = "/cruiseonly/cruise_only_list.php?".$urlParams_4_cruise_only_list;
							if(strpos($_SERVER['HTTP_REFERER'], "/back_office/estimateStep") !== false){
								$locationUrl = preg_replace('/[?|&]group_cd=[0-9]*/' , "" ,$_SERVER['HTTP_REFERER']);
								$groupCdStr = "?group_cd=".$_REQUEST['group_cd'];
								if(strpos($locationUrl, '?') !== false) $groupCdStr = "&group_cd=".$_REQUEST['group_cd'];
								$locationUrl .= $groupCdStr;
							}else if(strpos($_SERVER['HTTP_REFERER'], "/api_sandbox/") !== false || strpos($_SERVER['REQUEST_URI'], "/member/popup/") !== false){
								$locationUrl = "";
							}

							if(strpos($wText, "UNDER 21") !== false) {
								echo(
								'<html>
									<head>
									<title> :: 크루즈 여행의 모든것, 로얄캐리비안/셀러브리티/아자마라크루즈 :: </title>
									 <META HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
									<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
									</head>
									<body>
										<script>
											alert("예약하시는 캐빈에 만 21세 이상 성인이 없는 경우\n온라인 예약이 불가합니다.\n해당 예약 진행을 위해 로얄캐리비안크루즈 예약센터 (02-737-0003)로 문의 해 주세요.") ;
											if("'.$locationUrl.'" != "") location.href="'.$locationUrl.'" ;
										</script>
									</body>
								</html>') ;
							// step5 캐빈리스트 오류시 페이지 이동시키지 않음
							}elseif( $wShortText == 'CSE0292' || $wShortText == 'CSE0028'){
                                $this->isWarning = false;
                                return false;
                            }else {
								echo(
								'<html>
									<head>
									<title> :: 크루즈 여행의 모든것, 로얄캐리비안/셀러브리티/아자마라크루즈 :: </title>
									 <META HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
									<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
									</head>
									<body>
										<script>
											alert("다음과 같은 이유로 더 이상 예약 진행이 불가합니다.\n해당 사항 수정, 반영 후 진행하시거나 계속 예약이 불가할 경우\n로얄캐리비안크루즈 예약센터 (02-737-0003)로 문의해 주세요\n\n[메세지'.$wShortText.']'.$wText.'") ;
											if("'.$locationUrl.'" != "") location.href="'.$locationUrl.'" ;
										</script>
									</body>
								</html>') ;
							}
						}

						// CSW0066 : PREPAID GRATUITIES HAVE BEEN ADDED TO THE BOOKING

					}

				}
			}
			else
			{
				$this->isWarning = false ;
			}

		}




		// 에러메세지 체크하기
		function checkWarning2($dom)
		{
			$this->isWarning = false ;

			$nWarning	= $dom->getElementsByTagName("Warning") ;

			if( $nWarning->length > 0 )
			{
				foreach ($nWarning as $node) {

					$wShortText = $this->getA2($node,"ShortText")	;
					$wType = $this->getA2($node,"Type")				;
					$wText = $node->nodeValue 						;

					array_push($this->aWarning,array( "short" => $wShortText , "type" => $wType , "text" => $wText )) ;

					if( $wShortText == "" )
					{

						$this->isWarning = false ;
						return ;
					}else{


					/*
						$obj = new CruiseFront($_REQUEST,"") ;


						//디비에서 한글로 번역된 에러를 뒤집니다.
						$sql = "SELECT * FROM rccl_curise_errorList WHERE errCode = '".$wShortText."' LIMIT 0,1";
						$row = $obj->getRow($sql);
						//있으면 한글로 된걸로 바꿔줍니다.
						if($row!=0){
							$wText = $row["errKorText"];
						}

					*/
						// CSW0066 : PREPAID GRATUITIES HAVE BEEN ADDED TO THE BOOKING
						if( !($wShortText == "CSW0619" || $wShortText == "CSW0650" || $wShortText == "CSW0066") )
						{

								$_REQUEST["errorMsg"] = $wText ;

echo(
'<html>
<head>
<title> :: 크루즈 여행의 모든것, 로얄캐리비안/셀러브리티/아자마라크루즈 :: </title>
 <META HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
</head>
<body>
<script>
alert("해당 조건으로는 예약진행이 불가능합니다.\n[메세지]' . $wText .
										'\n\n고객센터(02.737.0003)로 연락주시면 자세히 안내해드리겠습니다.") ;
										history.go(-1);
</script>
										</body></html>') ;






		///					$this->alert('해당 조건으로는 예약진행이 불가능합니다.\n[메세지]' . $wText .
		//								'\n고객센터(02.737.0003)로 연락주시면 자세히 안내해드리겠습니다.') ;

							// echo "<script>alert('".$wText."');history.go(-1);</script>";
						}
					}

				}

				$this->isWarning = true ;

			}
			else
			{
				$this->isWarning = false ;
			}

		}

		// 에러메세지 체크하기
		function checkWarningForAdmin($dom)
		{
			$this->isWarning = false ;

			$nWarning	= $dom->getElementsByTagName("Warning") ;

			if( $nWarning->length > 0 )
			{
				foreach ($nWarning as $node) {

					$wShortText = $this->getA2($node,"ShortText")	;
					$wType = $this->getA2($node,"Type")				;
					$wText = $node->nodeValue 						;

					array_push($this->aWarning,array( "short" => $wShortText , "type" => $wType , "text" => $wText )) ;

					if( $wShortText == "" )
					{

						$this->isWarning = false ;
						return ;
					}else{


					/*
						$obj = new CruiseFront($_REQUEST,"") ;


						//디비에서 한글로 번역된 에러를 뒤집니다.
						$sql = "SELECT * FROM rccl_curise_errorList WHERE errCode = '".$wShortText."' LIMIT 0,1";
						$row = $obj->getRow($sql);
						//있으면 한글로 된걸로 바꿔줍니다.
						if($row!=0){
							$wText = $row["errKorText"];
						}

					*/
						if($wShortText !="CSW0619"){

echo(
'<html>
<head>
<title> :: 크루즈 여행의 모든것, 로얄캐리비안/셀러브리티/아자마라크루즈 :: </title>
 <META HTTP-EQUIV="imagetoolbar" CONTENT="no"/>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
</head>
<body>
<script>
alert("해당 조건으로는 예약진행이 불가능합니다.\n[메세지]' . $wText . '") ;
</script>
										</body></html>') ;

						}
					}

				}

				$this->isWarning = true ;

			}
			else
			{
				$this->isWarning = false ;
			}

		}

		function alert($msg)
		{
			echo "<script> alert('" . $msg . "');</script>" ;
		}


		// 카빈 리스트를 가져온다.
		function getCabinList($param)
		{



			/*
			$fPath = $fileDirectory."/".$fileName;

			$fp = fopen($fPath,"a+");

			fwrite($fp,"\n getCabinList Request Start :".date("H:i:s",strtotime(now))."\n");
			*/



			/*
			fwrite($fp,"\n getCabinList Request End :".date("H:i:s",strtotime(now))."\n");
			*/

			$this->res	= parent::getCabinList($param) ;
			//echo $this->req ;
			//return ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;


			//echo $dom ->saveXML();
			$this->checkWarning($dom) ;

			$cbBean = new CabinBean()	;

			if( $this->isWarning == false )
			{
				$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;

				$cbBean->duration	= $this->getA3($nSailingInfo,0,"Duration")			;
				$cbBean->start		= $this->getA3($nSailingInfo,0,"Start")				;
				$cbBean->shipCode	= $this->getA4($nSailingInfo,0,0,"ShipCode")		;
				$cbBean->regionCode	= $this->getA4($nSailingInfo,0,1,"RegionCode")		;

				$cbBean->cruisePkCode = $this->getA3($nSailingInfo,1,"CruisePackageCode")		;

				$nSelectedFare = $nSailingInfo->nextSibling  ;

				$cbBean->fareCode	= $this->getA2($nSelectedFare,"FareCode") ;

				$nlCabinOption = $dom->getElementsByTagName("CabinOption")	;
				$i = 0 ;
				foreach ($nlCabinOption as $node) {
					//if($i<15){

					$coBean = new CabinOptionBean() ;

						$coBean->cabinCategoryCode				=	$this->getA2($node,"CabinCategoryCode")			;
						$coBean->cabinNumber					=	$this->getA2($node,"CabinNumber")				;
						$coBean->cabinRanking					=	$this->getA2($node,"CabinRanking")				;
						$coBean->connectingCabinIndicator		=	$this->getA2($node,"ConnectingCabinIndicator")	;
						$coBean->connectingCabinNumber			=	$this->getA2($node,"ConnectingCabinNumber")		;

						$coBean->deckName						=	$this->getA2($node,"DeckName")					;
						$coBean->deckNumber						=	$this->getA2($node,"DeckNumber")				;
						$coBean->maxOccupancy					=	$this->getA2($node,"MaxOccupancy")				;
						$coBean->positionInShip					=	$this->getA2($node,"PositionInShip")			;
						$coBean->status							=	$this->getA2($node,"Status")					;

						$coBean->meName							=	$this->getA3($node,1,"Name")					;
						$coBean->meUnit							=	$this->getA3($node,1,"UnitOfMeasure")			;
						$coBean->meQuantity						=	$this->getA3($node,1,"UnitOfMeasureQuantity")	;
						$coBean->viewObstruction				=	$this->getA3($node,1,"TPA_ViewObstruction")		;
                        if($coBean->viewObstruction == "")
                        {
                            $coBean->viewObstruction				=	$this->getA3($node,2,"TPA_ViewObstruction")		;
                        }
		//				$coBean->remark							=	$this->getA3($node,2,"

						$nlCabinFilters =  $node->getElementsByTagName("CabinFilter")	;// 카빈 필터 리스트

						foreach( $nlCabinFilters as $nCabinFilter ) {
							array_push($coBean->cabinFilters,$this->getA2($nCabinFilter,"CabinFilterCode")) ;
						}

						array_push($cbBean->cabinOptions,$coBean) ;
						$i++ ;
					//}


				}

			}

			/*
			fwrite($fp,"\n getCabinList Parsing End :".date("H:i:s",strtotime(now))."\n");

			//파일 쓰기 끝 닫기
			fclose($fp);
			*/
			/************	file write	*************/


			return $cbBean ;



		}


		function getCabinDetail($param){
			$this->res	= parent::getCabinDetail($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			$this->checkWarning($dom) ;

			$cbBean = array();

			if( $this->isWarning == false ){
				$nlCabinOption = $dom->getElementsByTagName("CabinOption")	;
				$i = 0 ;
				foreach ($nlCabinOption as $node) {
					if($i<15){

						$coBean = array();

						$coBean[cabinCategoryCode]				=	$this->getA2($node,"CabinCategoryCode")			;
						$coBean[cabinNumber]					=	$this->getA2($node,"CabinNumber")				;
						$coBean[cabinRanking]					=	$this->getA2($node,"CabinRanking")				;
						$coBean[connectingCabinIndicator]		=	$this->getA2($node,"ConnectingCabinIndicator")	;
						$coBean[connectingCabinNumber]			=	$this->getA2($node,"ConnectingCabinNumber")		;

						$coBean[deckName]						=	$this->getA2($node,"DeckName")					;
						$coBean[deckNumber]						=	$this->getA2($node,"DeckNumber")				;
						$coBean[maxOccupancy]					=	$this->getA2($node,"MaxOccupancy")				;
						$coBean[positionInShip]					=	$this->getA2($node,"PositionInShip")			;
						$coBean[status]							=	$this->getA2($node,"Status")					;

						$coBean[meName]							=	$this->getA3($node,1,"Name")					;
						$coBean[meUnit]							=	$this->getA3($node,1,"UnitOfMeasure")			;
						$coBean[meQuantity]						=	$this->getA3($node,1,"UnitOfMeasureQuantity")	;
						$coBean[viewObstruction]				=	$this->getA3($node,1,"TPA_ViewObstruction")		;
                        if($coBean[viewObstruction] == "")
                        {
                            $coBean[viewObstruction]				=	$this->getA3($node,2,"TPA_ViewObstruction")		;
                        }
						//$nlCabinFilters = $this->getChild($node,3)->childNodes ;	// 카빈 필터 리스트
						$nlCabinFilters = $dom->getElementsByTagName("CabinFilter")	;
						$coBean[cabinFilters] = array();
						foreach( $nlCabinFilters as $nCabinFilter ) {
							array_push($coBean[cabinFilters], array("cabinFilterCode" => $this->getA2($nCabinFilter,"CabinFilterCode"))) ;
						}

						array_push($cbBean,$coBean) ;
						$i++ ;
					}
				}
			}

			return $cbBean ;
		}

		// 다이닝 리스트 가져오기
		function getDinningList($start,$sc,$persion_amt,$scc,$fareCode)
		{

			$this->res	= parent::getDinningList($start,$sc,$persion_amt,$scc,$fareCode) ;

			/*
			echo $this->res ;
			echo "<br />" ;
			echo $this->req ;
			exit ;
			*/


			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$this->checkWarning($dom) ;

			$list = array() ;

			if( $this->isWarning == false )
			{
				$nDinning = $dom->getElementsByTagName("DiningOption")	;

				foreach ($nDinning as $node)
				{
					$bean = array() ;

					$bean['CrossReferencingAllowed']	=  $this->getA2($node,"CrossReferencingAllowed")	;
					$bean['FamilyTimeIndicator']		=  $this->getA2($node,"FamilyTimeIndicator")		;
					$bean['PrepaidGratuityRequired']	=  $this->getA2($node,"PrepaidGratuityRequired")	;
					$bean['Sitting']					=  $this->getA2($node,"Sitting")					;
					$bean['SittingInstance']			=  $this->getA2($node,"SittingInstance")			;
					$bean['SittingStatus']				=  $this->getA2($node,"SittingStatus")				;
					$bean['SittingType']				=  $this->getA2($node,"SittingType")				;
					$bean['SmokingAllowed']				=  $this->getA2($node,"SmokingAllowed")				;

					array_push($list,$bean) ;
				}
			}

			return $list  ;
		}



		function holdCabin($param){
			$this->res	= parent::holdCabin($param);
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom->saveXML();
			$date = gmdate('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))-(3600*12)-(3000));
			$bean = array() ;
			$bean['date'] = $date;
			if( $this->isWarning == false ){
				$nCabin = $dom->getElementsByTagName("SelectedCabin")	;
				foreach ($nCabin as $node){
					$bean["CabinNumber"] = $this->getA2($node,"CabinNumber");
				}
			}
			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Hold Cabin Success");
			return array($bean, $WarningErrorInfo);
		}

		function releaseCabin($param){
			$this->res	= parent::releaseCabin($param) ;
			//debug_var($this->res);debug_var($this->req);
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom->saveXML();
			$date = gmdate('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))-(3600*12)-(3000));
			$bean = array() ;
			$bean['date'] = $date;
			if( $this->isWarning == false ){
				$nCabin = $dom->getElementsByTagName("SelectedCabin")	;
				foreach ($nCabin as $node){
					$bean["CabinNumber"] = $this->getA2($node,"CabinNumber");
				}
			}
			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Release Cabin Success");
			return array(bean, $WarningErrorInfo);
		}

		function getBookingHistory($id){

			$this->res	= parent::getBookingHistory($id) ;



			$dom = new DOMDocument() ;

			$dom->loadXML($this->res) ;



			$text = $dom->saveXML();

			$today = $this->getToday();

			$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlRS/";
			$fileName = $today.".txt";
			$this->logging($fileDirectory, $fileName, $text) ;

			/*
			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}

			if(is_dir($fileDirectory.$today)!=true){
				mkdir($fileDirectory.$today);
			}



			$fPath = $fileDirectory."/".$fileName;

			$fp = fopen($fPath,"a+");

			//파일에 쓰는부분 .

			fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$text."\n");
			fwrite($fp,"============================================================================\n");


			//파일 쓰기 끝 닫기

			fclose($fp);
			*/


		//	echo $dom->saveXML();
		}



		function makePayment($param)
		{
			$this->res = parent::makePayment($param) ;

			if($_SERVER["SERVER_ADDR"] == "54.92.27.148") {
				var_dump($this->res);
			}

			$dom = new DOMDocument() ;

			$dom->loadXML($this->res) ;



			$text = $dom->saveXML();

			$today = $this->getToday();

			$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlRS/";
			$fileName = $today.".txt";

			$this->logging($fileDirectory, $fileName, $text) ;

			/*
			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}



			$fPath = $fileDirectory."/".$fileName;

			$fp = fopen($fPath,"a+");

			//파일에 쓰는부분 .

			fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$text."\n");
			fwrite($fp,"============================================================================\n");


			//파일 쓰기 끝 닫기

			fclose($fp);



			$fileDirectory = $obj->webRoot."/home/rccl/xmlPayment/";
			$fileName = $today.".txt";
			$this->logging($fileDirectory, $fileName, $text) ;
			*/

			/*
			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}



			$fPath = $fileDirectory."/".$fileName;


			$fp = fopen($fPath,"a+");

			//파일에 쓰는부분 .

			fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$text."\n");
			fwrite($fp,"============================================================================\n");


			//파일 쓰기 끝 닫기

			fclose($fp);
			*/


			//$this->checkWarning($dom) ;
			if( $this->isWarning == false ){
				$nPayment = $dom->getElementsByTagName("ReservationPayment")->item(0)	;
				$list = Array(
					$this->getA3($nPayment,0,"ID"),
					$this->getA3($nPayment,0,"Type"),
					$this->getA4($nPayment,1,1,"Amount"),
					$this->getA4($nPayment,1,1,"ApprovalCode")
				);
				//	echo "id:".$list[0]."\ntype:".$list[1] ."\namount:". $list[2] ."\napprovalCode :". $list[3] ;
			}else{
				$erroMsg = $dom->getElementsByTagName("Warnings")->item(0);
				$_SESSION["msg"] = $this->getA3($erroMsg,0,"ShortText");
				$list = Array(
						$this->getA3($nPayment,0,"ID"),
						$this->getA3($nPayment,0,"Type"),
						$this->getA4($nPayment,1,1,"Amount"),
						$this->getA4($nPayment,1,1,"ApprovalCode")
					);
				//	echo "id:".$list[0]."\ntype:".$list[1] ."\namount:". $list[2] ."\napprovalCode :". $list[3] ;
			}

			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Make Payment Success");
			return array($list, $WarningErrorInfo);
		}


		function getToday(){
			return date("Ymd",mktime());


		}

		function logging($fileDirectory, $fileName, $text)
		{
			if( true )
			{
				$fPath = $fileDirectory."/".$fileName;

				$fp = fopen($fPath,"a+");

				//파일에 쓰는부분 .

				fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$text."\n");
				fwrite($fp,"============================================================================\n");


				//파일 쓰기 끝 닫기

				fclose($fp);
			}
		}

		function getBookingPrice_test($param)
		{
			$this->res	= parent::getBookingPriceReqTest($param) ;

			return "" ;
		}

		/***************************************************************************
		*	제  목 : 크루즈 API - getBookingPrice
		*	함수명 : getBookingPrice
		*	작성일 : 2013-07-18
		*	작성자 :
		*	설  명 : Promotion 및 Response 되는 xml 이 수정되면서 소스도 수정
		*	수  정 : dev.lee 2013-07-18
		'***************************************************************************/
		function getBookingPrice($param){

			$this->res	= parent::getBookingPrice($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$this->checkWarning($dom) ;


			if( $this->isWarning == false || 1==1)
			{
				$cbBean = new CabinBean()	;
				$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;
				$cbBean->bookNonRefTyp = $this->getA3($nSailingInfo,1,"BookingNonRefundableType")		;
				/*
				 * <alpha:SailingInfo>
				 * <alpha:InclusivePackageOption CruisePackageCode="FR07W032"/>
				 * <alpha:SelectedCategory FareCode="01349036" PromotionDescription="SINGLESPEC"/>
				 * </alpha:SailingInfo>
				*/

				$priceInfo = $dom->getElementsByTagName("PriceInfos")	;

				/*
					<alpha:PriceInfos>
						<alpha:PriceInfo Amount="4300.00" PriceTypeCode="49"/>					Base Price (Cabin Fare) PriceTypeCode = "49"
						<alpha:PriceInfo Amount="989.00" Percent="23.00" PriceTypeCode="73"/>
						<alpha:PriceInfo Amount="199.00" PriceTypeCode="60"/>
						<alpha:PriceInfo Amount="91.04" PriceTypeCode="18"/>
						<alpha:PriceInfo Amount="4590.04" PriceTypeCode="8"/>
						<alpha:PriceInfo Amount="989.00" PriceTypeCode="80"/>
						<alpha:PriceInfo Amount="3601.04" PriceTypeCode="42"/>
					</alpha:PriceInfos>

					49 – Tariff (Base Price). 기준 요금으로 위에 언급한 내용 참조
					73 – Commission 금액
					60 – Code 표에는 “Port Charge” 로 나오는데 저희 크루즈 선사에서는 “NCCF” 로 사용합니다. 현재 시스템 확인 바랍니다.
					18 – Taxes/Fee 로 세금
					107 – Option Amount 로 선불팁/PPGR (Pre-paid-Gratuity) 입니다
					8 – Gross Total
					80 – Commission Gross Total
					42 – Net Total
				*/

				$list = array() ;
				foreach ($priceInfo as $node)
				{
					$bean = new BookingPriceBean() ;

					$priceInfoList = $this->getEs($node, "PriceInfo") ;
					foreach($priceInfoList as $priceInfo)
					{
						$priceTypeCode = $this->getA2($priceInfo,"PriceTypeCode") ;

						if($priceTypeCode == "49")			// BASE PRICE
						{
							$bean->cabinPrice  = $this->getA2($priceInfo,"Amount") ;
						}
						else if($priceTypeCode == "60")		// NCCF
						{
							$bean->tip  = $this->getA2($priceInfo,"Amount") ;
						}
						else if($priceTypeCode == "18")		// Taxes/Fee 세금
						{
							$bean->tax  = $this->getA2($priceInfo,"Amount") ;
						}
						else if($priceTypeCode == "107")		// 선불팁
						{
							$bean->realTip  = $this->getA2($priceInfo,"Amount") ;
						}
						else if($priceTypeCode == "34")			// 프로모션 요금
						{
							$ppBean = new PromotionPriceBean() ;
							$ppBean->amount = $this->getA2($priceInfo,"Amount") ;			// 프로모션 금액
							$ppBean->codeDetail = $this->getA2($priceInfo,"CodeDetail") ;	// Remark
							$ppBean->nonRefundableType = $this->getA2($priceInfo,"NonRefundableType") ;	// 환불불가
							$ppBean->CodeDescription = $this->getA2($priceInfo,"CodeDescription") ;	// 환불불가

							array_push($bean->promotionInfo,$ppBean) ;
						}
						else if($priceTypeCode == "59")			// 온보드 크레딧
						{
							$bean->valueAddPrice  = $this->getA2($priceInfo,"FaceValue") ;	// 온보드 크레딧 가격이 FaceValue에 있음.. 추후 Amount 꼭 확인

							$ppBean = new PromotionPriceBean() ;
							$ppBean->codeDetail = $this->getA2($priceInfo,"CodeDetail") ;	// Remark
							$ppBean->nonRefundableType = $this->getA2($priceInfo,"NonRefundableType") ;	// 환불불가
							$ppBean->CodeDescription = $this->getA2($priceInfo,"CodeDescription") ;	// 환불불가

							array_push($bean->promotionInfo,$ppBean) ;
						}

					}

					$list['SailingInfo']['bookNonRefTyp'] = $cbBean->bookNonRefTyp;
					$list['PriceInfos'][] = $bean ;

					/*
					$bean->cabinPrice = $this->getA3($node,0,"Amount");	// 49
					$bean->tip = $this->getA3($node,3,"Amount");		// 60	NCCF
					$bean->tax = $this->getA3($node,4,"Amount");		// 18	TAX
					$bean->care = $this->getA3($node,5,"Amount");		// 107	// 선지불 팁
					$bean->realTip = $this->getA3($node,7,"Amount");	// 108	// tip
					$bean->fuel = $this->getA3($node,9,"Amount");		// 128
					//$totalFee = $bean->cabinPrice + $bean->care + $bean->tax + $bean->tip;
					*/

				}

				return $list ;

			}

		}

		function confirmBooking_test($param)
		{
			$this->res	= parent::confirmBookingReqTest($param) ;

			return "" ;
		}


		function confirmBooking($param, $TransactionActionCode = "Commit", $confirmId = "0", $paymentType = "")
		{
			//id 업뎃 때리고 그걸로 makePaymentRQ실행
			$this->res	= parent::confirmBooking($param, $TransactionActionCode, $confirmId, $paymentType) ;
//debug_var($this->res);debug_var($this->req);

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			/*
			$text = $dom->saveXML();
			$today = $this->getToday();

			$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlRS/";
			$fileName = $today.".txt";
			$this->logging($fileDirectory, $fileName, $text) ;



			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}


			$fPath = $fileDirectory."/".$fileName;

			$fp = fopen($fPath,"a+");

			//파일에 쓰는부분 .

			fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$text."\n");
			fwrite($fp,"============================================================================\n");


			//파일 쓰기 끝 닫기

			fclose($fp);
			*/


			// 임시로 주석처리 2013-08-14 중요한부분
			$this->checkWarning($dom) ;



			$list = array() ;

			if( $this->isWarning == false )
			{

				$nlist = $dom->getElementsByTagName("ReservationID") ;
				$reservationBean = Array() ;
				foreach($nlist as $node){

						$rBean = Array() ;
						$rBean["id"]			= $this->getA2($node,"ID")			;
						$rBean["type"]			= $this->getA2($node,"Type")					;
						$rBean["statusCode"]	= $this->getA2($node,"StatusCode")		;

//		 echo "status : ". $bean->statusCode ."Type : " . $bean->type . "id : " . $bean ->id;


					array_push($reservationBean, $rBean) ;


				}

				array_push($list,$reservationBean);



				//요금정보
				$paymentNodes = $dom->getElementsByTagName("Payment");
				$paymentBean = Array() ;
				foreach($paymentNodes as $node){

					$pBean = Array() ;
					$pBean['Amount']			=  $this->getA2($node,"Amount")	;
					$pBean['DueDate']		=  $this->getA2($node,"DueDate")	;
					$pBean['PaymentNumber']	=  $this->getA2($node,"PaymentNumber")	;

					array_push($paymentBean,$pBean);
				}

				array_push($list,$paymentBean);

				$cbBean = new CabinBean()	;
				$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;
				$cbBean->bookNonRefTyp = $this->getA3($nSailingInfo,0,"BookingNonRefundableType")		;

				array_push($list,$cbBean);
				$list['SailingInfo']['bookNonRefTyp'] = $nSailingInfo;

				$priceInfo = $dom->getElementsByTagName("PriceInfos")	;
				foreach ($priceInfo as $node) {
					$bean = new BookingPriceBean();

					$priceInfoList = $this->getEs($node, "PriceInfo");
					foreach ($priceInfoList as $priceInfo) {
						$priceTypeCode = $this->getA2($priceInfo, "PriceTypeCode");

						if ($priceTypeCode == "49")            // BASE PRICE
						{
							$bean->cabinPrice = $this->getA2($priceInfo, "Amount");
						} else if ($priceTypeCode == "60")        // NCCF
						{
							$bean->tip = $this->getA2($priceInfo, "Amount");
						} else if ($priceTypeCode == "18")        // Taxes/Fee 세금
						{
							$bean->tax = $this->getA2($priceInfo, "Amount");
						} else if ($priceTypeCode == "107")        // 선불팁
						{
							$bean->realTip = $this->getA2($priceInfo, "Amount");
						} else if ($priceTypeCode == "34")            // 프로모션 요금
						{
							$ppBean = new PromotionPriceBean();
							$ppBean->amount = $this->getA2($priceInfo, "Amount");            // 프로모션 금액
							$ppBean->codeDetail = $this->getA2($priceInfo, "CodeDetail");    // Remark
							$ppBean->nonRefundableType = $this->getA2($priceInfo, "NonRefundableType");    // 환불불가

							array_push($bean->promotionInfo, $ppBean);
						} else if ($priceTypeCode == "59")            // 온보드 크레딧
						{
							$bean->valueAddPrice = $this->getA2($priceInfo, "FaceValue");    // 온보드 크레딧 가격이 FaceValue에 있음.. 추후 Amount 꼭 확인

							$ppBean = new PromotionPriceBean();
							$ppBean->codeDetail = $this->getA2($priceInfo, "CodeDetail");    // Remark
							$ppBean->nonRefundableType = $this->getA2($priceInfo, "NonRefundableType");    // 환불불가

							array_push($bean->promotionInfo, $ppBean);
						}

					}
					$list['PriceInfos'][] = $bean;

				}

			}

			//return $bean->id  ;
			return $list;

		}

		function retrieveBooking($id, $newTerminalID = "", $isRetrievePriceMode=false){
			$this->res	= parent::retrieveBooking($id, $newTerminalID, $isRetrievePriceMode) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			$retrieveInfoNodes = array();

			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Retrieve Booking Success");

			if( $this->isWarning == false ){
				$SailingInfo = $dom->saveXML($dom->getElementsByTagName("SailingInfo")->item(0));
				$ReservationInfo = $dom->saveXML($dom->getElementsByTagName("ReservationInfo")->item(0));
				$BookingPriceInfo = $dom->saveXML($dom->getElementsByTagName("BookingPayment")->item(0));

			//181017 Leone Add replace function for inc_confirmReportCommon.php -
				$SailingInfo = str_replace("<alpha:","<",$SailingInfo);
				$SailingInfo = str_replace("</alpha:","</",$SailingInfo);
				$ReservationInfo = str_replace("<alpha:","<",$ReservationInfo);
				$ReservationInfo = str_replace("</alpha:","</",$ReservationInfo);
				$BookingPriceInfo = str_replace("<alpha:","<",$BookingPriceInfo);
				$BookingPriceInfo = str_replace("</alpha:","</",$BookingPriceInfo);

				$SailingInfoArr = XML2Array::createArray($SailingInfo);
				$ReservationInfoArr = XML2Array::createArray($ReservationInfo);
				$BookingPriceInfoArr = XML2Array::createArray($BookingPriceInfo);


				//$SailingInfo = simplexml_load_string($SailingInfo, "SimpleXMLElement", LIBXML_NOCDATA);
				//$SailingInfo = json_decode(json_encode($SailingInfo),TRUE);

				//$ReservationInfo = simplexml_load_string($ReservationInfo, "SimpleXMLElement", LIBXML_NOCDATA);
				//$ReservationInfo = json_decode(json_encode($ReservationInfo),TRUE);


				$retrieveInfoNodes['SailingInfo'] =$SailingInfoArr['SailingInfo'];// $SailingInfo;
				$retrieveInfoNodes['ReservationInfo'] = $ReservationInfoArr['ReservationInfo'];//$ReservationInfo;
                if($isRetrievePriceMode)
                {
                    $retrieveInfoNodes['BookingPayment'] = $BookingPriceInfoArr['BookingPayment'];//$ReservationInfo;
                }
			}

			return array($retrieveInfoNodes, $WarningErrorInfo);

			/*
			$text = $dom->saveXML();
			$today = $this->getToday();

			$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlRS/";
			$fileName = $today.".txt";
			$this->logging($fileDirectory, $fileName, $text) ;



			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}




			$fPath = $fileDirectory."/".$fileName;

			$fp = fopen($fPath,"a+");

			//파일에 쓰는부분 .

			fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$text."\n");
			fwrite($fp,"============================================================================\n");


			//파일 쓰기 끝 닫기

			fclose($fp);
			*/
		//	echo $dom->saveXML();


		}

		function login($param){

			$this->res = parent::login($param);

			$dom = new DOMDocument() ;

			$dom ->loadXML($this->res);

			//echo $dom ->saveXML();

		}

		function service($param){

			$this->res = parent::service($param);

			$dom = new DOMDocument() ;

			$dom ->loadXML($this->res);

			echo $dom ->saveXML();

		}






		//TMK Admin에 의해 새로 생긴 Method 2012-01-02 jang//
		// 카빈 리스트를 가져온다.
		function getCabinListForAdmin($param)
		{

			$this->res	= parent::getCabinList($param) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			//$this->checkWarning($dom) ;

			$cbBean = new CabinBean()	;

			if( $this->isWarning == false )
			{
				$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;

				$cbBean->duration	= $this->getA3($nSailingInfo,0,"Duration")			;
				$cbBean->start		= $this->getA3($nSailingInfo,0,"Start")				;
				$cbBean->shipCode	= $this->getA4($nSailingInfo,0,0,"ShipCode")		;
				$cbBean->regionCode	= $this->getA4($nSailingInfo,0,1,"RegionCode")		;

				$ctBean->cruisePkCode = $this->getA3($nSailingInfo,1,"CruisePackageCode")		;

				$nSelectedFare = $nSailingInfo->nextSibling  ;

				$ctBean->fareCode	= $this->getA2($nSelectedFare,"FareCode") ;

				$nlCabinOption = $dom->getElementsByTagName("CabinOption")	;

				foreach ($nlCabinOption as $node) {

					$coBean = new CabinOptionBean() ;

					$coBean->cabinCategoryCode				=	$this->getA2($node,"CabinCategoryCode")			;
					$coBean->cabinNumber					=	$this->getA2($node,"CabinNumber")				;
					$coBean->cabinRanking					=	$this->getA2($node,"CabinRanking")				;
					$coBean->connectingCabinIndicator		=	$this->getA2($node,"ConnectingCabinIndicator")	;
					$coBean->connectingCabinNumber			=	$this->getA2($node,"ConnectingCabinNumber")		;

					$coBean->deckName						=	$this->getA2($node,"DeckName")					;
					$coBean->deckNumber						=	$this->getA2($node,"DeckNumber")				;
					$coBean->maxOccupancy					=	$this->getA2($node,"MaxOccupancy")				;
					$coBean->positionInShip					=	$this->getA2($node,"PositionInShip")			;
					$coBean->status							=	$this->getA2($node,"Status")					;

					$coBean->meName							=	$this->getA3($node,1,"Name")					;
					$coBean->meUnit							=	$this->getA3($node,1,"UnitOfMeasure")			;
					$coBean->meQuantity						=	$this->getA3($node,1,"UnitOfMeasureQuantity")	;

                    $coBean->viewObstruction				=	$this->getA3($node,1,"TPA_ViewObstruction")		;
                    if($coBean->viewObstruction == "")
                    {
                        $coBean->viewObstruction				=	$this->getA3($node,2,"TPA_ViewObstruction")		;
                    }
	//				$coBean->remark							=	$this->getA3($node,2,"


					$nlCabinFilters = $this->getChild($node,3)->childNodes ;	// 카빈 필터 리스트



					//foreach( $nlCabinFilters as $nCabinFilter ) {

					//	array_push($coBean->cabinFilters,$this->getA2($nCabinFilter,"CabinFilterCode")) ;
					//}

					array_push($cbBean->cabinOptions,$coBean) ;


				}

			}


			return $cbBean ;

		}



		function holdCabinForAdmin($param)
		{

			$this->res	= parent::holdCabinForAdmin($param) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$this->checkWarning($dom) ;

			$list = array() ;

			if( $this->isWarning == false )
			{
				$selCabin = $dom->getElementsByTagName("SelectedCabin")	;
				$insurance = $dom->getElementsByTagName("Insurance") ;

				foreach ($selCabin as $node)
				{
					$bean = array() ;
					$bean["CabinNumber"]	= $this->getA2($node, "CabinNumber") ;
					$bean["HeldIndicator"]	= $this->getA2($node, "HeldIndicator") ;

					array_push($list,$bean) ;
				}

				foreach ($insurance as $node)
				{
					$bean = array() ;
					$bean["Insurance"]		= $this->getA2($node, "InsuranceCode") ;

					//echo $bean["Insurance"] ;

					array_push($list,$bean) ;
				}
			}

			return $list ;

		}

		function confirmBookingForAdmin($param)
		{

			$this->res	= parent::confirmBookingForAdmin($param) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;

			$this->checkWarningForAdmin($dom) ;

			$list = array() ;

			if( $this->isWarning == false )
			{

				//예약정보
				$rsvNodes = $dom->getElementsByTagName("ReservationID");
				foreach($rsvNodes as $node){

					$bean = Array() ;
					$bean['ID']			=  $this->getA2($node,"ID")	;
					$bean['Type']		=  $this->getA2($node,"Type")	;
					$bean['StatusCode']	=  $this->getA2($node,"StatusCode")	;

					array_push($list, $bean);
				}


				//결제정보
				$priceNodes = $dom->getElementsByTagName("BookingPrice");
				$priceBean = Array() ;
				foreach($priceNodes as $node){

					$bean = Array() ;
					$bean['Amount']			=  $this->getA2($node,"Amount")	;
					$bean['PriceTypeCode']	=  $this->getA2($node,"PriceTypeCode")	;

					array_push($priceBean,$bean);
				}

				array_push($list,$priceBean);


				//요금정보
				$paymentNodes = $dom->getElementsByTagName("Payment");
				$paymentBean = Array() ;
				foreach($paymentNodes as $node){

					$bean = Array() ;
					$bean['Amount']			=  $this->getA2($node,"Amount")	;
					$bean['DueDate']		=  $this->getA2($node,"DueDate")	;
					$bean['PaymentNumber']	=  $this->getA2($node,"PaymentNumber")	;

					array_push($paymentBean,$bean);
				}

				array_push($list,$paymentBean);

				//캐빈정보
				$priceInfoNodes = $dom->getElementsByTagName("PriceInfos");
				$priceInfoBean = Array() ;
				$priceTotal = 0 ;
				foreach($priceInfoNodes as $node){

					$bean = Array() ;

					$infoNode = $node->getElementsByTagName("PriceInfo") ;

					$bean["cabinFee"] = $this->getA5($infoNode, "PriceTypeCode", "49" , "Amount") ;
					$bean["tipFee"] = $this->getA5($infoNode, "PriceTypeCode", "60" , "Amount") ;	//NCCF
					$bean["taxFee"] = $this->getA5($infoNode, "PriceTypeCode", "18" , "Amount") ;	//TAX
					$bean["care"] = $this->getA6ExtSum($infoNode, "PricedComponentCode", "CRCR" , "Amount") ;		//C.CARE
					$bean["realTip"] = $this->getA6ExtSum($infoNode, "PricedComponentCode", "PPGR" , "Amount") ;	//TIP
					$bean["saleFee"] = $bean["cabinFee"] + $bean["tipFee"] + $bean["taxFee"] + $bean["care"] + $bean["realTip"] ;
					$priceTotal += $bean["saleFee"] ;

					/*
					$bean["cabinFee"] = $this->getA3($node,0,"Amount") + $this->getA3($node,9,"Amount") ;//cabinPrice + fuel
					$bean["tipFee"] = $this->getA3($node,3,"Amount");	//NCCF
					$bean["taxFee"] = $this->getA3($node,4,"Amount");	//TAX
					$bean["care"] = $this->getA3($node,5,"Amount");		//C.CARE
					$bean["realTip"] = $this->getA3($node,7,"Amount");	//TIP
					$bean["saleFee"] = $bean["cabinFee"] + $bean["tipFee"] + $bean["taxFee"] + $bean["care"] + $bean["realTip"] ;
					$priceTotal += $bean["saleFee"] ;
					*/

					array_push($priceInfoBean,$bean) ;


					/*
					$infoNodes = $node->childNodes ;
					$infoBean = Array() ;

					foreach($infoNodes as $infoNode)
					{
						$bean = Array() ;
						$bean['Amount']			= $this->getA2($infoNode, "Amount") ;
						$bean['PriceTypeCode']	= $this->getA2($infoNode, "PriceTypeCode") ;
						array_push($infoBean, $bean) ;
					}

					array_push($priceInfoBean,$infoBean);
					*/
				}

				array_push($list,$priceInfoBean);
				array_push($list,$priceTotal);

			}

			//$list[0] : 예약정보
			//$list[1] : 결제정보 Array
			//$list[2] : 요금정보 Array
			//$list[3] : 캐빈정보(요금) - $list[3][n] : 캐빈요금Array
			//$list[4] : 캐빈 총 요금

			return $list  ;

		}

		function test($str)
		{
			$dom = new DOMDocument() ;
			$dom->loadXML($str) ;

			$priceInfoNodes = $dom->getElementsByTagName("PriceInfos");

			foreach($priceInfoNodes as $node)
			{
				$infoNode = $node->getElementsByTagName("PriceInfo") ;

				echo $this->getA6ExtSum($infoNode, "PricedComponentCode", "CRCR" , "Amount") . "<br/>" ;



			}




		}




		function getFareList($param){
			$this->res	= parent::getFareList($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			$this->checkWarning($dom) ;

			$frBean = new FareBean();

			if( $this->isWarning == false ){
				$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;

				$frBean->DescriptionCode	= $this->getA3($nSailingInfo,0,"ListOfSailingDescriptionCode")		;
				$frBean->Duration			= $this->getA3($nSailingInfo,0,"Duration")			;
				$frBean->Start				= $this->getA3($nSailingInfo,0,"Start")				;
				$frBean->ShipCode			= $this->getA4($nSailingInfo,0,0,"ShipCode")		;
				$frBean->CruisePkCode = $this->getA3($nSailingInfo,1,"CruisePackageCode")		;

				$nlFairOption = $dom->getElementsByTagName("FareCodeOption")	;
				$i = 0 ;
				foreach ($nlFairOption as $node) {
					if($i<15){

						$foBean = new FareOptionBean();

						$foBean->FareCode						=	$this->getA2($node,"FareCode")			;
						$foBean->FareDescription				=	$this->getA2($node,"FareDescription")				;
						$foBean->ListOfFareQualifierCode		=	$this->getA2($node,"ListOfFareQualifierCode")				;
						$foBean->Status							=	$this->getA2($node,"Status")	;
						$foBean->DiscountTypes					=	$this->getA2($node,"DiscountTypes")		;
						$foBean->FaceCurrency					=	$this->getA2($node,"FaceCurrency")					;
						$foBean->FaceValueType					=	$this->getA2($node,"FaceValueType")				;
						$foBean->NonRefundableType				=	$this->getA2($node,"NonRefundableType")				;
						$foBean->PromotionClass					=	$this->getA2($node,"PromotionClass")			;
						$foBean->PromotionEligibility			=	$this->getA2($node,"PromotionEligibility")					;
						$foBean->PromotionTypes					=	$this->getA2($node,"PromotionTypes")					;
						$foBean->PromotionAmount				=	$this->getA2($node,"PromotionAmount")					;
						$foBean->ValueAddAmount					=	$this->getA2($node,"ValueAddAmount")					;

						$foBean->FareRemark						=	$this->getA($node->attributes,"FareRemark")					;

						/*
						$nlCabinFilters = $this->getChild($node,3)->childNodes ;	// 카빈 필터 리스트
						foreach( $nlCabinFilters as $nCabinFilter ) {
							array_push($coBean->cabinFilters,$this->getA2($nCabinFilter,"CabinFilterCode")) ;
						}
						*/

						array_push($frBean->FareOptions,$foBean) ;
						$i++ ;
					}
				}

				$taxInfo = $dom->getElementsByTagName("Tax");

				foreach ($taxInfo as $node) {
					array_push($frBean->Taxes, $this->getA2($node,"Amount")) ;
				}
			}

			return $frBean ;
		}


		function getFareDetail($param){
			$this->res	= parent::getFareDetail($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			$this->checkWarning($dom) ;

			if( $this->isWarning == false ){
				$fareOptions = array();
				$nlFareOption = $dom->getElementsByTagName("FareCodeOption")	;
				$i = 0 ;
				foreach ($nlFareOption as $node) {
					if($i<15){
						array_push($fareOptions,$this->getA2($node,"FareDescription")) ;
						$i++ ;
					}
				}
			}

			return $fareOptions ;
		}

		function getBookingList($param){
			$this->res	= parent::getBookingList($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			$this->checkWarning($dom) ;

			if( $this->isWarning == false ){
				/* $fareOptions = array();
				 $nlFareOption = $dom->getElementsByTagName("FareCodeOption")	;
				 $i = 0 ;
				 foreach ($nlFareOption as $node) {
				 if($i<15){
				 array_push($fareOptions,$this->getA2($node,"FareDescription")) ;
				 $i++ ;
				 }
				 } */
			}

			return $fareOptions ;
		}

		function getPaymentExtension($param){
			$this->res	= parent::getPaymentExtension($param) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			//$this->checkWarning($dom) ;

			if( $this->isWarning == false ){

				$paymentExtResult = array();

				$informationType = $dom->getElementsByTagName("InformationType");

				$extensionResult = array();
				$i = 0 ;
				foreach ($informationType as $node) {
					if($i<15){
						$item = array_map("item");
						$item->code = $this->getA2($node,"Code");
						$item->date = $this->getA2($node,"Date");
						$item->name = $this->getA2($node,"Name");
						array_push($extensionResult,$item) ;
						$i++ ;
					}
				}
			}

			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Extension Payment Success");

			return array($extensionResult, $WarningErrorInfo);
		}

		function getBookingHistory2($id){

			if($this->uniqTerminalId == ""){
				$mt = microtime() ;
				$key1 = substr($mt, 17, 6) ;
				$key2 = substr($mt, 2, 6) ;
				$cUniqId = $key1 . $key2 ;
				//$this->uniqTerminalId = $cUniqId;
				$this->makePOS($cUniqId) ;
			}

			$this->res	= parent::getBookingHistory2($id) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			//$this->checkWarning($dom) ;

			if( $this->isWarning == false ){
				$paymentExtResult = array();
				$historyInfo = $dom->getElementsByTagName("HistoryInfo");
				$historyResult = array();
				$i = 0 ;
				foreach ($historyInfo as $node) {
					$item = array();
					$item['LastModified'] = $this->getA2($node,"LastModified");

					$subItems = $node->getElementsByTagName("Item") ;
					//$subItems = $node->childNode;
					$item['Items'] = array();
					$j = 0;

					foreach($subItems as $subItem ){
						$item['Items'][$j]['LastModifierID'] = $this->getA2($subItem, "LastModifierID");
						$item['Items'][$j]['ItemName'] = $this->getA2($subItem, "ItemName");
						$item['Items'][$j]['Text'] = $subItem->childNodes->item(0)->firstChild->nodeValue;
					}

					array_push($historyResult,$item) ;
					$i++ ;
				}
			}

			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Booking History Success");

			if($_REQUEST['js'] == "1") $historyResult = json_decode(json_encode($historyResult));
			return array($historyResult, $WarningErrorInfo);
		}

		function getTransferList($param){

			if($this->uniqTerminalId == ""){
				$mt = microtime() ;
				$key1 = substr($mt, 17, 6) ;
				$key2 = substr($mt, 2, 6) ;
				$cUniqId = $key1 . $key2 ;
				$this->uniqTerminalId = $cUniqId;
			}

			$this->res	= parent::getTransferList($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			//$isError = $this->checkWarning($dom) ;

			$transferListResult = array();

			if( $this->isWarning == false ){

				$cruisePackage = $dom->getElementsByTagName("CruisePackage");

				$i = 0 ;
				foreach ($cruisePackage as $node) {
					$item = array();
					$item['CruisePackageCode'] = $this->getA2($node,"CruisePackageCode");
					$item['PackageTypeCode'] = $this->getA2($node,"PackageTypeCode");
					$item['Start'] = $this->getA2($node,"Start");
					$item['End'] = $this->getA2($node,"End");
					$item['Description'] = $this->getA2($node,"Description");
					$item['Status'] = $this->getA2($node,"Status");
					$item['FlightInfoRequiredInd'] = $this->getA2($node,"FlightInfoRequiredInd");
					$item['Text'] = $node->childNodes->item(0)->firstChild->nodeValue;
					//$item['LocationCode'] = $this->getA3($node, 0, "LocationCode");
					$subItems = $node->getElementsByTagName("Location");
					$item['LocationCode'] = array();
					$j = 0;
					foreach($subItems as $subItem ){
						$item['LocationCode'][$j++] .= $this->getA2($subItem, "LocationCode");
					}

					//$item['Amount'] = $this->getA3($node, 1, "Amount");
					$subItems = $node->getElementsByTagName("PriceInfo");
					$item['PriceInfo'] = array();
					$j = 0;
					foreach($subItems as $subItem ){
						$item['PriceInfo'][$j++] .= $this->getA2($subItem, "Amount");
					}

					array_push($transferListResult,$item) ;
					$i++ ;
				}
			}

			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Transfer List Success");

			if($_REQUEST['js'] == "1") $transferListResult = json_decode(json_encode($transferListResult));
			return array($transferListResult, $WarningErrorInfo);
		}

		function getTransferDetail($param){

			if($this->uniqTerminalId == ""){
				$mt = microtime() ;
				$key1 = substr($mt, 17, 6) ;
				$key2 = substr($mt, 2, 6) ;
				$cUniqId = $key1 . $key2 ;
				//$this->uniqTerminalId = $cUniqId;
				$this->makePOS($cUniqId) ;
			}

			$this->res	= parent::getTransferDetail($param) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//echo $dom ->saveXML();
			$this->checkWarning($dom) ;

			if( $this->isWarning == false ){

				$paymentExtResult = array();

				$textData = $dom->getElementsByTagName("TextData");

				$transferDetailResult = array();
				$i = 0 ;
				foreach ($textData as $node) {
					$transferListResult [$i]['text'] = $node->nodeValue;
					$i++ ;
				}
			}

			$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Transfer Detail Success");

			if($_REQUEST['js'] == "1") $transferListResult = json_decode(json_encode($transferListResult));
			return array($transferListResult, $WarningErrorInfo);
		}


		function releaseBooking($param, $newTerminalID = ""){

			$this->res	= parent::releaseBooking($param, $newTerminalID) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			//$this->checkWarning($dom) ;

			if( $this->isWarning == false ){
				$releaseBookingInfo = array();
				$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Release Booking Success");
			}

			return array($releaseBookingInfo, $releaseBookingInfo);
		}

		function crossReference($param, $targetConfirmIdArr, $xmlResult = ""){//다이닝 통합
			$this->res	= parent::crossReference($param, $targetConfirmIdArr, $xmlResult) ;
			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			$this->checkWarning($dom) ;

			if( $this->isWarning == false ){
				$LinkedBooking = $dom->getElementsByTagName("LinkedBooking");
				$LinkedBookingArr = array();
				foreach($LinkedBooking as $node){
					$rBean = array() ;
					$rBean["Relation"]		= $this->getA2($node,"Relation");
					$rBean["LinkTypeCode"]	= $this->getA2($node,"LinkTypeCode");
					$rBean["ID"]			= $this->getA3($node, 0,"ID");
					$rBean["Type"]			= $this->getA3($node, 0,"Type");
					array_push($LinkedBookingArr, $rBean) ;
				}

				$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Cross Reference Success");
			}

			return array($LinkedBookingArr, $WarningErrorInfo);
		}

		function ModifyBooking($param, $xmlContent = "", $TransactionActionCode = "Modify", $confirmId = "0"){
			//id 업뎃 때리고 그걸로 makePaymentRQ실행
			$this->res	= parent::ModifyBooking($param, $xmlContent, $TransactionActionCode, $confirmId) ;

			$dom = new DOMDocument() ;
			$dom->loadXML($this->res) ;
			// 임시로 주석처리 2013-08-14 중요한부분
			//$this->checkWarning($dom) ;
			$list = array() ;

			if( $this->isWarning == false ){
				$nlist = $dom->getElementsByTagName("ReservationID") ;
				$reservationBean = Array() ;
				foreach($nlist as $node){
					$rBean = Array() ;
					$rBean["id"]			= $this->getA2($node,"ID")			;
					$rBean["type"]			= $this->getA2($node,"Type")					;
					$rBean["statusCode"]	= $this->getA2($node,"StatusCode")		;
					array_push($reservationBean, $rBean) ;
				}

				array_push($list,$reservationBean);

				//요금정보
				$paymentNodes = $dom->getElementsByTagName("Payment");
				$paymentBean = Array() ;
				foreach($paymentNodes as $node){

					$pBean = Array() ;
					$pBean['Amount']		=  $this->getA2($node,"Amount")	;
					$pBean['DueDate']		=  $this->getA2($node,"DueDate")	;
					$pBean['PaymentNumber']	=  $this->getA2($node,"PaymentNumber")	;

					array_push($paymentBean,$pBean);
				}

				array_push($list,$paymentBean);

				$cbBean = new CabinBean()	;
				$nSailingInfo = $dom->getElementsByTagName("SailingInfo")->item(0) ;
				$cbBean->bookNonRefTyp = $this->getA3($nSailingInfo,0,"BookingNonRefundableType")		;

				array_push($list,$cbBean);

				$WarningErrorInfo = $this->getWarningErrorInfo($dom, "Modify Booking Success");
			}

			//return $bean->id  ;
			return array($list, $WarningErrorInfo);
		}


		/**
		 * 본사 api 통신 중 에러 또는 경고 메세지 추출 공통 함수 - By 유현돈
		 * @param unknown $dom
		 * @param unknown $target
		 */
		function getWarningErrorInfo($dom, $successMsg){
			$checkResult = array();
			$Warnings = $dom->getElementsByTagName("Warning") ;
			$j = 0;
			foreach($Warnings as $Warning){
				if($this->getA2($Warning, "ShortText") != ""){
					if($j == 0) $checkResult['Warnings'] = array();
					$item = array();
					$item['ShortText'] = $this->getA2($Warning, "ShortText");
					$item['Type'] = $this->getA2($Warning, "Type");
					$item['Text'] = $Warning->childNodes->item(0)->nodeValue;
					array_push($checkResult['Warnings'],$item);
					$j++;

				}
			}

			$Errors = $dom->getElementsByTagName("Error") ;
			$j = 0;
			foreach($Errors as $Error){
				if($this->getA2($Error, "ShortText") != ""){
					if($j == 0) $checkResult['Errors'] = array();
					$item = array();
					$item['ShortText'] = $this->getA2($Error, "ShortText");
					$item['Type'] = $this->getA2($Error, "Type");
					$item['Text'] = $Error->childNodes->item(0)->nodeValue;
					array_push($checkResult['Errors'],$item);
					$j++;

				}
			}

			$faultCodes = $dom->getElementsByTagName("faultcode");
			$faultStrings = $dom->getElementsByTagName("faultstring");
			$j = 0;
			foreach($faultCodes as $faultCode){
				if($j == 0) $checkResult['Faults'] = array();
				$checkResult['Faults']['FaultCode'] = $faultCode->childNodes->item(0)->nodeValue;
				foreach($faultStrings as $faultString){
					$checkResult['Faults']['FaultString'] = $faultString->childNodes->item(0)->nodeValue;
				}
				$j++;
			}
			$checkResult = $this->getResponseResultCode($checkResult, $successMsg);

			return $checkResult;
		}

		/**
		 * 본사 api 통신완료 후 클라이언트 리턴 공통 함수 - By 유현돈
		 * @param unknown $result
		 * @param unknown $successMsg
		 */
		function getResponseResultCode($target, $successMsg){
			$result = array();
			if($target['Faults']['FaultCode'] != ""){
				$result['ErrorInfo']['ResultCode'] = "0";
				$result['ErrorInfo']['ResultMsg'] = "[".$target['Faults']['FaultCode']."]".$target['Faults']['FaultString'];
			}else if($target['Warnings'][0]['ShortText'] != ""){
				if($target['Warnings'][0]['ShortText'] == "CSW" && $target['Warnings'][0]['Text'] != "ASSIST CARD OPTION HAS BEEN ADDED TO YOUR RESERVATION"){
					$result['ErrorInfo']['ResultCode'] = "1";
				}else{
					$result['ErrorInfo']['ResultCode'] = "0";
				}
				$result['ErrorInfo']['ResultMsg'] = "[".$target['Warnings'][0]['ShortText']."]".$target['Warnings'][0]['Text'];
			}else if($target['Errors'][0]['ShortText'] != ""){
				$result['ErrorInfo']['ResultCode'] = "0";
				$result['ErrorInfo']['ResultMsg'] = "[".$target['Errors'][0]['ShortText']."]".$target['Errors'][0]['Text'];
			}else{
				$result['ErrorInfo']['ResultCode'] = "1";
				$result['ErrorInfo']['ResultMsg'] = $successMsg;
			}

			return $result;
		}

// class end

	}



}
?>
