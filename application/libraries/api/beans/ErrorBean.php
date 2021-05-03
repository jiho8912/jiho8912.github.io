<?
	
if(! class_exists("ErrorBean") )	{

	class ErrorBean
	{
		var $err_type			;	// 에러
		var $err_code			;	// 에러
		var $err_msg			;	// 에러
		var $err_step			;	// 호출 API
		var $err_xml			;	// 에러 response xml 
		var $err_xml_req		;	// 에러 request xml 
	}
}

?>