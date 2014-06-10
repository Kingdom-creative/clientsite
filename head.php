
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.ico">

    <base href="<?php echo SITE_URL; ?>/">

    <title>Kingdom Creative - Client Site</title>

    <!-- Bootstrap core CSS -->
    <link href="http://kingdom-creative.co.uk/client/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://kingdom-creative.co.uk/client/style.css" rel="stylesheet">
    <link href="http://kingdom-creative.co.uk/client/css/font.css" rel="stylesheet">
    <link href="http://kingdom-creative.co.uk/client/css/font-awesome.css" rel="stylesheet">
    
    
    
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39014090-3', 'circuitpro.co.uk');
  ga('send', 'pageview');

</script> 

  </head>

  <body>

  
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="header">
      <div class="container">
      <div class="row">
      <div class="span2">
      <a href="<?php echo $client->username_CLIENT; ?>/home"><img src="http://kingdom-creative.co.uk/wp-content/uploads/2014/01/kingdom-color-white.png"></a>
      </div>
      
       <div class="span10 right-cl">
<ul class="nav nav-pills navbar-right">
<li><a href="<?php echo $client->username_CLIENT; ?>/home">Active Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/projects">Completed Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/logout">Logout</a></li></ul>
      </div>
      
<!--
      <div id="phone_visible" class="visible-xs">
<a href="#"><i class="fa fa-bars"></i></a>
</div>
-->

<div class="phone-menu">
<ul class="nav nav-pills nav-stacked">
<li><a href="<?php echo $client->username_CLIENT; ?>/home">Active Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/projects">Completed Projects</a></li>
<li><a href="<?php echo $client->username_CLIENT; ?>/logout">Logout</a></li>


</div>
      
      </div>
      </div>
    </div> <!-- /HEADER -->