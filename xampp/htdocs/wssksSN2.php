<?php require_once "header.php"; ?>
<?php checkAccess('#wssks2.php'); ?> 
<?php
$u = $_SESSION['username'];
$uid = $_SESSION['loginid'];
// print($u.'--'.$uid);

$asid_Kandydata = $conn->query("SELECT id_Kandydata FROM login WHERE username = '$u'")->fetch()[0];
$ID_kandydataKKWPR = $conn->query("SELECT ID_tabeli_wydzialow FROM kandydat_kierunki_wybrane_punkty_rankingowe WHERE ID_kandydata=$asid_Kandydata")->fetch()[0];

$ks  = $conn->query("SELECT Nazwa_kierunku FROM ssc2k where Id_kierunku=".$_POST['wybor'])->fetch()[0];
$ksN = $conn->query("SELECT Nazwa_kierunku FROM snc2k where Id_kierunku=".$_POST['wyborN'])->fetch()[0];
//$specj1  = mysql_result(mysql_query("SELECT Nazwa_specjalnosci FROM ssc2kis where Id_specjalnosci=".$_POST[spec1]), 0);
//$specj2  = mysql_result(mysql_query("SELECT Nazwa_specjalnosci FROM ssc2kis where Id_specjalnosci=".$_POST[spec2]), 0);
//$specj3  = mysql_result(mysql_query("SELECT Nazwa_specjalnosci FROM ssc2kis where Id_specjalnosci=".$_POST[spec3]), 0);
//$specj1N  = mysql_result(mysql_query("SELECT Nazwa_specjalnosci FROM snc2kis where Id_specjalnosci=".$_POST[spec1N]), 0);
//$specj2N  = mysql_result(mysql_query("SELECT Nazwa_specjalnosci FROM snc2kis where Id_specjalnosci=".$_POST[spec2N]), 0);
//$specj3N  = mysql_result(mysql_query("SELECT Nazwa_specjalnosci FROM snc2kis where Id_specjalnosci=".$_POST[spec3N]), 0);
opendb();

?>

<h4 align="center">PODGLĄD WYBORÓW DOTYCZĄCYCH KIERUNKÓW</h4>
<div class="container">

  <div class="table-responsive">          
  <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Informacja</th>
        <th>Treść informacji</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>STUDIA STACJONARNE- kierunek</td>
        <td><?php echo $ks ?></td>
      </tr>
      <tr>
        <td>STUDIA NIESTACJONARNE- kierunek</td>
        <td>		
		  <?php echo $ksN ?>
		</td>
      </tr>
    </tbody>
  </table>
  </div>
  
<br>
<p align="center">
<input class="btn btn-success btn-lg" value="POWRÓT" onclick="self.location.href=('./index.php')" type="button">&nbsp;&nbsp;

</div> 

<!--
<?php echo $specj1 ?>
<?php echo $specj2 ?>
<?php echo $specj3 ?>
<?php echo $specj1N ?>
<?php echo $specj2N ?>
<?php echo $specj3N ?>
-->

</tbody> </table> 
<?php
//$sysstud, $ks, $specj1, $specj2, $specj3
//$_Post[wybor] => 17, [spec1] => 69, [spec2] => 70, [spec3] => 71, [sys_stud] => S.
//if (($as1_error<>'') or ($as2_error<>'')) print ($as1_error.$as2_error);
$s1 = $_POST['spec1']; $s2 = $_POST['spec2']; $s3 = $_POST['spec3']; $s1N = $_POST['spec1N']; $s2N = $_POST['spec2N']; $s3N = $_POST['spec3N'];
if (substr($s1,0,1) == 'S') $s1=0;
if (substr($s2,0,1) == 'S') $s2=0;
if (substr($s3,0,1) == 'S') $s3=0;
if (substr($s1N,0,1) == 'N') $s1N=0;
if (substr($s2N,0,1) == 'N') $s2N=0;
if (substr($s3N,0,1) == 'N') $s3N=0;
//-------------------KKWPR

$ID_kier_II_dzienne = $_POST['wybor']; $ID_specjaln_1_dzienne = $s1; $ID_specjaln_2_dzienne = $s2; $ID_specjaln_3_dzienne = $s3;
$ID_kier_II_niestac = $_POST['wyborN']; $ID_specjaln_1_niestac = $s1N; $ID_specjaln_2_niestac = $s2N; $ID_specjaln_3_niestac = $s3N;

$Uzytkownik_kierunkow = 'Internet';
$ID_kandydata = $asid_Kandydata;
//echo '<pre>';print_r ($_POST);echo '</pre>';
//print('|01-'.$ID_kier_II_dzienne. '|02-'.$ID_specjaln_1_dzienne. '|03-'.$ID_specjaln_2_dzienne. '|04-'.$ID_specjaln_3_dzienne. '|05-'.$ID_kier_II_niestac. '|06-'.$ID_specjaln_1_niestac. '|07-'.$ID_specjaln_2_niestac. '|08-'.$ID_specjaln_3_niestac. '|09-'.$_POST[sys_stud]. '|10-'.'|11-'.$Uzytkownik_kierunkow. '|12-'.$ID_tabeli_wydzialow. '|13-'.$ID_kandydata. '|14-'.$uid. '|15-*'.$ID_kandydataKKWPR. '<BR>');
//-------------------------------INSERT czy UPDATE
if ($ID_kandydataKKWPR =='')
{
//-------------------------------INSERT
$zapytanie = "INSERT INTO kandydat_kierunki_wybrane_punkty_rankingowe ( ID_kandydata, ID_kier_II_dzienne, ID_specjaln_1_dzienne, ID_specjaln_2_dzienne, ID_specjaln_3_dzienne, ID_kier_II_niestac, ID_specjaln_1_niestac, ID_specjaln_2_niestac, ID_specjaln_3_niestac, Uzytkownik_kierunkow) VALUES ( :ID_kandydata, :ID_kier_II_dzienne, :ID_specjaln_1_dzienne, :ID_specjaln_2_dzienne, :ID_specjaln_3_dzienne, :ID_kier_II_niestac, :ID_specjaln_1_niestac, :ID_specjaln_2_niestac, :ID_specjaln_3_niestac, :Uzytkownik_kierunkow)";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $ID_kandydata
		, 'ID_kier_II_dzienne' => $ID_kier_II_dzienne
		, 'ID_specjaln_1_dzienne' => $ID_specjaln_1_dzienne
		, 'ID_specjaln_2_dzienne' => $ID_specjaln_2_dzienne
		, 'ID_specjaln_3_dzienne' => $ID_specjaln_3_dzienne
		, 'ID_kier_II_niestac' => $ID_kier_II_niestac
		, 'ID_specjaln_1_niestac' => $ID_specjaln_1_niestac
		, 'ID_specjaln_2_niestac' => $ID_specjaln_2_niestac
		, 'ID_specjaln_3_niestac' => $ID_specjaln_3_niestac
		, 'Uzytkownik_kierunkow' => $Uzytkownik_kierunkow
	]);
//if ($wynik) echo 'Przesyłanie danych na serwer IRK WAT zakończone pomyślnie.'; else echo '"<br>"[ wssksSN2 kkwpr Insert] Nastąpił błąd w przesyle danych. Proszę ponowić czynność po kilku minutach lub skontaktować się z administratorem (patrz stopka).';
}
else
{
//-------------------------------UPDATE
$zapytanie = "UPDATE kandydat_kierunki_wybrane_punkty_rankingowe SET ID_kier_II_dzienne = :ID_kier_II_dzienne, ID_kier_II_niestac = :ID_kier_II_niestac, Uzytkownik_kierunkow = :Uzytkownik_kierunkow, Data_aktualizacji_kierunkow = current_timestamp() WHERE ID_tabeli_wydzialow = :ID_tabeli_wydzialow";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kier_II_dzienne' => $ID_kier_II_dzienne
		, 'ID_kier_II_niestac' => $ID_kier_II_niestac
		, 'Uzytkownik_kierunkow' => $Uzytkownik_kierunkow
		, 'ID_tabeli_wydzialow' => $ID_kandydataKKWPR
	]);
//if ($wynik) echo 'Przesyłanie danych na serwer IRK WAT zakończone pomyślnie.'; else echo '"<br>"[ wssksSN2 kkwpr Update] Nastąpił błąd w przesyle danych. Proszę ponowić czynność po kilku minutach lub skontaktować się z administratorem (patrz stopka).';
opendb("irkDump");
$Uzytkownik_kierunkow = 'InternetDump';
$zapytanie = "INSERT INTO kandydat_kierunki_wybrane_punkty_rankingowe ( ID_kandydata, ID_kier_II_dzienne, ID_specjaln_1_dzienne, ID_specjaln_2_dzienne, ID_specjaln_3_dzienne, ID_kier_II_niestac, ID_specjaln_1_niestac, ID_specjaln_2_niestac, ID_specjaln_3_niestac, Uzytkownik_kierunkow) VALUES ( :ID_kandydata, :ID_kier_II_dzienne, :ID_specjaln_1_dzienne, :ID_specjaln_2_dzienne, :ID_specjaln_3_dzienne, :ID_kier_II_niestac, :ID_specjaln_1_niestac, :ID_specjaln_2_niestac, :ID_specjaln_3_niestac, :Uzytkownik_kierunkow)";
$stmt = $conn->prepare($zapytanie);
$stmt->execute([
		  'ID_kandydata' => $ID_kandydata
		, 'ID_kier_II_dzienne' => $ID_kier_II_dzienne
		, 'ID_specjaln_1_dzienne' => $ID_specjaln_1_dzienne
		, 'ID_specjaln_2_dzienne' => $ID_specjaln_2_dzienne
		, 'ID_specjaln_3_dzienne' => $ID_specjaln_3_dzienne
		, 'ID_kier_II_niestac' => $ID_kier_II_niestac
		, 'ID_specjaln_1_niestac' => $ID_specjaln_1_niestac
		, 'ID_specjaln_2_niestac' => $ID_specjaln_2_niestac
		, 'ID_specjaln_3_niestac' => $ID_specjaln_3_niestac
		, 'Uzytkownik_kierunkow' => $Uzytkownik_kierunkow
	]);
//if ($wynik) echo 'Przesyłanie danych na serwer IRK WAT zakończone pomyślnie.'; else echo '"<br>"[ wssksSN2 kkwpr dump] Nastąpił błąd w przesyle danych. Proszę ponowić czynność po kilku minutach lub skontaktować się z administratorem (patrz stopka).';
}
?>
<?php require_once "footer.php";?>
