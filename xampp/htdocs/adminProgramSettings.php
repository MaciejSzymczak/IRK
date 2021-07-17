<?php require_once "header.php"; ?>
<?php checkAccess('#index.php'); ?> 
<?php  
$username=$_SESSION['username'];
$isAdmin = $conn->query("SELECT isAdmin FROM login WHERE username='$username'")->fetch()[0];

if ($isAdmin!='+') {
	 echo '<div class="alert alert-danger" role="alert">
			  <strong>Och!</strong> Ten formularz jest dostępny tylko dla Administratora.
			</div>';
	 require_once "footer.php";
	 exit();
}
?>

<form id="refreshPage" action="adminProgramSettings.php" method="POST">
  <input type="hidden" id="command" name='command' value="<to be set>"/>

	<div class="row">

		<?php
			//------------- SAVE ------------------
			if ($_POST['command']=='SAVE') {
				function saveResource($resourceName) {
					global $conn;
					$query = "
					   update programSettings 
						  set value = ? 
						where LabelName = ?";
					$stmt = $conn->prepare($query);
					$stmt->execute([ $_POST[$resourceName], $resourceName]);
				}
				saveResource('CreateAccount1Visible');
				saveResource('CreateAccount1Button');
				saveResource('CreateAccount1Hint');
				saveResource('CreateAccount2Visible');
				saveResource('CreateAccount2Button');
				saveResource('CreateAccount2Hint');
				saveResource('LoginDisabledFlag');
				saveResource('LoginDisabledHint');
				saveResource('SSW_Disabled_MMDD');	
				saveResource('Degree1DisableApplication');	
				saveResource('Degree2DisableApplication');	
				saveResource('FeeMilitaryCivil');	
				saveResource('FeeCivil');	
				saveResource('SendingDocs');	
				saveResource('PasswordExpireInDays');	
			}	
		?>
		<div class="alert alert-success" <?php if ($_POST['command']=='SAVE') {} else { echo ' style="display: none;" '; }  ?> role="alert">
			<p>Zmiany zostały zapisane</p>
			<p></p>
		</div>	
		<?php if ($_POST['command']=='SAVE') { echo ' <script> self.location.href=("./index.php"); </script>'; }  ?>

		<?php
			$CreateAccount1Visible     = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Visible'")->fetch()[0] );
			$CreateAccount1Button      = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Button'")->fetch()[0] );
			$CreateAccount1Hint        = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Hint'")->fetch()[0] );
			$CreateAccount2Visible     = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Visible'")->fetch()[0] );
			$CreateAccount2Button      = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Button'")->fetch()[0] );
			$CreateAccount2Hint        = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Hint'")->fetch()[0] );
			$LoginDisabledFlag         = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'LoginDisabledFlag'")->fetch()[0] );
			$LoginDisabledHint         = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'LoginDisabledHint'")->fetch()[0] );
			$SSW_Disabled_MMDD         = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'SSW_Disabled_MMDD'")->fetch()[0] );
			$Degree1DisableApplication = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'Degree1DisableApplication'")->fetch()[0] );
			$Degree2DisableApplication = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'Degree2DisableApplication'")->fetch()[0] );
			$FeeMilitaryCivil          = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'FeeMilitaryCivil'")->fetch()[0] );
			$FeeCivil                  = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'FeeCivil'")->fetch()[0] );
			$SendingDocs               = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'SendingDocs'")->fetch()[0] );
			$PasswordExpireInDays      = htmlspecialchars( $conn->query("SELECT value FROM programSettings WHERE LabelName = 'PasswordExpireInDays'")->fetch()[0] );

			$LoginDisabledHintPreview  = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'LoginDisabledHint'")->fetch()[0];
			$CreateAccount1ButtonPreview      = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Button'")->fetch()[0] ;
			$CreateAccount1HintPreview        = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount1Hint'")->fetch()[0] ;
			$CreateAccount2ButtonPreview      = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Button'")->fetch()[0] ;
			$CreateAccount2HintPreview        = $conn->query("SELECT value FROM programSettings WHERE LabelName = 'CreateAccount2Hint'")->fetch()[0] ;

		?>

		<div class="panel panel-default">
		  <div class="panel-heading">Tylko studia wojskowe stacjonarne: zablokuj wybór kierunków studiów po dniu</div>
		  <div class="panel-body">
			
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="SSW_Disabled_MMDD">MMDD (miesiąc-dzień)</label>
				<div class="col-sm-10">
				<input name="SSW_Disabled_MMDD" value="<?php echo $SSW_Disabled_MMDD; ?>" maxlength="4"  placeholder="" size="4">
				</div>
			</div>
			
		  </div>
		</div>	

		<div class="panel panel-default">
		  <div class="panel-heading">Blokowanie wprowadzania zmian w ankiecie</div>
		  <div class="panel-body">
			
			<p>

			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="Degree1DisableApplication"></label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label><input name="Degree1DisableApplication" type="checkbox" value="+" <?php if ($Degree1DisableApplication=='+') echo ' checked'; ?> >Studia Stopień I - zablokuj wprowadzanie zmian w ankiecie</label>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="Degree2DisableApplication"></label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label><input name="Degree2DisableApplication" type="checkbox" value="+" <?php if ($Degree2DisableApplication=='+') echo ' checked'; ?> >Studia Stopień II - zablokuj wprowadzanie zmian w ankiecie</label>
					</div>
				</div>
			</div>

			</p>
			
		  </div>
		</div>	
		
		
		<div class="panel panel-default">
		  <div class="panel-heading">Komunikat powitalny</div>
		  <div class="panel-body">
			
			<p>
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="LoginDisabledHint">Komunikat dla użytkownika
					<br/><br/>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#LoginDisabledHintPreview">Podgląd</button>
					<!-- Modal -->
					<div id="LoginDisabledHintPreview" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title">Podgląd</h4>
						  </div>
						  <div class="modal-body">
							
							<div id="LoginDisabledHint" maxlength="999"  size="110" rows="10" cols="100"><?php echo $LoginDisabledHintPreview; ?></div>
							
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div> 	
				</label>

				<div class="col-sm-10">
				<textarea name="LoginDisabledHint" maxlength="999"  size="110" rows="10" cols="100" onchange="document.getElementById('LoginDisabledHint').innerHTML  = this.value;" ><?php echo $LoginDisabledHint; ?></textarea>
			</div>
			</div>

			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="LoginDisabledFlag"></label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label><input name="LoginDisabledFlag" type="checkbox" value="+" <?php if ($LoginDisabledFlag=='+') echo ' checked'; ?> >Logowanie zablokowane</label>
					</div>
				</div>
			</div>
			
			</p>
			
		  </div>
		</div>	
		
		
		<div class="panel panel-default">
		  <div class="panel-heading">Zakładanie konta 1</div>
		  <div class="panel-body">
			
			<p>
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="CreateAccount1Button">Etykieta przycisku
					<br/><br/>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#CreateAccount1ButtonPreview">Podgląd</button>
					<!-- Modal -->
					<div id="CreateAccount1ButtonPreview" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title">Podgląd</h4>
						  </div>
						  <div class="modal-body">
							
							<div id="CreateAccount1Button" maxlength="999"  size="110" rows="10" cols="100"><?php echo $CreateAccount1ButtonPreview; ?></div>
							
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div> 	
				</label>
				<div class="col-sm-10">
				<textarea name="CreateAccount1Button" maxlength="999"  size="110" rows="10" cols="100" onchange="document.getElementById('CreateAccount1Button').innerHTML  = this.value;"><?php echo $CreateAccount1Button; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="CreateAccount1Hint">Podpowiedź
					<br/><br/>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#CreateAccount1HintPreview">Podgląd</button>
					<!-- Modal -->
					<div id="CreateAccount1HintPreview" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title">Podgląd</h4>
						  </div>
						  <div class="modal-body">
							
							<div id="CreateAccount1Hint" maxlength="999"  size="110" rows="10" cols="100"><?php echo $CreateAccount1HintPreview; ?></div>
							
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div> 					
				</label>
				<div class="col-sm-10">
				<textarea name="CreateAccount1Hint" maxlength="999"  size="110" rows="10" cols="100" onchange="document.getElementById('CreateAccount1Hint').innerHTML  = this.value;"><?php echo $CreateAccount1Hint; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="CreateAccount1Visible"></label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label><input name="CreateAccount1Visible" type="checkbox" value="+" <?php if ($CreateAccount1Visible=='+') echo ' checked'; ?> >Wyświetlaj</label>
					</div>
				</div>
			</div>
			
			</p>
			
		  </div>
		</div>	
		
		
		<div class="panel panel-default">
		  <div class="panel-heading">Zakładanie konta 2</div>
		  <div class="panel-body">
								
			<p>
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="CreateAccount2Button">Etykieta przycisku
					<br/><br/>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#CreateAccount2ButtonPreview">Podgląd</button>
					<!-- Modal -->
					<div id="CreateAccount2ButtonPreview" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title">Podgląd</h4>
						  </div>
						  <div class="modal-body">
							
							<div id="CreateAccount2Button" maxlength="999"  size="110" rows="10" cols="100"><?php echo $CreateAccount2ButtonPreview; ?></div>
							
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div> 	
				</label>
				<div class="col-sm-10">
				<textarea name="CreateAccount2Button" maxlength="999"  size="110" rows="10" cols="100" onchange="document.getElementById('CreateAccount2Button').innerHTML  = this.value;"><?php echo $CreateAccount2Button; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="CreateAccount2Hint">Podpowiedź
					<br/><br/>
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#CreateAccount2HintPreview">Podgląd</button>
					<!-- Modal -->
					<div id="CreateAccount2HintPreview" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<h4 class="modal-title">Podgląd</h4>
						  </div>
						  <div class="modal-body">
							
							<div id="CreateAccount2Hint" maxlength="999"  size="110" rows="10" cols="100"><?php echo $CreateAccount2HintPreview; ?></div>
							
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div>

					  </div>
					</div> 					
				</label>
				<div class="col-sm-10">
				<textarea name="CreateAccount2Hint" maxlength="999"  size="110" rows="10" cols="100" onchange="document.getElementById('CreateAccount2Hint').innerHTML  = this.value;"><?php echo $CreateAccount2Hint; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="CreateAccount2Visible"></label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label><input name="CreateAccount2Visible" type="checkbox" value="+" <?php if ($CreateAccount2Visible=='+') echo ' checked'; ?> >Wyświetlaj</label>
					</div>
				</div>
			</div>					
			</p>
			
		  </div>
		</div>	
		
		<div class="panel panel-default">
		  <div class="panel-heading">Opłata za studia</div>
		  <div class="panel-body">
			
			<div class="form-group">
				<label title="" class="control-label col-sm-3" for="FeeMilitaryCivil">Studia wojskowe i cywilne</label>
				<div class="col-sm-9">
				<input name="FeeMilitaryCivil" value="<?php echo $FeeMilitaryCivil; ?>" maxlength="4"  placeholder="" size="4">
				</div>
			</div>
			
			<div class="form-group">
				<label title="" class="control-label col-sm-3" for="FeeCivil">Tylko studia cywilne</label>
				<div class="col-sm-9">
				<input name="FeeCivil" value="<?php echo $FeeCivil; ?>" maxlength="4"  placeholder="" size="4">
				</div>
			</div>

	    </div>
		</div>			
		
		<div class="panel panel-default">
		  <div class="panel-heading">Inne</div>
		  <div class="panel-body">
			
			<div class="form-group">
				<label title="" class="control-label col-sm-2" for="SendingDocs"></label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label><input name="SendingDocs" type="checkbox" value="+" <?php if ($SendingDocs=='+') echo ' checked'; ?> >Przesyłanie dokumentów</label>
					</div>
				</div>
			</div>			
			
			
	    </div>
		</div>			


		<div class="panel panel-default">
		  <div class="panel-heading">Ustawienia sesji</div>
		  <div class="panel-body">
		  
		  
			<div class="form-group">
				<label title="" class="control-label col-sm-3" for="PasswordExpireInDays">Wymuszaj zmiane hasła po dniach</label>
				<div class="col-sm-9">
				<input name="PasswordExpireInDays" value="<?php echo $PasswordExpireInDays; ?>" maxlength="4"  placeholder="" size="4">
				</div>
			</div>		  		
			
	    </div>
		</div>	

		<p align="center">
			<button type="button" class="btn btn-default glyphicon glyphicon-home" onclick="self.location.href=('./index.php');"> Anuluj</button>						
			<button type="button" class="btn btn-success glyphicon glyphicon-ok" onclick="document.getElementById('command').value='SAVE'; document.getElementById('refreshPage').submit();"> Zapisz</button>
		</p>

		
	</div>

</form>

<?php require_once "footer.php"; ?>