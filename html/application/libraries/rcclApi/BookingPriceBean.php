<?
	
if(! class_exists("BookingPriceBean") )	{

	class BookingPriceBean
	{			
		var $cabinPrice ;
		var $tip ;
		var $tax  ;
		var $care ;
		var $realTip ; 

		var $promotionInfo= array();	// 프로모션 할인금액 -> PromotionPriceBean객체 담김
		var $valueAddPrice ;			// 온보드 크레딧 On Board Credit
	}
}

?>