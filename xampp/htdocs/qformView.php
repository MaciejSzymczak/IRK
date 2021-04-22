<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php
$ID_obywatelstwa = array( '1' => 'polskie', '2' => 'afgańskie', '3' => 'angielskie', '4' => 'białoruskie', '5' => 'bułgarskie', '6' => 'czeskie', '7' => 'francuskie', '8' => 'litewskie', '9' => 'niemieckie', '10' => 'rosyjskie', '11' => 'słowackie', '12' => 'tunezyjskie', '13' => 'ukraińskie', '14' => 'wietnamskie', '15' => 'pozostałe');
$Id_wojewodztwa_meld = array( '4' => 'dolnośląskie', '6' => 'kujawsko - pomorskie', '7' => 'lubelskie', '8' => 'lubuskie', '9' => 'łódzkie', '10' => 'małopolskie', '11' => 'mazowieckie', '12' => 'opolskie', '13' => 'podkarpackie', '14' => 'podlaskie', '15' => 'pomorskie', '16' => 'śląskie', '17' => 'świętokrzyskie', '18' => 'warmińsko - mazurskie', '19' => 'wielkopolskie', '20' => 'zachodniopomorskie');
include 'inc\fq_wku.php';
$Id_zrodla_utrzymania = array( '1' => 'praca stała', '2' => 'praca dorywcza', '3' => 'prowadzenie gospodarstwa rolnego', '4' => 'prowadzenie działalności gospodarczej ', '5' => 'emerytura, renta', '6' => 'zasiłki', '7' => 'inne');
$ID_rodzaj_miejscowosci = array( '1' => 'Miasto', '2' => 'Wieś');
$ID_rodz_matury = array('1' => 'stara', '2' => 'nowa', '3' => 'IB', '4' => 'poza RP');
$id_komisji_okregowej = array( '1' => 'OKE w Gdańsku', '2' => 'OKE w Jaworznie', '3' => 'OKE w Krakowie', '4' => 'OKE w Łomży', '5' => 'OKE w Łodzi', '6' => 'OKE w Poznaniu', '7' => 'OKE w Warszawie', '8' => 'OKE w Wrocławiu');
$JezykAngMatura = array( '1' => 'NIE', '2' => 'TAK');

$Student_wat = array('1' => 'TAK', '2' => 'NIE');
$username = $_SESSION['username'];

$zapytanie = "SELECT *
FROM kandydat_dane_osobowe , kandydat_dane_adresowe , kandydat_kierunki_wybrane_punkty_rankingowe
WHERE kandydat_dane_osobowe.Id_Kandydata = kandydat_dane_adresowe.Id_Kandydata
AND kandydat_dane_adresowe.Id_Kandydata = kandydat_kierunki_wybrane_punkty_rankingowe.Id_Kandydata
AND kandydat_dane_osobowe.username = :username";
$stmt = $conn->prepare($zapytanie);
$stmt->execute(['username' => $username]);
$asR = $stmt->fetch();

if (array_key_exists($asR['ID_obywatelstwa'], $ID_obywatelstwa)) {$asR['ID_obywatelstwa'] = $ID_obywatelstwa[$asR['ID_obywatelstwa']];}
if (array_key_exists($asR['Id_wojewodztwa_meld'], $Id_wojewodztwa_meld)) {$asR['Id_wojewodztwa_meld'] = $Id_wojewodztwa_meld[$asR['Id_wojewodztwa_meld']];}
if (array_key_exists($asR['Id_wku'], $Id_wku)) {$asR['Id_wku'] = $Id_wku[$asR['Id_wku']];}
if (array_key_exists($asR['Id_zrodla_utrzymania'], $Id_zrodla_utrzymania)) {$asR['Id_zrodla_utrzymania'] = $Id_zrodla_utrzymania[$asR['Id_zrodla_utrzymania']];}
if (array_key_exists($asR['ID_rodzaj_miejscowosci'], $ID_rodzaj_miejscowosci)) {$asR['ID_rodzaj_miejscowosci'] = $ID_rodzaj_miejscowosci[$asR['ID_rodzaj_miejscowosci']];}
if (array_key_exists($asR['ID_rodz_matury'], $ID_rodz_matury)) {$asR['ID_rodz_matury'] = $ID_rodz_matury[$asR['ID_rodz_matury']];}
if (array_key_exists($asR['id_komisji_okregowej'], $id_komisji_okregowej)) {$asR['id_komisji_okregowej'] = $id_komisji_okregowej[$asR['id_komisji_okregowej']];}
if (array_key_exists($asR['JezykAngMatura'], $JezykAngMatura)) {$asR['JezykAngMatura'] = $JezykAngMatura[$asR['JezykAngMatura']];}
if (array_key_exists($asR['Student_wat'], $Student_wat)) {$asR['Student_wat'] = $Student_wat[$asR['Student_wat']];}

if (strcmp ($asR['ID_obywatelstwa'],'0')==0) $asR['ID_obywatelstwa']='BRAK';
if (strcmp ($asR['Id_wojewodztwa_meld'],'0')==0) $asR['Id_wojewodztwa_meld']='BRAK';
if (strcmp ($asR['Id_wku'],'0')==0) $asR['Id_wku']='BRAK';
if (strcmp ($asR['Id_zrodla_utrzymania'],'0')==0) $asR['Id_zrodla_utrzymania']='BRAK';
if (strcmp ($asR['ID_rodzaj_miejscowosci'],'0')==0) $asR['ID_rodzaj_miejscowosci']='BRAK';
if (strcmp ($asR['ID_rodz_matury'],'0')==0) $asR['ID_rodz_matury']='BRAK';
if (strcmp ($asR['id_komisji_okregowej'],'0')==0) $asR['id_komisji_okregowej']='BRAK';
if (strcmp ($asR['JezykAngMatura'],'0')==0) $asR['JezykAngMatura']='BRAK';


//generate <option value="2">budownictwo</option>
$ID_kier_1_niestac = '';
try{ 
	$arr_B = $conn->query("SELECT * FROM snc1k ORDER BY Nazwa_kierunku ASC")->fetchAll(); 
} catch(PDOException $e){ 
	die("Zapytanie niepoprawne"); 
};
for ($i = 0; $i <= count($arr_B)-1; $i++) {
	$ID_kier_1_niestac = $ID_kier_1_niestac . '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
}

$ID_kier_1_dzienne = '';
try{ 
	$arr_B = $conn->query("SELECT * FROM ssc1k ORDER BY Nazwa_kierunku ASC")->fetchAll(); 
} catch(PDOException $e){ 
	die("Zapytanie niepoprawne"); 
};
for ($i = 0; $i <= count($arr_B)-1; $i++) {
	$ID_kier_1_dzienne = $ID_kier_1_dzienne . '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
}


$ID_kier_1_dz_wojskowe = '';
try{ 
	$arr_B = $conn->query("SELECT * FROM ssw1k ORDER BY Nazwa_kierunku ASC")->fetchAll(); 
} catch(PDOException $e){ 
	die("Zapytanie niepoprawne"); 
};
for ($i = 0; $i <= count($arr_B)-1; $i++) {
	$ID_kier_1_dz_wojskowe = $ID_kier_1_dz_wojskowe . '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
}	

?>

<h4 align="center">DANE WPROWADZONE DO IRK WAT</h4>
<div class="container">
  <div class="row">
    <div class="col-sm-6">
	  <div class="panel panel-default" style="margin: 0px;">
	    <div class="panel-heading">DANE IDENTYFIKACYJNE</div>
          <div class="panel-body" style="padding-bottom: 0px;padding-top: 0px;">
	        <?php printLabel("<mark>PESEL:</mark>",$asR['Pesel']) ?>
	        <?php printLabel("<mark>E-MAIL:</mark>",$_SESSION['username']) ?>
		  </div>
		</div>
	  <div class="panel panel-default"  style="margin: 0px;">
	    <div class="panel-heading">DANE OSOBOWE KANDYDATA</div>
          <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">
	        <?php printLabel("Nazwisko:",$asR['Nazwisko']) ?>
			<?php printLabel("Imię:",$asR['Imie']) ?>
			<?php printLabel("Drugie imię:",$asR['Imie2']) ?>
			<?php printLabel("Imie ojca:",$asR['Imie_ojca']) ?>
			<?php printLabel("Imie matki:",$asR['Imie_matki']) ?>
			<?php printLabel("Data urodzenia:",$asR['data_urodzenia']) ?>
			<?php printLabel("Miejsce urodzenia:",$asR['Miejsce_urodzenia']) ?>
			<?php printLabel("Obywatelstwo:",$asR['ID_obywatelstwa']) ?>
		  </div>
		</div>
	  <div class="panel panel-default"  style="margin: 0px;">
	    <div class="panel-heading">ŚWIADECTWO DOJRZAŁOŚCI</div>
          <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
			<?php printLabel("Rodzaj matury:",$asR['ID_rodz_matury']) ?>
			<!--?php printLabel("Rok uzyskania matury:",$asR['Rok_Ukonczenia_Szkoly']) ?-->
			<!--?php printLabel("Nr świadectwa:",$asR['Nr_swiad_matura']) ?-->
			<!--?php printLabel("Data wystawienia:",$asR['data_wystawienia_matura']) ?-->
			<!--?php printLabel("Miejscowość wystawienia:",$asR['Miejscowosc_wystawienia_matura']) ?-->
			<!--?php printLabel("Nazwa szkoły:",$asR['Nazwa_szkoly']) ?-->
			<!--?php printLabel("OKE:",$asR['id_komisji_okregowej']) ?-->
			<?php printLabel("Język angielski na maturze:",$asR['JezykAngMatura']) ?>
		  </div>
		</div>
	</div>
    <div class="col-sm-6">
	  <div class="panel panel-default"  style="margin: 0px;">
	    <div class="panel-heading">ADRES ZAMIESZKANIA</div>
          <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
			<?php printLabel("Kod pocztowy:",$asR['Kod_pocztowy_meld']) ?>
			<?php printLabel("Miejscowość:",$asR['Miejscowosc_meld']) ?>
			<?php printLabel("Ulica:",$asR['Ulica_meld']) ?>
			<?php printLabel("Nr domu:",$asR['Nr_domu_meld']) ?>	
			<?php printLabel("Nr lokalu:",$asR['Nr_lokalu_meld']) ?>
			<?php printLabel("Województwo:",$asR['Id_wojewodztwa_meld']) ?>
			<?php printLabel("Rodzaj miejscowości:",$asR['ID_rodzaj_miejscowosci']) ?>
			<?php printLabel("---","---") ?>
			<?php printLabel("WKU:",$asR['Id_wku']) ?>
			<?php printLabel("Seria i nr książeczki wojskowej:",$asR['Military_Service_ID']) ?>
			<?php printLabel("Czy jesteś/będziesz absolwentem CWKM:",$asR['CWKM_Flag']) ?>
			<?php printLabel("Czy jesteś/będziesz absolwentem OLL:",$asR['OLL_Flag']) ?>
		  </div>
		</div>    
	  <div class="panel panel-default"  style="margin: 0px;">
	    <div class="panel-heading">ADRES DO KORESPONDENCJI</div>
          <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
			<?php printLabel("Kod pocztowy:",$asR['Kod_pocztowy']) ?>
			<?php printLabel("Miejscowość:",$asR['Miejscowosc']) ?>
			<?php printLabel("Ulica:",$asR['Ulica']) ?>
			<?php printLabel("Nr domu:",$asR['Nr_domu']) ?>
			<?php printLabel("Nr lokalu:",$asR['Nr_lokalu']) ?>
		  </div>
		</div>
	  <div class="panel panel-default"  style="margin: 0px;">
	    <div class="panel-heading">TELEFONY</div>
          <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
			<?php printLabel("Stacjonarny:",$asR['Nr_telefonu']) ?>
			<?php printLabel("Komórkowy:",$asR['Tel_kom']) ?>
		  </div>
		</div>		
    </div>
  </div>
  <h4 align="center">RODZAJ I KIERUNEK STUDIÓW</h4>
  <div class="row">
		<div class="col-sm-4">
		
		
		  <div class="panel panel-default"  style="margin: 0px;">
			<div class="panel-heading">STUDIA STACJONARNE "WOJSKOWE"</div>
			  <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  			  
					<div class="row">
						<div class="col-sm-3">
						1:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_1_dz_wojskowe" disabled>
								<?php echo $ID_kier_1_dz_wojskowe; ?>	
							</select>    
							<?php if (!empty($asR['ID_kier_1_dz_wojskowe'])) { echo  '<script>document.getElementsByName("ID_kier_1_dz_wojskowe")[0].value="'.$asR['ID_kier_1_dz_wojskowe'].'";</script>'; } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
						lub 2:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_2_dz_wojskowe" disabled>
								<?php echo $ID_kier_1_dz_wojskowe; ?>	
							</select>    
							<?php if (!empty($asR['ID_kier_2_dz_wojskowe'])) { echo  '<script>document.getElementsByName("ID_kier_2_dz_wojskowe")[0].value="'.$asR['ID_kier_2_dz_wojskowe'].'";</script>'; } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
						lub 3:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_3_dz_wojskowe" disabled>
								<?php echo $ID_kier_1_dz_wojskowe; ?>	
							</select>    
							<?php if (!empty($asR['ID_kier_3_dz_wojskowe'])) { echo  '<script>document.getElementsByName("ID_kier_3_dz_wojskowe")[0].value="'.$asR['ID_kier_3_dz_wojskowe'].'";</script>'; } ?>
						</div>
					</div>					  
			  </div>
		  </div>
		</div>
		<div class="col-sm-4">
		  <div class="panel panel-default"  style="margin: 0px;">
			<div class="panel-heading">lub STUDIA STACJONARNE "CYWILNE"</div>
			  <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
					<div class="row">
						<div class="col-sm-3">
						1:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_1_dzienne" disabled>
								<?php echo $ID_kier_1_dzienne; ?>	
							</select>
							<?php if (!empty($asR['ID_kier_1_dzienne'])) { echo  '<script>document.getElementsByName("ID_kier_1_dzienne")[0].value="'.$asR['ID_kier_1_dzienne'].'";</script>'; } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
						lub 2:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_2_dzienne" disabled>
								<?php echo $ID_kier_1_dzienne; ?>	
							</select>
							<?php if (!empty($asR['ID_kier_2_dzienne'])) { echo  '<script>document.getElementsByName("ID_kier_2_dzienne")[0].value="'.$asR['ID_kier_2_dzienne'].'";</script>'; } ?>
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-3">
						lub 3:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_3_dzienne" disabled>
								<?php echo $ID_kier_1_dzienne; ?>	
							</select>
							<?php if (!empty($asR['ID_kier_3_dzienne'])) { echo  '<script>document.getElementsByName("ID_kier_3_dzienne")[0].value="'.$asR['ID_kier_3_dzienne'].'";</script>'; } ?>
						</div>
					</div>				  				 				 
			  </div>
		  </div>		
		
		</div>
		<div class="col-sm-4">
		  <div class="panel panel-default"  style="margin: 0px;">
			<div class="panel-heading">lub STUDIA NIESTACJONARNE "CYWILNE"</div>
			  <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
					<div class="row">
						<div class="col-sm-3">
						1:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_1_niestac" disabled>
								<?php echo $ID_kier_1_niestac; ?>	
							</select>
							<?php if (!empty($asR['ID_kier_1_niestac'])) { echo  '<script>document.getElementsByName("ID_kier_1_niestac")[0].value="'.$asR['ID_kier_1_niestac'].'";</script>'; } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3">
						lub 2:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_2_niestac" disabled>
								<?php echo $ID_kier_1_niestac; ?>	
							</select>
							<?php if (!empty($asR['ID_kier_2_niestac'])) { echo  '<script>document.getElementsByName("ID_kier_2_niestac")[0].value="'.$asR['ID_kier_2_niestac'].'";</script>'; } ?>
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-3">
						lub 3:
						</div>
						<div class="col-sm-9">
							<select size="1" name="ID_kier_3_niestac" disabled>
								<?php echo $ID_kier_1_niestac; ?>	
							</select>
							<?php if (!empty($asR['ID_kier_3_niestac'])) { echo  '<script>document.getElementsByName("ID_kier_3_niestac")[0].value="'.$asR['ID_kier_3_niestac'].'";</script>'; } ?>
						</div>
					</div>				  				 				 
			  </div>
		  </div>		
		</div>		
  </div>
</div>  
				
  <br>
  <p align="center">
  <input value="POWRÓT" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button">
  </p> 

<?php require_once "footer.php"; ?>