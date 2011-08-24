<?php

  require_once 'config.php';
  require 'libs/search_engines.lib.php';
  require 'libs/utiles.lib.php';    //pasar para lib
  require 'libs/XMLParamParser.php';

  ini_set('display_errors', '1');

  $template = 'advanced_search.tpl';
  $tmpl = new SmartyCustom;

  $errors= array();
  $search_manager = new SearchEngineManager($mdb);

  if ("GET" == $_SERVER['REQUEST_METHOD'])
  {
    $input = $_GET;

    $client = new SoapClient($wsdl_path,array("trace"=>1, "exceptions"=>1));
    $search_engines = $client->listSearchEngines();

    //Obteniendo el primer search engine
    $first_engine= $search_engines[0];
    //print_r($first_engine); exit;
    //obteniendo el arreglo con los parametros y sus valores
    $parameters_array = $search_manager->getParamsArray($first_engine->id);   

    $tmpl->assign('search_engines',$search_engines);
    $tmpl->assign('first_engine',$first_engine);
    $tmpl->assign('parameters',Utiles::generateSearchEngineParam($parameters_array,""));    $tmpl->display($template);
  }
  else
  {
      $input = $_POST;

      if(isset($input['queries']))
      {
        $query = $input['queries'];
      	$search_id = $input['searchers'];
      	$count_elem = 10;
      	$init_elem = 1;

      	try
        {
            $query = Utiles::replace_acent($query);//para elminar el acento de la consulta

            $parameters_array = $search_manager->getParamsArray($search_id);

            $param_valor_xml = Utiles::getParamsValorXML($parameters_array,$input);

            $xml = new XMLParamParser();
            $parameters = $xml->readXMLParamValor($param_valor_xml);

            $client = new SoapClient($wsdl_path,array("trace"=>1, "exceptions"=>1));
            //print_r($parameters); exit;
            $result = $client->advancedSearch($query, $search_id, $count_elem, $init_elem,$parameters);


            $tmpl->assign('result',$result);
            $tmpl->display("advanced_search_results.tpl");
		}

		catch (SoapFault $fault)
		{
			echo $fault->faultstring;
			print "<pre>\n";
				print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n";
				print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n";
				print "Headers:\n".htmlspecialchars($client->__getLastRequestHeaders())."\n";
				print "</pre>";
		}
      }


  }

?>