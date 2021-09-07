<?php
require_once "header.php";

if (!isLoggedIn() == true) {
	 echo '<div class="alert alert-danger" role="alert">
			  <strong>Och!</strong> Musisz się zalogować, by móc używać tej Aplikacji.
			</div>';
	 echo '<p align="center"><button type="button" class="btn btn-success btn-lg" onclick="self.location.href=(\'./index.php\');"> Powrót</button></p>';
	 require_once "footer.php";
	 exit();
}

$as1=$_POST['asPesel'];
$asID_kandydata =$_POST['asID_kandydata'];
$data_aktualizacja = date("Y-m-d H:m:s");
$uzytkownik_aktualizacja = 'Internet';

//-------------------------------------PRZESYŁANIE DANYCH

$ID_olimpiady1 = $_POST['ID_olimpiady1'];
$ID_olimpiady2 = $_POST['ID_olimpiady2'];
$ID_olimpiady3 = $_POST['ID_olimpiady3'];

//OLIMPIADY

$zapytanie = "UPDATE kandydat_olimpiady  set ID_olimpiady1=:ID_olimpiady1, ID_olimpiady2=:ID_olimpiady2, ID_olimpiady3=:ID_olimpiady3, data_ostatniej_aktualiz=:data_aktualizacja, uzytkownik_aktualizacji=:uzytkownik_aktualizacja  where ID_kandydata= :ID_kandydata";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'ID_olimpiady1' => $ID_olimpiady1
		, 'ID_olimpiady2' => $ID_olimpiady2
		, 'ID_olimpiady3' => $ID_olimpiady3
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);



function UPDATE_KWM($ID_przedmiotu ){
	global $asID_kandydata;
	global $data_aktualizacja;
	global $uzytkownik_aktualizacja;
	global $conn;
	$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
	WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = :ID_przedmiotu";
	$stmt = $conn->prepare($zapytanie);
	if ($stmt->execute([
			  'ID_kandydata' => $asID_kandydata
			, 'Wynik_pisemny' => $_POST['Wynik_pisemny'.$ID_przedmiotu]
			, 'Wynik_ustny' => $_POST['Wynik_ustny'.$ID_przedmiotu]
			, 'Wynik_podstawowy' => $_POST['Wynik_podstawowy'.$ID_przedmiotu]
			, 'Wynik_rozszerzony' => $_POST['Wynik_rozszerzony'.$ID_przedmiotu]
			, 'Klasa_dwujezyczna' => $_POST['Klasa_dwujezyczna'.$ID_przedmiotu]
			, 'data_aktualizacja' => $data_aktualizacja
			, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
			, 'ID_przedmiotu' => $ID_przedmiotu
		])) 
		$as_info[]='Przedmiot 06. Wpisano '.$stmt->rowCount().' rekord. '; 
	else 
		$as_info[]='[06 ] Informacja dla Administratora systemu. W zapisie jest błąd.';
}

// ------------------------ Język polski
UPDATE_KWM('11');
// ------------------------ Język angielski
UPDATE_KWM('6');
// ------------------------ Język niemiecki
UPDATE_KWM('7');
// ------------------------ Język francuski
UPDATE_KWM('8');
// ------------------------ Język rosyjski
UPDATE_KWM('9');
// ------------------------ Język - inny nowożytny
UPDATE_KWM('10');
// ------------------------ Matematyka
UPDATE_KWM('1');
// ------------------------ Fizyka (fizyka z astronomią)
UPDATE_KWM('2');
// ------------------------ Historia
UPDATE_KWM('5');
// ------------------------ Geografia
UPDATE_KWM('4');
// ------------------------ Chemia
UPDATE_KWM('3');
// ------------------------ Wiedza o spoleczenstwie
UPDATE_KWM('12');
// ------------------------ Biologia
UPDATE_KWM('13');
//------------------------  Dodatkowy
UPDATE_KWM('14');

//============================================================ INSERT WPISANIE DO BAZY DUMPA
$pesel = $as1;$ID_kandydata=$_POST['asID_kandydata'];$data_aktualizacja = date("Y-m-d H:m:s");$uzytkownik_aktualizacja = 'InternetDump';
//-------------------------------------PRZESYŁANIE DANYCH DO DUMPA
opendb("irkDump");
// ------------------------ 11 Język polski
$ID_przedmiotu = '11';
include "wm_dml_insert_helper.php";

// ------------------------ 6  Język angielski
$ID_przedmiotu = '6';
include "wm_dml_insert_helper.php";

// ------------------------ 7  Język niemiecki
$ID_przedmiotu = '7';
include "wm_dml_insert_helper.php";

// ------------------------ 8  Język francuski
$ID_przedmiotu = '8';
include "wm_dml_insert_helper.php";

// ------------------------ 9  Język rosyjski
$ID_przedmiotu = '9';
include "wm_dml_insert_helper.php";

// ------------------------ 10 Język - inny nowożytny
$ID_przedmiotu = '10';
include "wm_dml_insert_helper.php";

// ------------------------ 1  Matematyka
$ID_przedmiotu = '1';
include "wm_dml_insert_helper.php";

// ------------------------ 2  Fizyka (fizyka z astronomią)
$ID_przedmiotu = '2';
include "wm_dml_insert_helper.php";

// ------------------------ 5  Historia
$ID_przedmiotu = '5';
include "wm_dml_insert_helper.php";

// ------------------------ 4  Geografia
$ID_przedmiotu = '4';
include "wm_dml_insert_helper.php";

// ------------------------ 3  Chemia
$ID_przedmiotu = '3';
include "wm_dml_insert_helper.php";

// ------------------------ 12  Wiedza o spoleczenstwie
$ID_przedmiotu = '12';
include "wm_dml_insert_helper.php";

// ------------------------ 13  Biologia
$ID_przedmiotu = '13';
include "wm_dml_insert_helper.php";

//------------------------ 14  Dodatkowy
$ID_przedmiotu = '14';
include "wm_dml_insert_helper.php";

// Refresh kandydat_dane_osobowe.wynikiMaturalne
include "wm_refresh_flag.php";

// ------------------------ Uwaga dotycząca błędów
print ('<br>Dane zostały zapisane.<br>');
//print('<br>'); print_r($as_info); print('<br>');
?>
<p align="center"><input value="Powrót" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button"/></p>;
<hr style="width: 80%; height: 0px;">

<?php require_once "footer.php"; ?>
