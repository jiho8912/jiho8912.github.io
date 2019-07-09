<?

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Common
{

   function segment_explode($seg) { //세크먼트 앞뒤 '/' 제거후 uri를 배열로 반환
		$len = strlen($seg);
		if(substr($seg, 0, 1) == '/') {
			$seg = substr($seg, 1, $len);
		}
		$len = strlen($seg);
		if(substr($seg, -1) == '/') {
			$seg = substr($seg, 0, $len-1);
		}
		$seg_exp1 = explode("/", $seg);
		//쿼리스트링을 key(query_string)로 하여 배열로 반환
		if($_SERVER["QUERY_STRING"]){
			$result=array();
			$strings = explode("&", $_SERVER["QUERY_STRING"]);
			foreach ($strings as $strs) {
				$a_arr = explode("=", $strs);
				@$result = array_merge($result, array($a_arr[0]=>$a_arr[1]));
			}
			$d_arr = array('query_string'=>$result);
			//맨끝 쿼리스트링 제거
			//array_pop($seg_exp1);
			//쿼리스트링을 제거한 배열과 쿼리스트링을 배열화한 것을 합쳐서 반환
			$seg_exp = array_merge($seg_exp1, $d_arr);
		} else {
			$seg_exp = $seg_exp1;
		}
		return $seg_exp;
	}

    function formatXml($xmlString)
    {
        $xmlDocument = new DOMDocument('1.0');
        $xmlDocument->preserveWhiteSpace = false;
        $xmlDocument->formatOutput = true;
        $xmlDocument->loadXML($xmlString);

        return $xmlDocument->saveXML();
    }

    function arr_get($array, $key, $default = null){
        return isset($array[$key]) ? $array[$key] : $default;
    }

    function timeStringNow()
    {
        $timestamp = time();
        $dt = new DateTime("now", new DateTimeZone('Asia/Seoul')); //first argument "must" be a string
        $dt->setTimezone(new DateTimeZone('Europe/London')); //adjust the object to correct timestamp
        return $dt->format('Y-m-d\TH:i:s\Z');
    }
}