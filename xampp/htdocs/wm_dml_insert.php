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

$as_err= array();
$as_info= array();

$username = $_SESSION['username'];
$ID_kandydata = $conn->query("SELECT Id_Kandydata FROM `kandydat_dane_osobowe` WHERE username = '$username'")->fetch()[0];
$pesel = $conn->query("SELECT Pesel FROM `kandydat_dane_osobowe` WHERE username = '$username'")->fetch()[0];
$as2=$ID_kandydata;
$data_ostatniej_aktualiz = date("Y-m-d H:m:s");
$uzytkownik_aktualizacji =  'Internet';
$ID_olimpiady1 = $_POST['ID_olimpiady1'];
$ID_olimpiady2 = $_POST['ID_olimpiady2'];
$ID_olimpiady3 = $_POST['ID_olimpiady3'];
//print ($ID_kandydata); print('<br>'); print ($data_ostatniej_aktualiz); print('<br>'); print ($uzytkownik_aktualizacji); print('<br>'); print ($_POST['asPesel']); print('<br>'); print ($as1); print('<br>'); print ($as2); print('<br>');

//OLIMPIADY

$zapytanie = "INSERT INTO kandydat_olimpiady (username,`ID_kandydata`,`ID_olimpiady1`,`ID_olimpiady2`, `ID_olimpiady3`, `data_ostatniej_aktualiz`, `uzytkownik_aktualizacji`)
	VALUES (:username, :ID_kandydata, :ID_olimpiady1, :ID_olimpiady2, :ID_olimpiady3, :data_ostatniej_aktualiz, :uzytkownik_aktualizacji)";
//print ($zapytanie); print('<br>');
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'username' => $username
		, 'ID_kandydata' => $ID_kandydata
		, 'ID_olimpiady1' => $ID_olimpiady1
		, 'ID_olimpiady2' => $ID_olimpiady2
		, 'ID_olimpiady3' => $ID_olimpiady3
		, 'data_ostatniej_aktualiz' => $data_ostatniej_aktualiz
		, 'uzytkownik_aktualizacji' => $uzytkownik_aktualizacji
	]);
//if ($wynik) echo  mysql_affected_rows().'+[ A ] Rejestracja została zakończona pomyślnie.'; else echo '[ 3 ] Informacja dla Administratora systemu. W zapisie jest błąd.';

//WYNIKI MATURALNE

// ------------------------ 11 Język polski
$ID_przedmiotu = '11';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa11'];
$Wynik_pisemny = $_POST['Wynik_pisemny11'];
$Wynik_ustny = $_POST['Wynik_ustny11'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy11'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony11'];
include "wm_dml_insert_helper.php";

// ------------------------ 6  Język angielski
$ID_przedmiotu = '6';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa6'];
$Wynik_pisemny = $_POST['Wynik_pisemny6'];
$Wynik_ustny = $_POST['Wynik_ustny6'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy6'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony6'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna6'];
include "wm_dml_insert_helper.php";

// ------------------------ 7  Język niemiecki
$ID_przedmiotu = '7';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa7'];
$Wynik_pisemny = $_POST['Wynik_pisemny7'];
$Wynik_ustny = $_POST['Wynik_ustny7'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy7'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony7'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna7'];
include "wm_dml_insert_helper.php";

// ------------------------ 8  Język francuski
$ID_przedmiotu = '8';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa8'];
$Wynik_pisemny = $_POST['Wynik_pisemny8'];
$Wynik_ustny = $_POST['Wynik_ustny8'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy8'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony8'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna8'];
include "wm_dml_insert_helper.php";

// ------------------------ 9  Język rosyjski
$ID_przedmiotu = '9';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa9'];
$Wynik_pisemny = $_POST['Wynik_pisemny9'];
$Wynik_ustny = $_POST['Wynik_ustny9'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy9'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony9'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna9'];
include "wm_dml_insert_helper.php";

// ------------------------ 10 Język - inny nowożytny
$ID_przedmiotu = '10';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa10'];
$Wynik_pisemny = $_POST['Wynik_pisemny10'];
$Wynik_ustny = $_POST['Wynik_ustny10'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy10'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony10'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna10'];
include "wm_dml_insert_helper.php";

// ------------------------ 1  Matematyka
$ID_przedmiotu = '1';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa1'];
$Wynik_pisemny = $_POST['Wynik_pisemny1'];
$Wynik_ustny = $_POST['Wynik_ustny1'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy1'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony1'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna1'];
include "wm_dml_insert_helper.php";

// ------------------------ 2  Fizyka (fizyka z astronomią)
$ID_przedmiotu = '2';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa2'];
$Wynik_pisemny = $_POST['Wynik_pisemny2'];
$Wynik_ustny = $_POST['Wynik_ustny2'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy2'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony2'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna2'];
include "wm_dml_insert_helper.php";

// ------------------------ 5  Historia
$ID_przedmiotu = '5';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa5'];
$Wynik_pisemny = $_POST['Wynik_pisemny5'];
$Wynik_ustny = $_POST['Wynik_ustny5'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy5'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony5'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna5'];
include "wm_dml_insert_helper.php";

// ------------------------ 4  Geografia
$ID_przedmiotu = '4';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa4'];
$Wynik_pisemny = $_POST['Wynik_pisemny4'];
$Wynik_ustny = $_POST['Wynik_ustny4'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy4'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony4'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna4'];
include "wm_dml_insert_helper.php";

// ------------------------ 3  Chemia
$ID_przedmiotu = '3';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa3'];
$Wynik_pisemny = $_POST['Wynik_pisemny3'];
$Wynik_ustny = $_POST['Wynik_ustny3'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy3'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony3'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna3'];
include "wm_dml_insert_helper.php";

// ------------------------ 12  Wiedza o spoleczenstwie
$ID_przedmiotu = '12';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa12'];
$Wynik_pisemny = $_POST['Wynik_pisemny12'];
$Wynik_ustny = $_POST['Wynik_ustny12'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy12'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony12'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna12'];
include "wm_dml_insert_helper.php";

// ------------------------ 13  Biologia
$ID_przedmiotu = '13';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa13'];
$Wynik_pisemny = $_POST['Wynik_pisemny13'];
$Wynik_ustny = $_POST['Wynik_ustny13'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy13'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony13'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna13'];
include "wm_dml_insert_helper.php";

//------------------------ 14  Dodatkowy
$ID_przedmiotu = '14';
$as_info[] = $ID_przedmiotu;
// $Ocena_koncowa = $_POST['Ocena_koncowa14'];
$Wynik_pisemny = $_POST['Wynik_pisemny14'];
$Wynik_ustny = $_POST['Wynik_ustny14'];
$Wynik_podstawowy = $_POST['Wynik_podstawowy14'];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony14'];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna14'];
include "wm_dml_insert_helper.php";


// ------------------------ Uwaga dotycząca błędów
print ('<br>Dane zostały zapisane.<br>W menu możesz ponownie wybrać PRZESŁANIE WYNIKÓW ZE ŚWIADECTWA DOJRZAŁOŚCI, skąd będzie można usunąć dane lub poprawić ewentualne błędy.');
?>
<p align="center"><input value="Powrót" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button"/></p>

<?php require_once "footer.php"; ?>