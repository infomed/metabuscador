Requisitos:

- PHP 5
- Mysql 5
- Extensión SOAP de PHP
- Smarty
- MDB2 de Pear

Instalación:

- Renombre el fichero config-sample.php por config.php.

- Cree una base de datos e inserte el SQL que se encuentra en DB/buscador.sql

- Ajuste los sgte parametros del config.php:
  
   //configuración de la base de datos
   $CONFIG['DB_HOST'] = 'localhost';
   $CONFIG['DB_NAME'] = '';
   $CONFIG['DB_USER'] = '';
   $CONFIG['DB_PASS'] = '';

   //configuración de Smarty
   $CONFIG['SMARTY_TEMPLATE_DIR'] = '/var/www/metabuscador/templates/';
   $CONFIG['SMARTY_COMPILE_DIR'] = '/var/www/metabuscador/templates_c/';
   $CONFIG['SMARTY_CONFIG_DIR'] = '/var/www/metabuscador/configs/';
   $CONFIG['SMARTY_CACHE_DIR'] = '/var/www/metabuscador/cache/';

   //section paths
   $dir = '/var/www/metabuscador/modulos';

   // Determine the base URL
   $wsdl_path = 'http://localhost/metabuscador/index.php?wsdl';

- El ejemplo que se muestra se basa en la búsqueda sobre Solr por la previa indexación de un dominio por Nutch. Para cambiar la la URL de solr edite el fichero modulos/buscadores/sitiosinfomedsolr_search_engine.php y cambie la URL:
 
  // URL Solr (Indexes crawl DB with solr for Nutch)
  $baseSolrURL = "http://localhost:8983/solr/core0/select/";

- La documentación del metabuscador puede encontrala en doc/Documentacion del Servicio de Búsqueda.pdf

- Se recomienda crear un VirtualHost que apunte por ejemplo a /var/www/metabuscador/ , pero esto es opcional.


