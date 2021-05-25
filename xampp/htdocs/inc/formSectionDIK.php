<script>
	var errCnt = 0;

	function peselIsOk(currentItem)
	{
		var s = currentItem.value;
		//Sprawdz dlugosc, musi byc 11 znaków
		if (s.length != 11)
		  return false;

		//Sprawdz, czy wszystkie znaki to cyfry
		var aInt = new Array();
		for (i=0;i<11; i++)
		{
		  aInt[i] = parseInt(s.substring(i,i+1));
		  if (isNaN(aInt[i]))
		  {
			return false;
		  }
		}

		//Sprawdz sume kontrolna
		var wagi = [1,3,7,9,1,3,7,9,1,3,1];
		var sum=0;
		for (i=0;i<11;i++)
		  sum+=wagi[i]*aInt[i];
		if ((sum%10)!=0)
		  return false;

		//Policz rok z uwzglednieniem XIX, XXI, XXII i XXIII wieku
		var rok = 1900+aInt[0]*10+aInt[1];
		if (aInt[2]>=2 && aInt[2]<8)
		  rok+=Math.floor(aInt[2]/2)*100;
		if (aInt[2]>=8)
		  rok-=100;

		var miesiac = (aInt[2]%2)*10+aInt[3];
		var dzien = aInt[4]*10+aInt[5];

		//Sprawdz poprawnosc daty urodzenia
		if (!checkDate(dzien,miesiac,rok))
		  return false;
		return true;
	}

	function checkDate(d,m,y)
	{
	  var dt = new Date(y,m-1,d);
	  return dt.getDate()==d &&
	  dt.getMonth()==m-1 &&
	  dt.getFullYear()==y;
	} 
  
	function validatePesel(currentItem)
	{		
		(peselIsOk(currentItem))?setItemValid (currentItem):setItemInvalid (currentItem);
		
		//default birth date
		var s = document.getElementById("data_urodzenia").value;
			if (peselIsOk(currentItem)) {
				//console.log('pesel ok');
				//2020.11.08 Feature disabled. Somehow default date is erased on entering the field. Presumably datetime picker issue
				//if (s.length==0 || s=='0000-00-00')
					//document.getElementById("data_urodzenia").value = getDateFromPesel(currentItem.value);			
				validateBirthDate(document.getElementById("data_urodzenia"),document.getElementById("Pesel").value);
			}

	}
	
	function setBirthDate(item){
		if (peselIsOk(item)){
			$('#datetimepicker1').datepicker("setDate", getDateFromPesel(item.value));
			$('#data_urodzenia').trigger("change");
		}
	}

	function setItemValid (currentItem)
	{
	  if (currentItem.style.backgroundColor == "pink") errCnt--;
	  currentItem.style.backgroundColor = "white";
	  document.getElementById("SubmitForm").disabled = errCnt!=0;					
	}
	function setItemInvalid (currentItem)
	{
	  if (currentItem.style.backgroundColor == "white" || currentItem.style.backgroundColor =="") errCnt++;
	  currentItem.style.backgroundColor = "pink";
	  document.getElementById("SubmitForm").disabled = errCnt!=0;
	}

	function pad(num, size) {
		var s = num+"";
		while (s.length < size) s = "0" + s;
		return s;
	}

	function getDateFromPesel(pesel) {
		var aInt = new Array();
		for (i=0;i<10; i++)
		{
		  aInt[i] = parseInt(pesel.charAt(i));
		}

		var yyyy = 1900+aInt[0]*10+aInt[1];
		if (aInt[2]>=2 && aInt[2]<8)
		  yyyy+=Math.floor(aInt[2]/2)*100;
		if (aInt[2]>=8)
		  yyyy-=100;

		var month = (aInt[2]%2)*10+aInt[3];
		var day = aInt[4]*10+aInt[5];
		
		return pad(yyyy,4)+'-'+pad(month,2)+'-'+pad(day,2);
	}


	function validateBirthDate(currentItem, pesel)
	{
		var dateFromPesel= getDateFromPesel(pesel);
		//console.log(dateFromPesel);
		var itemValue = currentItem.value;
					
		if (!(itemValue==dateFromPesel)) {  
			setItemInvalid ( currentItem );
		}
		else {
			setItemValid ( currentItem );
		}
	}

	function validateNotEmpty(currentItem)
	{		
		if (currentItem.value.length==0) {  
			setItemInvalid ( currentItem );
		}
		else {
			setItemValid ( currentItem );
		}
		//console.info(errCnt);
	}
	
	function initCap(currentItem)
	{
	  if (currentItem.value.length>0) {	 
	    var str = currentItem.value;
	    currentItem.value = str[0].toUpperCase() + str.substring(1,str.length);
	  }
	}
	
</script>
  <div class="panel panel-default">
    <div class="panel-heading">DANE IDENTYFIKACYJNE&nbsp;KANDYDATA
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="Nazwisko">Pesel</label>
			<div class="col-sm-7">
			<input name="Pesel" id="Pesel" value="<?php echo $asR['Pesel']?>" maxlength="30"  placeholder="Pesel" onkeyup="validatePesel(this); setBirthDate(this)" size="35">
				<button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#myModal3">Pomoc</button>
				<div id="myModal3" class="collapse" role="dialog">
						<p>W przypadku braku PESEL prosi się o kontakt z   rekrutacja@wat.edu.pl  tel. 261 837 939</p>
				</div> 	
			</div>
			<?php echo $PeselErrorMessage; ?>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="Nazwisko">Nazwisko</label>
			<div class="col-sm-7">
			<input name="Nazwisko" id="Nazwisko" value="<?php echo $asR['Nazwisko']?>" maxlength="30"  placeholder="Nazwisko" onchange="initCap(this)" onkeyup="validateNotEmpty(this)" size="35">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="Nazwisko">Imię</label>
			<div class="col-sm-7">
			<input name="Imie" id="Imie" value="<?php echo $asR['Imie']?>" maxlength="30" size="35" placeholder="Imię" onchange="initCap(this)" onkeyup="validateNotEmpty(this)" type="text">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="Imie2">Drugie imię</label>
			<div class="col-sm-7">
			<input name="Imie2" value="<?php echo $asR['Imie2']?>" maxlength="30" size="35" placeholder="Drugie imię" type="text" onchange="initCap(this)">
			</div>
		</div>	

	  <?php
	  //START:STUDY_DEGREE 1 ONLY
	  if ($_SESSION['STUDY_DEGREE'] == '1') {
	  ?>		  
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="Imie_ojca">Imię ojca  <span style="color:grey">(dotyczy kandydata na studia wojskowe)</span></label>
			<div class="col-sm-7">
			<input name="Imie_ojca" value="<?php echo $asR['Imie_ojca']?>" maxlength="30" size="35" type="text" onchange="initCap(this)">
			<button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#myModal1">Pomoc</button>
				<div id="myModal1" class="collapse" role="dialog">
						<p>Wypełnij to pole tylko gdy kandydujesz na studia „wojskowe”</p>
				</div> 			
			</div>
		</div>	
	    <div>
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="Imie_matki">Imię matki  <span style="color:grey">(dotyczy kandydata na studia wojskowe)</span></label>
			<div class="col-sm-7">
			<input name="Imie_matki" value="<?php echo $asR['Imie_matki']?>" maxlength="30" size="35" type="text" onchange="initCap(this)">
			<button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#myModal2">Pomoc</button>
				<div id="myModal2" class="collapse" role="dialog">
						<p>Wypełnij to pole tylko gdy kandydujesz na studia „wojskowe”</p>
				</div> 
			</div>
		</div>	
		</div>

	  <?php
	  }
	  //END:STUDY_DEGREE 1 ONLY
	  ?>		
				
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="data_urodzenia">Data urodzenia</label>
			<div class="col-sm-7">
            <div class='input-group date' id='datetimepicker1'>
				<input name="data_urodzenia" id="data_urodzenia" value="<?php echo $asR['data_urodzenia']?>" maxlength="10" placeholder="rrrr-mm-dd np. 1999-12-21" size="30" onchange="validateBirthDate(this,document.getElementById('Pesel').value)" type="text">
				<span class="input-group-addon" style="width:10px;">
				   <span class="glyphicon glyphicon-calendar"></span>
				</span> 
            </div>
			</div>
        <script type="text/javascript">	    
			$(function () {
                $('#datetimepicker1').datepicker({format: "yyyy-mm-dd",language: "pl"});
            });
        </script>		
		</div>			
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="Miejsce_urodzenia">Miejscowość urodzenia</label>
			<div class="col-sm-7">
			<input name="Miejsce_urodzenia" value="<?php echo $asR['Miejsce_urodzenia']?>" maxlength="50" size="35">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-5" for="ID_obywatelstwa">Obywatelstwo</label>
			<div class="col-sm-7">
				<select size="1" name="ID_obywatelstwa">
				<?php //if (!empty($asR['ID_obywatelstwa'])) { echo '<option>'.$asR['ID_obywatelstwa'].'</option>';} ?>
				<?php //if (empty($asR['ID_obywatelstwa'])) { echo '<option>--&gt; dokonaj wyboru &lt;--</option>';} ?>
				<option value="0">WYBIERZ</option>
				<option value="1">polskie</option>
				<option value="2">afgańskie</option>
				<option value="3">angielskie</option>
				<option value="4">białoruskie</option>
				<option value="5">bułgarskie</option>
				<option value="6">czeskie</option>
				<option value="7">francuskie</option>
				<option value="8">litewskie</option>
				<option value="9">niemieckie</option>
				<option value="10">rosyjskie</option>
				<option value="11">słowackie</option>
				<option value="12">tunezyjskie</option>
				<option value="13">ukraińskie</option>
				<option value="14">wietnamskie</option>
				<option value="15">pozostałe</option>
				</select>
		    </div>
		</div>			
		</div>
  </div>  