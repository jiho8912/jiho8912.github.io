<?

if(! class_exists("HTTPRequest") )	{

class HTTPRequest
{
   var $_fp;		// HTTP socket
   var $_url;       // full URL
   var $_host;      // HTTP host
   var $_protocol;  // protocol (HTTP/HTTPS)
   var $_uri;       // request URI
   var $_port;      // port

   var $req ;
   var $companyName = "TOURMARKETINGKOR";
   // var $SERVICE_URL = "https://mo.vanguardcar.com/services/OTA";	// TEST- alamo
   // var $SERVICE_URL = "https://www.vanguardcar.com/services/OTA";	// REAL- alamo

     var $SERVICE_URL = "https://xmldirect.ehi.com/services30/OTA30SOAP";	// REAL- alamo
   // var $SERVICE_URL = "http://www.alamo-stage.co.kr/gateApiLive.php";	// REAL- alamo
   var $Authorization = "T1RBX0FMTUtPUlBSRDE6UGpSZTc2eEQ=";				// REAL- alamo

   var $_mHeader = Array() ;

   // scan url
   function _scan_url()
   {
       $req = $this->_url;
       
       $pos = strpos($req, '://');
       $this->_protocol = strtolower(substr($req, 0, $pos));
       
       $req = substr($req, $pos+3);
       $pos = strpos($req, '/');
       if($pos === false)
           $pos = strlen($req);
       $host = substr($req, 0, $pos);
       
       if(strpos($host, ':') !== false)
       {
           list($this->_host, $this->_port) = explode(':', $host);
       }
       else 
       {
           $this->_host = $host;
           $this->_port = ($this->_protocol == 'https') ? 443 : 444;
		
       }
       
       $this->_uri = substr($req, $pos);
       if($this->_uri == '')
           $this->_uri = '/';
   }

   
   function getUniqTerminalId(){
		
		
	}
   
   // constructor
   function HTTPRequest($url)
   {

    	//Dev & Stage server
        if ( $_SERVER["SERVER_ADDR"] == "211.52.72.59" || 
        $_SERVER["SERVER_ADDR"] == "211.52.72.31" || 
       	$_SERVER["SERVER_ADDR"] == "211.52.72.36" ||
        $_SERVER["SERVER_ADDR"] == "172.31.7.139" || 
        $_SERVER["SERVER_ADDR"] == "54.92.27.148" ||
		$_SERVER["SERVER_ADDR"] == "192.168.0.18" || 
		$_SERVER["SERVER_ADDR"] == "127.0.0.1") {
// 			   $this->SERVICE_URL = "https://cis1-xmldirect.ehi.com/services30/OTA30SOAP";	// TEST- alamo			
// 			   $this->Authorization = "T1RBX0FMTUtPUlRTVDE6aDk1Rk4yclg=";
			$this->SERVICE_URL = "http://www.alamo-stage.co.kr/gateApiLive.php";
        }
        
						
	   if( $url != "" )
		   $this->setUrl($url) ;

		/*
		$cookieStr = $_COOKIE["uniqTerminalId"] ; 



		$cookieStr = pack("H*",$cookieStr);
		$aUser = split(chr(30),$cookieStr);

		$map['uniqTerminalIdofMap'] = $aUser[0];
		
		$uniqTerminalId  =  $this->getUniqTerminalId();

	
		$this->uniqTerminalId = $map['uniqTerminalIdofMap'] ;
		*/
   }

	function setUrl($url)
	{
		$this->_url = $url;
		$this->_scan_url();
		//echo $this->_url;
		// 크루즈 API 용

		/* 기존 코드 
		$this->addHeader("User-Agent","RPT-HTTPClient/0.3-3") ;
		$this->addHeader("Content-Type","text/xml; charset=utf-8") ;		
		$this->addHeader("SOAPAction","\"\"") ;		
		// $this->addHeader("Authorization","Basic Q09OU1RBR0VUTUtUSzpSY2wyVG91cjE=") ;
		*/
		
		$this->addHeader("Accept-Encoding","gzip,deflate") ;
		$this->addHeader("User-Agent","RPT-HTTPClient/0.3-3") ;
		$this->addHeader("Content-Type","text/xml; charset=utf-8") ;
		$this->addHeader("Authorization","Basic {$this->Authorization}") ;

	}

   function addHeader($name,$value)
	{
		$this->_mHeader[$name] = $value ;

	}

	function setBody($body)
	{
		$this->addHeader("Content-Length",strlen($body)) ;
		$this->makeHeader() ;
		$this->req = $this->req . $body ;
	}

	function makeHeader()
	{
		$crlf = "\r\n";

       // generate request
       $this->req = 'POST ' . $this->_uri . ' HTTP/1.1' . $crlf
           .    'Host: ' . $this->_host . $crlf ;

	   foreach( $this->_mHeader as $name => $value )
	   {
			$this->req = $this->req . $name . ": " . $value . $crlf ;
	   }
			
		$this->req = $this->req . $crlf;

	}

	function printReq()
	{
		echo "REQUEST : <br><br> " . $this->req . "<br>===================================<br>" ;

	}
   
   // download URL to string
   function get()
   {
		return false;
       $crlf = "\r\n";
                     
       // fetch
       /*
	   2014-10-17 ssl:// 오류로 인해 tls:// 로 교체
	   */
       try
	   {
		   	
			/*
		   $this->_fp = fsockopen(($this->_protocol == 'https' ? 'tls://' : '') . $this->_host, $this->_port, $errno, $errstr, 120);
		   fwrite($this->_fp, $this->req);
		   while(is_resource($this->_fp) && $this->_fp && !feof($this->_fp))
			   $response .= fread($this->_fp, 1024);
		   fclose($this->_fp);
			*/
			// echo $this->req;
			// exit;
			
		 	$body = substr($this->req, strpos($this->req, "<soapenv"));

			$headers = array(
				"POST ".$this->_uri." HTTP/1.1",
				"Host: " . $this->_host,
				"Accept-Encoding: gzip,deflate",
				"User-Agent: RPT-HTTPClient/0.3-3",
				"Content-type: text/xml;charset=UTF-8",
				'Authorization: Basic ' . $this->Authorization,
				"Content-length: ".strlen($body)
			); //SOAPAction: your op URL

			// echo json_encode($headers);
		 		 
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt($ch, CURLOPT_URL, $this->SERVICE_URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			
            // converting
            $response = curl_exec($ch); 
			curl_close($ch);
			$body = $response;
			
	   }
	   catch(Exception $e)
	   {
		   
			if(isset($ch))
			{
				curl_close($ch);
			}	   	
	   		/*
			if(isset($this->_fp))
			{
				fclose($this->_fp);
			}
			*/
			
	   }
	   /*
       // split header and body
       $pos = strpos($response, $crlf . $crlf);
       if($pos === false)
           return($response);
       $header = substr($response, 0, $pos);
       $body = substr($response, $pos + 2 * strlen($crlf));
       
       // parse headers
       $headers = array();
       $lines = explode($crlf, $header);
       foreach($lines as $line)
           if(($pos = strpos($line, ':')) !== false)
               $headers[strtolower(trim(substr($line, 0, $pos)))] = trim(substr($line, $pos+1));
	*/
       return($this->decode($body));
   }

	function encode($char)
	{
		$char = str_replace("<", "&lt;", $char) ;
		$char = str_replace(">", "&gt;", $char) ;
		$char = str_replace("\"", "&quot;", $char) ;

		return $char ;
	}

	function decode($char)
	{
		$char = str_replace("&lt;", "<", $char) ;
		$char = str_replace("&gt;", ">", $char) ;
		$char = str_replace("&quot;", "\"", $char) ;

		return $char ;
	}
}

}

?>
