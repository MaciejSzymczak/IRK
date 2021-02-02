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

//============================================================ UPDATE WPISANIE DO BAZY POPRAWEK Z ANKIETY


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

// ------------------------ 11 Język polski
// $Ocena_koncowa = $_POST['Ocena_koncowa11'];
$Wynik_pisemny = $_POST['Wynik_pisemny11'];
$Wynik_ustny = $_POST['Wynik_ustny11'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy11'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony11'];

$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '11'";
//print_r($zapytanie);
$stmt = $conn->prepare($zapytanie);
if ($stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	])) $as_info[]='Przedmiot 11. Wpisano '.$stmt->rowCount().' rekord. '; else $as_info[]='[11 ] Informacja dla Administratora systemu. W zapisie jest błąd.';

// ------------------------ 6  Język angielski
// $Ocena_koncowa = $_POST['Ocena_koncowa6'];
$Wynik_pisemny = $_POST['Wynik_pisemny6'];
$Wynik_ustny = $_POST['Wynik_ustny6'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy6'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony6'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna6'];

$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '6'";
$stmt = $conn->prepare($zapytanie);
if ($stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	])) $as_info[]='Przedmiot 06. Wpisano '.$stmt->rowCount().' rekord. '; else $as_info[]='[06 ] Informacja dla Administratora systemu. W zapisie jest błąd.';


// ------------------------ 7  Język niemiecki
// $Ocena_koncowa = $_POST['Ocena_koncowa7'];
$Wynik_pisemny = $_POST['Wynik_pisemny7'];
$Wynik_ustny = $_POST['Wynik_ustny7'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy7'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony7'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna7'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '7'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 8  Język francuski
// $Ocena_koncowa = $_POST['Ocena_koncowa8'];
$Wynik_pisemny = $_POST['Wynik_pisemny8'];
$Wynik_ustny = $_POST['Wynik_ustny8'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy8'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony8'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna8'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = '".$Wynik_pisemny."', Wynik_ustny = '".$Wynik_ustny."', Wynik_podstawowy = '".$Wynik_podstawowy."', Wynik_rozszerzony = '".$Wynik_rozszerzony."', Klasa_dwujezyczna = '".$Klasa_dwujezyczna."', data_aktualizacja = '".$data_aktualizacja."', uzytkownik_aktualizacja = '".$uzytkownik_aktualizacja."'
WHERE Id_Kandydata = $asID_kandydata AND ID_przedmiotu = '8'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 9  Język rosyjski
// $Ocena_koncowa = $_POST['Ocena_koncowa9'];
$Wynik_pisemny = $_POST['Wynik_pisemny9'];
$Wynik_ustny = $_POST['Wynik_ustny9'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy9'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony9'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna9'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '9'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 10 Język - inny nowożytny
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa10'];
$Wynik_pisemny = $_POST['Wynik_pisemny10'];
$Wynik_ustny = $_POST['Wynik_ustny10'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy10'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony10'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna10'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '10'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 1  Matematyka
// $Ocena_koncowa = $_POST['Ocena_koncowa1'];
$Wynik_pisemny = $_POST['Wynik_pisemny1'];
$Wynik_ustny = $_POST['Wynik_ustny1'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy1'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony1'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna1'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '1'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 2  Fizyka (fizyka z astronomią)
// $Ocena_koncowa = $_POST['Ocena_koncowa2'];
$Wynik_pisemny = $_POST['Wynik_pisemny2'];
$Wynik_ustny = $_POST['Wynik_ustny2'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy2'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony2'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna2'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '2'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 5  Historia
// $Ocena_koncowa = $_POST['Ocena_koncowa5'];
$Wynik_pisemny = $_POST['Wynik_pisemny5'];
$Wynik_ustny = $_POST['Wynik_ustny5'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy5'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony5'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna5'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '5'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 4  Geografia
// $Ocena_koncowa = $_POST['Ocena_koncowa4'];
$Wynik_pisemny = $_POST['Wynik_pisemny4'];
$Wynik_ustny = $_POST['Wynik_ustny4'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy4'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony4'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna4'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '4'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 3  Chemia
// $Ocena_koncowa = $_POST['Ocena_koncowa3'];
$Wynik_pisemny = $_POST['Wynik_pisemny3'];
$Wynik_ustny = $_POST['Wynik_ustny3'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy3'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony3'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna3'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '3'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 12   Wiedza o spoleczenstwie
// $Ocena_koncowa = $_POST['Ocena_koncowa12'];
$Wynik_pisemny = $_POST['Wynik_pisemny12'];
$Wynik_ustny = $_POST['Wynik_ustny12'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy12'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony12'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna12'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '12'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ 13  Biologia
// $Ocena_koncowa = $_POST['Ocena_koncowa13'];
$Wynik_pisemny = $_POST['Wynik_pisemny13'];
$Wynik_ustny = $_POST['Wynik_ustny13'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy13'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony13'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna13'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = '".$Wynik_pisemny."', Wynik_ustny = '".$Wynik_ustny."', Wynik_podstawowy = '".$Wynik_podstawowy."', Wynik_rozszerzony = '".$Wynik_rozszerzony."', Klasa_dwujezyczna = '".$Klasa_dwujezyczna."', data_aktualizacja = '".$data_aktualizacja."', uzytkownik_aktualizacja = '".$uzytkownik_aktualizacja."'
WHERE Id_Kandydata = $asID_kandydata AND ID_przedmiotu = '13'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

//------------------------ 14  Dodatkowy
// $Ocena_koncowa = $_POST['Ocena_koncowa14'];
$Wynik_pisemny = $_POST['Wynik_pisemny14'];
$Wynik_ustny = $_POST['Wynik_ustny14'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy14'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony14'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna14'];
$zapytanie = "UPDATE kandydat_wyniki_maturalne SET Wynik_pisemny = :Wynik_pisemny, Wynik_ustny = :Wynik_ustny, Wynik_podstawowy = :Wynik_podstawowy, Wynik_rozszerzony = :Wynik_rozszerzony, Klasa_dwujezyczna = :Klasa_dwujezyczna, data_aktualizacja = :data_aktualizacja, uzytkownik_aktualizacja = :uzytkownik_aktualizacja
WHERE Id_Kandydata = :ID_kandydata AND ID_przedmiotu = '14'";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $asID_kandydata
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);

// ------------------------ podsumowanie UPDATE
//print('$_SERVER'); print_r($_SERVER);
//print('<br>'.'*mw_newSD'.'<br>');print_r($_POST);print('<br>'.'mw_newSD*'.'<br>');
//print('<br>'.'$as_info'); print_r($as_info);print('<br>');

//============================================================ INSERT WPISANIE DO BAZY DUMPA
$pesel = $as1;$ID_kandydata=$_POST['asID_kandydata'];$data_aktualizacja = date("Y-m-d H:m:s");$uzytkownik_aktualizacja = 'InternetDump';
//-------------------------------------PRZESYŁANIE DANYCH DO DUMPA
opendb("irkDump");
// ------------------------ 11 Język polski
$ID_przedmiotu = '11';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa11'];
$Wynik_pisemny = $_POST['Wynik_pisemny11'];
$Wynik_ustny = $_POST['Wynik_ustny11'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy11'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony11'];
include "wm_dml_update_helper1.php";

// ------------------------ 6  Język angielski
$ID_przedmiotu = '6';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa6'];
$Wynik_pisemny = $_POST['Wynik_pisemny6'];
$Wynik_ustny = $_POST['Wynik_ustny6'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy6'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony6'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna6'];
include "wm_dml_update_helper2.php";

// ------------------------ 7  Język niemiecki
$ID_przedmiotu = '7';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa7'];
$Wynik_pisemny = $_POST['Wynik_pisemny7'];
$Wynik_ustny = $_POST['Wynik_ustny7'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy7'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony7'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna7'];
include "wm_dml_update_helper2.php";

// ------------------------ 8  Język francuski
$ID_przedmiotu = '8';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa8'];
$Wynik_pisemny = $_POST['Wynik_pisemny8'];
$Wynik_ustny = $_POST['Wynik_ustny8'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy8'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony8'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna8'];
include "wm_dml_update_helper2.php";

// ------------------------ 9  Język rosyjski
$ID_przedmiotu = '9';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa9'];
$Wynik_pisemny = $_POST['Wynik_pisemny9'];
$Wynik_ustny = $_POST['Wynik_ustny9'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy9'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony9'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna9'];
include "wm_dml_update_helper2.php";

// ------------------------ 10 Język - inny nowożytny
$ID_przedmiotu = '10';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa10'];
$Wynik_pisemny = $_POST['Wynik_pisemny10'];
$Wynik_ustny = $_POST['Wynik_ustny10'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy10'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony10'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna10'];
include "wm_dml_update_helper2.php";

// ------------------------ 1  Matematyka
$ID_przedmiotu = '1';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa1'];
$Wynik_pisemny = $_POST['Wynik_pisemny1'];
$Wynik_ustny = $_POST['Wynik_ustny1'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy1'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony1'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna1'];
include "wm_dml_update_helper3.php";

// ------------------------ 2  Fizyka (fizyka z astronomią)
$ID_przedmiotu = '2';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa2'];
$Wynik_pisemny = $_POST['Wynik_pisemny2'];
$Wynik_ustny = $_POST['Wynik_ustny2'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy2'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony2'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna2'];
include "wm_dml_update_helper3.php";

// ------------------------ 5  Historia
$ID_przedmiotu = '5';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa5'];
$Wynik_pisemny = $_POST['Wynik_pisemny5'];
$Wynik_ustny = $_POST['Wynik_ustny5'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy5'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony5'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna5'];
include "wm_dml_update_helper3.php";

// ------------------------ 4  Geografia
$ID_przedmiotu = '4';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa4'];
$Wynik_pisemny = $_POST['Wynik_pisemny4'];
$Wynik_ustny = $_POST['Wynik_ustny4'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy4'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony4'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna4'];
include "wm_dml_update_helper3.php";

// ------------------------ 3  Chemia
$ID_przedmiotu = '3';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa3'];
$Wynik_pisemny = $_POST['Wynik_pisemny3'];
$Wynik_ustny = $_POST['Wynik_ustny3'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy3'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony3'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna3'];
include "wm_dml_update_helper3.php";

// ------------------------ 12  Wiedza o spoleczenstwie
$ID_przedmiotu = '12';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa12'];
$Wynik_pisemny = $_POST['Wynik_pisemny12'];
$Wynik_ustny = $_POST['Wynik_ustny12'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy12'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony12'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna12'];
include "wm_dml_update_helper3.php";

// ------------------------ 13  Biologia
$ID_przedmiotu = '13';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa13'];
$Wynik_pisemny = $_POST['Wynik_pisemny13'];
$Wynik_ustny = $_POST['Wynik_ustny13'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy13'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony13'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna13'];
include "wm_dml_update_helper3.php";

//------------------------ 14  Dodatkowy
$ID_przedmiotu = '14';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa14'];
$Wynik_pisemny = $_POST['Wynik_pisemny14'];
$Wynik_ustny = $_POST['Wynik_ustny14'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy14'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony14'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna14'];
include "wm_dml_update_helper3.php";

// ------------------------ Uwaga dotycząca błędów
print ('<br>Dane zostały zapisane.<br>');
//print('<br>'); print_r($as_info); print('<br>');
?>
<p align="center"><input value="Powrót" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button"/></p>;
<hr style="width: 80%; height: 0px;">

<?php require_once "footer.php"; ?>
