<script type="text/javascript" >
var errCnt = 0;
function validatePostalCode(currentItem)
{
	var itemValue = currentItem.value;
	//digits only
	var reg = /^\d+$/;
	
	if (itemValue.length==0) itemValue="00000";
	if (!(reg.test(itemValue) && itemValue.length == 5)) {  
		if (currentItem.style.backgroundColor == "white" || currentItem.style.backgroundColor =="") errCnt++;
		currentItem.style.backgroundColor = "pink";
	}
	else {
		if (currentItem.style.backgroundColor == "pink") errCnt--;
		currentItem.style.backgroundColor = "white";
	}
	//console.info(errCnt);
	document.getElementById("SubmitForm").disabled = errCnt!=0;
}

function validateTT()
{
	var foundflag = false;
	var radios = document.getElementsByName('ID_rodzaj_miejscowosci');
	for (var i = 0, length = radios.length; i < length; i++)
	{
	 if (radios[i].checked)
	 {
	  //alert(radios[i].value);
	  foundflag = true;
	  break;
	 }
	}	
	
    LabelID_rodzaj_miejscowosci = document.getElementById('LabelID_rodzaj_miejscowosci');
	
		if (!foundflag) {  
			if (LabelID_rodzaj_miejscowosci.style.backgroundColor == "white" || LabelID_rodzaj_miejscowosci.style.backgroundColor =="") errCnt++;
			LabelID_rodzaj_miejscowosci.style.backgroundColor = "pink";
		}
		else {
			if (LabelID_rodzaj_miejscowosci.style.backgroundColor == "pink") errCnt--;
			LabelID_rodzaj_miejscowosci.style.backgroundColor = "white";
		}
	
	document.getElementById("SubmitForm").disabled = errCnt!=0;

}
</script>	
  <div class="panel panel-default">
    <div class="panel-heading">ADRES ZAMIESZKANIA
	</div>
	<div class="panel-body">	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Kod_pocztowy_meld">Kod pocztowy</label>
			<div class="col-sm-8">
			<input name="Kod_pocztowy_meld" value="<?php echo $asR['Kod_pocztowy_meld']?>" maxlength="5" placeholder="Kod pocztowy bez myślnika np. 01234" size="65" onkeyup="validatePostalCode(this)" type="text">
			</div>
		</div>					
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Miejscowosc_meld">Miejscowość</label>
			<div class="col-sm-8">
			<input name="Miejscowosc_meld" value="<?php echo $asR['Miejscowosc_meld']?>" maxlength="35" placeholder="Miejscowość zamieszkania" size="65" type="text">
			</div>
		</div>
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Ulica_meld">Ulica</label>
			<div class="col-sm-8">
			<input name="Ulica_meld" value="<?php echo $asR['Ulica_meld']?>" maxlength="25" size="65" type="text">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nr_domu_meld">Nr domu</label>
			<div class="col-sm-8">
			<input name="Nr_domu_meld" value="<?php echo $asR['Nr_domu_meld']?>" maxlength="9" size="65" type="text">
			</div>
		</div>
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nr_lokalu_meld">Nr lokalu</label>
			<div class="col-sm-8">
			<input name="Nr_lokalu_meld" value="<?php echo $asR['Nr_lokalu_meld']?>" maxlength="4" size="65">
			</div>
		</div>		
		<div class="row"></div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Id_wojewodztwa_meld">Wojew&oacute;dztwo</label>
			<div class="col-sm-8">
			<select size="1" name="Id_wojewodztwa_meld">
			<?php //if (!empty($asR['Id_wojewodztwa_meld'])) { echo '<option>'.$asR['Id_wojewodztwa_meld'].'</option>';} ?>
			<?php //if (empty($asR['Id_wojewodztwa_meld'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>			
			<option value="0">WYBIERZ</option>
			<option value="4">dolnośląskie</option>
			<option value="6">kujawsko - pomorskie</option>
			<option value="7">lubelskie</option>
			<option value="8">lubuskie</option>
			<option value="9">łódzkie</option>
			<option value="10">małopolskie</option>
			<option value="11">mazowieckie</option>
			<option value="12">opolskie</option>
			<option value="13">podkarpackie</option>
			<option value="14">podlaskie</option>
			<option value="15">pomorskie</option>
			<option value="16">śląskie</option>
			<option value="17">świętokrzyskie</option>
			<option value="18">warmińsko - mazurskie</option>
			<option value="19">wielkopolskie</option>
			<option value="20">zachodniopomorskie</option>
			</select>
			</div>
		</div>
		<div class="row"></div>		
		<div class="form-group">
			<label title="" class="control-label col-sm-4" id="LabelID_rodzaj_miejscowosci" for="ID_rodzaj_miejscowosci">Rodzaj miejscowości</label>
			<div class="col-sm-8">
			<label class="radio-inline"><input type="radio" value="1" name="ID_rodzaj_miejscowosci" <?php //if ($asR['ID_rodzaj_miejscowosci']=='Miasto') { echo 'checked';} ?> onchange="validateTT();" >miasto</label>
			<label class="radio-inline"><input type="radio" value="2" name="ID_rodzaj_miejscowosci" <?php //if ($asR['ID_rodzaj_miejscowosci']=='Wieś') { echo 'checked';} ?> onchange="validateTT();" >wieś</label>				
			<!--select size="1" name="XID_rodzaj_miejscowosci">
				<?php //if (!empty($asR['ID_rodzaj_miejscowosci'])) { echo '<option>'.$asR['ID_rodzaj_miejscowosci'].'</option>';} ?>
				<?php //if (empty($asR['ID_rodzaj_miejscowosci'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>				
				<option value="1">Miasto</option>
				<option value="2">Wieś</option>
			</select!-->
			</div>
		</div>		
		<div class="row"></div>	
		<p></p>
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Id_wku">WKU</label>
			<div class="col-sm-8">
			<select size="1" name="Id_wku" >
			<?php //if (!empty($asR['Id_wku'])) { echo '<option>'.$asR['Id_wku'].'</option>';} ?>
			<?php //if (empty($asR['Id_wku'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>
			<option value="0">WYBIERZ</option>
			<?php include 'inc\fFS_wku.php'; ?>
			</select>	
			<button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#myModal3">Pomoc</button>
				<div id="myModal3" class="collapse" role="dialog">
						<p>Wojskowa Komenda Uzupełnień, na ewidencji której jest kandydat</p>
				</div> 			
			</div>
		</div>
	    <?php
	    //START:STUDY_DEGREE 1 ONLY
	    if ($_SESSION['STUDY_DEGREE'] == '1') {
	    ?>		  
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Military_Service_ID">Seria i nr książeczki wojskowej</label>
			<div class="col-sm-8">
			<input name="Military_Service_ID" value="<?php echo $asR['Military_Service_ID']?>" maxlength="35" placeholder="Seria i nr książeczki wojskowej" size="65" type="text">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-12"><span style="color:grey">Dotyczy wyłącznie kandydata na studia wojskowe – wypełnij jeżeli posiadasz książeczkę wojskową.</span></label>
		</div>	
	    <?php
	    }
	    //END:STUDY_DEGREE 1 ONLY
	    ?>		
		</div>
  </div>