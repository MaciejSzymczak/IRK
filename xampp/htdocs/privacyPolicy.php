<?php 
if (!($_POST['B1'] == 'STUDIA I STOPNIA') and !($_POST['B1'] == 'STUDIA II STOPNIA')){echo "Dostęp zabroniony";exit();}
require_once "header.php"; 
?>

<div class="panel panel-default">
	<div class="panel-heading" style="text-align: center;">KLAUZULA INFORMACYJNA DOTYCZĄCA PRZETWARZANIA DANYCH OSOBOWYCH</div>
	<div class="panel-body">
1.	Administratorem danych osobowych Pani/Pana jest: Wojskowa Akademia Techniczna im. Jarosława Dąbrowskiego z siedzibą w Warszawie (00-908) przy ul. gen. Sylwestra Kaliskiego 2.<br/>
2.	Administrator danych powołał inspektora ochrony danych nadzorującego prawidłowość przetwarzania danych osobowych, z którym można się skontaktować za pośrednictwem adresu e-mail: iod@wat.edu.pl.<br/>
3.	Pani/Pana dane osobowe przetwarzane będą w celach rekrutacyjnych na studia, a po przyjęciu na studia, przetwarzane będą dla celów dokumentowania ich przebiegu oraz celów statutowych, statystycznych i archiwalnych.<br/>
4.	Podane dane przetwarzane będą na podstawie ustawy Prawo o szkolnictwie wyższym i nauce oraz innych przepisów.<br/>
5.	Podanie danych osobowych jest dobrowolne, ale niezbędne do realizacji celów do jakich zostały zebrane.<br/>
6.	Dane osobowe nie będą udostępniane innym odbiorcom, z wyjątkiem przypadków przewidzianych przepisami prawa (dane osobowe kandydatów na studia wojskowe przekazywane są wojskowym komendantom uzupełnień).<br/>
7.	Dane przechowywane będą przez okres 1 roku w stosunku do osób nieprzyjętych na studia oraz 50 lat w stosunku do osób przyjętych na studia.<br/>
8.	Posiada Pani/Pan prawo dostępu do treści swoich danych oraz, z zastrzeżeniem przepisów prawa, prawo do: ich sprostowania, usunięcia, ograniczenia przetwarzania, przenoszenia, wniesienia sprzeciwu, cofnięcia zgody w dowolnym momencie bez wpływu na zgodność z prawem przetwarzania, którego dokonano na podstawie zgody przed jej cofnięciem.<br/>
9.	Ma Pani/Pan prawo do wniesienia skargi do Prezesa Urzędu Ochrony Danych Osobowych.<br/>
10.	Pani/Pana dane nie będą przetwarzane w sposób zautomatyzowany i nie będą poddawane profilowaniu.<br/>
	</div>
</div>	

<div class="panel panel-default">
	<div class="panel-heading" style="text-align: center;">ZGODA</div>
	<div class="panel-body">
Po zapoznaniu się i akceptacji powyższej informacji wyrażam zgodę na przetwarzanie moich danych osobowych w celach rekrutacyjnych na studia.<br/>
<br/>
Nie wyrażenie zgody powoduje przerwanie procesu rejestracji w IRK (wyjście z IRK).<br/>
Wyrażenie zgody powoduje przejście do kontynuacji rejestracji w IRK.<br/> <br/> 
	<div style="text-align: center;">
	<form class="form-inline" method="post" action="<?php if ($_POST['B1'] == 'STUDIA I STOPNIA'){echo "newUserI.php";}else{echo "newUserII.php";}?>">
	
	<div class="row">
		<div class="col-sm-5">
		  <input class="btn btn-primary" value="Nie wyrażam zgody" onclick="parent.location.href='index.php'" type="button">
		</div>
		<div class="col-sm-2">
		</div>
		<div class="col-sm-5">
		  <input type="checkbox" class="form-check-input" id="privacyPolicy" onclick="document.getElementById('privacyPolicyContinue').disabled=!this.checked;">
          <label class="form-check-label" for="privacyPolicy">Wyrażam zgodę</label>
	      <input class="btn btn-primary" value="Dalej" id="privacyPolicyContinue" name="B1" type="submit" disabled>
		</div>
	</div>
       
	</form>
	</div>
	</div>
</div>	

<?php require_once "footer.php"; ?>