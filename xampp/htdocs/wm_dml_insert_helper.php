<?php
$pesel = $as1;
$ID_kandydata=$as2;
$data_aktualizacja = date("Y-m-d H:m:s");
$uzytkownik_aktualizacja = 'Internet';

$Wynik_pisemny = $_POST['Wynik_pisemny'.$ID_przedmiotu];
$Wynik_ustny = $_POST['Wynik_ustny'.$ID_przedmiotu];
$Wynik_podstawowy = $_POST['Wynik_podstawowy'.$ID_przedmiotu];
$Wynik_rozszerzony = $_POST['Wynik_rozszerzony'.$ID_przedmiotu];
$Klasa_dwujezyczna = $_POST['Klasa_dwujezyczna'.$ID_przedmiotu];

$zapytanie = "INSERT INTO kandydat_wyniki_maturalne (username, `ID_kandydata`, `pesel`, `ID_przedmiotu`, `Wynik_pisemny`, `Wynik_ustny`, `Wynik_podstawowy`, `Wynik_rozszerzony`, `Klasa_dwujezyczna`, `data_aktualizacja`, `uzytkownik_aktualizacja`)
VALUES ('".$username."', '".$ID_kandydata."', '".$pesel."', '".$ID_przedmiotu."', '".$Wynik_pisemny."', '".$Wynik_ustny."', '".$Wynik_podstawowy."', '".$Wynik_rozszerzony."', '".$Klasa_dwujezyczna."', '".$data_aktualizacja."', '".$uzytkownik_aktualizacja."')";
//print ($zapytanie); print('<br>');
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'username' => $username
		, 'ID_kandydata' => $ID_kandydata
		, 'pesel' => $pesel
		, 'ID_przedmiotu' => $ID_przedmiotu
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'Wynik_podstawowy' => $Wynik_podstawowy
		, 'Wynik_rozszerzony' => $Wynik_rozszerzony
		, 'Klasa_dwujezyczna' => $Klasa_dwujezyczna
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);
?>
