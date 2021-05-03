<?
	
if(! class_exists("CabinBean") )	{

	class CabinBean
	{			
		var $duration		;
		var $start			;
		var $shipCode		;
		var $regionCode		;

		var $cruisePkCode	;			// InclusivePackageOption

		var $fareCode		;			// Selected FareCode

		
		var $cabinOptions	= array() ;		// Cabin Options(Arrap)

	}
}

?>