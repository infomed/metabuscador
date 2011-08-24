<?php					
if (version_compare(PHP_VERSION,'5','>='))
   include('xmlrpc-php5.inc');
else
   include('xmlrpc-php4.inc');
?>
