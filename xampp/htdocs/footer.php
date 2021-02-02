    </div> <!-- container -->
  </div> <!-- row -->
</div> <!-- col-sm-12 -->


<div class="page-footer text-center">

	<div class="container">
		<div class="row">
		  <div class="col-sm-2"></div>
		  <div class="col-sm-8">
				Kontakt:&nbsp;
				<a href="mailto:rekrutacja@wat.edu.pl"><img alt="" src="images/email.gif" align="middle"></a>
				<span style="font-weight: bold;">rekrutacja@wat.edu.pl&nbsp;
				<img src="images/phone.jpg"> 261 837 939 </span>	 
		  </div>
		  <div class="col-sm-2"></div>
		</div>
	</div>
</div>

<?php
//this code is a stub. It can be used to make the forms read-only in admin mode.
//if (isset($_SESSION['adminUserName'])) {
if (false) {
?>
	<script>
		var inputs = document.getElementsByTagName("INPUT");
		for (var i = 0; i < inputs.length; i++) {
			console.log(inputs[i].name + inputs[i].type);
			if (inputs[i].type === 'text' || inputs[i].type === 'password' ) {
				inputs[i].disabled = true;
			}
		}
		
		inputs = document.getElementsByTagName("SELECT");
		for (var i = 0; i < inputs.length; i++) {
			console.log(inputs[i].name + inputs[i].type);
			if (inputs[i].type === 'select-one') {
				inputs[i].disabled = true;
			}
		}
	</script>
<?php
}

$conn = null; // close db connection

?>

</body>
</html>


