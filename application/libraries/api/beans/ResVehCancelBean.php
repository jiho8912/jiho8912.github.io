<?
if(! class_exists("ResVehCancelBean") )	{
	class ResVehCancelBean
	{
		var $cancelStatus	;	// 취소 상태
		var $Id				;	//예약번호 - (예약번호 + COUNT) 가 연결되어 넘어온다.
	}
}
?>