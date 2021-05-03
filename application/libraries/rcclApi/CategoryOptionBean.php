<?
	
if(! class_exists("CategoryOptionBean") )	{

	class CategoryOptionBean
	{			
		var $categoryLocation ;
		var $pricedCategoryCode ;

		var $priceInfos = Array() ;			// 가격정보들(Array)

		var $lowPrice ; 
	}
}

?>