<?php

// start session
session_start();
// include config class
require_once('login.class.php');
// create instance
$Login	= new Login;
// check permission
$Login->checkauth();
?>
<!--***********************************
*	PHP AJAX USING JQUERY
*	programmer@chazzuka.com
*	http://www.chazzuka.com
***********************************-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo utf8_encode("Administración");  ?></title>
<meta name="robots" content="noindex,nofollow" />
<link href="css/login.css" rel="stylesheet" media="all" type="text/css" />
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/form.js"></script>
<script language="javascript" type="text/javascript" src="js/login.js"></script>
</head>
<body>
    <div id="admin"><b><?php echo utf8_encode("Administración");  ?> del Servicio de Busqueda</b></div><div>&nbsp;</div>
	<div id="err"></div>
	<div id="wrapper"></div>
    <div id="footer">
            </div>
</body>
</html>
