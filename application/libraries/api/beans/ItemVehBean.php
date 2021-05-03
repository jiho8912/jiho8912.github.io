<?
	
if(! class_exists("ItemVehBean") )	{

	class ItemVehBean
	{
		
		var $baggageQuantity	;	//수화물양
		var $passengerQuantity	;	//탑승인원
		var $airConditionInd	;	//에어컨유무
		var $transmissionType	;	//변속기종류
		
		var $category			;	//카테고리
		var $doorCount			;	//도어갯수
		var $size				;	//사이즈
		var $name				;	//차량명
		var $code				;	//차량코드
		var $pictureUrl			;	//차량 이미지 URL
	}
}

?>