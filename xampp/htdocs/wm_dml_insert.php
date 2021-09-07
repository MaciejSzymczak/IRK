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
print ('<br>Dane zostały zapisane.<br>Możesz ponownie wybrać polecenie PRZESŁANIE WYNIKÓW ZE ŚWIADECTWA DOJRZAŁOŚCI aby poprawić ewentualne błędy.');
?>
<p align="center"><input value="Powrót" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button"/></p>

<?php require_once "footer.php"; ?>