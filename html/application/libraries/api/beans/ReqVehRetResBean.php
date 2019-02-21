<?
	
if(! class_exists("ReqVehRetResBean") )	{

	class ReqVehRetResBean
	{
		var $ic					; // 컨트랙 ID (본사에서 부여하는 식별 코드)

		var $uniqueId			; //예약번호		
		var $surname			; //영문성
		var $givenName			; //영문 이름
		var $pickUpDateTime		; //대여일
		var $pickUpLocation		; //대여지역
		var $vendor				; //벤더		
	}
}
