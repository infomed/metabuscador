<?php

 require_once '../../config.php';
 require '../../libs/infoSource_engines.lib.php';
 require '../../libs/search_engines.lib.php';
 require '../../libs/XMLParamParser.php';
 require '../../libs/utiles.lib.php';

 $search_manager = new SearchEngineManager($mdb);
 $parameters_array = $search_manager->getParamsArray($_GET['searchers']);

 echo Utiles::generateSearchEngineParam($parameters_array,'');
?>