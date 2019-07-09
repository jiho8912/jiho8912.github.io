<?

if(! class_exists("PriceInfoBean") )	{

	class PriceInfoBean
	{
		var $amount ;
		var $breakdownType  ;
		var $fareCode ;
		var $nccfAmount;

		var $promotionAmount ;	// promotion 금액
		var $valueAddAmount ;	// 온더 비딩 금액
		var $promotionDesc ;	// promotion 설명
		var $promotionClass ;
		var $promotionTypes;
		var $nonRefundableType; //환불불가
	}
    class PriceInfoBean2 extends PriceInfoBean
	{
		var $status  ;
	}
}

?>