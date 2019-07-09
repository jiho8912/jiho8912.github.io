<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/api/Res.php" ; ?>
<?

/** 크루즈 API 응답을 처리하는 클래스 **/

if(! class_exists("ResForAdmin") )	{

	class ResForAdmin extends Res
	{	

		function ResForAdmin($url, $uniqTerminalId)
		{
			$this->Res($url) ;
			$this->uniqTerminalId = $uniqTerminalId ;
		}


	}



}
?>