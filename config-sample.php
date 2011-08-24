<?php
   ini_set('display_errors', '1');

   //section Smary y PEAR
   require_once 'smarty/libs/Smarty.class.php';
   require_once 'MDB2.php';

   $CONFIG = array();
   $CONFIG['DB_HOST'] = 'localhost';
   $CONFIG['DB_NAME'] = '';
   $CONFIG['DB_USER'] = '';
   $CONFIG['DB_PASS'] = '';

   $CONFIG['SMARTY_TEMPLATE_DIR'] = '/var/www/buscador/templates/';
   $CONFIG['SMARTY_COMPILE_DIR'] = '/var/www/buscador/templates_c/';
   $CONFIG['SMARTY_CONFIG_DIR'] = '/var/www/buscador/configs/';
   $CONFIG['SMARTY_CACHE_DIR'] = '/var/www/buscador/cache/';
   $CONFIG['SMARTY_USE_CACHING'] = false;

   class SmartyCustom extends Smarty
   {
     function __construct()
     {
        // Class Constructor.
        // These automatically get set with each new instance.

        $this->Smarty();
        global $CONFIG;

        $this->template_dir = $CONFIG['SMARTY_TEMPLATE_DIR'];
        $this->compile_dir  = $CONFIG['SMARTY_COMPILE_DIR'];
        $this->config_dir   = $CONFIG['SMARTY_CONFIG_DIR'];
        $this->cache_dir    = $CONFIG['SMARTY_CACHE_DIR'];

        $this->caching = $CONFIG['SMARTY_USE_CACHING'];
      }
   }

   $dsn = 'mysql://'.$CONFIG['DB_USER'].':'.$CONFIG['DB_PASS'].'@'.$CONFIG['DB_HOST'].'/'.$CONFIG['DB_NAME'];
   $options = array ('persistent' => true);
   $mdb =& MDB2::factory($dsn, $options);
   $mdb->setFetchMode(MDB2_FETCHMODE_ASSOC);

   //end section Smary y PEAR

   //section PROXYS
   $PROXYS = array();

   $PROXYS[]= array('proxy_host' => '' , 'proxy_login' => "", 'proxy_password' => "", 'proxy_port' => 3128, 'proxy_user' => "", 'proxy_pass' => "");

   //section paths
   $dir = '/var/www/buscador/modulos';

   // Determine the base URL
    $wsdl_path = 'http://localhost/buscador/index.php?wsdl';

   //end section paths

?>
