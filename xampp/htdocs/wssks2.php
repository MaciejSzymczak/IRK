<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php
$u = $_SESSION['username']; $uid = $_SESSION['loginid'];
$record = $conn->query("SELECT ID_kier_II_dzienne,ID_kier_II_niestac FROM kandydat_kierunki_wybrane_punkty_rankingowe WHERE ID_kandydata in (SELECT id_Kandydata FROM login WHERE username = '$u')")->fetch();
$ID_kier_II_dzienne = $record['ID_kier_II_dzienne'];
$ID_kier_II_niestac = $record['ID_kier_II_niestac'];

?>
 
<table style="width: 80%; text-align: left; margin-left: auto; margin-right: auto;" border="0" cellpadding="2" cellspacing="2"><tbody><tr><td></td></tr><tr><td>
<form action="wssksSN2.php" method="post"><div style="text-align: center;"> </div><br>
<p style="color: rgb(51, 153, 153); text-align: center;"><big>WYBÓR KIERUNKU STUDIÓW CYWILNYCH DRUGIEGO STOPNIA</big></p><br>
<p style="font-weight: bold; text-align: center; color: rgb(0, 0, 0);"><span style="font-weight: bold;"><span style="color: rgb(255, 0, 0);">STUDIA STACJONARNE</span>&nbsp;</span></p>
<p style="text-align: center;"><span style="color: rgb(0, 0, 0);">Proszę dokonać wyboru kierunku</span></p>

<div style="text-align: center;">
<!-- NOTE! Selection of speciality was disabled. If you need enable it, replace disabled_onchange with onchange  -->
<select id="wybor" name="wybor" disabled_onchange="pokaz( this.value )">
	<?php
	//generate <option value="2">budownictwo</option>
	$stmt = $conn->prepare("SELECT * FROM ssc2k ORDER BY Nazwa_kierunku ASC");
	try{ $stmt->execute(); }
		catch(PDOException $e){ die('Zapytanie niepoprawne'); };
	$arr_B = $stmt->fetchAll();
	for ($i = 0; $i <= count($arr_B)-1; $i++) {
		echo '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
	}
	?>	
</select>
<?php if (!empty($ID_kier_II_dzienne)) { echo  '<script>document.getElementsByName("wybor")[0].value="'.$ID_kier_II_dzienne.'";</script>'; } ?>
</div><br>

<div style="text-align: center;" id="dodatkowe_pola1"></div>
<div style="text-align: center;" id="dodatkowe_pola2"></div>
<div style="text-align: center;" id="dodatkowe_pola3"></div>
<br><br><br>
<p style="font-weight: bold; text-align: center; color: rgb(0, 0, 0);"><span style="font-weight: bold;"><span style="color: rgb(255, 0, 0);">STUDIA NIESTACJONARNE</span>&nbsp;</span></p>
<p style="text-align: center;"><span style="color: rgb(0, 0, 0);">Proszę dokonać wyboru kierunku</span></p>
<small><span style="color: rgb(51, 153, 153);"><span style="font-weight: bold;"></span></span></small>

<div style="text-align: center;">
<!-- NOTE! Selection of speciality was disabled. If you need enable it, replace disabled_onchange with onchange  -->
<select id="wybor" name="wyborN" disabled_onchange="pokazN( this.value )">
	<?php
	//generate <option value="2">budownictwo</option>
	$stmt = $conn->prepare("SELECT * FROM snc2k ORDER BY Nazwa_kierunku ASC");
	try{ $stmt->execute(); }
		catch(PDOException $e){ die('Zapytanie niepoprawne'); };
	$arr_B = $stmt->fetchAll();
	for ($i = 0; $i <= count($arr_B)-1; $i++) {
		echo '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
	}
	?>		
</select>
<?php if (!empty($ID_kier_II_niestac)) { echo  '<script>document.getElementsByName("wyborN")[0].value="'.$ID_kier_II_niestac.'";</script>'; } ?>
</div><br>

<div style="text-align: center;" id="dodatkowe_pola1N"></div>
<div style="text-align: center;" id="dodatkowe_pola2N"></div>
<div style="text-align: center;" id="dodatkowe_pola3N"></div>
<br><br><br><br>
<input type="hidden" name="sys_stud" value="S" />
<div style="text-align: center;">
<input value="Dalej" class="btn btn-success btn-lg" type="submit">
<input value="Anuluj" class="btn btn-success btn-lg" onclick="self.location.href=('./index.php')" type="button"></p>
</div>
</form>

</td></tr><tr><td></td></tr></tbody></table><hr style="height: 1px; width: 70%;" noshade="noshade"><br>
<?php require_once "footer.php"; ?>

