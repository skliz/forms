<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);
    //Server settings

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'user@example.com';                     //SMTP username
    $mail->Password   = 'secret';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;     

// От кого письмо
$mail->setForm('info@fls.guru', 'Фрилансер по жизни!');
// Кому отправить
$mail->addAddress('masik475@Gmail.com','skliz-33@mail.ru')
// Тема письма
$mail->Subject = 'Привет, это фрилансер по жизни';

// Рука
$hand = "Правая";
if ($_POST['hand'] == "left"){
	$hand = "Левая";
}

// Тело письма
$body = '<h1>Встречайте суперписьмо!</h1>';


// Прикрепить файл
if (!empty($_FILES['image']['tmp_name'])) {
	// Путь загрузки файла
	$filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
	// грузим файл
	if (copy($_FILES['image']['tmp_name'], $filePath)){
		$fileAttach = $filePath;
		$body.='<p><strong>Фото в приложении</strong>';
		$mail->addAttachment($fileAttach);
	}
}

$mail->Body = $body;

// Отправляем
if (!$mail->send()) {
	$message = 'Ошибка';
}else {
	$message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
?>
