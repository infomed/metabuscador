<?php
ini_set('display_errors', '1');
ini_set('soap.wsdl_cache_enabled', '0'); // disabling WSDL cache

require_once '../config.php';

//parametros
$query = 'asma';
$infoS_id = '27'; //sitios de cuba
//$infoS_id = '7'; //localizador bireme
//$infoS_id = '9'; //localizador de salud

$count_elem = '10';
$init_elem = '0';

try
{
    //$client = new SoapClient($wsdl_path/*'http://localhost/buscador/index.php?wsdl'*/,array("trace"=>1, "exceptions"=>1));

    $client = new SoapClient('http://buscador.sld.cu/index.php?wsdl',array("trace"=>1, "exceptions"=>1));
    //$result = $client->search($query, $infoS_id, $count_elem, $init_elem);
    //$result = $client->listInfoSources();
    $result = $client->listSearchEngines();
	/*if (isset($_GET['debug'])) {        print "<pre>\n";
		print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n";
		print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n";
		print "Headers:\n".htmlspecialchars($client->__getLastRequestHeaders())."\n";
		print "</pre>";
	}   */
	print_r($result); exit;
}

catch (SoapFault $fault)
{	echo $fault->faultstring;
	print "<pre>\n";
		print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n";
		print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n";
		print "Headers:\n".htmlspecialchars($client->__getLastRequestHeaders())."\n";
		print "</pre>";
}
?>
