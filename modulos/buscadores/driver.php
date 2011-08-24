<?php

 set_time_limit("500");
 //include "../../xmlrpclib/xmlrpc.inc";
 require '../../libs/search_interface.php';
 //require '../../libs/XMLParamParser.php';
 require '../../config.php';
 //require "infoenlaces_search_engine.php";
 require "decs_search_engine.php";
 //require "bibliographic_search_engine.php";
 //require "aldia_search_engine.php";
 //include 'statistic_search_engine.php';
 //require "scielo_search_engine.php";
  //require "Cursos_search_engine.php";
 //require "events_search_engine.php";
 //require "blogs_search_engine.php";
 // require "politicas_search_engine.php";
  //require "cumed_search_engine.php";
 //require "liscuba_search_engine.php";

// require  "instituciones_search_engine.php";

 $query = 'Envejecer';
// $query = 'salud';
 //$param = array("collection" => "Argentina");
 $param = array();


 $x = new DecsSearchEngine();
 //$x = new  LisBiremeSearchEngine();
 //$x = new CumedSearchEngine();
 //$x = new EventsSearchEngine();
 // $x = new LisBiremeSearchEngine();
 $results = $x->search("asma", 10, 1, array());

 print_r($results);

?>
