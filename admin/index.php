<?php
/******************************
**	PHP Login Ajax JQuery
*******************************/
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
<title>ajax PHP Login function tutorial with jquery</title>
<link href="css/index.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
    <div id="footer">
   <a href="http://<?php echo $_SERVER['SERVER_NAME']?>/buscador/admin/buscadores/index.php">Buscadores</a>
   <div>&nbsp;</div>
    <a href="http://<?php echo $_SERVER['SERVER_NAME']?>/buscador/admin/fi/index.php"><?php echo utf8_encode("Fuentes de información")?></a>    </div>
    <div id="wrapper">
    	<a href="?a=logout">Log out/Salir</a>
    </div>
</body>
</html>
