<?php

  require_once 'config.php';
  require 'libs/utiles.lib.php';    //pasar para lib

  ini_set('display_errors', '1');

  $tmpl = new SmartyCustom;

  $errors= array();
  $parametersValue_array= array(); //arreglo con los nombres de los param de un buscador y sus valores

  $opr='';

  $input = $_GET;

  if(isset($input['q']))
  {
    $query = $input['q'];

    //print($query); exit;
    //$infoS_id = $input['d'];
    //$count_elem = $input['c'];
    //$init_elem = $input['i'];
    //ver
    //$page = $input['p'];
    //$format = $input['format'];

    $infoS_id = 38;
    $count_elem = 10;
    $init_elem = 1;

  	try
      {
        $query = Utiles::replace_acent($query);
        $client = new SoapClient($wsdl_path,array("trace"=>1, "exceptions"=>1));
        $result = $client->search($query, $infoS_id, $count_elem, $init_elem);
        $tmpl->assign('result',$result);
        $tmpl->display("main_search_results.tpl");

       // print_r($result); exit;
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

?>