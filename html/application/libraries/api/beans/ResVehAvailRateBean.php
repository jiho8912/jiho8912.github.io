<?
	
if(! class_exists("ResVehAvailRateBean") )	{

	class ResVehAvailRateBean
	{
		//Core
		var $status				;	//가용여부

		//Vehicle
		var $transmissionType	;	//변속기종류
		var $airConditionInd	;	//에어컨유무
		var $baggageQuantity	;	//수화물양
		var $passengerQuantity	;	//탑승인원
		
		var $vehCategory		;	//차량카테고리
		var $size				;	//차량크기
		var $name				;	//차량명
		var $code				;	//차량코드
		var $pictureUrl			;	//차량이미지

		//Vehicle Charges
		var $vehCharges = Array() ;	//요금

		//Total Charges
		var $rateTotalAmount	;	//차량요금(포함사항 포함)
		var $estimatedTotalAmount ;	//총예상요금
		var $currencyCode		;	//통화코드

		//Fees
		var $fees = Array()		;	//품목요금

		//Reference
		var $type				;	//차량 조회 타입
		var $datetime			;   //조회 시간
		var $referenceID		;   //차량 referenceID 


		//dev lim 추가사항
		var $doorCount			;	//문갯수
		var $corpDiscountNmbr	;	//회원사번호
		
		
		var $driverAge			;	// API 업그레이드로 인한 추가

	}
}

?>