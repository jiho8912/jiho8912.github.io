<?
/***************************************************************************
*	제  목 : 크루즈 API Response Entity
*	객체명 : PriceInfoBean
*	작성일 : 2013-07-02
*	작성자 : 	
*	설  명 : promotionAmount, valueAddAmount 추가 
*	수  정 : dev.lee 2013-07-02
'***************************************************************************/	
if(! class_exists("PaymentBean") )	{

	class PaymentBean
	{	
		var $id				;
		var $type			;
		var $amount			;
		var $approvalCode	;

		var $promotionAmount ;	// 프로모션 코드
		var $valueAddAmount ;	// 온보드 쉽 		
	}
}

?>