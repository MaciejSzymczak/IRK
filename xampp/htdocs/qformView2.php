<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php
$ID_obywatelstwa = array( '1' => 'polskie', '2' => 'afgańskie', '3' => 'angielskie', '4' => 'białoruskie', '5' => 'bułgarskie', '6' => 'czeskie', '7' => 'francuskie', '8' => 'litewskie', '9' => 'niemieckie', '10' => 'rosyjskie', '11' => 'słowackie', '12' => 'tunezyjskie', '13' => 'ukraińskie', '14' => 'pozostałe');
$Id_wojewodztwa_meld = array( '4' => 'dolnośląskie', '6' => 'kujawsko - pomorskie', '7' => 'lubelskie', '8' => 'lubuskie', '9' => 'łódzkie', '10' => 'małopolskie', '11' => 'mazowieckie', '12' => 'opolskie', '13' => 'podkarpackie', '14' => 'podlaskie', '15' => 'pomorskie', '16' => 'śląskie', '17' => 'świętokrzyskie', '18' => 'warmińsko - mazurskie', '19' => 'wielkopolskie', '20' => 'zachodniopomorskie');
include 'inc\fq_wku.php';
$Id_zrodla_utrzymania = array( '1' => 'praca stała', '2' => 'praca dorywcza', '3' => 'prowadzenie gospodarstwa rolnego', '4' => 'prowadzenie działalności gospodarczej ', '5' => 'emerytura, renta', '6' => 'zasiłki', '7' => 'inne');
$ID_rodzaj_miejscowosci = array( '1' => 'Miasto', '2' => 'Wieś');
$ID_rodz_matury = array('1' => 'stara', '2' => 'nowa', '3' => 'IB', '4' => 'poza RP');
$id_komisji_okregowej = array( '1' => 'OKE w Gdańsku', '2' => 'OKE w Jaworznie', '3' => 'OKE w Krakowie', '4' => 'OKE w Łomży', '5' => 'OKE w Łodzi', '6' => 'OKE w Poznaniu', '7' => 'OKE w Warszawie', '8' => 'OKE w Wrocławiu');
$Student_wat = array('1' => 'TAK', '2' => 'NIE');

$username = $_SESSION['username'];

$zapytanie = "SELECT *
FROM kandydat_dane_osobowe , kandydat_dane_adresowe
WHERE kandydat_dane_osobowe.Id_Kandydata = kandydat_dane_adresowe.Id_Kandydata
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
if (array_key_exists($asR['Student_wat'], $Student_wat)) {$asR['Student_wat'] = $Student_wat[$asR['Student_wat']];}

if (strcmp ($asR['ID_obywatelstwa'],'0')==0) $asR['ID_obywatelstwa']='-';
if (strcmp ($asR['Id_wojewodztwa_meld'],'0')==0) $asR['Id_wojewodztwa_meld']='-';
if (strcmp ($asR['Id_wku'],'0')==0) $asR['Id_wku']='-';
if (strcmp ($asR['Id_zrodla_utrzymania'],'0')==0) $asR['Id_zrodla_utrzymania']='-';
if (strcmp ($asR['ID_rodzaj_miejscowosci'],'0')==0) $asR['ID_rodzaj_miejscowosci']='-';
if (strcmp ($asR['ID_rodz_matury'],'0')==0) $asR['ID_rodz_matury']='-';
if (strcmp ($asR['id_komisji_okregowej'],'0')==0) $asR['id_komisji_okregowej']='-';
if (strcmp ($asR['Student_wat'],'0')==0) $asR['Student_wat']='-';

$zapytanie = "SELECT *
FROM kandydat_kierunki_wybrane_punkty_rankingowe,kandydat_dane_osobowe
WHERE kandydat_dane_osobowe.Id_Kandydata = kandydat_kierunki_wybrane_punkty_rankingowe.Id_Kandydata
AND kandydat_dane_osobowe.username = :username";
$stmt = $conn->prepare($zapytanie);
$stmt->execute(['username' => $username]);
$asK = $stmt->fetch();
//echo '<pre>';print_r ($asK);echo '</pre>';

$k2d='BRAK';$k2n='BRAK';
$s1d='BRAK';$s2d='BRAK';$s3d='BRAK';
$s1n='BRAK';$s2n='BRAK';$s3n='BRAK';

if (!empty($asK['ID_kier_II_dzienne'])) $k2d  = $conn->query("SELECT Nazwa_kierunku FROM ssc2k where Id_kierunku=".$asK['ID_kier_II_dzienne'])->fetch()[0];
if (!empty($asK['ID_kier_II_niestac'])) $k2n  = $conn->query("SELECT Nazwa_kierunku FROM snc2k where Id_kierunku=".$asK['ID_kier_II_niestac'])->fetch()[0];

?>

<h4 align="center">DANE WPROWADZONE DO IRK WAT - STUDIA II STOPNIA</h4>
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
			<!--?php printLabel("Imie ojca:",$asR['Imie_ojca']) ?-->
			<!--?php printLabel("Imie matki:",$asR['Imie_matki']) ?-->
			<?php printLabel("Data urodzenia:",$asR['data_urodzenia']) ?>
			<?php printLabel("Miejsce urodzenia:",$asR['Miejsce_urodzenia']) ?>
			<?php printLabel("Obywatelstwo:",$asR['ID_obywatelstwa']) ?>
		  </div>
		</div>
	  <div class="panel panel-default"  style="margin: 0px;">
	    <div class="panel-heading">TELEFONY</div>
          <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
			<?php printLabel("Stacjonarny:",$asR['Nr_telefonu']) ?>
			<?php printLabel("Komórkowy:",$asR['Tel_kom']) ?>
		  </div>
      </div>		
	  <!--div class="panel panel-default"  style="margin: 0px;">
	    <div class="panel-heading">KOLEJNE STUDIA STACJONARNE W UCZELNI PUBLICZNEJ</div>
          <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
			< ?php printLabel("Kolejne studia stacjonarne:",$asR['Student_wat']) ?>	
		  </div>
      </div-->		
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
			<?php printLabel("WKU:",$asR['Id_wku']) ?>
			<!--?php printLabel("Seria i nr ksiazeczki wojskowej:",$asR['Military_Service_ID']) ?-->
			<?php printLabel("Rodzaj miejscowości:",$asR['ID_rodzaj_miejscowosci']) ?>
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
    </div>
  </div>
  <h4 align="center">FORMY, KIERUNKI- STUDIA CYWILNE II STOPNIA</h4>
  <h5 align="center">FORMA STUDIÓW</h5>
  <div class="row">
		<div class="col-sm-6">
		
		
		  <div class="panel panel-default"  style="margin: 0px;">
			<div class="panel-heading">STUDIA STACJONARNE</div>
			  <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
                  <h5 align="center">KIERUNEK STUDIÓW</h5>
				  <?php echo $k2d?>
				  <!--h5 align="center">SPECJALNOŚCI</h5>				  
					<div class="row">
						<div class="col-sm-2">
						1:
						</div>
						<div class="col-sm-10">
						<?php echo $s1d ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
						lub 2:
						</div>
						<div class="col-sm-10">
						<?php echo $s2d ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
						lub 3:
						</div>
						<div class="col-sm-10">
						<?php echo $s3d ?>
						</div>
					</div-->					  
			  </div>
		  </div>			
		</div>
		<div class="col-sm-6">
		  <div class="panel panel-default"  style="margin: 0px;">
			<div class="panel-heading">STUDIA NIESTACJONARNE</div>
			  <div class="panel-body"  style="padding-bottom: 0px;padding-top: 0px;">	  
                  <h5 align="center">KIERUNEK STUDIÓW</h5>
				  <?php echo $k2n?>
				  <!--h5 align="center">SPECJALNOŚCI</h5>
					<div class="row">
						<div class="col-sm-2">
						1:
						</div>
						<div class="col-sm-10">
						<?php echo $s1n ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-2">
						lub 2:
						</div>
						<div class="col-sm-10">
						<?php echo $s2n ?>
						</div>
					</div>	
					<div class="row">
						<div class="col-sm-2">
						lub 3:
						</div>
						<div class="col-sm-10">
						<?php echo $s3n ?>
						</div>
					</div-->				  				 				 
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
