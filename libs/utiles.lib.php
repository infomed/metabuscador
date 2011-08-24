<?php

class Utiles
{
    //funcion que devuelve el codigo html de los parametros de determinado buscador, con los valores de los mismos o sin ellos
	public static function generateSearchEngineParam($parameters_array,$parametersValue_array)
	{
	     if(count($parameters_array)==0) return; //para los buscadores que no tengan parametros

	     if($parametersValue_array!='')
	     {
	        if(count($parameters_array) < count($parametersValue_array))//tiene que haber igual o mas param en el arreglo sin valores, nunca menos
	        {
	          echo "Error";
	        }
	        else
	        {
	        	//$count=count($parametersValue_array);
	        	$count=count($parameters_array);

	        	for($i=0; $i<$count;$i++)
	        	{
	        	   $temp=count($parameters_array[$i]);
	        	   $param_name= $parameters_array[$i][0];

	        	   if($parametersValue_array[$param_name])
	        		{
			   			if($temp==2)
	        			{
	        				$parameters_array[$i][2]= $parametersValue_array[$param_name];
	        			}
	        			else
	        			{
	        				$parameters_array[$i][3]= $parametersValue_array[$param_name];
	        			}

	               }
	        	}
	        }
	     }

	    //declarando objeto de tipo Smarty y asignando los valores a las variables
		 $mySmarty = new SmartyCustom;
		 $mySmarty->assign('params',$parameters_array);
		 return $mySmarty->fetch('Generate_Params.tpl');

	}
	//funcion para obtener el XML con los valores de los param de un buscador a partir del arreglo de param dado y de la entrada.
	public static function getParamsValorXML($parameters_array,$input)
	{
	    $count_param= count($parameters_array);
        //lo de los parametros
	    $buscador_params=array();
	    	for($i=0; $i<$count_param;$i++)
	    	{
	    	 	$name = $parameters_array[$i][0];
	    	 	$value= $input[$name];

	            //validando que los parametros esten llenos
	    	 	if($value and $value!= -1)
	    	 	{
	    	 		$buscador_params[$name]=$value;
	    	 	}
	    	}
	       $xml= new XMLParamParser();
           return $xml->writeXMLParamValor($buscador_params);
	}
    //funcion para obtener todos los archivos php que se encuentren en determinado directorio
    public static function getPHPFiles($dir)
    {
        $all_files = scandir($dir, 1);
        $count= count($all_files);
        $files = array();

	    for($i=0;$i<$count-2; $i++)
	    {
	      $file= $all_files[$i];//obteniendo fichero
	      $len= strlen($file); //cantidad de caracteres del fichero
	      $pos= strrpos($file,".php"); //ultima aparicion de la extension .php

	      if(($pos+4==$len) || ($pos+5==$len)) //si .php aparece al final de la cadena solo o con un numero detras ejemplo .php5 etc
	      {
	      	 array_push($files,$file);

	      }

	    }
	   return $files;
    }
    //funcion para subir un file al servidor
    public static function uploadFile($detination)
    {
       $errors= array();
       //global $HTTP_POST_FILES;
        global $_FILES;

       // print_r($_FILES);

       if (is_uploaded_file($_FILES['userfile']['tmp_name']))
       {
          //datos del arhivo
          $file_name = $_FILES['userfile']['name'];
          $file_type = $_FILES['userfile']['type'];
          $file_size = $_FILES['userfile']['size'];
          //compruebo si las características del archivo son las que deseo
          if ( !(strpos($file_name,"zip")) || ($file_size > 100000))
          {
            $errors['upload'] = "The extension of the file or size is not correct. Only ZIP files less than 100 kb are allowed";
          }
          else
          {          	//copy($HTTP_POST_FILES['userfile']['tmp_name'], $detination.'/'.$file_name);
          	move_uploaded_file($_FILES['userfile']['tmp_name'],$detination.'/'.$file_name);          }
       }
       else
       {
          $errors['upload'] = "Select a file to upload";
       }
       return $errors;
    }
    //funcion para descompactar un fichero
    function unZip($zip_file,$extract_dir)
    {
      $zip = new ZipArchive;

      if($zip->open($zip_file)===true)
      {
        $zip->extractTo($extract_dir);
        $zip->close();
        return true;
      }
      return false;
    }

   function replace_acent($s)
   {
	    $s = ereg_replace("[áàâãª]","a",$s);
	    $s = ereg_replace("[ÁÀÂÃ]","A",$s);
	    $s = ereg_replace("[ÍÌÎ]","I",$s);
	    $s = ereg_replace("[íìî]","i",$s);
	    $s = ereg_replace("[éèê]","e",$s);
	    $s = ereg_replace("[ÉÈÊ]","E",$s);
	    $s = ereg_replace("[óòôõº]","o",$s);
	    $s = ereg_replace("[ÓÒÔÕ]","O",$s);
	    $s = ereg_replace("[úùû]","u",$s);
	    $s = ereg_replace("[ÚÙÛ]","U",$s);
	    $s = ereg_replace("ç","c",$s);
	    $s = ereg_replace("Ç","C",$s);
	    $s = ereg_replace("[ñ]","n",$s);
	    $s = ereg_replace("[Ñ]","N",$s);

	    return $s;
   }
   //parseando un objto std class (para convertirlo a array)
   public static function parseStdClassObject($object)
   {
        $properties = array();
        if(Utiles::isArray($object))
		{
			foreach($object as $element)
			{
			  array_push($properties,Utiles::parseStdClassObject($element));
			}
		}
		else if(Utiles::isStdClass($object))
		{
		    $array = get_object_vars($object);

            foreach($array as $key => $value)
            {
              $properties[utf8_encode($key)] = Utiles::parseStdClassObject($value);
            }

        }
	 	else
			return utf8_encode($object);
        //die(print_r($properties));
		return $properties;
   }

   //parseando el objto std class para llevarlo a la estructura param -> valor
   //(se usa en la búsqueda avanzada)
   public static function parseStdClassParam($object)
   {
        $param = array();

        if(Utiles::isArray($object->item))
		{
			foreach ($object->item as $item)
            {
               $param[$item->key]= $item->value;
            }
		}
		else if(Utiles::isStdClass($object->item))
		{
		     $param[$object->item->key]= $object->item->value;
        }
	 	else
			return $param;
        //die(print_r($properties));
		return $param;
   }

   private static function isStdClass($object)
   {
	 return is_object($object);
   }

   private static function isArray($object)
   {
   	 return is_array($object);
   }

   public static function copyFile($source,$dest)
   {
      if(!copy($source, $dest))
      {
         return false;
      }
      else return true;
   }
   public static function deleteFile($file)
   {
      if(!unlink($file))
      {
         return false;
      }
      else return true;   }

   function removeDirRecur($dir)
   {
      $handle = opendir($dir);
      while (false!==($item = readdir($handle)))
      {
        if($item != '.' && $item != '..')
         {
             if(is_dir($dir.'/'.$item))
             {
                 Utiles::removeDirRecur($dir.'/'.$item);
             }
             else
             {
                unlink($dir.'/'.$item);
             }
         }
      }
     closedir($handle);
     if(rmdir($dir))
     {
         $success = true;
     }
  	 return $success;
  }

  public static function get_array($string_array)
  {
        $result = array();
        //eliminando parentesis
        $arr1 = split('[()]',$string_array);

        foreach ( $arr1 as $value)
        {
           if($value)
           {  //eliminando "-"           	  $arr2 = explode('-',$value);
           	  //formando par key->value
           	  $result[$arr2[0]]= $arr2[1];

           }
        }
	    return $result;
  }

 }
?>