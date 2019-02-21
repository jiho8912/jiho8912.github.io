<?
	
if(! class_exists("ReqVehResBean") )	{

	class ReqVehResBean
	{
		var $ic				;	// 컨트랙 ID (본사에서 부여하는 식별 코드)

		// VehResRQCore
		var $status			;	//가용여부
		
		var $pickUpLocation	;	//대여지점
		var $returnLocation	;	//반납지점
		var $pickUpDateTime	;	//대여시간
		var $returnDateTime	;	//반납시간
		
		var $email			;	//이메일
		var $givenName		;   //이름
		var $surname		;	//성
		
		var $areaCityCode	;	//지역번호
		var $phoneNumber	;	//전화번호
		
		var $airConditionIdn	;	// 에어컨 유무
		var $transmissionType	;	//변속기종류
		var $vehCategory	;	//차량카테고리
		var $doorCount		;	//차량 도어 갯수
		var $size			;	//차량크기
		var $code			;	//차량코드
		
		var $rateQualifier	;	//요금제코드
		var $contactId		;	//Contact ID
		var $promotionCode	;	//프로모션코드	-	쿠폰번호(업그레이드, 가격할인중 1개)
		var $vendor			;	//벤더(AL:알라모, ZL:내셔널)

		var $seriesCode		;	//프피페이드 시리즈 코드
		
		// VehResRQInfo
		var $type			;	//차량 조회 타입?(16으로 거의 고정)
		var $datetime		;   //조회 시간


		var $airCode		;	//항공사코드
		var $airMemId		;	//항공사멤버쉽 번호

		var $emcNo			;	//에메랄드클럽 번호

		var $equipType	=	Array() ;	// specialEquipPref 타입
		var $quantity   =	Array() ;	// specialEquipPref 수량


		var $planeCode;
		var $driverAge;
	}
}

?>