<?php


require_once('Classes/PHPMailer/class.phpmailer.php');
	$email_addr = "rajusunilv@gmail.com";//"syanlt6.tnega@tn.gov.in";
	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true; // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 465; // or 587
	$mail->FromName = 'Major Infra Structure Projects';
	$mail->IsHTML(true);
	$mail->Username = "majorinfraproject@gmail.com";
	$mail->Password = "majorinfra@!23";
	$mail->Subject = "Testing Mail";
	$mail->Body = "Dear HOD,<br/><br/>This is a sample mail for testing purpose.<br/><br/>This is an automated message. Please do not reply to this email ID.<br /><br />Major Infrastructure Team";

	
	$mail->AddAddress($email_addr);
	
	if(!$mail->Send())
	{
		print_r("Mailer Error: " . $mail->ErrorInfo);
	}
	else
	{
		//echo "Message has been sent";
	}
?>