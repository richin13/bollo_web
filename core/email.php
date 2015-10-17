<?php
function email_forgotten_pw($email, $token) {
    $subject = "Password recovery details";
    $body = "Hola, recientemente se ha solicitado un cambio de contraseña<br>
  Ingresa al siguiente enlace para restablecer la constraseña<br>
  <a href=http://bollo-server.bitnamiapp.com/bollo_web/?forgot=$token>
  Click aquí</a>";

    return _mail($email, $subject, $body);
}

function email_details($fname, $username, $email, $token) {
    $subject = "Bienvenido a Bollo";
    $body = "<h4><b>Gracias '$fname' por registrarte en Bollo.</b></h4><br>
             Tu nombre de usuario: '$username'<br>
             Ingresa al siguiente link para activar la cuenta<br>
             <a href=\"http://bollo-server.bitnamiapp.com/bollo_web/?activate=$token\">ACTIVAR</a>";

    return _mail($email, $subject, $body);
}

/**
 * @param $to string The recipient of the email to be sent.
 * @param $subject string The subject of the email to be sent.
 * @param $body string The body of the email to be sent.
 * @return bool True if the mail was sent correctly, false otherwise.
 * @throws Exception
 * @throws phpmailerException
 */
function _mail($to, $subject, $body) {
    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'richin13';
    $mail->Password = 'ewjedzhvwxccqulo';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->From = 'richin13@gmail.com';
    $mail->FromName = 'Ricardo Madriz - Bollo Dev Team';
    $mail->isHTML(true);

    $mail->addAddress($to);
    $mail->Subject = $subject;
    $mail->Body = $body;

    return $mail->send();
}