<?php
// default redirection
$url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);

// SUCCESSFUL
if(bSuccessUpload) {
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$addName = date("YmdHis");  //현재날짜,시간,분초구하기
	$name = $addName . '_' . $_FILES['Filedata']['name'];

	$filename_ext = strtolower(array_pop(explode('.',$name)));
	$allow_file = array("jpg", "png", "bmp", "gif");
	
	if(!in_array($filename_ext, $allow_file)) {
		$url .= '&errstr='.$name;
	} else {
		$uploadDir = $_SERVER['DOCUMENT_ROOT'].'/upload/';
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}
		
		$newPath = $uploadDir.urlencode($name);
		
		@move_uploaded_file($tmp_name, $newPath);

		$url .= "&bNewLine=true";
		$url .= "&sFileName=".urlencode(urlencode($name));
		$url .= "&sFileURL=/upload/".urlencode(urlencode($name));

		$link = mysql_connect('localhost', 'jiho8912', 'wlgh6464');
		mysql_select_db('jiho8912', $link);
		
		$file->contents_no = $_COOKIE['contents_no'];

		$sql = "INSERT INTO admin_files (`no`, `contents_no`, `original_name`, `file_name`, `file_type`, `file_size`, `state`, `reg_date`) VALUES (NULL, '".$file->contents_no."', '".$_FILES['Filedata']['name']."', '".$name."', '".$file->type."', '".$file->size."', 'Y', '".date('Y-m-d H:i:s')."');";
		mysql_query($sql);
		mysql_close($link);

	}
}
// FAILED
else {
	$url .= '&errstr=error';
}
	
header('Location: '. $url);
?>