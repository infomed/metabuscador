<?php

 class SitiosinfomedsolrSearchEngine implements SearchInterface
 {

     public function search($query, $count_elem, $init_elem, $parameters)
     {
           if(is_array($parameters) AND $parameters['sites'] != '') {
             $params = $parameters['sites'];
           } else { $params = ''; }

           //return new SoapFault("Server",$init_elem);

           if ($init_elem > 0) $init_elem = $init_elem - 1;
            
           // URL Solr (Indexes crawl DB with solr for Nutch)
           $baseSolrURL = "http://localhost:8983/solr/core0/select/";
           
           if ($params != '') $query = $query.' AND url:"'.$params.'" AND NOT url:"www.sld.cu/rss"';
           $query = urlencode($query);

           //$fullURL = $baseSolrURL . '?q='.$query .'&version=2.2&start=' . $init_elem. '&rows=' . $count_elem . '&indent=on'. $format;
           $fullURL = $baseSolrURL . '?indent=on&q='.$query .'&version=2.2&start=' . $init_elem. '&rows=' . $count_elem . '&fl=*%2Cscore&qt=&wt=json&explainOther=&hl=on&hl.fl=title';
           
           $result = array();

 	   $resultsJson = file_get_contents_curl($fullURL);

 	   $results = json_decode($resultsJson);

 	   $total = $results->{'response'}->{'numFound'};

 	   foreach ($results->{'response'}->{'docs'} as $item){
                $description = explode(' ', strip_tags($item->{'content'}));
		$i = 0;
                $desc = '';
                $desc_title = '';
		foreach ( $description as $p ) {
		  $i++;
                  if ($i < 10) $desc_title .= $p.' ';
		  if ($i > 25) break;
		  $desc .= $p.' ';
		}
                
                $desc = preg_replace('/(@{.+?)+(}@)/i', '', $desc); 
                $title = ucfirst(strip_tags($item->{'title'}[0]));
                if ($title == '' || strlen($title) <= 10 ) $title = $desc_title.' ...';
                if ($item->{'type'}[0] == 'application/pdf') $title = '[PDF] '.$title;
                
                //$title = ereg_replace(" {1,}"," ",$title);
                //$desc = ereg_replace(" {1,}"," ",$desc);

 	        $result[] = array('title' => $title,
		             'url' => $item->{'url'},
		             'description' => $desc.' ...'
			   );
 	   }
//print_r($result); exit;
           return array("total" => $total, "results" => $result);
    }

    private function encode_params($parameters) {
    $param_names= array_keys($parameters);//obteniendo arreglo de nombres de los parametros

        foreach ($param_names as $name)
    	{
    	    $value= $parameters[$name];
    	    $value= $name."=".$value;
    	    $params = $params."&".$value;
        }
        return $params;    }

 }

function file_get_contents_curl($url) {
	/*
	This is a file_get_contents replacement function using cURL
	One slight difference is that it uses your browser's idenity
	as it's own when contacting google.
	*/

	$ch = curl_init();

	$userAgent = '';

	//curl_setopt($ch, CURLOPT_USERAGENT,	'Mozilla/5.0 (Windows; U; Windows NT 5.1; es-ES; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5');
	curl_setopt($ch, CURLOPT_USERAGENT,	$_SERVER['HTTP_USER_AGENT']);
	//curl_setopt($ch, CURLOPT_USERAGENT,	'Isis Server 0.1');
	//curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, getClientIP());
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 1);
        //curl_setopt($ch,CURLOPT_PROXY,'');
        //curl_setopt($ch,CURLOPT_PROXYUSERPWD,'');
	curl_setopt($ch, CURLOPT_URL, $url);

	$data = curl_exec($ch);
	
	curl_close($ch);
        
	return $data;
}

function getClientIP(){

		$limit= 255;
		$three = mt_rand(0,255);
		$four  = mt_rand(0,255);
        return  array('X-Forwarded-For: 192.168.' . $three . '.' . $four );
}
?>
