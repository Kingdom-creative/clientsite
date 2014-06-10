<?php 

//Local  

/*
  
	define('DBHOST', '127.0.0.1');
	define('DBUSER', 'db_user');
	define('DBPASS', 'entree');
	define('DBASE', 'clientsite');
	
*/
//Remote

	define('DBHOST', 'localhost');
	define('DBUSER', 'root');
	define('DBPASS', 'root');
	define('DBASE', 'clientsite'); 
	
//Other Vars

	define('PROJECT_RESULTS_PER_PAGE', '10');
	define('SITE_URL','http://'.$_SERVER['SERVER_NAME'] .dirname($_SERVER['PHP_SELF']));
	define('SITE_SUPPORT_EMAIL', 'support@circuitpro.co.uk');
	
	
?>