<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/api/HTTPRequest.php" ; ?>
<?

if(! class_exists("CruisAPI") )	{



class CruisAPI extends HTTPRequest
{

		function CruisAPI($url)
		{
			$this->url = $url ;

			$this->HTTPRequest($url) ;
		
			$this->POS= '
			<POS>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="284565" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="154398" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="284565" ID_Context="AGENT1"/>
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
					<RequestorID Type="5" ID="284565" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$uniqTerminalId.'">
					<RequestorID Type="5" ID="154398" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$uniqTerminalId.'">
				<RequestorID Type="5" ID="284565" ID_Context="AGENT1"/>
				<BookingChannel Type="7">
					<CompanyName CompanyShortName="'.$this->companyName.'"/>
				</BookingChannel>
				</Source>
			</POS>';			

		} 

		
		var $url = "" ;
		

		var $prefix = '
		<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"  xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
		<soapenv:Header/>
		<soapenv:Body>' ;

		// xml version="1.0" encoding="UTF-8" 제거했음

		var $fnStartTag = "";

		var $POS = "";

		var $body = "";
		var $fnEndTag	= "";

		var $postfix = '</soapenv:Body></soapenv:Envelope>' ;

		var $text = "" ;


	// 세팅하기
	function putH(	$name,$interface,$functionName,$maxResponses,$moreIndicator,
					$retransmissionIndicator,$sequenceNmbr,$transactionIdentifier)
	{

		//$time = gmdate('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))-(3600*12)-(3000));
		//$time = "2008-07-17T12:44:44.866-04:00" ;
		$time = date('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z")));
		if( $maxResponses != "" ) 
			$str0 = ' MaxResponses="' . $maxResponses . '" ' ;
		if( $moreIndicator != "" ) 
			$str1 = ' MoreIndicator="' . $moreIndicator . '" ' ;
		if( $retransmissionIndicator != "" )
			$str2 = ' RetransmissionIndicator="' . $retransmissionIndicator . '" ' ;
		if( $transactionIdentifier != "" )
			$str3 = ' TransactionIdentifier="' . $transactionIdentifier . '" ' ;


	

		$this->fnStartTag =
		'<m:' . $name . '  xmlns:m="' .  $interface . '">' .
		'<' . $functionName . ' ' . $str0 . ' ' . $str1 . ' ' . $str2 .  
		'SequenceNmbr="' . $sequenceNmbr . '" TimeStamp="' . $time . '" ' . $str3 . ' ' . 
		'Version="1.0"   xmlns="http://www.opentravel.org/OTA/2003/05/alpha">' ;

		// MoreDataEchoToken="01" => getSaillingList 에서 이걸 넣으면 데이터가 안나온다.
		// 하지만 getCabinList 또는 getCategoryList 에서는 필수항목으로 들어갈 수 있다.

		$this->fnEndTag = '</' . $functionName . '></m:' . $name . '>' ;

	}



	function putH2(	$name,$interface,$functionName,$maxResponses,$moreIndicator,
					$retransmissionIndicator,$sequenceNmbr,$transactionIdentifier,$transactionActionCode)
	{
		$time = date('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z")));
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
					<RequestorID Type="5" ID="284565" ID_Context="AGENCY1"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
					<RequestorID Type="5" ID="154398" ID_Context="AGENCY2"/>
					<BookingChannel Type="7">
						<CompanyName CompanyShortName="'.$this->companyName.'"/>
					</BookingChannel>
				</Source>
				<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
				<RequestorID Type="5" ID="284565" ID_Context="AGENT1"/>
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
		$time = date('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z")));
		//$time = gmdate('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z"))-(3600*12)-(3000));
		$this->text = '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha">
<SOAP-ENV:Body>
 <m:login xmlns:m="http://services.rccl.com/Interfaces/Login">
 <m0:RCL_CruiseLoginRQ Version="2.0" SequenceNmbr="1" RetransmissionIndicator="false" Target="Test" TimeStamp="'.$time.'">
 <m0:POS>
 <m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <m0:RequestorID Type="5" ID="284565" ID_Context="AGENCY1" /> 
 <m0:BookingChannel Type="7">
  <m0:CompanyName CompanyShortName="'.$this->companyName.'" /> 
  </m0:BookingChannel>
  </m0:Source>
 <m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <m0:RequestorID Type="5" ID="154398" ID_Context="AGENCY2" /> 
 <m0:BookingChannel Type="7">
 <m0:CompanyName CompanyShortName="'.$this->companyName.'" /> 
  </m0:BookingChannel>
  </m0:Source>
 <m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <m0:RequestorID Type="5" ID="284565" ID_Context="AGENT1" /> 
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

		$time = date('Y-m-d\TH:i:s\Z', strtotime(date("Y-m-d\TH:i:s\Z")));
		
		$this->text = '<SOAP-ENV:Envelope xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns="http://www.opentravel.org/OTA/2003/05/alpha" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<SOAP-ENV:Body>
 <m:getOptionDetail xmlns:m="http://services.rccl.com/Interfaces/OptionDetail">
<OTA_CruiseSpecialServiceAvailRQ MaxResponses="30" MoreDataEchoToken="1" RetransmissionIndicator="false" SequenceNmbr="1" Target="Test" TimeStamp="2008-05-21T13:26:38" Version="2.0">
 <POS>
 <Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <RequestorID Type="5" ID="284565" ID_Context="AGENCY1" /> 
<BookingChannel Type="7">
  <CompanyName CompanyShortName="'.$this->companyName.'" /> 
  </BookingChannel>
  </Source>
<Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <RequestorID Type="5" ID="154398" ID_Context="AGENCY2" /> 
<BookingChannel Type="7">
  <CompanyName CompanyShortName="'.$this->companyName.'" /> 
  </BookingChannel>
  </Source>
 <Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
  <RequestorID Type="5" ID="284565" ID_Context="AGENT1" /> 
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

	function putB2($body) 
	{
		

		$start = '
		<SOAP-ENV:Envelope xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:m0="http://www.opentravel.org/OTA/2003/05/alpha" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
		<SOAP-ENV:Body>
		<m:retrieveBooking xmlns:m="http://services.rccl.com/Interfaces/RetrieveBooking">
		<m0:OTA_ReadRQ MaxResponses="030" MoreDataEchoToken="01" MoreIndicator="false" PrimaryLangID="en-us" RetransmissionIndicator="false" SequenceNmbr="1" Target="Test" TimeStamp="2008-05-16T13:51:14" TransactionStatusCode="Start" Version="2.0">
		<m0:POS>
		<m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
		<m0:RequestorID Type="5" ID="284565" ID_Context="AGENCY1" /> 
		<m0:BookingChannel Type="7">
		<m0:CompanyName CompanyShortName="'.$this->companyName.'" /> 
		</m0:BookingChannel>
		</m0:Source>
		<m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
		<m0:RequestorID Type="5" ID="154398" ID_Context="AGENCY2" /> 
		<m0:BookingChannel Type="7">
		<m0:CompanyName CompanyShortName="'.$this->companyName.'" /> 
		</m0:BookingChannel>
		</m0:Source>
		<m0:Source ISOCurrency="USD" TerminalID="'.$this->uniqTerminalId.'">
		<m0:RequestorID Type="5" ID="284565" ID_Context="AGENT1" /> 
		<m0:BookingChannel Type="7">
		<m0:CompanyName CompanyShortName="'.$this->companyName.'" /> 
		</m0:BookingChannel>
		</m0:Source>
		</m0:POS>
		';


		$endTag ='
		</m0:OTA_ReadRQ>
		</m:retrieveBooking>
		</SOAP-ENV:Body>
		</SOAP-ENV:Envelope>';
	
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
	

}
}

?>