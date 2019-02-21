<?
	
if(! class_exists("ReqVehAvailRateBean") )	{

	class ReqVehAvailRateBean
	{
		var $ic				;	// 컨트랙 ID (본사에서 부여하는 식별 코드)

		var $pickUpLocation	;	//대여지점
		var $returnLocation	;	//반납지점
		var $pickUpDateTime	;	//대여시간
		var $returnDateTime	;	//반납시간
		var $rateQualifier	;	//요금제코드
		var $contactId		;	//Contact ID
		var $promotionCode	;	//프로모션코드	-	쿠폰번호(업그레이드, 가격할인중 1개)
		var $vendor			;	//벤더(AL:알라모, ZL:내셔널)

		var $airCode		;	//항공사코드
		var $airMemId		;	//항공사멤버쉽 번호

		var $emcNo			;	//에메랄드클럽 번호

	}
}

?>