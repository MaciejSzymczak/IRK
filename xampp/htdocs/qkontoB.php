<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php 
	$username=$_SESSION['username'];
	$stmt = $conn->prepare("SELECT Pesel FROM kandydat_dane_osobowe WHERE username = :username");
	$stmt->execute(['username' => $username]);
	$aspesel = $stmt->fetch()[0];
	
	$W = array(1,10,3,30,9,90,27,76,81,34,49,5,50,15,53,45,62,38,89,17,73,51,25,56,75,71,31,19,93,57);
	$as2="12406960035000";
	$as3=$aspesel;
	$as4="2521";
	$as1=$as2.substr($as3, 0, -1).$as4;
	$Z =0;
	for ($i=0;$i<30;$i++) $Z += $as1[29-$i] * $W[$i];
	$asKonto=$Z % 97;
	$asKonto=98-$asKonto; if (strlen($asKonto)==1) $asKonto="0".$asKonto;
	$asKonto=$asKonto.$as2.substr($as3, 0, -1);
	$zapytanie = "UPDATE kandydat_dane_osobowe SET konto_bankowe= :konto_bankowe WHERE pesel = :pesel";
	$stmt = $conn->prepare($zapytanie);
	$stmt->execute(['konto_bankowe' => $asKonto, 'pesel' => $aspesel]);
	//
	
	$FeeMilitaryCivil = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'FeeMilitaryCivil'")->fetch()[0];
	$FeeCivil = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'FeeCivil'")->fetch()[0];
?>


<script>

//---------------------------------------------------------------------------------
function copyToClipboard(text) {
	var input = document.createElement('textarea');
	document.body.appendChild(input);                  
	input.value = text;
	input.focus();
	input.select();
	s = document.execCommand('Copy');
	if (!s) {
		alert("Dostęp do schowka został zablokowany przez przeglądarkę, po prostu przepisz nr rachunku ręcznie", "Błąd");
	} else input.value = '';
	$("#myModal").modal();
	input.remove();
}

</script>

<div class="container">
  <div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">NUMER KONTA BANKOWEGO</div>
		<div class="panel-body">

			<div class="alert alert-info">
			<strong>UWAGA!</strong> 
				Na indywidualne konto bankowe można wpłacać <strong>wyłącznie opłatę rekrutacyjną</strong><br/>
				Nie jest to konto przeznaczone do uiszczenia innych opłat (jak czesne, opłata za akademik, opłata za legitymację itp.)<br/>
				Dokonanie opłaty rekrutacyjnej na ww. konto zwalnia kandydata z obowiązku dostarczenia do Akademii potwierdzenia jej wniesienia.
			</div>

			<div class="form-group">
				<label title="Username" class="control-label col-sm-2 h3" for="username">Nr Konta</label>
				<div class="col-sm-10">

					<ul class="pagination h3">
					  <li><a style="color:black;"><?php print(substr($asKonto, 0, 2));?> </a></li>
					  <li><a style="color:black;"><?php print(substr($asKonto, 2, 4));?> </a></li>
					  <li><a style="color:black;"><?php print(substr($asKonto, 6, 4));?> </a></li>
					  <li ><a style="color:black;"><?php print(substr($asKonto, 10, 4));?></a></li>
					  <li><a style="color:black;"><?php print(substr($asKonto, 14, 4));?></a></li>
					  <li><a style="color:black;"><?php print(substr($asKonto, 18, 4));?></a></li>  
					  <li><a style="color:black;"><?php print(substr($asKonto, 22, 4));?></a></li>    
					  <li>&nbsp;<input value="Kopiuj"  style='margin-top:15px' class="btn btn-default" onclick="copyToClipboard('<?php print($asKonto);?>');" type="button"/></li>  
					</ul>

				</div>
			</div>
			<div class="form-group">
				<label title="Password" class="control-label col-sm-2 h3" for="password">Tytułem</label>
				<div class="col-sm-10">
					<h3>OPŁATA REKRUTACYJNA</h3>
				</div>
			</div>
			<div class="form-group">
				<label title="Password" class="control-label col-sm-2 h3" for="password">Kwota</label>
				<div class="col-sm-10">
					<h3>
					  <?php
						if ($_SESSION['STUDY_DEGREE'] == '1') {
							print($FeeMilitaryCivil).' zł<small>- na studia wojskowe lub wojskowe i cywilne.</small><br/>';
							print($FeeCivil).' zł<small> -na studia wyłącznie cywilne.</small>';
						}
						else {
							print($FeeCivil).' zł';
						}
					  ?>
					</h3>
				</div>
			</div>
			<input value="POWRÓT" class="btn btn-primary btn-lg center-block" onclick="self.location.href=('./index.php')" type="button"/>
		</div>
	</div>
  </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Nr konta bankowego został skopiowany do schowka</h4>
        </div>
        <div class="modal-body">
		  <p>By wyeliminować możliwość zmiany nr rachunku w schowku przez złośliwe oprogramowanie, sprawdź czy pierwsza i ostatnia cyfry w skopiowanym nr rachunku są prawidłowe</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

<?php require_once "footer.php"; ?>
