<?php

function printLabel($label, $value) {
	echo '<div class="row">
		  <div class="col-sm-4"><label>'.$label.'</label></div>
		  <div class="col-sm-8">'.$value.'</div>
		</div>';
}

function show_registration_form($label, $action,$errormessage){
    echo '<div class="container">'.$errormessage.'
			<script>
				var errCnt = 0;

				function validateNotEmpty(currentItem)
				{		
					(currentItem.value.length!=0)?setItemValid (currentItem):setItemInvalid (currentItem);
				}
				function validateEmail(currentItem) {
					var email = currentItem.value;
					var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
					(re.test(String(email).toLowerCase()))?setItemValid (currentItem):setItemInvalid (currentItem);
				}				
				function setItemValid (currentItem)
				{
				  if (currentItem.style.backgroundColor == "pink") errCnt--;
				  currentItem.style.backgroundColor = "white";
				  document.getElementById("cmdlogin").disabled = errCnt!=0;					
				}
				function setItemInvalid (currentItem)
				{
				  if (currentItem.style.backgroundColor == "white" || currentItem.style.backgroundColor =="") errCnt++;
				  currentItem.style.backgroundColor = "pink";
				  document.getElementById("cmdlogin").disabled = errCnt!=0;
				}
			</script> 	
		<div class="panel panel-default">
		  <div class="panel-heading">ZAKŁADANIE KONTA. Twój adres email będzie Twoją nazwą użytkownika.</div>
		  <div class="panel-body">
		   <form class="form-horizontal" method="post" action="./'.$action.'">
			  <div class="form-group">
				<label class="control-label col-sm-2" for="email">WPROWADŹ TWÓJ ADRES EMAIL:</label>
				<div class="col-sm-10">
				<input id="email" name="email" type="text"  maxlength="255" placeholder="email" class="form-control"  onkeyup="validateEmail(this)">
				</div>
			  </div>
			  <div class="form-group">
				<label title="" class="control-label col-sm-2" for=""></label>
				<div class="col-sm-10">
				<input class="btn btn-default btn-lg" type="reset" onclick="self.location.href=(&quot;./index.php&quot;);" value="Anuluj"/>
				<input type="submit" id="cmdlogin" name="register" class="btn btn-primary btn-lg" value="ZAŁÓŻ KONTO"  />
				</div>
			  </div>
			</form>
			  <script> 
				  validateNotEmpty(document.getElementById("email"));
			  </script> 
		  </div>
		</div>
	</div>';
}
?>
