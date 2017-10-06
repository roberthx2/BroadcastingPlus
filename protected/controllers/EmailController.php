<?php

class EmailController extends Controller
{
	public function actionSendMail($asunto, $body, $destinatarios, $destinatarios_copia)
	{
        $mail = new YiiMailer;

        $mail->IsHTML(true);
        //Tell PHPMailer to use SMTP
        $mail->isSMTP();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        //Ask for HTML-friendly debug output
        $mail->Debugoutput = 'html';
        //Set the hostname of the mail server
        $mail->Host = 'mail.insigniamobile.com';
        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;
        //Set the encryption system to use - ssl (deprecated) or tls
        // $mail->SMTPSecure = 'tls';
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = "notificaciones.admin@insigniamobile.com";
        //Password to use for SMTP authentication
        $mail->Password = "qwe123#";
        //Set who the message is to be sent from
        $mail->setFrom('notificaciones.admin@insigniamobile.com', 'BroadcastingPlus');
        //Set who the message is to be sent to

        foreach ($destinatarios as $value)
        {
        	$mail->addAddress($value["correo"], $value["nombre"]);
        }

        foreach ($destinatarios_copia as $value)
        {
        	$mail->addCC($value["correo"], $value["nombre"]);
        }

        //Set the subject line
        $mail->Subject = $asunto;
        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body

        $mail->msgHTML($body);

        //Replace the plain text body with one created manually
        //$mail->AltBody = 'This is a plain-text message body';
        //Attach an image file
        //$mail->addAttachment('images/phpmailer_mini.gif');
        //send the message, check for errors
        if (!$mail->send()) {
            //echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            //echo "Message sent!";
        }
    }
}

?>