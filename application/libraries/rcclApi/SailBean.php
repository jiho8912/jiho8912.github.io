<?

if(! class_exists("SailBean") )	{

	class SailBean
	{
		var $maxResponses 	;		// 최대 40개, response 되어진 갯수
		var $moreDataEchoToken ;	// 페이징을 위한 token
		var $moreIndicator ;		// 다음페이지가 있는지 없는지 여부 true : 있음, false : 없음

		var $sailOptions	= array() ;		// Cabin Options(Arrap)
	}
}

?>