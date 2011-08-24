<?php

//SECTION CONFIGURATIONS
//include("feedcreator.class.php");
//END SECTION CONFIGURATIONS

//SECTION CLASS
 class GeneralAdaptor implements AdaptorInterface
 { 	public function adaptTo($format, $results, $name, $description, $link, $path)
 	{        switch($format)
 		{
 		   case RSS:

                $rss = new UniversalFeedCreator();
				$rss->useCached();
				$rss->title = $name;
				$rss->description = $description;
				$rss->link = $link;
				$rss->syndicationURL = $syndicationURL.$PHP_SEL;//"http://buscador.sld.cu/main_search.php".$PHP_SELF;

				$image = new FeedImage();
				$image->title = "infomed logo";
				$image->url = "http://buscador.sld.cu/imagenes/logo.gif";
				$image->link = "http://buscador.sld.cu/imagenes/logo.gif";
				$image->description = "Feed provided by infomed. Click to visit.";
				$rss->image = $image;

				foreach($results as $result)
				{
					$item = new FeedItem();
				    $item->title = utf8_decode($result["title"]);
				    $item->link =  $result["url"];

				    if($result["description"] != "nd")
				    {
				      $item->description = utf8_decode($result["description"]);
				    }
				    $rss->addItem($item);
				}
				$rss->saveFeed("RSS1.0", $path."/".$name.".xml", false);
				break;

			 case XML:
			      echo "Not implemented yet";
			      break; 		}
	}
 }
?>
