<?
	require_once("class.phpmailer.php"); // 같은 폴더에 넣으면됨
	require_once("class.smtp.php"); // 같은 폴더에 넣으면됨

	$data['adminEmail'] = "받는사람이메일주소1";
	$data['adminEmail2'] = "받는사람이메일주소2";
	$data['adminEmail3'] = "받는사람이메일주소3";

	$data['from_email'] = 'test@naver.com'; //보내는 사람 메일계정
	$smtp_mail_id = $data['from_email'];  // 보내는사람 이메일계정
	$smtp_mail_pw = '비밀번호'; // 보내는사람 이메일계정 비밀번호

	$to_email = $data['adminEmail'].','.$data['adminEmail2'].','.$data['adminEmail3']; // 받는사람 이메일
	$addresses = array_filter(explode(',', $to_email));

	$to_name = "관리자"; // 받는사람 이름
	$title = '제목제목'; // 메일제목. 
	$from_name = '이름이름'; // 보내는사람 이름
	$from_email = $data['from_email']; // 보내는사람 이메일
	$content = '메일 내용 내용 html 가능'; // 내용

	$smtp_use = 'smtp.naver.com'; //네이버 메일 사용시
	//$smtp_use = 'smtp.gmail.com'; //구글 메일 사용시 주석제거
	if ($smtp_use == 'smtp.naver.com') { 
		$from_email = $smtp_mail_id; //네이버메일은 보내는 id로만 전송이가능함
	}else {
		$from_email = $from_email; 
	}
	//메일러 로딩

	$mail = new PHPMailer(true);
	$mail->IsSMTP();
	try {
		$mail->CharSet = "UTF-8";
		$mail->Encoding = "base64";
		$mail->Host = $smtp_use;   // email 보낼때 사용할 서버를 지정
		$mail->SMTPAuth = true;          // SMTP 인증을 사용함
		$mail->Port = 465;            // email 보낼때 사용할 포트를 지정
		$mail->SMTPSecure = "ssl";        // SSL을 사용함
		$mail->Username   = $smtp_mail_id; // 계정
		$mail->Password   = $smtp_mail_pw; // 패스워드
		$mail->SetFrom($from_email, $from_name); // 보내는 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)

		foreach ($addresses as $address) {
			$mail->AddAddress($address, $to_name);  // 받을 사람 email 주소와 표시될 이름 (표시될 이름은 생략가능)
		}

		$mail->Subject = $title;         // 메일 제목
		$mail->MsgHTML($content);         // 메일 내용 (HTML 형식도 되고 그냥 일반 텍스트도 사용 가능함)
		$mail->Send();              // 실제로 메일을 보냄

	} catch (phpmailerException $e) {
		echo $e->errorMessage();
	} catch (Exception $e) {
		echo $e->getMessage();
	}
?>