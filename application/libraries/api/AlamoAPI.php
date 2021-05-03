<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/api/HTTPRequest.php" ; ?>
<?

if(! class_exists("AlamoAPI") )	{



	class AlamoAPI extends HTTPRequest
	{
		var $POS = "";
		var $requestId = "300083" ;		// 요청 아이디
		var $iata = "AL016141" ;			// 아야타 번호

		var $strXmlHead = "" ;		// 전문 헤더 부분
		var $strXmlTail = "" ;		// 전문 테일 부분

		var $url = "" ;		
		
		var $fnStartTag = "";
		var $body = "";
		var $fnEndTag	= "";

		var $text = "" ;



		function AlamoAPI($url)
		{
			$this->url = $url ;

			$this->HTTPRequest($url) ;

			$this->initParam();
		}


		/**
		 * 요금제에 따라 설정 값 바인딩
		 */
		function initParam()
		{
			/*
			echo "this->requestId : {$this->requestId} <br>";
			echo "this->iata : {$this->iata} <br>";
			echo "this->requestorID : {$this->requestorID} <br>";
			echo "this->corpDiscountNumber : {$this->corpDiscountNumber} <br>";
			
			echo "ic : { $_REQUEST[ic]} <br>";
			echo "iata_code : { $_REQUEST[iata_code]} <br>";
			echo "requestor_code : { $_REQUEST[requestor_code]} <br>";
			echo "discount_code : { $_REQUEST[discount_code]} <br>";
			*/
			$this->requestId = ($_REQUEST["ic"] != "") ? $_REQUEST["ic"] : $this->requestId ;
			$this->iata = ($_REQUEST["iata_code"] != "") ? $_REQUEST["iata_code"] : $this->iata ;
			$this->requestorID = ($_REQUEST["requestor_code"] != "") ? $_REQUEST["requestor_code"] : $this->requestorID ;
			$this->corpDiscountNumber = ($_REQUEST["discount_code"] != "") ? $_REQUEST["discount_code"] : $this->corpDiscountNumber ;
			
			
			//echo "this->contractID : {$this->requestId} <br>";
			//echo "this->iata : {$this->iata} <br>";
			//echo "this->requestorID : {$this->requestorID} <br>";
			//echo "this->corpDiscountNumber : {$this->corpDiscountNumber} <br>";
			
			//exit;
		}

		function setFeeData($requestId, $iata, $requestorID, $corpDiscountNumber)
		{
			$this->requestId = ($requestId != "") ? $requestId : $this->requestId ;
			$this->iata = ($iata != "") ? $iata : $this->iata ;
			$this->requestorID = ($requestorID != "") ? $requestorID : $this->requestorID ;
			$this->corpDiscountNumber = ($corpDiscountNumber != "") ? $corpDiscountNumber : $this->corpDiscountNumber ;
		}

		/*
			SOAP DATA 생성 2012-01-11 ADD BY DEV.LEE
		*/
		function initSetSOAPData($functionName, $vendor)
		{
			/*
			$this->strXmlHead = '
				<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
					<SOAP-ENV:Body>
					<ns1:do_' . $functionName . ' xmlns:ns1="OTA" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
					<brand xsi:type="xsd:string">' . $vendor . '</brand>
					<schema xsi:type="xsd:string">2007A</schema>
					<request xsi:type="xsd:string">' ;


			$this->strXmlTail = '
					</request>
					</ns1:do_' . $functionName . '>
					</SOAP-ENV:Body>
					</SOAP-ENV:Envelope>
			' ;
			*/

			$this->strXmlHead = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns="http://www.opentravel.org/OTA/2003/05">
					<soapenv:Header/>
					<soapenv:Body>
					' ;

			$this->strXmlTail = '					
					</soapenv:Body>
					</soapenv:Envelope>
			' ;
		}


		/*
			CAR 기본 HEADER 생성 2012-01-11 ADD BY DEV.LEE
		*/
		function putH($functionName, $maxResponses, $sequenceNmbr, $transactionIdentifier)
		{
			$time = date('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z")));
			
			if( $maxResponses != "" ) 
				$strMaxResponse = ' MaxResponses="' . $maxResponses . '" ' ;
			if( $transactionIdentifier != "" )
				$strTransactionIdentifier = ' TransactionIdentifier="' . $transactionIdentifier . '" ' ;

			/*
			$this->fnStartTag =	'
				
				<' . $functionName . '
				xmlns="http://www.opentravel.org/OTA/2003/05"
				xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
				xsi:schemaLocation="http://www.opentravel.org/OTA/2007A/'.$functionName.'.xsd"
				TimeStamp="' . $time . '"
				Target="Production"
				Version="2.0"' .
				$strMaxResponse . '
				SequenceNmbr="' . $sequenceNmbr . '" ' .
				$strTransactionIdentifier . '>' ;
			*/

			$this->fnStartTag =	'
				<' . $functionName . ' 
				PrimaryLangID="EN" TimeStamp="' . $time . '"
				Target="Test" 
				Version="3.0" 
				' . $strTransactionIdentifier . ' 				
				SequenceNmbr="' . $sequenceNmbr . '"
				' . $strMaxResponse . ' 
				xmlns="http://www.opentravel.org/OTA/2003/05" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 			
				xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05:\\Users\\e557gc\\Documents\\XML\\2012BU~1\\' . $functionName . '.xsd">
			' ;

			$this->fnEndTag = '</' . $functionName . '>' ;
		}
		
		// POS
		function makePOS($ic='',$vendor='')
		{
			$this->requestId = ($ic != "") ? $ic : $this->requestId ;
			
			$addSource = "" ;

			if($vendor == "ZL")
			{
				//내셔널 대한항공
				if($ic == "5030220" || $ic == "5029349")
				{
					$this->iata = "NC002175" ;
				}
				//내셔널 아시아나
				else if($ic == "5030370" || $ic == "5030341")
				{
					$this->iata = "NC002631" ;
				}

				//나머지 기본
				else
				{
					$this->iata = "NC002146" ;
				}
			}
			else
			{
				//알라모 대한항공
				if($ic == "7015881" || $ic == "7015648")
				{
					$this->iata = "AL021141" ;
				}
				//알라모 아시아나
				else if($ic == "7016010" || $ic == "7015977")
				{
					$this->iata = "AL021725" ;
				}
				//나머지 기본
				else
				{
					$this->iata = "AL016141" ;
				}
			}

			$addSource .= '
				<Source>
					<RequestorID Type="4" ID="' . $this->iata . '" ID_Context="IATA"/>
				</Source>
			' ;

			$this->POS = '
				<POS>
					<Source ISOCountry="KR">
						<RequestorID Type="4" ID="' . $this->requestId . '">
							<CompanyName Code="KR" CompanyShortName="KRWEBXML"/>
						</RequestorID>
					</Source>
					'.$addSource.'
				</POS>
			' ;

		} 


		// 몸체 세팅하기
		function putB($body) 
		{
			$this->body = $body ;

			// $strEncodeBody = $this->encode($this->fnStartTag . $this->POS . $this->body . $this->fnEndTag) ;
			$strEncodeBody = ($this->fnStartTag . $this->POS . $this->body . $this->fnEndTag) ;

			// 전체 전문생성
			$this->text = '<?xml version="1.0" encoding="UTF-8"?>' . $this->strXmlHead . $strEncodeBody . $this->strXmlTail ;
			
			$this->setBody($this->text) ;		// HTTPRequest 함수	
		}


	}
}

?>