<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php
	$username=$_SESSION['username'];
	$stmt = $conn->prepare("SELECT Pesel FROM kandydat_dane_osobowe WHERE username = :username");
	$stmt->execute(['username' => $username]);
	$aspesel = $stmt->fetch()[0];

	$zapytanie = "SELECT kwota_oplaty,konto_ogolne_kwota FROM kandydat_dane_osobowe WHERE Pesel=:pesel";
	$stmt = $conn->prepare($zapytanie);
	$stmt->execute(['pesel' => $aspesel]);
	$asR = $stmt->fetch();
	//-------------
	$a5=$asR['kwota_oplaty'];
	$a6=$asR['konto_ogolne_kwota'];
	if (($a5 == 0) AND ($a6 == 0)) {$a1=' BRAK';} else {$a1=' JEST';}
	//-------------
	$szukanyPzdj = 'D:/xampp2/htdocs_data/'.$aspesel.'.jpg';
	$wynikPzdj = 'N';
	if (file_exists($szukanyPzdj)) {$wynikPzdj = 'T';}

	$zapytanie = "SELECT rozmiar,revision_comments FROM zdjecia WHERE pesel=:pesel";
	$stmt = $conn->prepare($zapytanie);
	$stmt->execute(['pesel' => $aspesel]);
	$asR = $stmt->fetch();
	$a2=$asR['rozmiar'];
	$revision_comments=$asR['revision_comments'];
	if (($a2>100) and ($wynikPzdj == 'T')) {$a2='Oczekuje na akceptację';} else {$a2=' BRAK';}

	//-------------
	$komunikat       = $conn->query("SELECT komunikat       FROM kwalifikacje WHERE pesel='$aspesel'")->fetch()[0];
	$Inne            = $conn->query("SELECT inne            FROM kwalifikacje WHERE pesel='$aspesel'")->fetch()[0];
	$wynikiMaturalne = $conn->query("SELECT wynikiMaturalne FROM kandydat_dane_osobowe WHERE pesel='$aspesel'")->fetch()[0];

	if ($komunikat=='')       {$komunikat=' BRAK';}
	if ($Inne=='')            {$Inne=' BRAK';}
	if ($wynikiMaturalne=='') {$wynikiMaturalne=' BRAK';}

	$CertificateOfMaturityProvided = $conn->query("SELECT revision_comments FROM documents WHERE pesel='$aspesel'")->fetch()[0];
	$CertificateOfMaturityProvided2 = $conn->query("SELECT CertificateOfMaturityProvided FROM kandydat_dane_osobowe WHERE pesel='$aspesel'")->fetch()[0];
	if ($CertificateOfMaturityProvided=='') $CertificateOfMaturityProvided = $CertificateOfMaturityProvided2;
	if ($CertificateOfMaturityProvided=='') {$CertificateOfMaturityProvided=' BRAK';}

	$szukanyPdec = 'D:/xampp2/htdocs_dec/'.$aspesel.'.pdf';
	$wynikPdec = 'N';
	if (file_exists($szukanyPdec)) {$wynikPdec = 'T';} 
	//print($szukanyPzdj.'&nbsp'."|".'&nbsp'.$wynikPzdj.'&nbsp'."|".'&nbsp'.$szukanyPdec.'&nbsp'."|".'&nbsp'.$wynikPdec.'&nbsp'."|".'&nbsp');
?>

<h4 align="center">INFORMACJE DLA KANDYDATA</h4>
<div class="container">


  <div class="table-responsive">          
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Informacja</th>
        <th>Treść informacji</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Opłata rekrutacyjna</td>
        <td><?php print('&nbsp;'.$a1);?></td>
      </tr>
      <tr>
        <td>Zdjęcie do Elektronicznej Legitymacji Studenckiej ELS</td>
        <td>		
		  <?php if (empty($revision_comments)) {print('&nbsp;'.$a2.'&nbsp;'.'&nbsp;');} ?>
		  <?php if (!empty($revision_comments)) {
					if ($revision_comments=='Zaakceptowane') {
						print '<div class="alert alert-success" role="alert">' . $revision_comments .'</div>'; 
					} else {
						print '<div class="alert alert-danger" role="alert">ODRZUCONE: ' . $revision_comments .'</div>';
					} 
		  } ?>
	      <!--  <input value="Pobierz" onclick="self.location.href=('./qInfoDlZdj.php')" type="button"
		  <?php if($wynikPzdj == 'N') echo 'disabled="disabled"';?>  [[ err. 2014-09-09 ]]-->
		</td>
      </tr>
	  <?php
	  if ($_SESSION['STUDY_DEGREE'] == '1') {
		  print '<tr>';
		    print '<td>Wyniki ze świadectwa dojrzałości</td>';
		    print '<td>&nbsp;' .$wynikiMaturalne. '</td>';
		  print '</tr>';
		  print '<tr>';
		    print '<td>Świadectwo dojrzałości</td>';
		    print '<td>&nbsp;' .$CertificateOfMaturityProvided. '</td>';
		  print '</tr>';  
	  }
	  ?>
      <tr>
        <td>Wynik rekrutacji</td>
        <td>
		  <?php print('&nbsp;'.$komunikat.'&nbsp;'.'&nbsp;');?>
	      <!--   <input value="Pobierz" onclick="self.location.href=('./qInfoDlDec.php')" type="button" <?php if($wynikPdec == 'N') echo 'disabled="disabled"';?> > -->
		</td>
      </tr>
      <tr>
        <td>Inne informacje</td>
        <td>
		  <?php print('&nbsp;'.$Inne);?>
		</td>
      </tr>	  
    </tbody>
  </table>
  </div>
  
<br>
<p align="center">
<input class="btn btn-success btn-lg" type="button" onClick="window.print()" value="DRUKUJ" >&nbsp;&nbsp;
<input class="btn btn-success btn-lg" value="POWRÓT" onclick="self.location.href=('./index.php')" type="button">
</p>

</div>  

<?php require_once "footer.php"; ?>

