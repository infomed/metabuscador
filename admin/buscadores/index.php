<?php

session_start();
// include config class
require_once('../login.class.php');
// create instance
$Login	= new Login;
// check permission
$Login->checkauth();

  require_once '../../config.php';
  require '../../libs/search_engines.lib.php';
  require '../../libs/utiles.lib.php';
  require '../../libs/XMLParamParser.php';

  $errors = array();
  $template = '';
  $tmpl = new SmartyCustom;
  $opr='';
  $engine;

  if ("GET" == $_SERVER['REQUEST_METHOD'])
  {
    $input = $_GET;

    $opr=isset($input['opr'])?$input['opr']:'';

    $se_manager = new SearchEngineManager($mdb);

    switch ($opr)
    {
         case 'get':
           $engine = $se_manager->get($input['id']);
           if (!$engine)
           {
                $errors['msg'] = 'Invalid search engine';
                $tmpl->assign('engines', $se_manager->getAll());
                $template = 'search_engine_list.tpl';
           }
           else
           {
                $tmpl->assign('engine', $engine);
                $template = 'search_engine.tpl';
           }
           $tmpl->assign('errors', $errors);
           $tmpl->display($template);
           break;
         case 'add':
           $tmpl->assign('engine', new SearchEngine('', '', '', '', '',''));
           $tmpl->assign('errors', $errors);
           $tmpl->display('search_engine.tpl');
           break;

         default:
           $tmpl->assign('engines', $se_manager->getAll());
           $tmpl->assign('errors', $errors);
           $tmpl->display('search_engine_list.tpl');
    }
  }
  else
  {
      $input = $_POST;

      if($input['cancel'] == 'Cancel')
      {
      	header("location:index.php");
      	exit;
      }
      $se_manager = new SearchEngineManager($mdb);
      switch ($input['opr'])
      {
          case 'add':

            $name = $input['name'];
            $description = $input['description'];
            //validando name and description
            $engine = new SearchEngine($input['name'], $input['description'],'', '','','');
            $errors = $se_manager->validate($engine);

            //upload del fichero
            $errors = array_merge($errors, Utiles::uploadFile($dir."/buscadores"));

            if(!$errors['upload'])//si el upload fue exitoso
            {
              //descompactando el fichero
              $file_name = $HTTP_POST_FILES['userfile']['name'];

              $result = Utiles::unZip($dir."/buscadores/".$file_name,$dir."/buscadores/");

              if(!$result)
              {
                $errors['unzip'] = "Failure unziping the file";
              }
              else //parsear el xml para obtener los param del buscador
              {

               $path = $dir."/buscadores/".substr($file_name,0,strlen($file_name)-4);
               //obteniendo el array de configuracion
               $xml = new XMLParamParser();
               $config_array = $xml->readXMLConfig($path."/config.xml");
               //llevar los param a XML para guardar en la BD
               $params = $xml->writeXMLParam($config_array["parameters"]);

               //extrayendo fichero de implementación (copiandolo en modulos/buscadores)
               //extrayendo fichero wsdl (si hay y copiandolo en modulos/buscadores)
               // Open the directory

               $dir_handle = @opendir($path) or die("Error opening $path");
               // Loop through the files
               while($file = readdir($dir_handle))
               {
                 if(pathinfo($file,PATHINFO_EXTENSION) == "wsdl" or (pathinfo($file,PATHINFO_EXTENSION) == "php"
               	 and pathinfo($file,PATHINFO_BASENAME) == $config_array['implementation']))//extraer wsdl o php con la implementación
                 {
                   if(!Utiles::copyFile($path."/".$file, $dir."/buscadores/".$file))
                   {
                   	 $error['copy'] = "Failure copying ".$file;
                   }
                 }
               }
               closedir($dir_handle);
               //eliminar fichero .zip y fichero descompactado

               if(!Utiles::deleteFile($dir."/buscadores/".$file_name) or
                !Utiles::removeDirRecur($dir."/buscadores/".substr($file_name,0,strlen($file_name)-4)))
                {
                  $error['delete'] = "Failure deleting files";
                }

              }
            }
            if (!$errors)
            {
               $engine = new SearchEngine($name, $description, $params, $config_array['implementation'], $config_array['classname'],'');
               $se_manager->save($engine);
               header("Location: index.php");
            }
            $tmpl->assign('errors', $errors);
            $tmpl->assign('engine', $engine);
            $tmpl->display('search_engine.tpl');
            break;
        case 'upd':

            $engine = $se_manager->get($input['id']);

            if($engine)
            {
              if(is_uploaded_file($HTTP_POST_FILES['userfile']['tmp_name']))
              {
                 //upload del fichero
                 $errors = Utiles::uploadFile($dir."/buscadores");
                 if(!$errors['upload'])//si el upload fue exitoso
				 {
				     //descompactando el fichero
				     $file_name = $HTTP_POST_FILES['userfile']['name'];
				     $result = Utiles::unZip($dir."/buscadores/".$file_name,$dir."/buscadores/");

				     if(!$result)
				     {
				       $errors['unzip'] = "Failure unziping the file";
				     }
				     else //parsear el xml para obtener los param del buscador
				     {
				       $path = $dir."/buscadores/".substr($file_name,0,strlen($file_name)-4);
				       $xml = new XMLParamParser();
				       $config_array = $xml->readXMLConfig($path."/config.xml");
				       //llevar los param a XML para guardar en la BD
				       $params = $xml->writeXMLParam($config_array["parameters"]);

				       //extrayendo fichero de implementación (copiandolo en modulos/buscadores)
                       //extrayendo fichero wsdl (si hay y copiandolo en modulos/buscadores)
                       // Open the directory

                       $dir_handle = @opendir($path) or die("Error opening $path");
                       // Loop through the files
                       while($file = readdir($dir_handle))
                       {
		                 if(pathinfo($file,PATHINFO_EXTENSION) == "wsdl" or (pathinfo($file,PATHINFO_EXTENSION) == "php"
		               	 and pathinfo($file,PATHINFO_BASENAME) == $config_array['implementation']))//extraer wsdl o php con la implementación
		                 {
		                   if(!Utiles::copyFile($path."/".$file, $dir."/buscadores/".$file))
		                   {
		                   	 $error['copy'] = "Failure copying ".$file;
		                   }
		                 }
	                   }
	                   closedir($dir_handle);
	                   //eliminar fichero .zip y fichero descompactado

	                   if(!Utiles::deleteFile($dir."/buscadores/".$file_name) or
	                   !Utiles::removeDirRecur($dir."/buscadores/".substr($file_name,0,strlen($file_name)-4)))
	                   {
	                     $error['delete'] = "Failure deleting files";
	                   }

				     }
				 }
			  }

              $data = array('name'=>$input['name'],'description'=>$input['description'],
              'params'=>$params,'implementation'=>$config_array['implementation'],'classname'=> $config_array['classname'] );

              $se_manager->update($engine, $data);
              $errors = array_merge($errors, $se_manager->validate($engine));
            }
            else
            {
                $errors['msg'] = 'Invalid Search Engine';
            }

            if (!$errors)
            {
                $se_manager->save($engine);
                header("Location: index.php");
            }
            $tmpl->assign('errors', $errors);
            $tmpl->assign('engine', $engine);
            $tmpl->display('search_engine.tpl');
            break;
         case 'del':
            $se_manager->delete($input['id']);
            if ($input['fmt']!='js')
            {
                header("Location: index.php");
                break;
            }
            else
            {
                echo 'Engine deleted';
            }
     }
  }
?>
</div>
</div>
