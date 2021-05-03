<?
if(! class_exists("ResVehResBean") )	{
	class ResVehResBean
	{
		// VehReservation - Customer
		var $givenName			;   //이름
		var $surname			;	//성
		var $phoneNumber		;	//전화번호
		var $email				;	//이메일

		// VehReservation - VehSegmentCore - ConfID
		var $type				;	//차량 조회 타입? (14 - reservation)
		var $Id					;	//예약번호 - (예약번호 + COUNT) 가 연결되어 넘어온다.

		// VehReservation - VehSegmentCore - Vendor
		var $vendor				;	//벤더(AL:알라모, ZL:내셔널)
		
		// VehReservation - VehSegmentCore - VehRentalCore
		var $pickUpLocation		;	//대여지점		
		var $returnLocation		;	//반납지점
		var $pickUpDateTime		;	//대여시간
		var $returnDateTime		;	//반납시간

		// VehReservation - VehSegmentCore - Vehicle
		var $airConditionIdn	;	// 에어컨 유무
		var $transmissionType	;	//변속기종류
		var $baggageQuantity	;	//수화물양
		var $passengerQuantity	;	//탑승인원
		var $vehCategory		;	//차량카테고리
		var $doorCount			;	//차량 도어 갯수
		var $size				;	//차량크기
		var $code				;	//차량코드
		var $name				;	//차량명		
		var $pictureUrl			;	//차량이미지

		// VehReservation - VehSegmentCore - RentalRate
		var $vehiclePeriodUnitName	;	//  ex) RentalPeriod
		var $distUnitName			;	//	ex) Mile
		var $unlimited				;	//  ex) true

		var $vehCharges = Array() ;		//요금

		var $rateQualifier	;			//요금제코드
		
		var $specialEquipments = Array() ;	//차량 옵션별 요금 - SUB ITEM 있음( ItemSpEquipmentBean )

		// VehReservation - VehSegmentCore - Fees
		var $fees = Array()		;	//품목요금
		
		// VehReservation - VehSegmentCore - TotalCharge
		var $rateTotalAmount		;	//차량요금(포함사항 포함)
		var $estimatedTotalAmount	;	//총예상요금
		var $currencyCode			;	//통화코드

		// VehReservation - VehSegmentInfo - VendorMessages
		var $msgs = Array()		;	//메시지
		
		var $coverages = Array() ;	//보험여부
		
		var $arrivalNumber ; // 항공편명 number
		var $arrivalCode ; // 항공편명 code
	}
}
?>