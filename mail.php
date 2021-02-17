<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


$method = $_SERVER['REQUEST_METHOD'];
$subject = " Новая заявка";
//Script Foreach
$c = true;
if ( $method === 'POST' ) {

    $name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
    $phone = isset($_POST["phone"]) ? trim($_POST["phone"]) : '';
	$height = isset($_POST["height"]) ? trim($_POST["email"]) : '';

	foreach ( $_POST as $key => $value ) {
		if ( $value != ""  ) {
			$message .= "
			" . ( ($c = !$c) ? '<tr>':'<tr style="background-color: #f8f8f8;">' ) . "
				<td style='padding: 10px; border: #e9e9e9 1px solid;'><b>$key</b></td>
				<td style='padding: 10px; border: #e9e9e9 1px solid;'>$value</td>
			</tr>
			";
		}
	}


$message = "<table style='width: 100%;'>$message</table>";

function adopt($text) {
	return '=?UTF-8?B?'.Base64_encode($text).'?=';
}

$mail = new PHPMailer;
$mail->CharSet = 'UTF-8';

// Настройки SMTP
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->SMTPDebug = 0;

$mail->Host = 'ssl://smtp.yandex.ru';
$mail->Port = 465;
$mail->Username = 'info@mistodent.com.ua';
$mail->Password = 'secret';

// От кого
$mail->setFrom('info@mistodent.com.ua', 'Стоматология');

// Кому
$mail->addAddress('mistodent@gmail.com');

// Тема письма
$mail->Subject = $subject;

// Тело письма
$body = '<p><strong>«Hello, world!» </strong></p>';
$mail->msgHTML($message);

// Приложение
//$mail->addAttachment(__DIR__ . '/image.jpg');

 $mail->send() ? header('Location: /success.php'):header('Location: /error.php');
}
else{
  
  header('Location: /error.php');
}