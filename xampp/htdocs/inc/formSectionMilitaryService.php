<script>
	var errCnt = 0;
	function validatePickListNotEmpty(currentItem)
	{		
		if ( currentItem.value == '---' 
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

	<?php
	//START:STUDY_DEGREE 1 ONLY
	if ($_SESSION['STUDY_DEGREE'] == '1') { 
	?>		  
    <div class="panel-heading">DOTYCZY KANDYDATÓW NA STUDIA WOJSKOWE</div>
	<?php
	}
	?>		

	<?php
	//START:STUDY_DEGREE 1 ONLY
	if ($_SESSION['STUDY_DEGREE'] == '2') {
	?>		  
    <div class="panel-heading">INNE DANE</div>
	<?php
	}
	?>		

	<div class="panel-body">	
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
			<label title="" class="control-label col-sm-12"><span style="color:grey">Wypełnij jeżeli posiadasz książeczkę wojskową.</span></label>
		</div>	
		<div class="row"></div>	
		<p></p>			
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="CWKM_Flag">Czy jesteś/będziesz absolwentem CWKM (Certyfikowana Wojskowa Klasa Mundurowa)</label>
			<div class="col-sm-8">
			<select size="1" name="CWKM_Flag" onchange="validatePickListNotEmpty(this);">
			<?php //if (!empty($asR['CWKM_Flag'])) { echo '<option>'.$asR['CWKM_Flag'].'</option>';} ?>
			<?php //if (empty($asR['CWKM_Flag'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>
			<option value="---">WYBIERZ</option>
			<?php include 'inc\Yes_No.php'; ?>
			</select>			
			</div>
		</div>
		<div class="row"></div>	
		<p></p>			
		
		<div class="form-group">
			<label title="" class="control-label col-sm-4" for="OLL_Flag">Czy jesteś/będziesz absolwentem OLL (Ogólnokształcące Liceum Lotnicze w Dęblinie)</label>
			<div class="col-sm-8">
			<select size="1" name="OLL_Flag" onchange="validatePickListNotEmpty(this);">
			<?php //if (!empty($asR['OLL_Flag'])) { echo '<option>'.$asR['OLL_Flag'].'</option>';} ?>
			<?php //if (empty($asR['OLL_Flag'])) { echo '<option>-----&gt; dokonaj wyboru &lt;--------</option>';} ?>
			<option value="---">WYBIERZ</option>
			<?php include 'inc\Yes_No.php'; ?>
			</select>			
			</div>
		</div>		
	    <?php
	    }
	    //END:STUDY_DEGREE 1 ONLY
	    ?>		
	</div>
  </div>