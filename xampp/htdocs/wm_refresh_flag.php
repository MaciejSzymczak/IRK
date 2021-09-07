<?php

opendb();
$username = $_SESSION['username'];
$validRows = $conn->query("
		select count(1) 
		from kandydat_wyniki_maturalne
		 where username = '$username'
		   and 
		   (  IFNULL(Wynik_pisemny,0) != 0 
		   or IFNULL(Wynik_ustny,0) != 0 
		   or IFNULL(Wynik_podstawowy,0) != 0 
		   or IFNULL(Wynik_rozszerzony,0) != 0 
		   or IFNULL(Klasa_dwujezyczna,0) != 0
		   )
	")->fetch()[0];

if ($validRows >0) {
	$result = 'TAK';
} else {
	$result = 'BRAK';		
}

$zapytanie = "
		update kandydat_dane_osobowe
		   set wynikiMaturalne = :result
		   where username = :username
			 and wynikiMaturalne <> :result	
	";
$stmt = $conn->prepare($zapytanie);
try{
	$stmt->execute([
		  'username' => $username
		, 'result' => $result
		]); 
} 
catch(PDOException $e){ 
	die('Błąd update kandydat_dane_osobowe: '.$e); 
};

?>