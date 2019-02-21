<?
	
if(! class_exists("ReqVehCancelBean") )	{

	class ReqVehCancelBean
	{
		var $ic				;	// 컨트랙 ID (본사에서 부여하는 식별 코드)
		
		var $uniqueId		;	// 예약번호
		var $givenName		;   // 이름
		var $surname		;	// 성
		var $vendor			;	// 벤더(AL:알라모, ZL:내셔널)

	}
}

?>