<?
	
if(! class_exists("CabinOptionBean") )	{

	class CabinOptionBean
	{			
		var $cabinCategoryCode	;
		var $cabinNumber		;
		var $cabinRanking		;
		var $connectingCabinIndicator		;
		var $connectingCabinNumber			;
		var $deckName						;
		var $deckNumber			;
		var $maxOccupancy		;
		var $positionInShip		;
		var $status				;

		var $meName				;		// measurement info 
		var $meUnit				;
		var $meQuantity			;

		var $remark				;	
		var $viewObstruction	; 
		var $cabinFilters	= array() ;

	}
}

?>