<?php

include('db.php');


?>

<?php
$localPage = 'please login';

 include ('head.php'); ?>
 
<script type="text/javascript" language="JavaScript1.2"><!--

var formVerify = function () {

	var errorMsgOrder = new Array();
	var errorMsg = '';
	
	//Username
	if (document.clientLogin['username'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Username not entered';
	//Password
	if (document.clientLogin['password'].value.length == 0)
		errorMsgOrder[errorMsgOrder.length] = 'Password not entered';
	
	if (errorMsgOrder.length != 0)
		errorMsg = 'Error: ' + errorMsgOrder.join(', ') + '.';
	if (errorMsg.length > 0) {
		alert(errorMsg);
		return false;
	}
	
	document.getElementById("status").style.visibility="visible";
	document.newProfile.submitButtonName.disabled = true;
	return true;
	
};


//-->
</script>


    <div class="modal">
    
    <div class="modal-header">
    <img src="http://www.circuitpro.co.uk/images/circuit-pro-logo.png">
    </div>
    
    <div class="modal-body"><h4>Login to access this page!</h4>
  
    
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


