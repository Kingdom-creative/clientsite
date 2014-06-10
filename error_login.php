<?php include ('db.php'); ?>
<?php include ('functions.php'); ?>


<?php

	$localPage="client login";

	//Check if client is logged in first
	if (checkLoggedIn()) {
	header("Location: /client/".$_SESSION['username']."/home"); }

?>



<?php include ('head_index.php'); ?>



    
    <div class="container" id="login">
    <div class="row">
    
    <div class="col-xs-12">
    <h1>Welcome to your new client site!</h1>
    <h5 class="sub-title hidden-xs">We hope you enjoy your stay</h5>
    <p class="hidden-xs">Our re-brand has given us the opportunity to make things better for you and as we want to make clients lives easier, we know little changes affect our clients in a huge way. <br>We always appreciate feedback and are happy to tailor things to your needs. <a href="#">Get in touch and let us know how we can improve your experience.</a></p>
    <p>&nbsp;</p>
    <h5 class="sub-title">Please sign in</h5>
    </div>
    
    <div class="col-md-6">
    
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
      
      
<form action="login.php" class="show-ie" method="post" name="clientLogin" enctype="multipart/form-data"class="form-signin" role="form"  onsubmit="return formVerify();">
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

