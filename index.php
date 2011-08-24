<?php
ini_set('display_errors', '1');
require_once('webservice_soap/nusoap.php');

// Create the server instance
$server = new soap_server();

// Initialize WSDL support
$server->configureWSDL('SearchService', 'urn:searchService');

//adding complex types

//InfoSourceEngine
$server->wsdl->addComplexType(
    'InfoSourceEngine',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string'),
        'search_engine_id' => array('name' => 'search_engine_id', 'type' => 'xsd:int'),
        'params' => array('name' => 'params', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:int')
    )
);
//ArrayOfInfoSourceEngine
$server->wsdl->addComplexType(
	'ArrayOfInfoSourceEngine',
	'complexType',
	'array',
	'',
	'SOAP-ENC:Array',
	array(),
	array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'InfoSourceEngine[]')),
	'InfoSourceEngine'
);
//SearchResult
$server->wsdl->addComplexType(
    'SearchResult',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'title' => array('name' => 'title', 'type' => 'xsd:string'),
        'url' => array('name' => 'url', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string')
    )
);
//ArrayOfSearchResult
$server->wsdl->addComplexType(
	'ArrayOfSearchResult',
	'complexType',
	'array',
	'',
	'SOAP-ENC:Array',
	array(),
	array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'SearchResult[]')),
	'SearchResult'
);

//SearchEngine
$server->wsdl->addComplexType(
    'SearchEngine',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string'),
        'params' => array('name' => 'params', 'type' => 'xsd:array'),
        'implementation' => array('name' => 'implementation', 'type' => 'xsd:string'),
        'class_name' => array('name' => 'class_name', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'type' => 'xsd:int')
    )
);
//ArrayOfSearchEngine
$server->wsdl->addComplexType(
	'ArrayOfSearchEngine',
	'complexType',
	'array',
	'',
	'SOAP-ENC:Array',
	array(),
	array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'SearchEngine[]')),
	'SearchEngine'
);

//AdaptorEngine
$server->wsdl->addComplexType(
    'AdaptorEngine',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'name' => array('name' => 'name', 'type' => 'xsd:string'),
        'description' => array('name' => 'description', 'type' => 'xsd:string'),
        'file' => array('name' => 'file', 'type' => 'xsd:string'),
        'class_name' => array('name' => 'class_name', 'type' => 'xsd:string'),
        'search_engine_id' => array('name' => 'search_engine_id', 'type' => 'xsd:int'),
        'id' => array('name' => 'id', 'type' => 'xsd:int')
    )
);
//ArrayOfAdaptorEngine
$server->wsdl->addComplexType(
	'ArrayOfAdaptorEngine',
	'complexType',
	'array',
	'',
	'SOAP-ENC:Array',
	array(),
	array(array('ref'=>'SOAP-ENC:arrayType','wsdl:arrayType'=>'AdaptorEngine[]')),
	'AdaptorEngine'
);


// Register the method to expose
$server->register('search',//method name
		array('query' => 'xsd:string', 'infoS_id' => 'xsd:int', 'count_elem' => 'xsd:int','init_elem' => 'xsd:int'),	// input parameters
		array('return' => 'ArrayOfSearchResult'),				    // output parameters
		'urn:Search_Service',						// namespace
		'urn:Search_Service#search',					// soapaction
		'rpc',											// style
		'encoded',										// use
		'Search information in an information source'		// documentation
);

$server->register('listInfoSources',//method name
		array(),	// input parameters
		array('return' => 'ArrayOfInfoSourceEngine'),		// output parameters
		'urn:Search_Service',						// namespace
		'urn:Search_Service#listInfoSources',					// soapaction
		'rpc',											// style
		'encoded',										// use
		'List all the information sources'		// documentation
);

$server->register('listSearchEngines',//method name
		array(),	// input parameters
		array('return' => 'ArrayOfSearchEngine'),		// output parameters
		'urn:Search_Service',						// namespace
		'urn:Search_Service#listSearchEngines',					// soapaction
		'rpc',											// style
		'encoded',										// use
		'List all the search engines'		// documentation
);

$server->register('listAdaptorEngines',//method name
		array(),	// input parameters
		array('return' => 'ArrayOfAdaptorEngine'),		// output parameters
		'urn:Search_Service',						// namespace
		'urn:Search_Service#listAdaptorEngines',					// soapaction
		'rpc',											// style
		'encoded',										// use
		'List all the adaptors engines'		// documentation
);

$server->register('advancedSearch',//method name
		array('query' => 'xsd:string', 'searchE_id' => 'xsd:int', 'count_elem' => 'xsd:int','init_elem' => 'xsd:int','parameters' => 'xsd:array'),	// input parameters
		array('return' => 'ArrayOfSearchResult'),				    // output parameters
		'urn:Search_Service',						// namespace
		'urn:Search_Service#advancedSearch',					// soapaction
		'rpc',											// style
		'encoded',										// use
		'Advanced Search in a search engine'		// documentation
);

$server->register('adaptTo',//method name
		array('format' => 'xsd:string', 'infoS_id' => 'xsd:int', 'results' => 'ArrayOfSearchResult', 'link' =>'xsd:string', 'path' => 'xsd:string'),	// input parameters
		array('return' => 'xsd:string'),		// output parameters
		'urn:Search_Service',						// namespace
		'urn:Search_Service#adaptTo',					// soapaction
		'rpc',											// style
		'encoded',										// use
		'List all the adaptors engines'		// documentation
);

// Use the request to (try to) invoke the service
$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);

?>