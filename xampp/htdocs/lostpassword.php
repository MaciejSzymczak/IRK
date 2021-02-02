<?php

require_once "header.php";

function show_lostpassword_form(){
    echo '<form action="./lostpassword.php" method="post">
	
			<div class="panel panel-default">
				<div class="panel-heading">ODZYSKIWANIE HASŁA</div>
					<div class="panel-body">

					  <div class="form-group">
						<label class="control-label col-sm-2" for="email">EMAIL:</label>
						<div class="col-sm-10">
						<input id="email" name="email" type="text"  maxlength="255" placeholder="email" class="form-control">
						</div>
					  </div>
					  <br/><br/>
					  <div class="form-group">
						<input class="btn btn-default btn-lg" type="reset" onclick="self.location.href=(&quot;./index.php&quot;);" value="Anuluj"/>
						<input class="btn btn-primary btn-lg" name="lostpass" type="submit" value="ODZYSKANIE HASŁA">
					  </div>

					</div>
				</div>
			</div>	
</form>';
}

if (isset($_POST['lostpass'])){

    if (lostPassword($_POST['email'])){
        echo "Twoje poprzednie, utracone hasło zostało skasowane.<p> System wygenerował nowe i przesłał na podany przy rejestracji adres e-mail.</p>
        <p>Pamiętaj! Możesz w łatwy sposób zmienić przesłane hasło.</p>
        <br /><a href='./index.php'>Kliknij, aby przejść na stronę logowania.</a>
        ";
    }else {
        echo "Email jest błędny";
        show_lostpassword_form();
    }

} else {
    //user has not pressed the button
    show_lostpassword_form();
}

 require_once "footer.php";
?>
