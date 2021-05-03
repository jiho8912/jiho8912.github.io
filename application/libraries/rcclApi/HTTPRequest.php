<?php include_once($_SERVER['DOCUMENT_ROOT']."/common/classes/logger/KLogger.php");?>
<?
if(! class_exists("HTTPRequest") )	{

class HTTPRequest
{
   var $_fp;        // HTTP socket
   var $_url;        // full URL
   var $_host;        // HTTP host
   var $_protocol;    // protocol (HTTP/HTTPS)
   var $_uri;        // request URI
   var $_port;        // port

   var $req ;
   var $companyName = "TOURMARKETINGKOR";
   var $FITURL =  "https://services.rccl.com/Reservation_FITWeb/sca";
   var $ECCP_FITURL = "https://payment.token.rccl.com/Reservation_FITWeb/sca";//
   //var $FITURL =  "https://stage.services.rccl.com/Reservation_FITWeb/sca"; var $ECCP_FITURL = "http://stage.services.rccl.com:444/Reservation_FITWeb/sca";
   //"http://www.rccl-please.co.kr:80/gatePayApiLive.php?act=";
   //var $FITURL = "http://stage.services.rccl.com:444/Reservation_FITWeb/sca";
   var $interfaceURL ="http://services.rccl.com/Interfaces";
   var $uniqTerminalId ;


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
		return $this->uniqTerminalId;
	}

   // constructor
   function HTTPRequest($url)
   {
    	//Dev & Stage server
       if ($_SERVER["SERVER_NAME"] == "211.52.72.51"|| $_SERVER["SERVER_NAME"] == "rccl_dev.kr" ||
		   $_SERVER["SERVER_NAME"] == "211.52.72.36"|| $_SERVER["SERVER_NAME"] == "rccl-dev.kr" ||
           $_SERVER["SERVER_ADDR"] == "211.52.72.31" || $_SERVER["SERVER_ADDR"] == "211.52.72.36" ||
           $_SERVER["SERVER_ADDR"] == "211.52.72.59" || $_SERVER["SERVER_ADDR"] == "211.52.72.51") {
           //$this->ECCP_FITURL = "http://rccl-stage.kr/gatePayApiLive.php?act=";
           $this->ECCP_FITURL = "http://rccl-stage.kr/gateApiLive.php?act=";
           $this->FITURL = "http://rccl-stage.kr/gateApiLive.php?act="; //real - rccl
       }

		if( $url != "" )
			$this->setUrl($url) ;

		$cookieStr = "";

		$mt = microtime() ;
		$key1 = substr($mt, 17, 6) ;
		$key2 = substr($mt, 2, 6) ;
		$map['uniqTerminalIdofMap'] = $key1 . $key2 ;

		if (isset($_COOKIE["uniqTerminalId"])) {
			$cookieStr = $_COOKIE["uniqTerminalId"] ;
		}
		if(isset($_REQUEST["uniqTerminalId"]))
		{
			$cookieStr = $_REQUEST["uniqTerminalId"] ;
		}
		if($cookieStr!="" && strlen($cookieStr) == 22)
		{
			$cookieStrPack = pack("H*",$cookieStr);
			$aUser = explode(chr(30),$cookieStrPack);

			$map['uniqTerminalIdofMap'] = $aUser[0];
		}

		$this->uniqTerminalId = $map['uniqTerminalIdofMap'];
		$cookieStr = $this->uniqTerminalId . chr(30);
		$cookieStr = bin2hex($cookieStr); // 16진수로 암호화
		// set cookie
		setcookie("uniqTerminalId", $cookieStr, -1, "/", "");
		$_REQUEST["uniqTerminalId"] = $cookieStr;

   }

	function setUrl($url)
	{
		$this->_url = $url;
		$this->_scan_url();
		//echo $this->_url;
		// 크루즈 API 용
		//$this->addHeader("Connection","Keep-Alive") ;			// 2011년 11월 03일 느려지는 문제 해결 T.Y Junior
		$this->addHeader("User-Agent","PHP-SOAP/5.2.12") ;
		$this->addHeader("Content-Type","text/xml; charset=utf-8") ;
		$this->addHeader("SOAPAction","\"\"") ;
		// $this->addHeader("Authorization","Basic Q09OU1RBR0VUTUtUSzpSY2wyVG91cjE=") ;
		$this->addHeader("Authorization","Basic Q09OVE1LVEs6cnI5MjRDWg==") ; //base64(username + ":" + password);
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
       $this->req = 'POST ' . $this->_uri . ' HTTP/1.0' . $crlf
           .    'Host: ' . $this->_host . $crlf ;

	   foreach( $this->_mHeader as $name => $value )
	   {
			$this->req = $this->req . $name . ": " . $value . $crlf ;
	   }

		$this->req = $this->req . $crlf;

	}

	function printReq()
	{
		echo "REQUEST : <br<br> " . $this->req . "<br>===================================<br>" ;

	}

   // download URL to string
   function get()
   {

       if ($_SERVER["SERVER_NAME"] == "211.52.72.51"|| strpos($_SERVER["SERVER_NAME"], "dev.")!== false ||
           $_SERVER["SERVER_ADDR"] == "211.52.72.31" || $_SERVER["SERVER_ADDR"] == "211.52.72.36" ||
           $_SERVER["SERVER_ADDR"] == "211.52.72.59" || $_SERVER["SERVER_ADDR"] == "211.52.72.51") {

			return $this->get_curl();
        }

		$crlf = "\r\n";


		$errNumber=0;
		$errString="";
		// fetch
		$this->_fp = fsockopen(($this->_protocol == 'https' ? 'ssl://' : '') . $this->_host, $this->_port, $errNumber, $errString);
        $response = "";

		if($this->_fp)
		{
			 fwrite($this->_fp, $this->req);
			 while(is_resource($this->_fp) && $this->_fp && !feof($this->_fp))
				 $response .= fread($this->_fp, 1024);
			 fclose($this->_fp);
		}
		else
		{
			//TODO : Make Log File for fsockopen error Handling.
			$errNumber=0;
			$errString="";

			$kLoggerDir = "/home/logs/kLog";
			$kLogger = new KLogger($kLoggerDir.'/log-'.date("Y-m-d").'.log', KLogger::INFO);
			$kLogger->LogError("[HTTPRequest.get()] fsockOpen request : ".($_SERVER['HTTPS']=='on') === true ? 'https://' : 'http://'.$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT']."/".$_SERVER['REQUEST_URI']."\n\n");
			$response .= "Connection Error Occured. Report To RCCL.kr Dev Team";
			return($response);
		}
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

		// redirection?
		if(isset($headers['location']))
		{
			$http = new HTTPRequest($headers['location']);
			return($http->DownloadToString($http));

		}
		else
		{
			unset($headers);
			unset($headers);
			unset($header);
			return($body);

		}
   }

   function get_curl()
   {

       $crlf = "\r\n";

        try
        {
            $body = substr($this->req, strpos($this->req, "<soapenv"));

            $headers = array(
                "POST ".$this->_uri." HTTP/1.1",
                "Host: " . $this->_host,
                "SOAPAction:",
                "User-Agent: PHP-SOAP/5.2.12",
                "Content-type: text/xml;charset=UTF-8",
                'Authorization: Basic Q09OVE1LVEs6cnI5MjRDWg== ',
                "Content-length: ".strlen($body)
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSLVERSION, 6);
            curl_setopt($ch, CURLOPT_URL, $this->_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

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

        }
       // redirection?
      // if(isset($headers['location']))
      // {
      //     $http = new HTTPRequest($headers['location']);
      //     return($http->DownloadToString($http));

      // }
      // else
      // {

           return($body);

      // }
   }
}

}

?>
