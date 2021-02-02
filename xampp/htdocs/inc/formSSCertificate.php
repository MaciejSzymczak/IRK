<script>
	var errCnt = 0;
	function validatePickListNotEmpty(currentItem)
	{		
		if ( currentItem.value != '1' 
		  && currentItem.value != '2' 
		  && currentItem.value !='3' 
		  && currentItem.value != '4' 
		  && currentItem.value != 'stara' 
		  && currentItem.value != 'nowa' 
		  && currentItem.value != 'IB' 
		  && currentItem.value != 'poza RP' 
		  ) {  
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
</script>

  <div class="panel panel-default">
    <div class="panel-heading">ŚWIADECTWO DOJRZAŁOŚCI</div>
	<div class="panel-body">
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="ID_rodz_matury">Rodzaj matury</label>
			<div class="col-sm-8">
		    <select size="1" name="ID_rodz_matury" id="ID_rodz_matury" onchange="validatePickListNotEmpty(this);">
				<?php //if (!empty($asR['ID_rodz_matury'])) { echo '<option>'.$asR['ID_rodz_matury'].'</option>';} ?>
				<?php //if (empty($asR['ID_rodz_matury'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>
				<option value="0">WYBIERZ</option>
				<option value="1">stara</option>
				<option value="2">nowa</option>
				<option value="3">IB</option>
				<option value="4">poza RP</option>
			</select>
			<button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#myModal">Pomoc</button>
				<div id="myModal" class="collapse" role="dialog">
						<p>
						<span style="font-weight: bold;"> nowa</span> - matura z wynikami w procentach, wydawana przez OKE<br>
						<span style="font-weight: bold;"> stara</span> - matura z ocenami, wydawana przez szkołę <br>
						<span style="font-weight: bold;"> IB</span> - matura międzynarodowa <br>
						<span style="font-weight: bold;"> poza RP</span> - matura uzyskana za granicą RP
						</p>

				</div> 
			</div>
		</div>	
		<div class="col-sm-12">
		<div class="row well">
		<div style="text-align: center;">Uwagi</div>
		1. Jeżeli legitymujesz się świadectwem dojrzałości "nowej" lub "starej" matury, to po zaznaczeniu, przejdź do zakładki PRZESYŁANIE WYNIKÓW MATURALNYCH ZE ŚWIADECTWA DOJRZAŁOŚCI, wypełnij i prześlij celem naliczenia punktów rankingowych.<br/><br/>
		2. Jeżeli legitymujesz się świadectwem dojrzałości "IB" lub "poza RP" musisz je dostarczyć do uczelnianej komisji rekrutacyjnej, która dokona naliczenia punktów rankingowych.
		</div>
		</div>
		<!--div class="form-group">
			<label title="" class="control-label col-sm-4" for="Rok_Ukonczenia_Szkoly">Rok uzyskania matury</label>
			<div class="col-sm-8">
			<input value="<?php echo $asR['Rok_Ukonczenia_Szkoly']?>" maxlength="4" size="65" placeholder="np. 2016" name="Rok_Ukonczenia_Szkoly">
			</div>
		</div-->		
		<!--div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nr_swiad_matura">Nr świadectwa</label>
			<div class="col-sm-8">
			<input size="65" name="Nr_swiad_matura" value="<?php echo $asR['Nr_swiad_matura']?>" placeholder="np. M/700223344/09">
			</div>
		</div-->
		<!--div class="form-group">
			<label title="" class="control-label col-sm-4" for="data_wystawienia_matura">Data wystawienia</label>
			<div class="col-sm-8">
			<! --input size="65" maxlength="10" value="<?php echo $asR['data_wystawienia_matura']?>" placeholder="np.: 1981-04-13" name="data_wystawienia_matura"-- >

            <div class='input-group date' id='datetimepicker1'>
				<input name="data_wystawienia_matura" id="data_urodzenia" value="<?php echo $asR['data_wystawienia_matura']?>" maxlength="10" placeholder="rrrr-mm-dd np. 1999-12-21" size="30" onchange="validateBirthDate(this,'<?php echo trim($$asR['Pesel'])?>')" type="text">
				<span class="input-group-addon" style="width:10px;">
				   <span class="glyphicon glyphicon-calendar"></span>
				</span> 
            </div>

			</div>
			
        <script>
			$(function () {
                $('#datetimepicker1').datepicker({
                 format: "yyyy-mm-dd",
                 language: "pl"
               });
            });
        </script>
		
			
		</div-->	
		<!--div class="form-group">
			<label title="" class="control-label col-sm-4" for="Miejscowosc_wystawienia_matura">Miejscowość wystawienia</label>
			<div class="col-sm-8">
			<input size="65" value="<?php echo $asR['Miejscowosc_wystawienia_matura']?>" placeholder="Miejscowość wystawienia świadectwa dojrzałości" name="Miejscowosc_wystawienia_matura">
			</div>
		</div-->
		<!--div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nazwa_szkoly">Nazwa szkoły</label>
			<div class="col-sm-8">
			<input size="65" value="<?php echo $asR['Nazwa_szkoly']?>" placeholder="Pełna nazwa szkoły np.: X LO im. J.Bema w Warszawie" name="Nazwa_szkoly">
			</div>
		</div-->		
		<!--div class="form-group">
			<label title="" class="control-label col-sm-4" for="id_komisji_okregowej">OKE</label>
			<div class="col-sm-8">
		    <select size="1" name="id_komisji_okregowej">
			<?php if (!empty($asR['id_komisji_okregowej'])) { echo '<option>'.$asR['id_komisji_okregowej'].'</option>';} ?>
			<?php if (empty($asR['id_komisji_okregowej'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>			
			<option value="1">OKE w Gdańsku</option>
			<option value="2">OKE w Jaworznie</option>
			<option value="3">OKE w Krakowie</option>
			<option value="4">OKE w Łomży</option>
			<option value="5">OKE w Łodzi</option>
			<option value="6">OKE w Poznaniu</option>
			<option value="7">OKE w Warszawie</option>
			<option value="8">OKE w Wrocławiu</option>
			</select>&nbsp;(miejscowość Okręgowej Komisji Egzaminacyjnej)
			</div>
		</div-->		
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nazwa_szkoly">Język angielski na świadectwie dojrzałości</label>
			<div class="col-sm-8">
			<select size="1" name="JezykAngMatura">
			<?php //if (!empty($asR['JezykAngMatura'])) { echo '<option>'.$asR['JezykAngMatura'].'</option>';} ?>
			<?php //if (empty($asR['JezykAngMatura'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>			
			<option value="0">WYBIERZ</option>
			<option value="1">NIE</option>
			<option value="2">TAK</option>
			</select>
			<button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#myModal2">Pomoc</button>
				<!-- Modal -->
				<div id="myModal2" class="collapse" role="dialog">
						<p>
						Wybierz <strong>TAK</strong> jeżeli zdawałeś(-aś) / będziesz zdawał(a) j.angielski na egz. maturalnym
						</p>
				</div> 			
			</div>
		</div>	
		</div>
  </div>