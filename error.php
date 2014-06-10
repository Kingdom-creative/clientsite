 <? include ('head.php'); ?>

 <div class="container" id="login">
    <div class="row">
    
    <div class="col-xs-12">
    <h1><?php print($thisException->getMessage()); ?></h1>
    <h5 class="sub-title">3 Strikes and you're out</h5>
    <p>&nbsp;</p>
    <h5 class="sub-title">Please sign in</h5>
    </div>
    
    <div class="col-md-6">
    
<form action="login.php" class="hide-ie" method="post" name="clientLogin" enctype="multipart/form-data"class="form-signin" role="form"  onsubmit="return formVerify();">
        <p><input type="text" class="form-control" placeholder="Username" name="username" required="" autofocus=""></p>
        <p><input type="password" class="form-control" placeholder="Password" name="password" required=""></p>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
         <input class="btn btn-primary" name="submitButtonName" type="submit" value="Login to Client Site" onSubmit="return formVerify()" />
      </form>
      
      
<form action="login.php" class="show-ie" method="post" name="clientLogin" enctype="multipart/form-data"class="form-signin" role="form"  onsubmit="return formVerify();">
        <p><input type="text" class="form-control" value="Username" name="username" required="" autofocus=""></p>
        <p><input type="password" class="form-control" value="Password" name="password" required=""></p>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
         <input class="btn btn-primary" name="submitButtonName" type="submit" value="Login to Client Site" onSubmit="return formVerify()" />
      </form>




    </div>
    
    </div>
    </div>


<?php include ('footer.php'); ?>
