<?php

include('db.php');

session_start();
session_destroy();

//see if cookie is set and kill it

if(isset($_COOKIE['client-ID'])) {
	
	setcookie('client-ID', $userDetail->email, time() - (86400 * 60));

	}

?>

<?php
$localPage = 'logged out';

 include ('head_index.php'); ?>


<div class="container" id="login">
    <div class="row">
    
    <div class="col-xs-12">
    <h1>You are now logged out</h1>
    <h5 class="sub-title">Please visit us again soon</h5>
    <p>&nbsp;</p>

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
         <input class="btn btn-primary" name="submitButtonName" type="submit" value="Login again to Client Site" onSubmit="return formVerify()" />
      </form>
      
      
<form action="login.php" class="show-ie" method="post" name="clientLogin" enctype="multipart/form-data"class="form-signin" role="form"  onsubmit="return formVerify();">
        <p><input type="text" class="form-control" value="Username" name="username" required="" autofocus="" onfocus="this.value = '';"></p>
        <p><input type="password" class="form-control" value="Password" name="password" required="" onfocus="this.value = '';"></p>
<!--
        <label class="checkbox">
          <input type="checkbox" value="remember"> Keep me logged in
        </label>
-->
         <input class="btn btn-primary" name="submitButtonName" type="submit" value="Login again to Client Site" onSubmit="return formVerify()" />
      </form>




    </div>
    
    </div>
    </div>
       
<?php include ('footer.php'); ?>

