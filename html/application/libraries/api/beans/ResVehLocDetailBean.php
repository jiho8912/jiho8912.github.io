<?
if(! class_exists("ResVehLocDetailBean") )	{
	class ResVehLocDetailBean
	{
		var $pickUpLocation				;	//대여지점
		var $atAirport					;	//공항여부?
		var $name						;	//대여지명

		var $vehs = Array()				;	//차량정보 - SUB ITEM 있음( ItemVehBean )
		
		var $addressLine = Array()		;	//대여지 주소
		var $phoneNumber = Array()		;	//대여지 전화번호

		var $specialEquipments = Array() ;	//차량 옵션별 요금 - SUB ITEM 있음( ItemSpEquipmentBean )
		
	}
}

?>