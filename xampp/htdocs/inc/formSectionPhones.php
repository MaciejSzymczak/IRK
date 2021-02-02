  <div class="panel panel-default">
    <div class="panel-heading">TELEFONY KONTAKTOWE
	</div>
	<div class="panel-body">
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Tel_kom">Komórkowy</label>
			<div class="col-sm-8">
			<input name="Tel_kom" value="<?php echo $asR['Tel_kom']?>" maxlength="30" placeholder="Cudzoziemcy z nr kierunkowym kraju np. +47 802123123" size="65">
			</div>
		</div>			
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Nr_telefonu">Stacjonarny</label>
			<div class="col-sm-8">
			<input name="Nr_telefonu" value="<?php echo $asR['Nr_telefonu']?>" placeholder="Nr telefonu stacjonarnego z nr kierunkowym np.: 22 6543215" maxlength="30" size="65">
			</div>
		</div>	

	</div>
  </div>  
  <!--div class="panel panel-default">
    <div class="panel-heading">INNE</div>
	<div class="panel-body">
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Student_wat">Kolejne studia stacjonarne</label>
			<div class="col-sm-8">
			<select size="1" name="Student_wat">
			< ?php if (!empty($asR['Student_wat'])) { echo '<option>'.$asR['Student_wat'].'</option>';} ?>
			< ?php if (empty($asR['Student_wat'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>						
			<option value="1">TAK</option>
			<option value="2">NIE</option>
			</select>
			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal3">Pomoc</button>
				<div id="myModal3" class="modal fade" role="dialog">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Kolejne studia stacjonarne</h4>
					  </div>
					  <div class="modal-body">
						<p>
						Zaznacz TAK, jeżeli jesteś studentem lub absolwentem studi&oacute;w stacjonarnych w uczelni publicznej
						</p>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>

				  </div>
				</div>			
			</div>
		</div>	
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="Id_zrodla_utrzymania">Źr&oacute;dła utrzymania<br>(Nie wymagane)</label>
			<div class="col-sm-8">
			<select disabled="disabled" size="1" name="Id_zrodla_utrzymania">
			<option>-----&gt; dokonaj wyboru &lt;--------</option>
			<option value="1">praca stała</option>
			<option value="2">praca dorywcza</option>
			<option value="3">prowadzenie gospodarstwa rolnego</option>
			<option value="4">prowadzenie działalności gospodarczej </option>
			<option value="5">emerytura, renta</option>
			<option value="6">zasiłki</option>
			<option value="7">inne</option>
			</select>
			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal4">Pomoc</button>
				<div id="myModal4" class="modal fade" role="dialog">
				  <div class="modal-dialog">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Źr&oacute;dła utrzymania</h4>
					  </div>
					  <div class="modal-body">
						<p>
						(<span style="color: rgb(255, 0, 0);">Niewymagane</span>) Podaj źr&oacute;dło utrzymania rodziny lub własne
						</p>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
					</div>

				  </div>
				</div>			
			</div>
		</div>	
	</div>
  </div-->
