<?php
/**
 * Скрипт отправки сообщения
 * @param String $to      куда отправлять
 * @param String $subject тема письма
 * @param String $body    само письмо
 */
function Send_Mail($to,$subject,$body)
{
	$emails = array(
		// ['email'=>'olimpiada24-01@mail.ru', 'uname'=>'olimpiada24-01', 'pass'=>'2ol#i0m4*p1'],
		// ['email'=>'olimpiada24-02@mail.ru', 'uname'=>'olimpiada24-02', 'pass'=>'2pl#i*0m2o4'],
		// ['email'=>'olimpiada24-03@mail.ru', 'uname'=>'olimpiada24-03', 'pass'=>'4*p3l#i0m2o'],
		// ['email'=>'olimpiada24-04@mail.ru', 'uname'=>'olimpiada24-04', 'pass'=>'4o4*2mpl#i0'],
		// ['email'=>'olimpiada24-05@mail.ru', 'uname'=>'olimpiada24-05', 'pass'=>'0m4pl#2o*5i'],
		// ['email'=>'olimpiada24-06@mail.ru', 'uname'=>'olimpiada24-06', 'pass'=>'0l#pi64o*m2'],
		// ['email'=>'olimpiada24-07@mail.ru', 'uname'=>'olimpiada24-07', 'pass'=>'il#4o*27p0m'],
		// ['email'=>'olimpiada24-08@mail.ru', 'uname'=>'olimpiada24-08', 'pass'=>'l#i*2o8p0m4'],
		// ['email'=>'olimpiada24-09@mail.ru', 'uname'=>'olimpiada24-09', 'pass'=>'9ml#o0*pi24'],
		// ['email'=>'olimpiada24-10@mail.ru', 'uname'=>'olimpiada24-10', 'pass'=>'opm4*ol#i02'],
		['email'=>'support@olimpiada24.ru', 'uname'=>'support@olimpiada24.ru', 'pass'=>'T34K!1d9'],
	);
	// $erand = random_int(0, 9);
	$erand = 0;
	require 'class.phpmailer.php';
	$from       = mb_strtolower($emails[$erand]['email']);//"u0689399@scp26.hosting.reg.ru";
	$mail       = new PHPMailer();
	$mail->IsSMTP(true);            // используем протокол SMTP
	$mail->IsHTML(true);
	$mail->SMTPAuth   = true;                  // разрешить SMTP аутентификацию 
	$mail->Host       = "scp26.hosting.reg.ru";//"smtp.mail.ru";//"mail.u0689399.cp.regruhosting.ru";//"tls://smtp.scp26.hosting.reg.ru"; // SMTP хост
	$mail->Port       =  465;//587(без ssl);//465 (ssl);                    // устанавливаем SMTP порт
	$mail->Username   = $emails[$erand]['uname'];//"u0689399";  //имя пользователя SMTP  
	$mail->Password   = $emails[$erand]['pass'];//"T34K!1d9";  // SMTP пароль
	$mail->SMTPSecure = "ssl";
	$mail->CharSet = "UTF-8";
	$mail->SetFrom($from, 'support.olimpiada24');
	$mail->AddReplyTo($from,'support.olimpiada24');
	$mail->Subject    = $subject;
	$mail->MsgHTML($body);
	// $address = $to;
	$mail->AddAddress($to);
	$mail->Send(); 
}
?>
