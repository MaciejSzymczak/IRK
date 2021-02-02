  <div class="panel panel-default">
    <div class="panel-heading">NR i ADRES JEDNOSTKI WOJSKOWEJ&nbsp;<span style="color: rgb(255, 0, 0);">(wypełnia wyłącznie żołnierz odbywający służbę wojskową)</span>
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nazwa_JW">Nazwa JW</label>
			<div class="col-sm-8">
			<input name="Nazwa_JW" value="<?php echo $asR['Nazwa_JW']?>" maxlength="50" placeholder="Nazwa lub numer Jednostki Wojskowej" size="45" type="text">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="kod_pocz_JW">Kod pocztowy JW</label>
			<div class="col-sm-8">
			<input name="kod_pocz_JW" value="<?php echo $asR['kod_pocz_JW']?>" maxlength="5" placeholder="Kod pocztowy bez myślnika np. 01234" size="45">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Miejscowosc_JW">Miejscowość JW</label>
			<div class="col-sm-8">
			<input name="Miejscowosc_JW" value="<?php echo $asR['Miejscowosc_JW']?>" maxlength="50" size="45">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Ulica_JW">Ulica JW</label>
			<div class="col-sm-8">
			<input name="Ulica_JW" value="<?php echo $asR['Ulica_JW']?>" maxlength="50" size="45">
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="NrTel_JW">Nr Telefonu do JW</label>
			<div class="col-sm-8">
			<input name="NrTel_JW" value="<?php echo $asR['NrTel_JW']?>" maxlength="50" size="45">
			</div>
		</div>	
	</div>
  </div> 