<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>


<?php

	$localPage="client login";
	

	//Check if client is logged in first
	if (checkLoggedIn()) {
	
	session_start();
	
	if(isset($_COOKIE['client-ID'])){
		$clientData = fetchClientData($_COOKIE['client-ID']); 
		$_SESSION['_ID'] = $clientData->_kp_CLIENT;
		$_SESSION['username'] = $clientData->username_CLIENT;
        $_SESSION['password'] = $clientData->password_CLIENT;
	
	}
	
	header("Location: /client/".$_SESSION['username']."/home"); }

?>



<?php include ('head_index.php'); ?>


    
    <div class="container" id="login">
    <div class="row">
    
    <div class="span12">
    <h1>Welcome to your client site!</h1>
    <h5 class="sub-title hidden-xs">We hope you enjoy your stay</h5>

    <p>&nbsp;</p>
    <h5 class="sub-title">Please sign in</h5>
    </div>
    
    <div class="span6">
    
<form action="login.php" class="hide-ie" method="post" name="clientLogin" enctype="multipart/form-data"class="form-signin" role="form"  onsubmit="return formVerify();">
        <p><input type="text" class="form-control" placeholder="Username" name="username" required="" autofocus=""></p>
        <p><input type="password" class="form-control" placeholder="Password" name="password" required=""></p>
      
<!--
 <label class="checkbox">
          <input type="checkbox" value="remember"> Keep me logged in
        </label>
-->

         <input class="btn btn-primary" name="submitButtonName" type="submit" value="Login to Client Site" onSubmit="return formVerify()" />
      </form>
      
      
<form action="login.php" class="show-ie" method="post" name="clientLogin" enctype="multipart/form-data" class="form-signin" role="form"  onsubmit="return formVerify();">
        <p><input type="text" class="form-control" value="Username" name="username" required="" onfocus="this.value = '';"></p>
        <p><input type="password" class="form-control" value="Password" name="password" required="" onfocus="this.value = '';"></p>
        
<!--
<label class="checkbox">
          <input type="checkbox" value="remember"> Keep me logged in
        </label>
-->

         <input class="btn btn-primary" name="submitButtonName" type="submit" value="Login to Client Site" onSubmit="return formVerify()" />
      </form>




    </div>
    
    </div>
    </div>
       
<?php include ('footer.php'); ?>

