
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <base href="<?php echo SITE_URL; ?>/">

    <title>Kingdom Creative - Client Site</title>

    <!-- Bootstrap core CSS -->
    <link href="http://kingdom-creative.co.uk/client/css/bootstrap.min.css" rel="stylesheet">



  </head>

  <body>

  
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="header">
      <div class="container">
      <div class="row">
      <div class="col-xs-3 col-sm-2 col-md-2">
      <a href="<?php echo $client->username_CLIENT; ?>/home"><img src="http://kingdom-creative.co.uk/wp-content/uploads/2014/01/kingdom-color-white.png"></a>
      </div>
      
       <div class="col-xs-9 col-sm-10 col-md-10 right-cl hidden-xs hidden-sm">
<ul class="nav nav-pills navbar-right">
<li><a href="http://kingdom-creative.co.uk/client/">Home</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/home">Active Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/projects">Completed Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/logout">Logout</a></li></ul>
      </div>
      
      <div id="phone_visible" class="visible-xs">
<a href="#"><i class="fa fa-bars"></i></a>
</div>

<div class="phone-menu">
<ul class="nav nav-pills nav-stacked">
<li><a href="<?php echo $client->username_CLIENT; ?>/home">Home</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/home">Active Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/projects">Completed Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/logout">Logout</a></li>


</div>
      
      </div>
      </div>
    </div> <!-- /HEADER -->
    
    

		
		<!-- Support for IE9 -->
		<!--[if lt IE 9]>
			<script type='text/javascript' src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<script type='text/javascript' src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<link rel="stylesheet" href="css/ie.css">
		<![endif]-->
	


  </body>
</html>
