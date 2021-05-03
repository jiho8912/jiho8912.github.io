<?
	
if(! class_exists("ItinInfoBean") )	{

	class ItinInfoBean
	{			
		var $portName		;
		var $portCode		;

		var $text			;

		var $itinTimes = Array() ;			// 시간정보들(Array)		[  detail / qualifier / dayOfWeek ] 
	}
}

?>