<style>
td {
padding: 0 !important;
margin: 0 !important;
vertical-align: center; !important;
}
.nopadding {
padding: 0 !important;
margin: 0 !important;
}
.table-active {
  background-color: rgba(0, 0, 0, 0.075);
}
.table-warning {
  background-color: #ffeeba;
}
.table-condensed{
  font-size: 12px;
}
</style>
<?php 
$username=$_SESSION['username'];
$aspesel = $conn->query("SELECT Pesel FROM kandydat_dane_osobowe WHERE username = '$username'")->fetch()[0];
$_POST['aspesel']=$aspesel;

if ($InsertUpdateFlag == 'Update') {
	$ID_kandydata = '';
	
	//============================================================ ODCZYTANIE Z BAZY WYNIKÓW ZE ŚWIADECTWA DOJRZAŁOŚCI
	// ------------------------ 11 Jezyk polski
	$zapytanie = "SELECT *
	FROM kandydat_wyniki_maturalne
	WHERE username = :username
	AND ID_przedmiotu = :ID_przedmiotu;";
	$stmt = $conn->prepare($zapytanie);
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '11']);
	$asR = $stmt->fetch();
	$Wynik_pisemny11=$asR['Wynik_pisemny'];
	$Wynik_ustny11=$asR['Wynik_ustny'];
	$asID_kandydata = $asR['ID_kandydata'];
	// ------------------------ 6 Jezyk angielski
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '6']);
	$asR = $stmt->fetch();
	$Wynik_pisemny6=$asR['Wynik_pisemny'];
	$Wynik_ustny6=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna6=$asR['Klasa_dwujezyczna'];
	// ------------------------ 7 Jezyk niemiecki
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '7']);
	$asR = $stmt->fetch();
	$Wynik_pisemny7=$asR['Wynik_pisemny'];
	$Wynik_ustny7=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna7=$asR['Klasa_dwujezyczna'];
	// ------------------------ 8 Jezyk francuski
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '8']);
	$asR = $stmt->fetch();
	$Wynik_pisemny8=$asR['Wynik_pisemny'];
	$Wynik_ustny8=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna8=$asR['Klasa_dwujezyczna'];
	// ------------------------ 9 Jezyk rosyjski
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '9']);
	$asR = $stmt->fetch();
	$Wynik_pisemny9=$asR['Wynik_pisemny'];
	$Wynik_ustny9=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna9=$asR['Klasa_dwujezyczna'];
	// ------------------------ 10 Jezyk - inny nowo?ytny
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '10']);
	$asR = $stmt->fetch();
	$Wynik_pisemny10=$asR['Wynik_pisemny'];
	$Wynik_ustny10=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna10=$asR['Klasa_dwujezyczna'];
	// ------------------------ 1 Matematyka
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '1']);
	$asR = $stmt->fetch();
	$Wynik_pisemny1=$asR['Wynik_pisemny'];
	$Wynik_ustny1=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna1=$asR['Klasa_dwujezyczna'];
	// ------------------------ 2 Fizyka (fizyka z astronomi1)
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '2']);
	$asR = $stmt->fetch();
	$Wynik_pisemny2=$asR['Wynik_pisemny'];
	$Wynik_ustny2=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna2=$asR['Klasa_dwujezyczna'];
	// ------------------------ 5 Historia
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '5']);
	$asR = $stmt->fetch();
	$Wynik_pisemny5=$asR['Wynik_pisemny'];
	$Wynik_ustny5=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna5=$asR['Klasa_dwujezyczna'];
	// ------------------------ 4 Geografia
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '4']);
	$asR = $stmt->fetch();
	$Wynik_pisemny4=$asR['Wynik_pisemny'];
	$Wynik_ustny4=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna4=$asR['Klasa_dwujezyczna'];
	// ------------------------ 3 Chemia
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '3']);
	$asR = $stmt->fetch();
	$Wynik_pisemny3=$asR['Wynik_pisemny'];
	$Wynik_ustny3=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna3=$asR['Klasa_dwujezyczna'];
	// ------------------------ 12 Wiedza o spo3eczenstwie
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '12']);
	$asR = $stmt->fetch();
	$Wynik_pisemny12=$asR['Wynik_pisemny'];
	$Wynik_ustny12=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna12=$asR['Klasa_dwujezyczna'];
	// ------------------------ 13 Biologia
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '13']);
	$asR = $stmt->fetch();
	$Wynik_pisemny13=$asR['Wynik_pisemny'];
	$Wynik_ustny13=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna13=$asR['Klasa_dwujezyczna'];
	//------------------------ 14 Dodatkowy
	$stmt->execute(['username' => $username, 'ID_przedmiotu' => '14']);
	$asR = $stmt->fetch();
	$Wynik_pisemny14=$asR['Wynik_pisemny'];
	$Wynik_ustny14=$asR['Wynik_ustny'];
	$Klasa_dwujezyczna14=$asR['Klasa_dwujezyczna'];
	$as_id_kandydata=$asR['ID_kandydata']; // <-- dla OLIMPIADY
	//============================================================ ODCZYTANIE Z BAZY OLIMPIAD
	// ------------------------ OLIMPIADY
	$as1='';
	$as2='Je?eli w danych o olimpiadzie/ach jest b31d prosze skorzystaa z podanych w stopce kontaktów celem sprostowania.';
	$zapytanie = "SELECT * FROM kandydat_olimpiady WHERE ID_kandydata = '$as_id_kandydata';";
	$asR = $conn->query($zapytanie)->fetch();
	$nr1 = $asR['ID_olimpiady1'];
	$nr2 = $asR['Id_olimpiady2'];
	$nr3 = $asR['Id_olimpiady3'];
	if ($nr1>0){
		$ID_olimpiady1 = $conn->query("SELECT Nazwa FROM slownik_olimpiad_przedmiotowych WHERE Id_olimpiady = $nr1")->fetch()[0];
	}
	if ($nr2>0){
		$p1=' i ';
		$ID_olimpiady2 = $conn->query("SELECT Nazwa FROM slownik_olimpiad_przedmiotowych WHERE Id_olimpiady = $nr2")->fetch()[0];
	}
	if ($nr3>0){
		$p2=' oraz ';
		$ID_olimpiady3 = $conn->query("SELECT Nazwa FROM slownik_olimpiad_przedmiotowych WHERE Id_olimpiady = $nr3")->fetch()[0];
	}
}
?>

<script type="text/javascript" >
var errCnt = 0;
function validateNumber(currentItem)
{
	var itemValue = Number(currentItem.value);
	if (isNaN(itemValue)) itemValue = -1;
	//console.info(itemValue);
	if (itemValue != 0 && (itemValue > 6 || itemValue < 2)) {
		if (currentItem.style.backgroundColor == "white" || currentItem.style.backgroundColor =="") errCnt++;
		currentItem.style.backgroundColor = "pink";
	}
	else {
		if (currentItem.style.backgroundColor == "pink") errCnt--;
		currentItem.style.backgroundColor = "white";
	}
	//console.info(errCnt);
	document.getElementById("SubmitForm").disabled = errCnt!=0;
}
</script> 

<div class="Well"><span style="font-weight: bold; color: rgb(51, 102, 102);">
ZESTAWIENIE WYNIKÓW ZE ŚWIADECTWA DOJRZAŁOŚCI I OSIĄGNIĘĆ ZE SZKOŁY ŚREDNIEJ, BĘDĄCYCH PODSTAWĄ WYLICZENIA PUNKTÓW RANKINGOWYCH</span><br>
<ul>

  <li><small>Niniejsze zestawienie wyników będzie <span style="font-weight: bold;">weryfikowane przy składaniu dokumentów</span>
przez kandydatów przyjętych - wpisanie wyników zawyżonych, w stosunku do dostarczonych dokumentów, spowoduje <span style="font-weight: bold;">skreślenie kandydata</span> z listy przyjętych.</small></li>

  <li><small>Jeżeli legitymujesz się <span style="font-weight: bold;">maturą międzynarodową IB </span>lub uzyskaną poza granicami Polski musisz ją dostarczyć bezpośrednio do Uczelnianej Komisji Rekrutacyjnej,
która dokona naliczenia punktów rankingowych - <span style="font-weight: bold;">nie wpisuj wyników w&nbsp;tabeli.</span></small></li>

  <li><small><strong style="font-weight: normal;">Jeżeli jesteś <span style="font-weight: bold;">laureatem lub finalistą </span>stopnia centralnego olimpiady uprawniającej do przyjęcia na studia do WAT bez postępowania
rekrutacyjnego i posiadasz dyplom lub zaświadczenie wydane przez Komitet Główny Olimpiady - <span style="font-weight: bold;">wybierz nazwę olimpiady / olimpiad</span></strong> (maksymalnie 3 olimpiady).</small></li>

</ul>
</div>

<form method="post" action="wm_dml.php" name="wm1">
  <div align="container">
	  <div class="panel panel-default">
	  <div class="panel-heading">WYBÓR OLIMPIADY / OLIMPIAD</div>
	  <div class="panel-body text-center nopadding"> 
		<!--div class="alert alert-warning nopadding">
		  <small>
		  Proszę o szczególną uwagę przy wypełnianiu olimpiad. Jeżeli zostanie popełniony błąd, proszę skorzystać z podanych w stopce kontaktów celem sprostowania.
		  </small>
		</div--> 		
			<select size="1" name="ID_olimpiady1">
			<?php if (!empty($ID_olimpiady1)) { echo '<option value="'.$nr1.'">'.$ID_olimpiady1.'</option>';} ?>
			<option>--&gt; dokonaj wyboru &lt;--</option>
			<?php
				$arr_A = $conn->query("select Id_olimpiady, Nazwa from slownik_olimpiad_przedmiotowych order by Id_olimpiady")->fetchAll();
				for ($i = 0; $i <= count($arr_A)-1; $i++) {
				 echo '<option value="'.$arr_A[$i]['Id_olimpiady'].'">'.$arr_A[$i]['Nazwa'].'</option>';   
				}
			?>
			</select><br>

			<select size="1" name="ID_olimpiady2">
			<?php if (!empty($ID_olimpiady2)) { echo '<option value="'.$nr2.'">'.$ID_olimpiady2.'</option>';} ?>
			<option>--&gt; dokonaj wyboru &lt;--</option>
			<?php
				for ($i = 0; $i <= count($arr_A)-1; $i++) {
				 echo '<option value="'.$arr_A[$i]['Id_olimpiady'].'">'.$arr_A[$i]['Nazwa'].'</option>';   
				}
			?>
			</select><br>
			
			<select size="1" name="ID_olimpiady3">
			<?php if (!empty($ID_olimpiady3)) { echo '<option value="'.$nr3.'">'.$ID_olimpiady3.'</option>';} ?>
			<option>--&gt; dokonaj wyboru &lt;--</option>
			<?php
				for ($i = 0; $i <= count($arr_A)-1; $i++) {
				 echo '<option value="'.$arr_A[$i]['Id_olimpiady'].'">'.$arr_A[$i]['Nazwa'].'</option>';
				}
			?>
			</select>
	  </div>
	  </div>
	  <div class="panel panel-default">
	  <div class="panel-heading">TABELA WYNIKÓW ZE ŚWIADECTWA DOJRZAŁOŚCI - STARA MATURA (SKALA OCEN OD 2 do 6)</div>
	  <div class="panel-body"> 
  
		  <table class="table table-hover table-condensed text-center nopadding">

			<tbody>
			  <tr>
				<td class="table-active" colspan="1" rowspan="2">Przedmiot</td>
				<td class="table-active" colspan="3" rowspan="1"> Oceny ze świadectwa dojrzałości. <strong>Skala ocen (2&divide;6)</strong>
				</td>
			  </tr>
			  <tr>
				<td class="table-active">Część pisemna<br>(stara matura- ocena)</td>
				<td class="table-active">Część ustna<br>(stara matura- ocena)</td>
				<td class="table-active">Część pisemna poziom dwujęzyczny<br>(stara matura- ocena)</td>
			  </tr>
			  <tr>
				<td class="table-active">język polski</td>
				<td class="table-warning"><input name="Wynik_pisemny11" value="<?php echo $Wynik_pisemny11 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td ><input name="Wynik_ustny11" size="20" value="<?php echo $Wynik_ustny11 ?>" input maxlength="1" onchange="validateNumber(this)"></td>
				<td></td>
			  </tr>
			  <tr>
				<td class="table-active">język angielski </td>				
				<td class="table-warning"><input name="Wynik_pisemny6" value="<?php echo $Wynik_pisemny6 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny6" value="<?php echo $Wynik_ustny6 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td ><input name="Klasa_dwujezyczna6" value="<?php echo $Klasa_dwujezyczna6 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>			
			  </tr>
			  <tr>
				<td class="table-active">język niemiecki</td>
				<td class="table-warning"><input name="Wynik_pisemny7" value="<?php echo $Wynik_pisemny7 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny7" value="<?php echo $Wynik_ustny7 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna7" value="<?php echo $Klasa_dwujezyczna7 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">język francuski </td>
				<td class="table-warning"><input name="Wynik_pisemny8" value="<?php echo $Wynik_pisemny8 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny8" value="<?php echo $Wynik_ustny8 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna8" value="<?php echo $Klasa_dwujezyczna8 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">język rosyjski</td>
				<td class="table-warning"><input name="Wynik_pisemny9" value="<?php echo $Wynik_pisemny9 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny9" value="<?php echo $Wynik_ustny9 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna9" value="<?php echo $Klasa_dwujezyczna9 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">język- inny nowożytny</td>
				<td class="table-warning"><input name="Wynik_pisemny10" value="<?php echo $Wynik_pisemny10 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny10" value="<?php echo $Wynik_ustny10 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna10" value="<?php echo $Klasa_dwujezyczna10 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">matematyka</td>
				<td class="table-warning"><input name="Wynik_pisemny1" value="<?php echo $Wynik_pisemny1 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny1" value="<?php echo $Wynik_ustny1 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna1" value="<?php echo $Klasa_dwujezyczna1 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">fizyka (fizyka z astronomią)</td>
				<td class="table-warning"><input name="Wynik_pisemny2" value="<?php echo $Wynik_pisemny2 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny2" value="<?php echo $Wynik_ustny2 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna2" value="<?php echo $Klasa_dwujezyczna2 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">historia</td>
				<td class="table-warning"><input name="Wynik_pisemny5" value="<?php echo $Wynik_pisemny5 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny5" value="<?php echo $Wynik_ustny5 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna5" value="<?php echo $Klasa_dwujezyczna5 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">geografia</td>
				<td class="table-warning"><input name="Wynik_pisemny4" value="<?php echo $Wynik_pisemny4 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny4" value="<?php echo $Wynik_ustny4 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna4" value="<?php echo $Klasa_dwujezyczna4 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">chemia</td>
				<td class="table-warning"><input name="Wynik_pisemny3" value="<?php echo $Wynik_pisemny3 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny3" value="<?php echo $Wynik_ustny3 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna3" value="<?php echo $Klasa_dwujezyczna3 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">wiedza o społeczeństwie</td>
				<td class="table-warning"><input name="Wynik_pisemny12" value="<?php echo $Wynik_pisemny12 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny12" value="<?php echo $Wynik_ustny12 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna12" value="<?php echo $Klasa_dwujezyczna12 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
				<td class="table-active">biologia</td>
				<td class="table-warning"><input name="Wynik_pisemny13" value="<?php echo $Wynik_pisemny13 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Wynik_ustny13" value="<?php echo $Wynik_ustny13 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
				<td><input name="Klasa_dwujezyczna13" value="<?php echo $Klasa_dwujezyczna13 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr>
			  <tr>
			    <td class="table-active">informatyka</td>
			    <td class="table-warning"><input name="Wynik_pisemny14" value="<?php echo $Wynik_pisemny14 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			    <td><input name="Wynik_ustny14" value="<?php echo $Wynik_ustny14 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			    <td><input name="Klasa_dwujezyczna14" value="<?php echo $Klasa_dwujezyczna14 ?>" size="20" input maxlength="1" onchange="validateNumber(this)"></td>
			  </tr> 
			</tbody>
		  </table>
		  <strong style="font-weight: normal;"><br>
		  <span style="font-weight: bold;"><small>1)</small>&nbsp;<small>Część pisemna poziom dwujęzyczny</small></span> - <small><small>dotyczy absolwenta klasy z wykładowym językiem obcym, w której część przedmiotów nauczana była dwujęzycznie - wpisz wyniki z części pisemnej matury z języka obcego i innych przedmiotów zdawanych&nbsp; w&nbsp; języku obcym.</small></small><br>
		  </strong>

	  </div>
	  </div>
	  <div style="text-align: center;">
		  <input id="SubmitForm" class="btn btn-success" value="PRZEŚLIJ" name="B1" type="submit">
		  <input class="btn btn-info" value="RESETUJ" name="B2" type="reset" onClick="window.location.reload()">
		  <input onclick="window.print()" class="btn btn-info" value=" DRUKUJ " type="button">
		  <input name="asPesel" value="<?php echo $aspesel ?>" type="hidden"> 
		  <input class="btn btn-info" value="POWRÓT" onclick="self.location.href=('./index.php')" type="button">
      </div>  
	  <input name="asID_kandydata" value="<?php echo $asID_kandydata?>" type="hidden">
  </div>   
</form>
