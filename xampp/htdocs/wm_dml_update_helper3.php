<?php
$zapytanie = "INSERT INTO kandydat_wyniki_maturalne (username, `ID_kandydata`, `pesel`, `ID_przedmiotu`, `Wynik_pisemny`, `Wynik_ustny`, `data_aktualizacja`, `uzytkownik_aktualizacja`)
VALUES (:username, :ID_kandydata, :pesel, :ID_przedmiotu, :Wynik_pisemny, :Wynik_ustny, :data_aktualizacja, :uzytkownik_aktualizacja)";
//print ($zapytanie); print('<br>');
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'username' => $username
		, 'ID_kandydata' => $ID_kandydata
		, 'pesel' => $pesel
		, 'ID_przedmiotu' => $ID_przedmiotu
		, 'Wynik_pisemny' => $Wynik_pisemny
		, 'Wynik_ustny' => $Wynik_ustny
		, 'data_aktualizacja' => $data_aktualizacja
		, 'uzytkownik_aktualizacja' => $uzytkownik_aktualizacja
	]);
//if ($wynik) echo  mysql_affected_rows().'+[ A ] Rejestracja została zakończona pomyślnie.'; else echo '[ 3 ] Informacja dla Administratora systemu. W zapisie jest błąd.';
?>
