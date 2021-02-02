<?php

##### Mail functions #####

function sendLostPasswordEmail($email, $newpassword)
{

    global $domain;
    $message = "Komunikat zawiera nowe hasło, wygenerowane na żądanie ze strony https://$domain/,

Oto dane:

     Login:  Twój adres email
Nowe hasło:  $newpassword

Po zalogowaniu koniecznie zmień hasło na stronie https://$domain/.

Administrator IRK WAT
";

    if (sendMail($email, "Twoje poprzednie hasło zostało usunęte", $message, "rekrutacja@wat.edu.pl"))
    {
        return true;
    } else
    {
        return false;
    }


}

function sendMail($emailto, $subject, $content, $from)
{
    $header = "From: $from" . "\r\n";
	$header .= "Mime-Version: 1.0" . "\r\n";
	$header .= "Content-type: text/html; charset=UTF-8\r\n";
	//Content-Transfer-Encoding: 8bit\r\n
		 
	//$subject=iconv("windows-1250","UTF-8", $subject);
	$subject='=?UTF-8?B?'.base64_encode($subject).'?=';
	//$content=iconv("windows-1250","UTF-8", $content);

		if (mail($emailto, $subject, $content, $header))
    {
        return true;
    } else
    {
        return false;
    }
    return false;
}


function sendActivationEmail($uid, $email, $actcode)
{
    global $domain;
    $link = "<a href='https://$domain/activate.php?uid=$uid&actcode=$actcode'>TUTAJ</a>";
    $message = "
Dziękujemy za rejestrację w Internetowej Rejestracji Kandydatów na studia w WAT.</br>
Proszę kliknąć $link w celu dokonania aktywacji utworzonego konta.</br>
<br/>
Administrator IRK WAT
";
    if (sendMail($email, "Proszę aktywować nowo utworzone konto.", $message, "rekrutacja@wat.edu.pl"))
    {
        return true;
    } else
    {
        return false;
    }
}

?>