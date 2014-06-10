<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>


<?php

	$localPage="client login";

	//Check if client is logged in first
	if (checkLoggedIn()) {
	header("Location: /client/".$_SESSION['username']."/home"); }

?>


<?php include ('head.php'); ?>


	

    <div class="modal">
    
    <div class="modal-body">
    <img src="http://www.circuitpro.co.uk/images/circuit-pro-logo.png">
    <form action="login.php" method="post" name="clientLogin" enctype="multipart/form-data" onsubmit="return formVerify();">
    Username<br>
    <input class="text-field" name="username" type="text"  placeholder=" "/>
Password<br>
    <input class="text-field" name="password" type="password" placeholder=" " />
    </div>
    <div class="modal-footer">

    <input class="btn btn-warning" name="submitButtonName" type="submit" value="Login to Client Site" onSubmit="return formVerify()" /></form>
    </div>
    
       
  </body>
</html>


