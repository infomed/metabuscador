<?php

class XMLParamParser
{
  function readXMLParam($myxml)
  {	  $doc = new DOMDocument();
	  $doc->loadXML($myxml);
	  $param_list = $doc->getElementsByTagName( "param" );

	  $parameters = array();
	 foreach( $param_list as $param )
	 {
	   $name = $param->getElementsByTagName( "name" )->item(0);

	   $type = $param->getElementsByTagName( "type" )->item(0);

	   $param_array= array();
	   $param_array[0]= $name->nodeValue;
	   $param_array[1]= $type->nodeValue;

	  if($type->nodeValue=="list")
	  {
	      $option= $param->getElementsByTagName("options")->item(0);
	      $label_list= $option->getElementsByTagName("label");

	      $options_array=array();

	       foreach($label_list as $label)
	       {
	         $label_key= $label->getAttribute('value');
	         $label_name=$label->nodeValue;
             $options_array[$label_key]= $label_name;

	       }
	       $param_array[2]=$options_array;
	  }

	  $parameters []= $param_array;
	 }

     return $parameters;
  }

  function writeXMLParam($array_params)
  {
     $doc = new DOMDocument();
     $doc->formatOutput = true;

     $ps = $doc->createElement( "parameters" );
     $doc->appendChild( $ps );

     foreach($array_params as $param )
     {
        $p = $doc->createElement("param");

        //creando tag de name
        $name = $doc->createElement("name");
	    $name->appendChild($doc->createTextNode($param[0]));//name

	    $p->appendChild( $name );

        //creando tag de type
	    $type = $doc->createElement("type");
	    $type->appendChild($doc->createTextNode($param[1]));//type

	    $p->appendChild( $type );

        if(count($param)==3) //el type  es list
        {
	    	  //creando tag de options
	    	 $options = $doc->createElement( "options" );

          //cogiendo las llaves del arreglo de opciones,se encuentra en la pos 2
             $options_labels= array_keys($param[2]);

	         foreach($options_labels as $label)
             {
                //creando los tag de label
		         $l = $doc->createElement( "label" );
		         $l->appendChild($doc->createTextNode($param[2][$label]));
		         $l->setAttribute('value',$label);

		         $options->appendChild($l);
             }

	    	 $p->appendChild( $options );
    	 }
    	 $ps->appendChild( $p);
      }

    return $doc->saveXML();
  }

  function readXMLParamValor($myxml)
  {
      $doc = new DOMDocument();
	  $doc->loadXML($myxml);
	  $param_list = $doc->getElementsByTagName( "param" );

	  $parameters = array();

	 foreach($param_list as $param )
	 {
	    $param_name= $param->getAttribute('name');
		$param_value=$param->nodeValue;

		$parameters[$param_name]=$param_value;

	 }

     return $parameters;

  }

  function writeXMLParamValor($buscador_params)
  {
     $doc = new DOMDocument();
     $doc->formatOutput = true;

     $r = $doc->createElement( "parameters" );
     $doc->appendChild( $r );

     $param_names= array_keys($buscador_params);

     foreach($param_names as $name)
     {
         $param = $doc->createElement( "param" );
         $param->appendChild($doc->createTextNode($buscador_params[$name]));
         $param->setAttribute('name',$name);

         $r->appendChild($param);     }
     return $doc->saveXML();
  }
  function readXMLConfig($myxml)
  {
      $config_array = array();
	  $doc = new DOMDocument();
	  $doc->load($myxml);

	  //fichero de implementacion
	  $implementation = $doc->getElementsByTagName("implementation");
	  $implementation = $implementation->item(0)->nodeValue;
      $config_array["implementation"] = $implementation;
	  //nombre de la clase
	  $classname = $doc->getElementsByTagName("classname");
	  $classname = $classname->item(0)->nodeValue;
	  $config_array["classname"] = $classname;

	  //parametros del buscador
	  $param_list = $doc->getElementsByTagName("param");
      $parameters = array();

      foreach($param_list as $param )
	  {
	    $name = $param->getElementsByTagName( "name" )->item(0);

	    $type = $param->getElementsByTagName( "type" )->item(0);

	    $param_array= array();
	    $param_array[0]= $name->nodeValue;
	    $param_array[1]= $type->nodeValue;

	    if($type->nodeValue=="list")
	    {
	      $option= $param->getElementsByTagName("options")->item(0);
	      $label_list= $option->getElementsByTagName("label");

	      $options_array=array();

	       foreach($label_list as $label)
	       {
	         $label_key= $label->getAttribute('value');
	         $label_name=$label->nodeValue;
             $options_array[$label_key]= $label_name;
	       }
	       $param_array[2]=$options_array;
	    }
	   $parameters []= $param_array;
	  }

     $config_array["parameters"] = $parameters;
     return $config_array;
  }}

?>