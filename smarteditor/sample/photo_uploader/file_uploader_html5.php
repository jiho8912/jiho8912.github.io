<?php
 	$sFileInfo = '';
	$headers = array();
	 
	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		} 
	}
	@ini_set("allow_url_fopen","1");
	$file = new stdClass;
	$file->original_name = str_replace("\0", "", rawurldecode($headers['file_name']));
	$file->size = $headers['file_size'];
	$file->type = $headers['file_type'];

	$file->contents_no = $_COOKIE['contents_no'];

	$file->content = file_get_contents("php://input");

	$filename_ext = strtolower(array_pop(explode('.',$file->original_name)));
	mt_srand();
	//$file->file_name = md5(uniqid(mt_rand())).'.'.$filename_ext;
	$addName = date("YmdHis");  //현재날짜,시간,분초구하기
	$file->file_name = $addName . '_' . $file->original_name;
	$allow_file = array("jpg", "png", "bmp", "gif"); 
	
	if(!in_array($filename_ext, $allow_file)) {
		echo "NOTALLOW_".$file->file_name;
	} else {
		$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/upload/';
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}

		$newPath = $uploadDir.iconv("utf-8", "cp949", $file->file_name);

		$link = mysql_connect('localhost', 'jiho8912', 'wlgh6464');
		mysql_select_db('jiho8912', $link);

		$sql = "INSERT INTO admin_files (`no`, `contents_no`, `original_name`, `file_name`, `file_type`, `file_size`, `state`, `reg_date`) VALUES (NULL, '".$file->contents_no."', '".$file->original_name."', '".$file->file_name."', '".$file->type."', '".$file->size."', 'Y', '".date('Y-m-d H:i:s')."');";
		mysql_query($sql);
		mysql_close($link);

		if(file_put_contents($newPath, $file->content)) {
			$sFileInfo .= "&bNewLine=true";
			$sFileInfo .= "&sFileName=".$file->file_name;
			$sFileInfo .= "&sFileURL=/upload/".$file->file_name;
		}
		echo $sFileInfo;
	}
?>