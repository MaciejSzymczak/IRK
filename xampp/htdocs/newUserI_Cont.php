<?php
if (!($_POST['stStud1'] == 'DALEJ' OR $_POST['register'] == 'ZAŁÓŻ KONTO')){ echo "Dostęp zabroniony";exit(); }
require_once "header.php";
if (isset($_POST['register'])){
	$returnMessage = registerNewUser($_POST['email'], '7');
	if ($returnMessage=='OK'){
		echo '<div class="alert alert-info" role="alert"><p> Dziękujemy za założenie konta.</p>',
		'<p>System przesłał na wskazany adres e-mail, link do aktywacji założonego konta. </p>',
		'<p>Sprawdź czy wiadomości z linkiem nie trafiła do spamu.</p>',
		'<p><bold> Przed zalogowaniem proszę aktywować założone konto. </bold></p></div>';
?>
		<form method="post" action="--WEBBOT-SELF--"> <br>
		<p align="center">
		  <input value="POWRÓT"  onclick="self.location.href=('./index.php')"  type="button">
		</p>
		</form>
<?php
    }else {
        show_registration_form('STUDIA I STOPNIA','newUserI_Cont.php','<div class="alert alert-danger"><strong>'.$returnMessage.'</strong> Proszę wyjść i spróbować jeszcze raz lub skontaktować się z DOK WAT (patrz stopka)</div>');
    }
} else {
    show_registration_form('STUDIA I STOPNIA','newUserI_Cont.php','');
}
?>
<?php
 require_once "footer.php";
?>

				