<?php

$serverName = "SONY\MSSQLSERVER2014";
$connectionInfo = array( "Database"=>"SocHarcumOnLine",'CharacterSet' => 'UTF-8' , "UID"=>"sa", "PWD"=>"123");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>