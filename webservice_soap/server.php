<?php

ini_set('display_errors', '0');
ini_set('soap.wsdl_cache_enabled', '0'); // disabling WSDL cache

require_once '../config.php';
require '../libs/XMLParamParser.php';
require '../libs/search_engines.lib.php';
require '../libs/adaptors_engines.lib.php';
require '../libs/infoSource_engines.lib.php';
require '../libs/search_interface.php'; //pasar para lib
require '../libs/adaptors_interface.php';
require '../libs/utiles.lib.php';
require '../libs/feedcreator.class.php';

// Define the method as a PHP function
 function search($query,$infoS_id,$count_elem,$init_elem)
 {
    global $mdb;
   //acciones relacionadas con la fuente de información
 	$infoS_manager = new InfoSourceEngineManager($mdb);
 	$infoS = $infoS_manager->get($infoS_id); //obteniendo objeto fuente de informacion

    $xmlParser= new XMLParamParser();
 	//obteniendo arreglo con los parametros de la fuente de informacion y sus valores
 	$array_params = $xmlParser->readXMLParamValor($infoS->getSearchEngineParams());
    //acciones relacionadas con el buscador
 	$searchE_id = $infoS->getSearchEngineId(); //obteniendo id del buscador
    $searchE_manager = new SearchEngineManager($mdb);
 	$searchE = $searchE_manager->get($searchE_id);//obteniendo el objeto buscador
 	$class_name = $searchE->getClassName(); //obteniendo nombre de la clase del buscador

 	$implementation = $searchE->getImplementation(); //
 	require_once "../modulos/buscadores/".$implementation;

 	//instanciación de la clase e invocación del método search
 	$search_object = new $class_name();

 	$result = $search_object->search($query,$count_elem,$init_elem,$array_params);
 	return $result;
 }
 function listInfoSources()
 {
   global $mdb;
   $infoS_manager = new InfoSourceEngineManager($mdb);

   return $infoS_manager->getAll(); //obteniendo todas las FI registradas en la BD
   //getAll devuelve un arreglo de objetos InfoSourceEngine
 }

 function listSearchEngines()
 {
   global $mdb;
   $searchE_manager = new SearchEngineManager($mdb);

   return $searchE_manager->getAll();
 }

 function listAdaptorEngines()
 {
   global $mdb;
   $adapE_manager = new AdaptorEngineManager($mdb);

   return $adapE_manager->getAll();
 }

 function advancedSearch($query, $searchE_id, $count_elem, $init_elem, $parameters)
 {
    global $mdb;

    //obteniendo arreglo de parametros y sus valores (a partir del StdClass de entrada)
    $param = Utiles::parseStdClassParam($parameters);

    //acciones relacionadas con el buscador
 	$searchE_manager = new SearchEngineManager($mdb);
 	$searchE = $searchE_manager->get($searchE_id);//obteniendo el objeto buscador
 	$class_name = $searchE->getClassName(); //obteniendo nombre de la clase del buscador
 	$implementation = $searchE->getImplementation();
 	require_once "../modulos/buscadores/".$implementation;

    //instanciación de la clase e invocación del método search
 	$search_object = new $class_name();
 	$result = $search_object->search($query,$count_elem,$init_elem,$param);
    return $result;
 }

 function adaptTo($format, $infoS_id, $results, $link, $path)
 {
    global $mdb;
    //acciones relacionadas con la fuente de información
 	$infoS_manager = new InfoSourceEngineManager($mdb);
 	$infoS = $infoS_manager->get($infoS_id); //obteniendo objeto fuente de informacion
    //obteniendo search engine ID
    $sEng_id = $infoS->getSearchEngineId();

    //acciones relacionadas con los adaptadores
 	$adaptor_manager = new AdaptorEngineManager($mdb);
 	//obtener adaptadores para un search engine dado
 	$adaptors = $adaptor_manager->getByEngineId($sEng_id); //obteniendo objeto adaptador
    $adaptor;

    /*por si hay mas de un adaptador, aqui se escoge el del forato dado, los adaptadores se deben
    nomenclar name format-name ej: lis RSS*/
 	foreach($adaptors as $adap)
 	{
 		$name = $adap->getName();

 		if(strstr($name, $format))
 		{
 			$adaptor = $adap;
 			break;
 		}
 	}
    //preparando parametros para ejecutar el adaptador
 	$results = $results["results"];
    $name = $adaptor->getName();
    $description = $adaptor->getDescription();
    $syndicationURL = $link;
    $class_name = $adaptor->getClassName(); //obteniendo nombre de la clase del buscador
    $implementation = $adaptor->getImplementation(); //
 	require_once "../modulos/adaptadores/".$implementation;

    //instanciación de la clase e invocación del método search
 	$adapt_object = new $class_name();
 
       $adapt_object->adaptTo($format, $results, $name, $description, $link, $syndicationURL,$path);

 	$nombre_archivo = $path."/".$name.".xml";

 	return (string)$nombre_archivo; 

 }
 /*function _convertEncoding($string)
 {
	return 0 === strlen($this->getEncoding() || 'utf-8' === strtolower($this->getEncoding())) ? $string : mb_convert_encoding($string, 'UTF-8', $this->getEncoding());
 } */

$server = new SoapServer($wsdl_path);
$server->addFunction('search');
$server->addFunction('listInfoSources');
$server->addFunction('listSearchEngines');
$server->addFunction('listAdaptorEngines');
$server->addFunction('advancedSearch');
$server->addFunction('adaptTo');

$server->handle();

?>
