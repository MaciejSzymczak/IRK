  <div class="panel panel-default">
    <div class="panel-heading">ADRES DO KORESPONDENCJI&nbsp;<span style="color: rgb(255, 0, 0);">(proszę wypełnić wyłącznie w przypadku jeżeli adres do korespondencji jest inny niż zamieszkania)</span>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Kod_pocztowy">Kod pocztowy</label>
			<div class="col-sm-8">
			<input name="Kod_pocztowy" value="<?php echo $asR['Kod_pocztowy']?>" maxlength="5" placeholder="Kod pocztowy bez myślnika np. 01234" size="65" type="text" onkeyup="validatePostalCode(this)">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Miejscowosc">Miejscowość</label>
			<div class="col-sm-8">
			<input name="Miejscowosc" value="<?php echo $asR['Miejscowosc']?>" maxlength="35" size="65" type="text">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Ulica">Ulica</label>
			<div class="col-sm-8">
			<input name="Ulica" value="<?php echo $asR['Ulica']?>" maxlength="25" size="65" type="text">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nr_domu">Nr domu</label>
			<div class="col-sm-8">
			<input name="Nr_domu" value="<?php echo $asR['Nr_domu']?>" maxlength="9" size="65" type="text">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nr_lokalu">Nr lokalu</label>
			<div class="col-sm-8">
			<input name="Nr_lokalu" value="<?php echo $asR['Nr_lokalu']?>" maxlength="4" size="65" type="text">
			</div>
		</div>	
	</div>
  </div> 