<?
if(! class_exists("ReqVehModifyBean") )	{
	class ReqVehModifyBean
	{
		// VehModifyRQCore
		var $modifyType ;
		var $status			;	//가용여부

		var $uniqueId		;	//예약번호

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
		var $size			;	//차량크기



		var $rateQualifier	;	//요금제코드
		var $contactId		;	//Contact ID
		var $vendor			;	//벤더(AL:알라모, ZL:내셔널)

		var $equipType	=	Array() ;	// specialEquipPref 타입
		var $quantity   =	Array() ;	// specialEquipPref 수량
		var $action = array() ;			// specialEquipAction 타입  Add : 추가 , Replace : 기존값사용 , Cancel : 취소

		// VehModifyRQInfo
	}
}


?>