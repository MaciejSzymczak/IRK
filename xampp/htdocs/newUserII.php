<?php 
	if (!($_POST['Caller'] == 'privacyPolicy')){header('Location: index.php');}
	require_once "header.php";
?>
<div class="panel panel-default">
	<div class="panel-heading" style="text-align: center;">INFORMACJE DLA KANDYDATA<br>KORZYSTAJĄCEGO Z INTERNETOWEJ REJESTRACJI KANDYDATÓW<br><strong>NA STUDIA II STOPNIA</strong></div>
	<div class="panel-body">
      Przed przystąpieniem do rejestracji należy dokładnie zapoznać się z zasadami rekrutacji na studia drugiego stopnia do WAT.<br>
      Rejestracja za pośrednictwem Internetu nie zwalnia kandydata z obowiązku dostarczenia do WAT kompletu wymaganych dokumentów, tj.:<br>
      <ul>
        <li><strong>kserokopia dyplomu ukończenia studiów (oryginał do wglądu),</strong></li>
        <li>kserokopia suplementu do dyplomu lub jego odpis albo indeks lub jego kserokopia (oryginał do wglądu),&nbsp;</li>
        <li>kolorowa fotografia w formie cyfrowej, którą należy przesłać poprzez rejestrację internetową,&nbsp;</li>
        <li>potwierdzenie wniesienia opłaty rekrutacyjnej (nie dotyczy opłat wniesionych na konto wygenerowane podczas rejestracji internetowej),</li>
      </ul>
      Podczas rejestracji zostanie wygenerowany indywidualny numer konta bankowego, na który należy dokonać opłaty rekrutacyjnej,<br><br>
      Do założenia konta niezbędne są:
      <ul>
        <li><strong>adres e-mail</strong></li>
      </ul>
      <div style="text-align: center;">
      <form method="post" action="newUserII_Cont.php">
	    <input class="btn btn-default" value="ANULUJ" onclick="parent.location.href='index.php'" type="button">
	    <input class="btn btn-primary" value="DALEJ" name="stStud2" type="submit">
	  </form>
      </div>
	</div>
</div>	
<?php require_once "footer.php";?>