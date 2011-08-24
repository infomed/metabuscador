<?php

  include 'config.php';
  require 'libs/infoSource_engines.lib.php';
  require 'libs/utiles.lib.php';    //pasar para lib
  require 'libs/adaptors_interface.php';
  require 'modulos/adaptadores/general_adaptor.php';

  ini_set('display_errors', '1');

  $template = 'main_search.tpl';
  $tmpl = new SmartyCustom;

  $errors= array();
  $parametersValue_array= array(); //arreglo con los nombres de los param de un buscador y sus valores
  $fi_manager = new InfoSourceEngineManager($mdb);

  $opr='';

  if ("GET" == $_SERVER['REQUEST_METHOD'])
  {
    $input = $_GET;

    //$modos = array("General","Presentaciones","Documentos");
    $client = new SoapClient($wsdl_path,array("trace"=>1, "exceptions"=>1));
    $infosources = $client->listInfoSources();
    foreach($infosources as $source)
    {
       $source->name = utf8_decode($source->name);
       $source->description = utf8_decode($source->description);
    }

    $tmpl->assign('infosources',$infosources);

    $tmpl->display($template);

  }
  else
  {
      $input = $_POST;

      if(isset($input['queries']))
      {
        $query = $input['queries'];
      	$infoS_id = $input['infosources'];
      	$count_elem = 10;
      	$init_elem =1;

      	try
        {
            $query = Utiles::replace_acent($query);
            $client = new SoapClient($wsdl_path,array("trace"=>1, "exceptions"=>1));
            $result = $client->search($query, $infoS_id, $count_elem, $init_elem);

            /*print_r($query);
            print_r('<br>');
            print_r($wsdl_path);
            print_r('<br>');
            print_r($infoS_id);
            print_r('<br>');
            print_r($count_elem);
            print_r('<br>');
            print_r($init_elem);
            print_r('<br>');
            print_r($result); exit;*/

            $tmpl->assign('result',$result);
            $tmpl->display("main_search_results.tpl");

            //probando RSS
           /* $results = $result["results"];

			//obtener estos param mediante infoS_id;
			$name = "NAME";
			$description = "RESULTS";
			$link = "http://buscador.sld.cu/main_search.php";
			$syndicationURL = "http://buscador.sld.cu/main_search.php";

			$adaptor = new GeneralAdaptor();

			$adaptor->ToRSS($results, $name, $description, $link, $syndicationURL);*/

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
