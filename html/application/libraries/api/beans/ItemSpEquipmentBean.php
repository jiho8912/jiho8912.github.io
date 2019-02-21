<?	

if(! class_exists("ItemSpEquipmentBean") )	{

	class ItemSpEquipmentBean
	{
		var $type			;	// 종류
		var $guaranteedInd  ;	//	
		var $includedInRate	;	// 수수료포함?
		var $currencyCode	;	// 통화
		var $unitName = Array() ;	// 기간
		var $unitCharge = Array() ;	// 기간별 요금

		var $quantity ;			// RETRES에서 사용되는 예약된 건에 대한 QUANTITY
		var $amount ;			// RETRES에서 사용되는 예약된 건에 대한 AMOUNT
	}
}
?>