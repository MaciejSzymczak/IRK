<?php 
	if (!($_POST['Caller'] == 'privacyPolicy')){header('Location: index.php');}
	require_once "header.php"; 
?>

<div class="panel panel-default">
	<div class="panel-heading" style="text-align: center;">INFORMACJE DLA KANDYDATA<br>KORZYSTAJĄCEGO Z INTERNETOWEJ REJESTRACJI KANDYDATÓW NA STUDIA</div>
	<div class="panel-body">
		Przed przystąpieniem do rejestracji należy dokładnie zapoznać się z zasadami rekrutacji na studia dostępnymi na stronie WAT.<br/>
		Wybranie kierunków studiów wojskowych uruchamia procedurę rekrutacyjną na studia wojskowe.<br/>
		Rejestracja za pośrednictwem Internetu na studia wojskowe nie zwalnia kandydata z obowiązku dostarczenia do WAT wniosku do Rektora-Komendanta o powołanie do służby kandydackiej (do pobrania ze strony WAT).<br/>
		Podczas rejestracji zostanie wygenerowany indywidualny numer konta bankowego, na który należy dokonać opłaty rekrutacyjnej. <br/><br/>
		Do założenia konta niezbędne są:
		<ul>
		  <li><strong>adres e-mail</strong></li>
		</ul>
	<div style="text-align: center;">
	<form method="post" action="newUserI_Cont.php"> 
	  <input class="btn btn-default" value="ANULUJ" onclick="parent.location.href='index.php'" type="button">
	  <input class="btn btn-primary" value="DALEJ" name="stStud1" type="submit">
    </form>
	</div>
	</div>
</div>	
<?php require_once "footer.php"; ?>
