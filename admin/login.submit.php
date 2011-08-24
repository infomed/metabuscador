<?php
/******************************
**	PHP Login Ajax JQuery
**	programmer@chazzuka.com
**	http://www.chazzuka.com/
*******************************/
// start session
session_start();
// include config class
require_once('login.class.php');
// create instance
$Login	= new Login;
// signin
$Login->signin();

?>