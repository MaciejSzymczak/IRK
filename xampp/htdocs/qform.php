<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php
if (!isLoggedIn() == true) {
	 echo '<div class="alert alert-danger" role="alert">
			  <strong>Och!</strong> Musisz się zalogować, by móc używać tej Aplikacji.
			</div>';
	 echo '<p align="center"><button type="button" class="btn btn-success btn-lg" onclick="self.location.href=(\'./index.php\');"> Powrót</button></p>';
	 require_once "footer.php";
	 exit();
}
include "inc/FormDict.php";

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT ile_login FROM login WHERE username=:username");
$stmt->execute(['username' => $username]);
$FczyS = $stmt->fetch()[0];
//echo "$FczyS";
//echo $_SESSION['STUDY_DEGREE'];

$UpdateMode = 0;	//	0-insert, 1-update
if ($FczyS <> '1') {
	$UpdateMode = 1;
}

// Ustalenie, którą kartę należy wyświetlić
if (($_SERVER['REQUEST_METHOD'] == 'GET') || (! isset($_POST['stage']))) {
    $stage = 1;
	$ReadFromDB = 1;
} else {
    $stage = (int) $_POST['stage'];
	$ReadFromDB = 0;	// => wszystko wczytane z session; np wejscie w stage 1 przez "wstecz" ze stage 2
}

// Zapisanie przesłanych danych
if (!$ReadFromDB) {
    foreach ($_POST as $key => $value) {
        $_SESSION[$key] = $value;
		//echo $key.'='. $value.'====<br />';
    }
}
//-*-print "[#02]".$username." | formView.php";


// study degree 1 & 2
if ($UpdateMode) {	// => old formS or formS2
	if ($ReadFromDB) {
		
		$zapytanie = "SELECT *
			FROM kandydat_dane_osobowe, kandydat_dane_adresowe
			WHERE kandydat_dane_osobowe.Id_Kandydata = kandydat_dane_adresowe.Id_Kandydata
			AND kandydat_dane_osobowe.username = :username";
		$stmt = $conn->prepare($zapytanie);
		$stmt->execute(['username' => $username]);
		$asR = $stmt->fetch();
		//echo $asR['Id_Kandydata'];
		
		// wrzucam do SESSION wszystkie dane z DB (ma miejsce tylko przy pierwszym wejściu do formularza - stage=1)
		foreach ($asR as $key => $value) {
			$_SESSION[$key] = $value;
			//echo $key.'='. $value.'====<br />';
		}
	} else {	// read from SESSION
		foreach ($_SESSION as $key => $value) {
			$asR[$key] = $value;
			//echo $key.'='. $value.'====<br />';
		}
	}
	
	//--------------------
	$asasId_Kandydata = $asR['Id_Kandydata'];
	//--------------------
} else {	// => old formF or formF2
	if ($ReadFromDB) {	//	= czysty formularz
		$asR['ID_obywatelstwa'] = 0;
		$asR['Id_wojewodztwa_meld'] = 0;
		$asR['ID_rodzaj_miejscowosci'] = 0;
		$asR['Id_wku'] = 0;
		foreach ($asR as $key => $value) {
			$_SESSION[$key] = $value;
		}
	} else {	// read from SESSION
		foreach ($_SESSION as $key => $value) {
			$asR[$key] = $value;
		}
	}
}


if ($_SESSION['STUDY_DEGREE']=='1') {	// => old formF or formS
	$day = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'SSW_Disabled_MMDD'")->fetch()[0];
	$today = date("md");
	if ($today>$day) {$tn='Y';} else {$tn='N';}

	$_SESSION['SSW_Disable'] =$tn; //Y = Picklist studia stacjonarne "wojskowe" is disabled (shutter)
	//echo "$tn";
	
	if ($UpdateMode) {	// => old formS
		if ($ReadFromDB) {
			
			$zapytanie = "SELECT *
				FROM kandydat_kierunki_wybrane_punkty_rankingowe
				WHERE Id_Kandydata = :Id_Kandydata";
			$stmt = $conn->prepare($zapytanie);
			$stmt->execute(['Id_Kandydata' => $asasId_Kandydata]);
			$asR2 = $stmt->fetch();
			
			// wrzucam do SESSION wszystkie dane z DB (ma miejsce tylko przy pierwszym wejściu do formularza - stage=1)
			foreach ($asR2 as $key => $value) {
				$_SESSION[$key] = $value;
				$asR[$key] = $value;
				//echo $key.'='. $value.'====<br />';
			}
		}
	} else {	// => old formF
		if ($ReadFromDB) {	//	= czysty formularz
			$asR['ID_rodz_matury'] = 0;
			$asR['JezykAngMatura'] = 0;
			foreach ($asR as $key => $value) {
				$_SESSION[$key] = $value;
			}
		}
	}
}


if ($stage == 2) {
	$PeselErrorMessage = '';
	$stmt = $conn->prepare("SELECT id_kandydata FROM kandydat_dane_osobowe WHERE username != :username and pesel = :pesel limit 1");
	$stmt->execute(['username' => $username, 'pesel' => $_POST['Pesel']]);
	
	if ($stmt->rowCount() > 0) {
		$PeselErrorMessage = 
		'<div class="alert alert-danger">
		Ten numer pesel został już użyty przez kogoś innego.
		</div>';
		$stage  =1;
		$asR['Pesel']            = $_POST['Pesel'];
		$asR['Nazwisko']         = $_POST['Nazwisko'];
		$asR['Imie']             = $_POST['Imie'];
		$asR['Imie2']            = $_POST['Imie2'];
		$asR['Imie_ojca']        = $_POST['Imie_ojca'];
		$asR['Imie_matki']       = $_POST['Imie_matki'];
		$asR['data_urodzenia']   = $_POST['data_urodzenia'];
		$asR['ID_obywatelstwa']  = $_POST['ID_obywatelstwa'];
	}                          
}


if ($stage == 1) { ?>
	<form action='<?php echo $_SERVER['SCRIPT_NAME'] ?>' method='post'>
	<!-- form1.html.początek fS2 (05) -->
	  <div class="container">
	  <?php
		if ($_SESSION['STUDY_DEGREE']=='1') {
			include 'inc\formAppHeaderI.php';
			include 'inc\formSectionFieldOfStudy.php';
		} else if ($_SESSION['STUDY_DEGREE']=='2') {
			include 'inc\formAppHeaderII.php';
		}
	  ?>
	  <?php include 'inc\formSectionDIK.php'; ?>
	  </div> 
	  <!-- form1.html.koniec -->
	  <input name="stage" value="<?php echo $stage + 1 ?>" type="hidden">
	  <p align="center"><input id="SubmitForm" value="DALEJ (do str.2)" class="btn btn-success btn-lg" type="submit"></p>
	  <script>
		validatePesel(document.getElementById("Pesel"));
		validateNotEmpty(document.getElementById("Nazwisko"));
		validateNotEmpty(document.getElementById("Imie"));
		$('select[name=ID_obywatelstwa]').val('<?=$asR['ID_obywatelstwa']?>');
	  </script>  
	</form>
<?php } else if ($stage == 2) { ?>
	<form action='<?php echo $_SERVER['SCRIPT_NAME'] ?>' method='post'>
	  <!-- form2.html.początek -->
	  <div class="container">
	  <?php include 'inc\formSectionMainAddress.php'; ?>
	  <?php include 'inc\formSectionCorrAddress.php'; ?>
	  <!--?php include 'inc\formSectionBarracksAddress.php'; ?-->
	  </div>
	  <!-- form2.html.koniec -->
	  <input type='hidden' name='stage' value='<?php echo $stage + 1 ?>'/>
	  <p align="center">
		<input id="PrevForm" value="Wstecz" class="btn btn-info btn-lg" type="button" />
		<input id="SubmitForm" type='submit' class="btn btn-success btn-lg" value='DALEJ (do str.3)' />
	  </p>
	  <script>
		$(function () {
			$('#PrevForm').click(function(){
				$('input[name=stage]').val('<?=$stage-1?>').parents('form').submit();
			});
		});
		$('select[name=Id_wojewodztwa_meld]').val('<?=$asR['Id_wojewodztwa_meld']?>');
		$('input[name=ID_rodzaj_miejscowosci][value=<?=$asR['ID_rodzaj_miejscowosci']?>]').prop("checked",true);
		$('select[name=Id_wku]').val('<?=$asR['Id_wku']?>');
		validateTT();
	  </script>  
	</form>
<?php } else if ($stage == 3) { ?>
	<form action='<?php echo $_SERVER['SCRIPT_NAME'] ?>' method='post'>
	<input type='hidden' name='stage' value='<?php echo $stage + 1 ?>'/>
	<!-- form3.html.początek -->
	  <div class="container">
	  <?php
		if ($_SESSION['STUDY_DEGREE']=='1') {
			include 'inc\formSSCertificate.php';
		}
	  ?>
	  <?php include 'inc\formSectionPhones.php'; ?>
	  </div>
	<!-- form3.html.koniec -->
	  <input name="stage" value="<?php echo $stage + 1 ?>" type="hidden">
	  <p align="center">
		<input id="PrevForm" value="Wstecz" class="btn btn-info btn-lg" type="button" />
		<input id="SubmitForm" value="WYŚLIJ DO IRK WAT" class="btn btn-success btn-lg" type="submit">
		<?php if (isset($_SESSION['adminUserName'])) {  ?>
			<input value="POWRÓT (Przycisk widoczny tylko dla administratora)" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button">	
		<?php }  ?>
	  </p>
	  <script>
		$(function () {
			$('#PrevForm').click(function(){
				$('input[name=stage]').val('<?=$stage-1?>').parents('form').submit();
			});
		});
	  <?php if ($_SESSION['STUDY_DEGREE']=='1') { ?>
		$('select[name=ID_rodz_matury]').val('<?=$asR['ID_rodz_matury']?>');
		$('select[name=JezykAngMatura]').val('<?=$asR['JezykAngMatura']?>');
		validatePickListNotEmpty(document.getElementById("ID_rodz_matury"));
	  <?php } ?>
	  </script>  
	</form>
<?php } else if ($stage == 4) { ?>
	<form action='<?php echo $_SERVER['SCRIPT_NAME'] ?>' method='post'>
	<!-- form2.html.początek -->
	<!-- przesyłanie danych POCZATEK -->
	<?php
	// utworzenie krótkich nazw zmiennych
	//-------------------KDO
	$ID_obywatelstwa = trim($_SESSION['ID_obywatelstwa']);
	$id_komisji_okregowej = trim($_SESSION['id_komisji_okregowej']);
	$ID_rodz_matury = trim($_SESSION['ID_rodz_matury']);
	$data_urodzenia = trim($_SESSION['data_urodzenia']);
	$data_wystawienia_matura = trim($_SESSION['data_wystawienia_matura']);
	$Imie = trim($_SESSION['Imie']);
	$Imie2 = trim($_SESSION['Imie2']);
	$Imie_matki = trim($_SESSION['Imie_matki']);
	$Imie_ojca = trim($_SESSION['Imie_ojca']);
	$Miejsce_urodzenia = trim($_SESSION['Miejsce_urodzenia']);
	$Miejscowosc_wystawienia_matura = trim($_SESSION['Miejscowosc_wystawienia_matura']);
	$Nazwa_szkoly = trim($_SESSION['Nazwa_szkoly']);
	$Pesel = trim($_SESSION['Pesel']);
	$Nazwisko = trim($_SESSION['Nazwisko']);
	$Nr_swiad_matura = trim($_SESSION['Nr_swiad_matura']);
	$Rok_Ukonczenia_Szkoly = trim($_SESSION['Rok_Ukonczenia_Szkoly']);
	$Student_wat = trim($_SESSION['Student_wat']);
	$Nr_albumu = trim($_SESSION['Nr_albumu']);
	
	$data_ostatniej_aktualizacji = date("Y-m-d");
	$Uzytkownik_aktualiz_osobowe = 'Internet';
	
	opendb();
	
	if (!$UpdateMode) {	//	=> insert - formF or formF2
		$data_wprowadzenia = date("Y-m-d");
		$uzytkownik_wprowadzenia = 'Internet';
		
		$Id_Kandydata = NULL;
		$Rodzaj_studiow = $_SESSION['STUDY_DEGREE'];
		
		$zapytanie = "INSERT INTO kandydat_dane_osobowe (
				  username
				, Id_Kandydata
				, Rodzaj_studiow
				, data_wprowadzenia
				, uzytkownik_wprowadzenia
			) VALUES (
				  :username
				, :Id_Kandydata
				, :Rodzaj_studiow
				, :data_wprowadzenia
				, :uzytkownik_wprowadzenia
			)";
		$stmt = $conn->prepare($zapytanie);
		try{ 
			$stmt->execute(['username' => $username
					, 'Id_Kandydata' => $Id_Kandydata
					, 'Rodzaj_studiow' => $Rodzaj_studiow
					, 'data_wprowadzenia' => $data_wprowadzenia
					, 'uzytkownik_wprowadzenia' => $uzytkownik_wprowadzenia
				]); 
		} catch(PDOException $e){ die('"<br>"[ FormF2 kdo ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e); };
		$_SESSION['as_LastID']=$conn->query("SELECT MAX(Id_Kandydata) FROM kandydat_dane_osobowe")->fetch()[0];
		$_SESSION['as_email']=$conn->query("SELECT email FROM login WHERE username = '$username'")->fetch()[0];
	}
	
	$zapytanie = "UPDATE kandydat_dane_osobowe
	SET Nazwisko = :Nazwisko
		, Imie = :Imie
		, Imie2 = :Imie2
		, Imie_ojca = :Imie_ojca
		, Imie_matki = :Imie_matki
		, data_urodzenia = :data_urodzenia
		, Miejsce_urodzenia = :Miejsce_urodzenia
		, pesel = :Pesel
		, ID_obywatelstwa = :ID_obywatelstwa
		, ID_rodz_matury = :ID_rodz_matury
		, Rok_Ukonczenia_Szkoly = :Rok_Ukonczenia_Szkoly
		, Nr_swiad_matura = :Nr_swiad_matura
		, data_wystawienia_matura = :data_wystawienia_matura
		, Miejscowosc_wystawienia_matura = :Miejscowosc_wystawienia_matura
		, Nazwa_szkoly = :Nazwa_szkoly
		, id_komisji_okregowej = :id_komisji_okregowej
		, Student_wat = :Student_wat
		, Nr_albumu = :Nr_albumu
		, data_ostatniej_aktualizacji = :data_ostatniej_aktualizacji
		, Uzytkownik_aktualiz_osobowe = :Uzytkownik_aktualiz_osobowe
	WHERE username = :username";
	$stmt = $conn->prepare($zapytanie);
	if(!$stmt->execute(['username' => $username
		, 'Nazwisko' => $Nazwisko
		, 'Imie' => $Imie
		, 'Imie2' => $Imie2
		, 'Imie_ojca' => $Imie_ojca
		, 'Imie_matki' => $Imie_matki
		, 'data_urodzenia' => $data_urodzenia
		, 'Miejsce_urodzenia' => $Miejsce_urodzenia
		, 'Pesel' => $Pesel
		, 'ID_obywatelstwa' => $ID_obywatelstwa
		, 'ID_rodz_matury' => $ID_rodz_matury
		, 'Rok_Ukonczenia_Szkoly' => $Rok_Ukonczenia_Szkoly
		, 'Nr_swiad_matura' => $Nr_swiad_matura
		, 'data_wystawienia_matura' => $data_wystawienia_matura
		, 'Miejscowosc_wystawienia_matura' => $Miejscowosc_wystawienia_matura
		, 'Nazwa_szkoly' => $Nazwa_szkoly
		, 'id_komisji_okregowej' => $id_komisji_okregowej
		, 'Student_wat' => $Student_wat
		, 'Nr_albumu' => $Nr_albumu
		, 'data_ostatniej_aktualizacji' => $data_ostatniej_aktualizacji
		, 'Uzytkownik_aktualiz_osobowe' => $Uzytkownik_aktualiz_osobowe])) 
		throw new Exception($stmt->error);
	////if ($wynik) echo  mysql_affected_rows().'+[ A ] Rejestracja została zakończona pomyślnie.'; else echo '"<br>"[ FormS2 kdo ] Informacja dla Administratora systemu. W zapisie jest błąd.';
	
	
	//-------------Wyrzucono z KDA zostawiono w KDO  Student_wat i Nr_albumu ------KDA
	$ID_rodzaj_miejscowosci = trim($_SESSION['ID_rodzaj_miejscowosci']);
	$Id_wojewodztwa_meld = trim($_SESSION['Id_wojewodztwa_meld']);
	$Id_zrodla_utrzymania = trim($_SESSION['Id_zrodla_utrzymania']);
	$Kod_pocztowy = trim($_SESSION['Kod_pocztowy']);
	$Kod_pocztowy_meld = trim($_SESSION['Kod_pocztowy_meld']);
	$Miejscowosc = trim($_SESSION['Miejscowosc']);
	$Miejscowosc_JW = trim($_SESSION['Miejscowosc_JW']);
	$Miejscowosc_meld = trim($_SESSION['Miejscowosc_meld']);
	$Nazwa_JW = trim($_SESSION['Nazwa_JW']);
	$Nr_domu = trim($_SESSION['Nr_domu']);
	$Nr_domu_meld = trim($_SESSION['Nr_domu_meld']);
	$Nr_lokalu = trim($_SESSION['Nr_lokalu']);
	$Nr_lokalu_meld = trim($_SESSION['Nr_lokalu_meld']);
	$Nr_telefonu = trim($_SESSION['Nr_telefonu']);
	$Tel_kom = trim($_SESSION['Tel_kom']);
	$Id_wku = trim($_SESSION['Id_wku']);
	$Military_Service_ID = trim($_SESSION['Military_Service_ID']);
	$Ulica = trim($_SESSION['Ulica']);
	$Ulica_JW = trim($_SESSION['Ulica_JW']);
	$NrTel_JW = trim($_SESSION['NrTel_JW']);
	$Ulica_meld = trim($_SESSION['Ulica_meld']);
	$kod_pocz_JW = trim($_SESSION['kod_pocz_JW']);
	
	$data_aktualizacji_adr = date("Y-m-d");
	$Uzytkownik_aktualizacja_adr = 'Internet';

	if (!$UpdateMode) {	//	=> insert = formF2
		$Id_Kandydata=$_SESSION['as_LastID'];
		$Adres_mail = trim($_SESSION['as_email']);
		
		$zapytanie = "INSERT INTO kandydat_dane_adresowe (
				  Id_Kandydata
				, Adres_mail
				, data_aktualizacji_adr
				, Uzytkownik_aktualizacja_adr
			) VALUES (
				  :Id_Kandydata
				, :Adres_mail
				, :data_aktualizacji_adr
				, :Uzytkownik_aktualizacja_adr
			)";
		$stmt = $conn->prepare($zapytanie);
		try{ 
			$stmt->execute(['Id_Kandydata' => $Id_Kandydata
					, 'Adres_mail' => $Adres_mail
					, 'data_aktualizacji_adr' => $data_aktualizacji_adr
					, 'Uzytkownik_aktualizacja_adr' => $Uzytkownik_aktualizacja_adr
				]); 
		} catch(PDOException $e){ die('"<br>"[ FormF2 kda ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e); };
		$asasId_Kandydata = $Id_Kandydata;
	}
	
	$zapytanie = "UPDATE kandydat_dane_adresowe
	SET ID_rodzaj_miejscowosci= :ID_rodzaj_miejscowosci
		, Id_wojewodztwa_meld= :Id_wojewodztwa_meld
		,  Id_zrodla_utrzymania= :Id_zrodla_utrzymania
		,  Kod_pocztowy= :Kod_pocztowy
		,  Kod_pocztowy_meld= :Kod_pocztowy_meld
		,  Miejscowosc= :Miejscowosc
		,  Miejscowosc_JW= :Miejscowosc_JW
		,  Miejscowosc_meld= :Miejscowosc_meld
		,  Nazwa_JW= :Nazwa_JW
		,  Nr_domu= :Nr_domu
		,  Nr_domu_meld= :Nr_domu_meld
		,  Nr_lokalu= :Nr_lokalu
		,  Nr_lokalu_meld= :Nr_lokalu_meld
		,  Nr_telefonu= :Nr_telefonu
		,  Tel_kom= :Tel_kom
		,  Ulica= :Ulica
		,  Ulica_JW= :Ulica_JW
		, NrTel_JW= :NrTel_JW
		,  Ulica_meld= :Ulica_meld
		,  Id_wku= :Id_wku
		,  Military_Service_ID= :Military_Service_ID
		,  kod_pocz_JW= :kod_pocz_JW
	WHERE Id_Kandydata = :Id_Kandydata";
	$stmt = $conn->prepare($zapytanie);
	$stmt->execute(['Id_Kandydata' => $asasId_Kandydata
		, 'ID_rodzaj_miejscowosci' => $ID_rodzaj_miejscowosci
		, 'Id_wojewodztwa_meld' => $Id_wojewodztwa_meld
		, 'Id_zrodla_utrzymania' => $Id_zrodla_utrzymania
		, 'Kod_pocztowy' => $Kod_pocztowy
		, 'Kod_pocztowy_meld' => $Kod_pocztowy_meld
		, 'Miejscowosc' => $Miejscowosc
		, 'Miejscowosc_JW' => $Miejscowosc_JW
		, 'Miejscowosc_meld' => $Miejscowosc_meld
		, 'Nazwa_JW' => $Nazwa_JW
		, 'Nr_domu' => $Nr_domu
		, 'Nr_domu_meld' => $Nr_domu_meld
		, 'Nr_lokalu' => $Nr_lokalu
		, 'Nr_lokalu_meld' => $Nr_lokalu_meld
		, 'Nr_telefonu' => $Nr_telefonu
		, 'Tel_kom' => $Tel_kom
		, 'Ulica' => $Ulica
		, 'Ulica_JW' => $Ulica_JW
		, 'NrTel_JW' => $NrTel_JW
		, 'Ulica_meld' => $Ulica_meld
		, 'Id_wku' => $Id_wku
		, 'Military_Service_ID' => $Military_Service_ID
		, 'kod_pocz_JW' => $kod_pocz_JW
		]);
	////if ($wynik) echo  mysql_affected_rows().'+[ B ] Rejestracja została zakończona pomyślnie.'; else echo '"<br>"[ FormS2 kda ] Informacja dla Administratora systemu. W zapisie jest błąd.';
	
	
	if ($_SESSION['STUDY_DEGREE']=='1') {	// => old formF or formS
		$JezykAngMatura = trim($_SESSION['JezykAngMatura']);
		
		$zapytanie = "UPDATE kandydat_dane_osobowe
			SET JezykAngMatura = :JezykAngMatura
			WHERE username = :username";
		$stmt = $conn->prepare($zapytanie);
		if(!$stmt->execute(['username' => $username
			, 'JezykAngMatura' => $JezykAngMatura
			])) 
			throw new Exception($stmt->error);
		
		//echo "jezyk matura done<br />";
		
		$ID_kier_1_dz_wojskowe = $_SESSION['ID_kier_1_dz_wojskowe'];
		$ID_kier_1_dzienne = $_SESSION['ID_kier_1_dzienne'];
		$ID_kier_1_niestac = $_SESSION['ID_kier_1_niestac'];
		$ID_kier_2_dz_wojskowe = $_SESSION['ID_kier_2_dz_wojskowe'];
		$ID_kier_2_dzienne = $_SESSION['ID_kier_2_dzienne'];
		$ID_kier_2_niestac = $_SESSION['ID_kier_2_niestac'];
		$ID_kier_3_dz_wojskowe = $_SESSION['ID_kier_3_dz_wojskowe'];
		$ID_kier_3_dzienne = $_SESSION['ID_kier_3_dzienne'];
		$ID_kier_3_niestac = $_SESSION['ID_kier_3_niestac'];
		
		$ID_tabeli_wydzialow = NULL;
		$Data_aktualizacji_kierunkow = date("Y-m-d H:i:s");
		$Uzytkownik_kierunkow = 'Internet';
		
		if (!$UpdateMode) {	//	=> insert = formF
			$zapytanie = "INSERT INTO kandydat_kierunki_wybrane_punkty_rankingowe (ID_kandydata)
				VALUES (:ID_kandydata)";
			//echo "sql: $zapytanie<br />";
			//echo "idk: $Id_Kandydata<br />";
			$stmt = $conn->prepare($zapytanie);
			try{ 
				$stmt->execute(['ID_kandydata' => $Id_Kandydata]); 
			} catch(PDOException $e){
				die('"<br>"[ FormF punkty ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e);
			};
		}
		
		$zapytanie = "UPDATE kandydat_kierunki_wybrane_punkty_rankingowe
			SET    ID_kier_1_dzienne = :ID_kier_1_dzienne
				,  ID_kier_1_niestac = :ID_kier_1_niestac
				,  ID_kier_2_dzienne = :ID_kier_2_dzienne
				,  ID_kier_2_niestac = :ID_kier_2_niestac
				,  ID_kier_3_dzienne = :ID_kier_3_dzienne
				,  ID_kier_3_niestac = :ID_kier_3_niestac
				,  Data_aktualizacji_kierunkow = :Data_aktualizacji_kierunkow
				,  Uzytkownik_kierunkow = :Uzytkownik_kierunkow
			WHERE Id_Kandydata = :Id_Kandydata";
		//echo "sql: $zapytanie<br />";
		$stmt = $conn->prepare($zapytanie);
		try{ 
			//echo "idk: $asasId_Kandydata<br />";
			$stmt->execute(['Id_Kandydata' => $asasId_Kandydata
				, 'ID_kier_1_dzienne' => $ID_kier_1_dzienne
				, 'ID_kier_1_niestac' => $ID_kier_1_niestac
				, 'ID_kier_2_dzienne' => $ID_kier_2_dzienne
				, 'ID_kier_2_niestac' => $ID_kier_2_niestac
				, 'ID_kier_3_dzienne' => $ID_kier_3_dzienne
				, 'ID_kier_3_niestac' => $ID_kier_3_niestac
				, 'Data_aktualizacji_kierunkow' => $Data_aktualizacji_kierunkow
				, 'Uzytkownik_kierunkow' => $Uzytkownik_kierunkow
				]);
		} catch(PDOException $e){
			die('"<br>"[ Form punkty ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e);
		};
		
		if ($_SESSION['SSW_Disable']=='N') {
			$zapytanie = "UPDATE kandydat_kierunki_wybrane_punkty_rankingowe
				SET    ID_kier_1_dz_wojskowe = :ID_kier_1_dz_wojskowe
					,  ID_kier_2_dz_wojskowe = :ID_kier_2_dz_wojskowe
					,  ID_kier_3_dz_wojskowe = :ID_kier_3_dz_wojskowe
				WHERE Id_Kandydata = :Id_Kandydata";
			$stmt = $conn->prepare($zapytanie);
			$stmt->execute(['Id_Kandydata' => $asasId_Kandydata
				, 'ID_kier_1_dz_wojskowe' => $ID_kier_1_dz_wojskowe
				, 'ID_kier_2_dz_wojskowe' => $ID_kier_2_dz_wojskowe
				, 'ID_kier_3_dz_wojskowe' => $ID_kier_3_dz_wojskowe
				]);
		}
	}
	
	
	if ($UpdateMode) {	// formS, formS2
		//-------------------LOGIN
		$zapytanie = "UPDATE login SET ile_login=ile_login+1 WHERE username = :username";
		$stmt = $conn->prepare($zapytanie);
		$stmt->execute(['username' => $username]);
		////if ($wynik) echo  mysql_affected_rows().'+[ D ] Rejestracja została zakończona pomyślnie.'; else echo '"<br>"[ FormS2 $ile_login ] Informacja dla Administratora systemu. W zapisie jest błąd.';
	} else {	// insert = formF, formF2
		//-------------------LOGIN
		$zapytanie = "UPDATE login SET ile_login= 2, id_Kandydata= :Id_Kandydata WHERE username = :username";
		$stmt = $conn->prepare($zapytanie);
		try{ 
			$stmt->execute(['username' => $username
					, 'Id_Kandydata' => $Id_Kandydata
				]); 
		} catch(PDOException $e){ die('"<br>"[ FormF2 ile_login ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e); };
	}

	//<!-- przesyłanie danych KONIEC -->

	//-------------------VALIDACJA
	$as_1='We wskazanym polu dopuszczalne są tylko cyfry.';
	$as_err= array();
	if(!ctype_digit($Kod_pocztowy_meld)&& (!empty($Kod_pocztowy_meld))) $as_err[] = "BŁĄD w kodzie pocztowym miejsca zamieszkania. ".$as_1;
	if(!ctype_digit($Kod_pocztowy)&& (!empty($Kod_pocztowy))) $as_err[] = "BŁĄD w kodzie pocztowym. ".$as_1;
	if(!ctype_digit($Rok_Ukonczenia_Szkoly)&& (!empty($Rok_Ukonczenia_Szkoly))) $as_err[] = "BŁĄD w roku uzyskania matury. ".$as_1;
	if(!ctype_digit($Nr_albumu)&& (!empty($Nr_albumu))) $as_err[] = "BŁĄD w nr albumu. ".$as_1;
	if($Nazwisko=='') $as_err[] = "BŁĄD. Bez przesady. NAZWISKO jest wymagane. ";
	if($Imie=='') $as_err[] = "BŁĄD. Brak IMIENIA. ";
	if($data_urodzenia=='') $as_err[] = "BŁĄD. Brak DATY URODZENIA. ";
	if($Miejsce_urodzenia=='') $as_err[] = "BŁĄD. Brak MIEJSCA URODZENIA. ";
	 if ($as_err) {
		 print 'Proszę o usunięcie następujących błędów w ponownym uruchomieniu ANKIETY <ul><li>';
		 print implode('</li><li>', $as_err);
		 print '</li></ul>';
	 } else {print"Nie stwierdzono błędów możliwych do wykrycia przez automat.";}

	//-------------------PRZESYŁANIE DANYCH DO DUMPA

	if ($UpdateMode) {	// formS, formS2
		
		$data_ostatniej_aktualizacji = date("Y-m-d H:m:s");
		$data_wprowadzenia = date("Y-m-d H:m:s");
		$Uzytkownik_aktualiz_osobowe = 'InternetDump';

		opendb("irkdump");
		   $zapytanie = "INSERT INTO kandydat_dane_osobowe (username
				, Nip
				, Nazwisko
				, Imie
				, Imie2
				, Imie_ojca
				, Imie_matki
				, data_urodzenia
				, Miejsce_urodzenia
				, pesel
				, ID_obywatelstwa
				, Rodzaj_studiow
				, data_ostatniej_aktualizacji
				, Student_wat
				, Nr_albumu
				, Uzytkownik_aktualiz_osobowe
				, data_wprowadzenia
				, uzytkownik_wprowadzenia)
		   VALUES (:username
				, :Id_Kandydata
				, :Nazwisko
				, :Imie
				, :Imie2
				, :Imie_ojca
				, :Imie_matki
				, :data_urodzenia
				, :Miejsce_urodzenia
				, :pesel
				, :ID_obywatelstwa
				, :Rodzaj_studiow
				, :data_ostatniej_aktualizacji
				, :Student_wat
				, :Nr_albumu
				, :Uzytkownik_aktualiz_osobowe
				, :data_wprowadzenia
				, :uzytkownik_wprowadzenia)";
		$stmt = $conn->prepare($zapytanie);
		try {
			$stmt->execute(['username' => $username
					, 'Id_Kandydata' => $asasId_Kandydata
					, 'Nazwisko' => $Nazwisko
					, 'Imie' => $Imie
					, 'Imie2' => $Imie2
					, 'Imie_ojca' => $Imie_ojca
					, 'Imie_matki' => $Imie_matki
					, 'data_urodzenia' => $data_urodzenia
					, 'Miejsce_urodzenia' => $Miejsce_urodzenia
					, 'pesel' => $Pesel
					, 'ID_obywatelstwa' => $ID_obywatelstwa
					, 'Rodzaj_studiow' => $Rodzaj_studiow
					, 'Student_wat' => $Student_wat
					, 'Nr_albumu' => $Nr_albumu
					, 'data_ostatniej_aktualizacji' => $data_ostatniej_aktualizacji
					, 'Uzytkownik_aktualiz_osobowe' => $Uzytkownik_aktualiz_osobowe
					, 'data_wprowadzenia' => $data_wprowadzenia
					, 'uzytkownik_wprowadzenia' => $uzytkownik_wprowadzenia
				]);
		} catch(PDOException $e){
			die('"<br>"[ dump KDO ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e);
		};
		////if ($wynik) echo  mysql_affected_rows().'+[ A ] Rejestracja została zakończona pomyślnie.'; else echo '"<br>"[ FormS2 Dump kdo ] Informacja dla Administratora systemu. W zapisie jest błąd.';
		//print $zapytanie;

		$data_aktualizacji_adr = date("Y-m-d H:m:s");
		$Uzytkownik_aktualizacja_adr = 'InternetDump';


		$zapytanie = "INSERT INTO kandydat_dane_adresowe (Id_Kandydata
				, ID_rodzaj_miejscowosci
				, Id_wojewodztwa_meld
				, Id_zrodla_utrzymania
				, Kod_pocztowy
				, Kod_pocztowy_meld
				, Miejscowosc
				, Miejscowosc_JW
				, Miejscowosc_meld
				, Nazwa_JW
				, Nr_domu
				, Nr_domu_meld
				, Nr_lokalu
				, Nr_lokalu_meld
				, Nr_telefonu
				, Tel_kom
				, Ulica
				, Ulica_JW
				, Ulica_meld
				, Id_wku
				, kod_pocz_JW
				, Adres_mail
				, data_aktualizacji_adr
				, Uzytkownik_aktualizacja_adr
			) VALUES (:Id_Kandydata
				, :ID_rodzaj_miejscowosci
				, :Id_wojewodztwa_meld
				, :Id_zrodla_utrzymania
				, :Kod_pocztowy
				, :Kod_pocztowy_meld
				, :Miejscowosc
				, :Miejscowosc_JW
				, :Miejscowosc_meld
				, :Nazwa_JW
				, :Nr_domu
				, :Nr_domu_meld
				, :Nr_lokalu
				, :Nr_lokalu_meld
				, :Nr_telefonu
				, :Tel_kom
				, :Ulica
				, :Ulica_JW
				, :Ulica_meld
				, :Id_wku
				, :kod_pocz_JW
				, :Adres_mail
				, :data_aktualizacji_adr
				, :Uzytkownik_aktualizacja_adr)";
		$stmt = $conn->prepare($zapytanie);
		try {
			$stmt->execute(['Id_Kandydata' => $asasId_Kandydata
					, 'ID_rodzaj_miejscowosci' => $ID_rodzaj_miejscowosci
					, 'Id_wojewodztwa_meld' => $Id_wojewodztwa_meld
					, 'Id_zrodla_utrzymania' => $Id_zrodla_utrzymania
					, 'Kod_pocztowy' => $Kod_pocztowy
					, 'Kod_pocztowy_meld' => $Kod_pocztowy_meld
					, 'Miejscowosc' => $Miejscowosc
					, 'Miejscowosc_JW' => $Miejscowosc_JW
					, 'Miejscowosc_meld' => $Miejscowosc_meld
					, 'Nazwa_JW' => $Nazwa_JW
					, 'Nr_domu' => $Nr_domu
					, 'Nr_domu_meld' => $Nr_domu_meld
					, 'Nr_lokalu' => $Nr_lokalu
					, 'Nr_lokalu_meld' => $Nr_lokalu_meld
					, 'Nr_telefonu' => $Nr_telefonu
					, 'Tel_kom' => $Tel_kom
					, 'Ulica' => $Ulica
					, 'Ulica_JW' => $Ulica_JW
					, 'Ulica_meld' => $Ulica_meld
					, 'Id_wku' => $Id_wku
					, 'kod_pocz_JW' => $kod_pocz_JW
					, 'Adres_mail' => $Adres_mail
					, 'data_aktualizacji_adr' => $data_aktualizacji_adr
					, 'Uzytkownik_aktualizacja_adr' => $Uzytkownik_aktualizacja_adr
				]);
		} catch(PDOException $e){
			die('"<br>"[ dump KDA ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e);
		};
		////if ($wynik) echo  mysql_affected_rows().'+[ B ] Rejestracja została zakończona pomyślnie.'; else echo '"<br>"[ FormS2 Dump kda ] Informacja dla Administratora systemu. W zapisie jest błąd.';
		//print $zapytanie;
		
		if ($_SESSION['STUDY_DEGREE']=='1') {	// formS
			$Data_aktualizacji_kierunkow = date("Y-m-d H:i:s");
			$Uzytkownik_kierunkow = 'InternetDump';
			
			$zapytanie = "INSERT INTO kandydat_kierunki_wybrane_punkty_rankingowe (
					  ID_tabeli_wydzialow
					, ID_kandydata
					, ID_kier_1_dz_wojskowe
					, ID_kier_1_dzienne
					, ID_kier_1_niestac
					, ID_kier_2_dz_wojskowe
					, ID_kier_2_dzienne
					, ID_kier_2_niestac
					, ID_kier_3_dz_wojskowe
					, ID_kier_3_dzienne
					, ID_kier_3_niestac
					, Data_aktualizacji_kierunkow
					, Uzytkownik_kierunkow
				) VALUES (:ID_tabeli_wydzialow
					, :Id_Kandydata
					, :ID_kier_1_dz_wojskowe
					, :ID_kier_1_dzienne
					, :ID_kier_1_niestac
					, :ID_kier_2_dz_wojskowe
					, :ID_kier_2_dzienne
					, :ID_kier_2_niestac
					, :ID_kier_3_dz_wojskowe
					, :ID_kier_3_dzienne
					, :ID_kier_3_niestac
					, :Data_aktualizacji_kierunkow
					, :Uzytkownik_kierunkow)";
			$stmt = $conn->prepare($zapytanie);
			try {
				$stmt->execute(['Id_Kandydata' => $asasId_Kandydata
					, 'ID_tabeli_wydzialow' => $ID_tabeli_wydzialow
					, 'ID_kier_1_dzienne' => $ID_kier_1_dzienne
					, 'ID_kier_1_niestac' => $ID_kier_1_niestac
					, 'ID_kier_2_dzienne' => $ID_kier_2_dzienne
					, 'ID_kier_2_niestac' => $ID_kier_2_niestac
					, 'ID_kier_3_dzienne' => $ID_kier_3_dzienne
					, 'ID_kier_3_niestac' => $ID_kier_3_niestac
					, 'ID_kier_1_dz_wojskowe' => $ID_kier_1_dz_wojskowe
					, 'ID_kier_2_dz_wojskowe' => $ID_kier_2_dz_wojskowe
					, 'ID_kier_3_dz_wojskowe' => $ID_kier_3_dz_wojskowe
					, 'Data_aktualizacji_kierunkow' => $Data_aktualizacji_kierunkow
					, 'Uzytkownik_kierunkow' => $Uzytkownik_kierunkow
					]);
			} catch(PDOException $e){
				die('"<br>"[ dump KKWPR ] Informacja dla Administratora systemu. W zapisie jest błąd. '.$e);
			};
		}
	}
	
	
		opendb();
		$revision_comments = $conn->query("SELECT revision_comments FROM zdjecia WHERE username='$username'")->fetch()[0];
		if ($revision_comments!='Zaakceptowane') {
			echo '<div class="alert alert-info" role="alert">Do podania należy załączyć zdjęcie. Użyj przycisku PRZESŁANIE/PODGLĄD ZDJĘCIA</div>';
		}
	?>
	<p align="center">
		<input value="PRZEJŚCIE DO PRZESŁANIA ZDJĘCIA" class="btn btn-success btn-lg" onclick="self.location.href=('./photoUpload.php')" <?php if ($revision_comments=='Zaakceptowane') { echo ' style="display: none;" '; }  ?> type="button">
		<input value="POWRÓT" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')"  <?php if ($revision_comments!='Zaakceptowane') { echo ' style="display: none;" '; }  ?>  type="button">	
	   <?php if (isset($_SESSION['adminUserName'])) {  ?>
		<input value="POWRÓT" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button">	
	   <?php }  ?>
	</p>
	</form>
<?php }
require_once "footer.php";
?>