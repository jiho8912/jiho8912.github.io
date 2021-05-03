<? include $_SERVER["DOCUMENT_ROOT"] . "/application/libraries/rcclApi/HTTPRequest.php" ; ?>
<?

if(! class_exists("CruisAPI") )	{



class CruisAPI extends HTTPRequest
{

		var $requestorID_Agency1 = '284565';
		var $requestorID_Agency2 = '154398';
		var $requestorID_Agent1 = '284565';
		function CruisAPI($url)
		{
			$this->url = $url ;

			$this->HTTPRequest($url) ;
			$this->POS= '
			<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="'.$this->companyName.'"/>
				</BookingChannel>
				</Source>
			</POS>';




		}

		function makePOS($uniqTerminalId)
		{
			$this->POS= '
			<POS>
				<Source ISOCurrency="USD" TerminalID="'. $uniqTerminalId .'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="'.$this->companyName.'"/>
				</BookingChannel>
				</Source>
			</POS>';

		}

		function makePOS2($uniqTerminalId)
		{
			$this->POS= '
			<POS>
				<Source ISOCurrency="USD" TerminalID="'. $uniqTerminalId .'" AgentSine="'. $uniqTerminalId .'" PseudoCityCode="KK11" AgentDutyCode="7" >
					<BookingChannel Type="1">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
			</POS>';

			/*
			 <Source ISOCurrency="USD" TerminalID="'.$uniqTerminalId.'" AgentSine="'. $uniqTerminalId .'" PseudoCityCode="KK11" AgentDutyCode="7">
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$uniqTerminalId.'" AgentSine="'. $uniqTerminalId .'" PseudoCityCode="KK11" AgentDutyCode="7">
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="'.$this->companyName.'"/>
				</BookingChannel>
				</Source>
			 */

		}


		var $url = "" ;


		/* var $prefix = '
		<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body>' ; */

		var $prefix = '
		<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
					      xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/"
						  xmlns:xsd="http://www.w3.org/2001/XMLSchema"
						  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
						  xmlns="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body>' ;

		// xml version="1.0" encoding="UTF-8" 제거했음

		var $fnStartTag = "";

		var $POS = "";

		var $body = "";
		var $fnEndTag	= "";

		var $postfix = '</soapenv:Body></soapenv:Envelope>' ;

		var $text = "" ;

	/***************************************************************************
	 *	제  목 : 크루즈 API HREADER 생성
	 *	함수명 : putH_Core
	 *	작성일 : 2016-06-09
	 *	작성자 :
	 *	설  명 : 기존 HEADER 생성에 PAGING TOKEN 추가된 버전
	 *	수  정 :
	 '***************************************************************************/
	function putH_Core($name,$interface,$functionName,$maxResponses,$moreIndicator,
					$retransmissionIndicator,$sequenceNmbr,$transactionIdentifier , $moreDataEchoToken = "", $ver="1.0", $target = "")
	{
		$time = timeStringNow();
		$str0 = $str1 = $str2 = $str3 = $str4 = $str5 = "";
		if( $maxResponses != "" )
			$str0 = ' MaxResponses="' . $maxResponses . '" ' ;
		if( $moreIndicator != "" )
			$str1 = ' MoreIndicator="' . $moreIndicator . '" ' ;
		if( $retransmissionIndicator != "" )
			$str2 = ' RetransmissionIndicator="' . $retransmissionIndicator . '" ' ;
		if( $transactionIdentifier != "" )
			$str3 = ' TransactionIdentifier="' . $transactionIdentifier . '" ' ;
		if( $moreDataEchoToken != "" )
			$str4 = ' MoreDataEchoToken="' . $moreDataEchoToken . '" ' ;
		if( $target != "" )
			$str5 = ' Target="' . $target . '" ' ;

		$this->fnStartTag =
		'<m:' . $name . ' xmlns:m="' .  $interface . '">' .
		'<' . $functionName . ' ' . $str0 . ' ' . $str1 . ' ' . $str2 .
		'SequenceNmbr="' . $sequenceNmbr . '" TimeStamp="' . $time . '" ' . $str3 . ' ' . $str4 . ' ' . $str5 . ' ' .
		'Version="' . $ver . '" xmlns="http://www.opentravel.org/OTA/2003/05/alpha">' ;

		$this->fnEndTag = '</' . $functionName . '></m:' . $name . '>' ;
	}

	/***************************************************************************
	*	제  목 : 크루즈 API HREADER 생성
	*	함수명 : putH
	*	작성일 : 2013-07-02
	*	작성자 :
	*	설  명 : 기존 HEADER 생성에 VERSION 추가된 버전
	*	수  정 : dev.lee 2016-06-09
	'***************************************************************************/
	function putH(	$name,$interface,$functionName,$maxResponses,$moreIndicator,
					$retransmissionIndicator,$sequenceNmbr,$transactionIdentifier , $ver="1.0", $MoreDataEchoToken = "", $target = "")
	{
		$this->putH_Core($name,$interface,$functionName,$maxResponses,$moreIndicator,
					$retransmissionIndicator,$sequenceNmbr,$transactionIdentifier, $MoreDataEchoToken, $ver, $target) ;
	}



	function putH2(	$name,$interface,$functionName,$maxResponses,$moreIndicator,
					$retransmissionIndicator,$sequenceNmbr,$transactionIdentifier,$transactionActionCode)
	{
		$time = timeStringNow();
		//$time = gmdate('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))-(3600*12)-(3000));
		//$time = "2011-03-24T05:30:39.831" ;

		if( $maxResponses != "" )
			$str0 = ' MaxResponses="' . $maxResponses . '" ' ;
		if( $moreIndicator != "" )
			$str1 = ' MoreIndicator="' . $moreIndicator . '" ' ;
		if( $retransmissionIndicator != "" )
			$str2 = ' RetransmissionIndicator="' . $retransmissionIndicator . '" ' ;
		if( $transactionIdentifier != "" )
			$str3 = ' TransactionIdentifier="' . $transactionIdentifier . '" ' ;
		if ( $transactionActionCode != "" )
			$str4 = ' TransactionActionCode="' . $transactionActionCode . '" ';
		$this->fnStartTag =
		'<m:' . $name . '  xmlns:m="' .  $interface . '">' .
		'<' . $functionName . ' ' . $str0 . ' ' . $str1 . ' ' . $str2 .
		'SequenceNmbr="' . $sequenceNmbr . '" ' . $str4 . '  TimeStamp="' . $time . '" ' . $str3 . ' ' .
		'Version="1.0"   xmlns="http://www.opentravel.org/OTA/2003/05/alpha">' ;

		// MoreDataEchoToken="01" => getSaillingList 에서 이걸 넣으면 데이터가 안나온다.
		// 하지만 getCabinList 또는 getCategoryList 에서는 필수항목으로 들어갈 수 있다.

		$this->fnEndTag = '</' . $functionName . '></m:' . $name . '>' ;

	}






	// 몸체 세팅하기
	function putB($body)
	{


		$this->body = $body ;

		// 전체 전문생성
		$this->text = $this->prefix . $this->fnStartTag . $this->POS . $this->body . $this->fnEndTag . $this->postfix ;


			//	echo $this->text;


		/*
		$today = $this->getToday();

		$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlRQ/";

		if(is_dir ($fileDirectory)!=true){
			mkdir($fileDirectory);
		}



		$fileName = $today.".txt";

		$fPath = $fileDirectory."/".$fileName;

		$fp = fopen($fPath,"a+");

		//파일에 쓰는부분 .

		fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$this->text."\n");
		fwrite($fp,"\n============================================================================\n");


		//파일 쓰기 끝 닫기

		fclose($fp);
		*/

		$this->setBody($this->text) ;		// HTTPRequest 함수

	}

	function putB3($body) //KO
	{

		$pos2 = '<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="'.$this->companyName.'"/>
				</BookingChannel>
				</Source>
			</POS>';

		$this->body = $body ;

		$this->text = $this->prefix . $this->fnStartTag . $pos2 . $this->body . $this->fnEndTag . $this->postfix ;
	//	echo $this->text;


		/*
		$today = $this->getToday();

		$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlRQ/";

		if(is_dir ($fileDirectory)!=true){
			mkdir($fileDirectory);
		}



		$fileName = $today.".txt";

		$fPath = $fileDirectory."/".$fileName;

		$fp = fopen($fPath,"a+");

		//파일에 쓰는부분 .
		fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$this->text."\n");

		fwrite($fp,"\n============================================================================\n");


		//파일 쓰기 끝 닫기

		fclose($fp);
		*/

		/*******************************/

		/*
		$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlPayment/";

		if(is_dir ($fileDirectory)!=true){
			mkdir($fileDirectory);
		}



		$fileName = $today.".txt";

		$fPath = $fileDirectory."/".$fileName;

		$fp = fopen($fPath,"a+");

		//파일에 쓰는부분 .
		fwrite($fp,"\n\nxmlStart:".date("H:i:s",strtotime(now))."\n".$this->text."\n");

		fwrite($fp,"\n============================================================================\n");


		//파일 쓰기 끝 닫기

		fclose($fp);
		*/

		$this->setBody($this->text);
	}

	function getToday(){
			return date("Ymd",mktime());


		}

	function apiLogin(){
		$time = timeStringNow();
		//$time = gmdate('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))-(3600*12)-(3000));
		$this->text = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
<SOAP-ENV:Body>
 <m:login xmlns:m="http://services.rccl.com/Interfaces/Login">
 <m0:RCL_CruiseLoginRQ Version="2.0" SequenceNmbr="1" RetransmissionIndicator="false" Target="Test" TimeStamp="'.$time.'">
 <m0:POS>
 <m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <m0:RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1" />
 <m0:BookingChannel Type="7">
  <m0:CompanyName CompanyShortName="'.$this->companyName.'" />
  </m0:BookingChannel>
  </m0:Source>
 <m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <m0:RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2" />
 <m0:BookingChannel Type="7">
 <m0:CompanyName CompanyShortName="'.$this->companyName.'" />
  </m0:BookingChannel>
  </m0:Source>
 <m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <m0:RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1" />
 <m0:BookingChannel Type="7">
  <m0:CompanyName CompanyShortName="'.$this->companyName.'" />
  </m0:BookingChannel>
  </m0:Source>
  </m0:POS>
  </m0:RCL_CruiseLoginRQ>
  </m:login>
  </SOAP-ENV:Body>
  </SOAP-ENV:Envelope>';


		$this->setBody($this->text);
	}

	function getListOfService(){

		$time = timeStringNow();

		$this->text = '<SOAP-ENV:Envelope xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns="http://www.opentravel.org/OTA/2003/05/alpha" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<SOAP-ENV:Body>
 <m:getOptionDetail xmlns:m="http://services.rccl.com/Interfaces/OptionDetail">
<OTA_CruiseSpecialServiceAvailRQ MaxResponses="30" MoreDataEchoToken="1" RetransmissionIndicator="false" SequenceNmbr="1" Target="Test" TimeStamp="'.$time.'" Version="2.0">
 <POS>
 <Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1" />
<BookingChannel Type="7">
  <CompanyName CompanyShortName="'.$this->companyName.'" />
  </BookingChannel>
  </Source>
<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2" />
<BookingChannel Type="7">
  <CompanyName CompanyShortName="'.$this->companyName.'" />
  </BookingChannel>
  </Source>
 <Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1" />
 <BookingChannel Type="7">
  <CompanyName CompanyShortName="'.$this->companyName.'" />
  </BookingChannel>
  </Source>
  </POS>
		<SailingInfo>
		<SelectedSailing Start="2011-07-17">
		<CruiseLine ShipCode="FR" />
		</SelectedSailing>
		</SailingInfo>
		<SpecialService Code="FUEL" />
		</OTA_CruiseSpecialServiceAvailRQ>
		</m:getOptionDetail>
		</SOAP-ENV:Body>
		</SOAP-ENV:Envelope>';


		$this->setBody($this->text);
	}

	function putB2($body, $name, $interface, $functionName, $newTerminalID = "", $isRetrievePriceMode=false)
	{
		if($newTerminalID != "") $this->uniqTerminalId = $newTerminalID;

		$TransactionCodeKey = 'TransactionStatusCode';
		$TransactionCodeValue = 'Start';
		if($isRetrievePriceMode)
		{
			$TransactionCodeKey = 'TransactionActionCode';
			$TransactionCodeValue = 'RetrievePrice';
		}
		$time = timeStringNow();
		$start = '
		<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body>
		<m:'.$functionName.' xmlns:m="'.$interface.'">
		<m0:'.$name.' MaxResponses="030" MoreDataEchoToken="01" MoreIndicator="false" PrimaryLangID="en-us" RetransmissionIndicator="false" SequenceNmbr="1" Target="Test" TimeStamp="'.$time.'" '.$TransactionCodeKey.'="'.$TransactionCodeValue.'" Version="2.0">
		<m0:POS>
		<m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
		<m0:RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1" />
		<m0:BookingChannel Type="7">
		<m0:CompanyName CompanyShortName="'.$this->companyName.'" />
		</m0:BookingChannel>
		</m0:Source>
		<m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
		<m0:RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2" />
		<m0:BookingChannel Type="7">
		<m0:CompanyName CompanyShortName="'.$this->companyName.'" />
		</m0:BookingChannel>
		</m0:Source>
		<m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
		<m0:RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1" />
		<m0:BookingChannel Type="7">
		<m0:CompanyName CompanyShortName="'.$this->companyName.'" />
		</m0:BookingChannel>
		</m0:Source>
		</m0:POS>
		';


		$endTag ='
		</m0:'.$name.'>
		</m:'.$functionName.'>
		</soapenv:Body>
		</soapenv:Envelope>';

		$this->start = $start;
		$this->endTag = $endTag;
		$this->body = $body;
		// 전체 전문생성
		$this->text = $this->start . $this->body . $this->endTag;
	//	echo $this->text;


		/*
		$today = $this->getToday();

		$fileDirectory = $obj->webRoot."/home/logs/rccl/xmlRQ/";

		if(is_dir ($fileDirectory)!=true){
			mkdir($fileDirectory);
		}


		$fileName = $today.".txt";

		$fPath = $fileDirectory."/".$fileName;

		$fp = fopen($fPath,"a+");

		//파일에 쓰는부분 .

		fwrite($fp,"\r\n\r\nxmlStart:".date("H:i:s",strtotime(now))."\n".$this->text."\r\n");
		fwrite($fp,"\r\n============================================================================\r\n");


		//파일 쓰기 끝 닫기

		fclose($fp);
		*/

		$this->setBody($this->text) ;		// HTTPRequest 함수

	}

	/*
		http://175.117.145.14:8080/test_bookingprice.php
	*/
	function getBookingPriceAPI()
	{
		$time = timeStringNow();

		$this->text = '
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsd=" http://www.w3.org/2001/XMLSchema" xmlns:xsi=" http://www.w3.org/2001/XMLSchema-instance" xmlns:example="http://www.example.com">
			<soapenv:Header/>
			<soapenv:Body>
			<cat:getBookingPrice xmlns:cat="http://services.rccl.com/Interfaces/BookingPrice" xmlns="http://www.opentravel.org/OTA/2003/05/alpha">
			<OTA_CruisePriceBookingRQ Version="1.0" TimeStamp="'.$time.'" TransactionIdentifier="106597" SequenceNmbr="1" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
			<POS>
			<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
			<RequestorID ID="'.$this->requestorID_Agency1.'" Type="5" ID_Context="AGENCY1"/>
			<BookingChannel Type="7">
			<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
			</BookingChannel>
			</Source>
			<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
			<RequestorID ID="'.$this->requestorID_Agency2.'" Type="5" ID_Context="AGENCY2"/>
			<BookingChannel Type="7">
			<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
			</BookingChannel>
			</Source>
			<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
			<RequestorID ID="'.$this->requestorID_Agent1.'" Type="5" ID_Context="AGENT1"/>
			<BookingChannel Type="7">
			<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
			</BookingChannel>
			</Source>
			</POS>
			<SailingInfo>
			<SelectedSailing Start="2013-07-21">
			<CruiseLine ShipCode="JR"/>
			</SelectedSailing>
			<InclusivePackageOption CruisePackageCode="JR07M175"/>
			<SelectedCategory FareCode="A0005236" PricedCategoryCode="V2" WaitlistIndicator="false" BerthedCategoryCode="V2">
			<SelectedCabin CabinNumber="GTY" Status="39"/>

			</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>
			<GuestDetails>
			<GuestDetail>
			<ContactInfo Age="30" ProfileType="1"/>
			<GuestTransportation Mode="29" Status="39">
			<GatewayCity LocationCode="C/O"/>
			</GuestTransportation>

			<SelectedDining Sitting="O" SittingType="Open" Status="36"/>
			<SelectedPackages/>
			</GuestDetail>
			<GuestDetail>
			<ContactInfo Age="30" ProfileType="1"/>
			<GuestTransportation Mode="29" Status="39">
			<GatewayCity LocationCode="C/O"/>
			</GuestTransportation>

			<SelectedDining Sitting="O" SittingType="Open" Status="36"/>
			<SelectedPackages/>
			</GuestDetail>
			</GuestDetails>
			</ReservationInfo>
			</OTA_CruisePriceBookingRQ>
			</cat:getBookingPrice>
			</soapenv:Body>
			</soapenv:Envelope>

		'  ;

		// 로얄티 회원번호 삽입한 버젼
		$this->text = '
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body><m:getBookingPrice  xmlns:m="http://services.rccl.com/Interfaces/BookingPrice"><OTA_CruisePriceBookingRQ    RetransmissionIndicator="false" SequenceNmbr="1" TimeStamp="'.$time.'"  TransactionIdentifier="106597"  Version="1.0"   xmlns="http://www.opentravel.org/OTA/2003/05/alpha">
			<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
				</BookingChannel>
				</Source>
			</POS>
			<SailingInfo>
			<SelectedSailing Start="2013-07-21">
			<CruiseLine ShipCode="JR"/>
			</SelectedSailing>
			<InclusivePackageOption CruisePackageCode="JR07M175"/>
			<SelectedCategory FareCode="00044655" PricedCategoryCode="V2" WaitlistIndicator="false" BerthedCategoryCode="V2">
			<SelectedCabin CabinNumber="GTY" Status="39"/>





			</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>

			<GuestDetails>
			<GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<LoyaltyInfo MembershipID="329309359"/>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<LoyaltyInfo MembershipID="329309359"/>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<LoyaltyInfo MembershipID="329309359"/>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<LoyaltyInfo MembershipID="329309359"/>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail>
			</GuestDetails>
			</ReservationInfo></OTA_CruisePriceBookingRQ></m:getBookingPrice></soapenv:Body></soapenv:Envelope>

		' ;

		// 프로모션 코드 삽입한 버젼
		$this->text = '
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body><m:getBookingPrice  xmlns:m="http://services.rccl.com/Interfaces/BookingPrice"><OTA_CruisePriceBookingRQ    RetransmissionIndicator="false" SequenceNmbr="1" TimeStamp="'.$time.'"  TransactionIdentifier="106597"  Version="1.0"   xmlns="http://www.opentravel.org/OTA/2003/05/alpha">
			<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
				</BookingChannel>
				</Source>
			</POS>
			<SailingInfo>
			<SelectedSailing Start="2013-07-21">
			<CruiseLine ShipCode="JR"/>
			</SelectedSailing>
			<InclusivePackageOption CruisePackageCode="JR07M175"/>
			<SelectedCategory FareCode="00044655" PricedCategoryCode="V2" WaitlistIndicator="false" BerthedCategoryCode="V2">
			<SelectedCabin CabinNumber="GTY" Status="39"/>

			<SelectedPromotions PromotionCode="CODE100" />




			</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>

			<GuestDetails>
			<GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">

				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O" CodeContext="IATA"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail>
			</GuestDetails>
			</ReservationInfo></OTA_CruisePriceBookingRQ></m:getBookingPrice></soapenv:Body></soapenv:Envelope>

		' ;

		$this->text = '
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body><m:getBookingPrice  xmlns:m="http://services.rccl.com/Interfaces/BookingPrice"><OTA_CruisePriceBookingRQ    RetransmissionIndicator="false" SequenceNmbr="1" TimeStamp="'.$time.'"  TransactionIdentifier="106597"  Version="1.0"   xmlns="http://www.opentravel.org/OTA/2003/05/alpha">
			<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
				</BookingChannel>
				</Source>
			</POS>
			<SailingInfo>
			<SelectedSailing Start="2013-07-21">
			<CruiseLine ShipCode="JR"/>
			</SelectedSailing>
			<InclusivePackageOption CruisePackageCode="JR07M175"/>
			<SelectedCategory FareCode="A0005237" PricedCategoryCode="V2" WaitlistIndicator="false" BerthedCategoryCode="V2">
			<SelectedCabin CabinNumber="GTY" Status="39"/>
			<SelectedPromotions PromotionCode="CODE100" />
			</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>

			<GuestDetails>
			<GuestDetail>
				<ContactInfo Age="30" ProfileType="1">
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail><GuestDetail>
				<ContactInfo Age="30" ProfileType="1">
				</ContactInfo>
				<GuestTransportation Mode="29" Status="39">
				<GatewayCity LocationCode="C/O"/>
				</GuestTransportation>

				<SelectedDining Sitting="O" SittingType="Open" Status="36"/>



				</GuestDetail>
			</GuestDetails>
			</ReservationInfo></OTA_CruisePriceBookingRQ></m:getBookingPrice></soapenv:Body></soapenv:Envelope>
		' ;


		$this->setBody($this->text);
	}

	function getConfirmBookingAPI()
	{
		// CruiseBookRQ
		$this->text = '
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body><m:confirmBooking  xmlns:m="http://services.rccl.com/Interfaces/ConfirmBooking"><OTA_CruiseBookRQ   SequenceNmbr="1"  TransactionActionCode="Commit"   TimeStamp="'.$time.'"  TransactionIdentifier="0"  Version="1.0"   xmlns="http://www.opentravel.org/OTA/2003/05/alpha">
			<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
				</BookingChannel>
				</Source>
			</POS>
			<AgentInfo Contact="TOURMARKETINGKOR" />
			<SailingInfo>
				<SelectedSailing Duration="P7N" Start="2013-07-21" Status="60">
					<CruiseLine ShipCode="JR" VendorCode="Z" />
				</SelectedSailing>
				<InclusivePackageOption CruisePackageCode="JR07M175" />
				<SelectedCategory FareCode="00044655" PricedCategoryCode="09" WaitlistIndicator="false" BerthedCategoryCode="09">
					<SelectedCabin CabinNumber="WLT" Status="39" />
					<SelectedPromotions PromotionCode="CODE100" />
				</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>
				<ReservationID ID="0" LastModifyDateTime="2013-07-18T18:21:28" StatusCode="42" Type="14" />
				<GuestDetails>

				<GuestDetail>
					<ContactInfo Age="30" ContactType="CNT" Nationality="KR" BirthDate="1983-01-01">
						<PersonName>
							<GivenName>TEST</GivenName>
							<Surname>TEST</Surname>
							<NameTitle>MR</NameTitle>
						</PersonName>
						<Telephone PhoneNumber="010-6670-9963" />
					</ContactInfo>
					<ContactInfo ContactType="ALT">
						<Email>hongjae.lee@richware.co.kr</Email>
					</ContactInfo>

					<SelectedDining Status="39" Sitting="O" SittingType="Open" />
				</GuestDetail>
				<GuestDetail>
					<ContactInfo Age="30" ContactType="CNT" Nationality="KR" BirthDate="1983-02-02">
						<PersonName>
							<GivenName>TEST</GivenName>
							<Surname>TEST</Surname>
							<NameTitle>MR</NameTitle>
						</PersonName>
						<Telephone PhoneNumber="010-6670-9963" />

					</ContactInfo>
					<ContactInfo ContactType="ALT">
						<Email>hongjae.lee@richware.co.kr</Email>
					</ContactInfo>

					<SelectedDining Status="39" Sitting="O" SittingType="Open" />
				</GuestDetail>
				<GuestDetail>
					<ContactInfo Age="30" ContactType="CNT" Nationality="KR" BirthDate="1983-03-03">
						<PersonName>
							<GivenName>TEST</GivenName>
							<Surname>TEST</Surname>
							<NameTitle>MR</NameTitle>
						</PersonName>
						<Telephone PhoneNumber="010-6670-9963" />

					</ContactInfo>
					<ContactInfo ContactType="ALT">
						<Email>hongjae.lee@richware.co.kr</Email>
					</ContactInfo>

					<SelectedDining Status="39" Sitting="O" SittingType="Open" />
				</GuestDetail>
				<GuestDetail>
					<ContactInfo Age="30" ContactType="CNT" Nationality="KR" BirthDate="1983-04-04">
						<PersonName>
							<GivenName>TEST</GivenName>
							<Surname>TEST</Surname>
							<NameTitle>MR</NameTitle>
						</PersonName>
						<Telephone PhoneNumber="010-6670-9963" />

					</ContactInfo>
					<ContactInfo ContactType="ALT">
						<Email>hongjae.lee@richware.co.kr</Email>
					</ContactInfo>

					<SelectedDining Status="39" Sitting="O" SittingType="Open" />
				</GuestDetail>
				</GuestDetails>
				<LinkedBookings>
					<LinkedBooking>
					</LinkedBooking>
				</LinkedBookings>
			</ReservationInfo>
			</OTA_CruiseBookRQ></m:confirmBooking></soapenv:Body></soapenv:Envelope>
		' ;

		$this->text = '
			<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body><m:confirmBooking  xmlns:m="http://services.rccl.com/Interfaces/ConfirmBooking"><OTA_CruiseBookRQ   SequenceNmbr="1"  TransactionActionCode="Commit"   TimeStamp="'.$time.'"  TransactionIdentifier="0"  Version="1.0"   xmlns="http://www.opentravel.org/OTA/2003/05/alpha">
			<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency1.'" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="'.$this->requestorID_Agency2.'" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="'.$this->requestorID_Agent1.'" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="TOURMARKETINGKOR"/>
				</BookingChannel>
				</Source>
			</POS>
			<AgentInfo Contact="TOURMARKETINGKOR" />
			<SailingInfo>
				<SelectedSailing Duration="P9N" Start="2013-10-21" Status="60">
					<CruiseLine ShipCode="LG" VendorCode="R" />
				</SelectedSailing>
				<InclusivePackageOption CruisePackageCode="LG09R012" />
				<SelectedCategory FareCode="A0005229" PricedCategoryCode="D2" WaitlistIndicator="false" BerthedCategoryCode="D2">
					<SelectedCabin CabinNumber="7554" Status="39" />

				</SelectedCategory>
			</SailingInfo>
			<ReservationInfo>
				<ReservationID ID="0" LastModifyDateTime="2013-08-01T14:06:11" StatusCode="42" Type="14" />
				<GuestDetails>

				<GuestDetail>
					<ContactInfo Age="35" ContactType="CNT" Nationality="KR" BirthDate="1978-01-01">
						<PersonName>
							<GivenName>BRIAN</GivenName>
							<Surname>SOMERVILLE</Surname>
							<NameTitle>MR</NameTitle>
						</PersonName>
						<Telephone PhoneNumber="010-2322-3232" />
						<LoyaltyInfo MembershipID="329309359" />
					</ContactInfo>
					<ContactInfo ContactType="ALT">
						<Email>hongjae.lee@richware.co.kr</Email>
					</ContactInfo>
					<SelectedDining Status="39" Sitting="2" SittingType="Traditional" />

					<SelectedOptions OptionCode="PPGR"/><SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/><SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/></GuestDetail>
				<GuestDetail>
					<ContactInfo Age="35" ContactType="CNT" Nationality="KR" BirthDate="1978-01-01">
						<PersonName>
							<GivenName>TEST</GivenName>
							<Surname>TESTER</Surname>
							<NameTitle>MR</NameTitle>
						</PersonName>
						<Telephone PhoneNumber="010-2322-3232" />
						<LoyaltyInfo MembershipID="329309359" />
					</ContactInfo>
					<ContactInfo ContactType="ALT">
						<Email>hongjae.lee@richware.co.kr</Email>
					</ContactInfo>
					<SelectedDining Status="39" Sitting="2" SittingType="Traditional" />

					<SelectedOptions OptionCode="PPGR"/><SelectedOptions OptionCode="TIAC" SelectedOptionsIndicator="false"/><SelectedOptions OptionCode="TIAS" SelectedOptionsIndicator="false"/></GuestDetail>
				</GuestDetails>
				<LinkedBookings>
					<LinkedBooking>
					</LinkedBooking>
				</LinkedBookings>
			</ReservationInfo>
			</OTA_CruiseBookRQ></m:confirmBooking></soapenv:Body></soapenv:Envelope>
		' ;


		$this->setBody($this->text);
	}


}
}

?>
