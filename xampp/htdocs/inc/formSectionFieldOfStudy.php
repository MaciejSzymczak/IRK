<?php

$ID_kier_1_niestac = '';
try{ 
	$arr_B = $conn->query("SELECT * FROM snc1k ORDER BY Nazwa_kierunku ASC")->fetchAll(); 
} catch(PDOException $e){ 
	die("Zapytanie niepoprawne"); 
};
for ($i = 0; $i <= count($arr_B)-1; $i++) {
	$ID_kier_1_niestac = $ID_kier_1_niestac . '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
}

$ID_kier_1_dzienne = '';
try{ 
	$arr_B = $conn->query("SELECT * FROM ssc1k ORDER BY Nazwa_kierunku ASC")->fetchAll(); 
} catch(PDOException $e){ 
	die("Zapytanie niepoprawne"); 
};
for ($i = 0; $i <= count($arr_B)-1; $i++) {
	$ID_kier_1_dzienne = $ID_kier_1_dzienne . '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
}


$ID_kier_1_dz_wojskowe = '';
try{ 
	$arr_B = $conn->query("SELECT * FROM ssw1k ORDER BY Nazwa_kierunku ASC")->fetchAll(); 
} catch(PDOException $e){ 
	die("Zapytanie niepoprawne"); 
};
for ($i = 0; $i <= count($arr_B)-1; $i++) {
	$ID_kier_1_dz_wojskowe = $ID_kier_1_dz_wojskowe . '<option value="'.$arr_B[$i]['Id_kierunku'].'">'.$arr_B[$i]['Nazwa_kierunku'].'</option>';
}	
?>

  <div class="row well">
    <div class="col-sm-3">
		<table>
			<tr>
				<td>
					<h4 <?php if ($_SESSION['SSW_Disable']=='Y') {  echo 'style="color: #dddddd;"'; }  ?> >studia stacjonarne "wojskowe"</h4>
					<select size="1" name="ID_kier_1_dz_wojskowe" <?php if ($_SESSION['SSW_Disable']=='Y') {  echo 'style="color: #dddddd;" disabled'; }  ?> >
						<?php echo $ID_kier_1_dz_wojskowe; ?>	
					</select>    
					<?php if (!empty($asR['ID_kier_1_dz_wojskowe'])) { echo  '<script>document.getElementsByName("ID_kier_1_dz_wojskowe")[0].value="'.$asR['ID_kier_1_dz_wojskowe'].'";</script>'; } ?>
					<select size="1" name="ID_kier_2_dz_wojskowe" <?php if ($_SESSION['SSW_Disable']=='Y') {  echo 'style="color: #dddddd;" disabled'; }  ?> >
						<?php echo $ID_kier_1_dz_wojskowe; ?>	
					</select>
					<?php if (!empty($asR['ID_kier_2_dz_wojskowe'])) { echo  '<script>document.getElementsByName("ID_kier_2_dz_wojskowe")[0].value="'.$asR['ID_kier_2_dz_wojskowe'].'";</script>'; } ?>
					<select size="1" name="ID_kier_3_dz_wojskowe" <?php if ($_SESSION['SSW_Disable']=='Y') {  echo 'style="color: #dddddd;" disabled'; }  ?> >
						<?php echo $ID_kier_1_dz_wojskowe; ?>	
					</select>
					<?php if (!empty($asR['ID_kier_3_dz_wojskowe'])) { echo  '<script>document.getElementsByName("ID_kier_3_dz_wojskowe")[0].value="'.$asR['ID_kier_3_dz_wojskowe'].'";</script>'; } ?>
				</td>
				<td>
					<br/>&nbsp;&nbsp;&nbsp;lub
				</td>
			</tr>
		</table>
	</div>
    <div class="col-sm-1">
	</div>
    <div class="col-sm-4">
		<table>
			<tr>
				<td>
					<h4>studia stacjonarne "cywilne"</h4>
					<select size="1" name="ID_kier_1_dzienne">
						<?php echo $ID_kier_1_dzienne; ?>	
					</select>
					<?php if (!empty($asR['ID_kier_1_dzienne'])) { echo  '<script>document.getElementsByName("ID_kier_1_dzienne")[0].value="'.$asR['ID_kier_1_dzienne'].'";</script>'; } ?>
					<select size="1" name="ID_kier_2_dzienne">
						<?php echo $ID_kier_1_dzienne; ?>	
					</select>
					<?php if (!empty($asR['ID_kier_2_dzienne'])) { echo  '<script>document.getElementsByName("ID_kier_2_dzienne")[0].value="'.$asR['ID_kier_2_dzienne'].'";</script>'; } ?>
					<select size="1" name="ID_kier_3_dzienne">
						<?php echo $ID_kier_1_dzienne; ?>	
					</select>
					<?php if (!empty($asR['ID_kier_3_dzienne'])) { echo  '<script>document.getElementsByName("ID_kier_3_dzienne")[0].value="'.$asR['ID_kier_3_dzienne'].'";</script>'; } ?>
				</td>
				<td>
					<br/>&nbsp;&nbsp;&nbsp;lub
				</td>
			</tr>
		</table>
    </div>
    <div class="col-sm-1">
	</div>
    <div class="col-sm-3">
    	<h4>studia niestacjonarne "cywilne"</h4>
        <select size="1" name="ID_kier_1_niestac">
			<?php echo $ID_kier_1_niestac; ?>	
        </select>
        <?php if (!empty($asR['ID_kier_1_niestac'])) { echo  '<script>document.getElementsByName("ID_kier_1_niestac")[0].value="'.$asR['ID_kier_1_niestac'].'";</script>'; } ?>
        <select size="1" name="ID_kier_2_niestac">
			<?php echo $ID_kier_1_niestac; ?>	
        </select>
        <?php if (!empty($asR['ID_kier_2_niestac'])) { echo  '<script>document.getElementsByName("ID_kier_2_niestac")[0].value="'.$asR['ID_kier_2_niestac'].'";</script>'; } ?>
		<select size="1" name="ID_kier_3_niestac">
			<?php echo $ID_kier_1_niestac; ?>	
		  </select>
        <?php if (!empty($asR['ID_kier_3_niestac'])) { echo  '<script>document.getElementsByName("ID_kier_3_niestac")[0].value="'.$asR['ID_kier_3_niestac'].'";</script>'; } ?>
    </div>
  </div>  