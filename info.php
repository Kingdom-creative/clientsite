<?php

$to = "ben.treston@circuitpro.co.uk";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "support@circuitpro.co.uk";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);


?>