<?php

session_start();
// include config class
require_once('../login.class.php');
// create instance
$Login	= new Login;
// check permission
$Login->checkauth();

  require_once '../../config.php';
  require '../../libs/infoSource_engines.lib.php';
  require '../../libs/search_engines.lib.php';
  require '../../libs/XMLParamParser.php';
  require '../../libs/utiles.lib.php';

  $template = '';
  $tmpl = new SmartyCustom;

  $errors= array();
  $parametersValue_array= array(); //arreglo con los nombres de los param de un buscador y sus valores
  $fi_manager = new InfoSourceEngineManager($mdb);
  $search_manager = new SearchEngineManager($mdb);
  $opr='';

  if ("GET" == $_SERVER['REQUEST_METHOD'])
  {
    $input = $_GET;

    $opr=isset($input['opr'])?$input['opr']:'';

    switch ($opr)
    {
         case 'get':

           $engine = $fi_manager->get($input['id']);

           if (!$engine)
           {
                $errors['msg'] = 'Invalid Info Source Engine';
                $tmpl->assign('info_sources', $fi_manager->getAll());
                $template = 'finfo_engine_list.tpl';
           }
           else
           {
              //obteniendo el buscador para la fuente de informacion seleccionada
              $search_id = $engine->getSearchEngineId();
              $search_engine= $search_manager->get($search_id);

              //obteniendo el arreglo de parametros del buscador
              $parameters_array = $search_manager->getParamsArray($search_id);

              //obteniendo el arreglo con los parametros y sus valores (in info source table)
              $parametersValue_array = $fi_manager->getSearchEngineParamsArray($engine->getId());

              $tmpl->assign('info_source', $engine);
              $tmpl->assign('searchers', $search_manager->getAll());

              $tmpl->assign('parameters',Utiles::generateSearchEngineParam($parameters_array,$parametersValue_array));
              $template = 'finfo_engine.tpl';
           }
           $tmpl->assign('errors', $errors);
           $tmpl->display($template);
           break;
         case 'add':
           //obteniendo el id del primer buscador de la lista

           //VER
           $search_first=$search_manager->getFirstSearchEngine();
           $search_id= $search_first->getId();
           //obteniendo el arreglo de parametros del buscador
           $parameters_array = $search_manager->getParamsArray($search_id);
           $tmpl->assign('info_source', new InfoSourceEngine('', '', '', '', ''));
           $tmpl->assign('errors', $errors);
           $tmpl->assign('searchers', $search_manager->getAll());
           $tmpl->assign('parameters',Utiles::generateSearchEngineParam($parameters_array,''));

           $tmpl->display('finfo_engine.tpl');
           break;
         default:
           $tmpl->assign('info_sources', $fi_manager->getAll());
           $tmpl->assign('errors', $errors);
           $tmpl->display('finfo_engine_list.tpl');
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
      switch ($input['opr'])
      {
          case 'add':
            //obteniendo el arreglo de parametros del buscador
            $parameters_array = $search_manager->getParamsArray($input['searchers']);

            $buscadorParam = Utiles::getParamsValorXML($parameters_array,$input);

            $engine = new InfoSourceEngine($input['name'], $input['description'], $input['searchers'],$buscadorParam,'');

            $errors = $fi_manager->validate($engine);
            if (!$errors)
            {
                $fi_manager->save($engine);
                header("Location: index_finfo.php");
            }
            $tmpl->assign('errors', $errors);
            $tmpl->assign('info_source', $engine);
            $tmpl->assign('searchers', $search_manager->getAll());

             //obteniendo el arreglo con los parametros y sus valores
            $parametersValue_array = $fi_manager->getSearchEngineParamsArrayNew($engine);

            $tmpl->assign('parameters',Utiles::generateSearchEngineParam($parameters_array,$parametersValue_array));
            $tmpl->display('finfo_engine.tpl');
            break;

          case 'upd':

            $engine = $fi_manager->get($input['id']);
            $parametersValue_array=array();
            $parameters_array=array();
            $buscadorParam='';

            if ($engine)
            {
                //obteniendo el arreglo de parametros del buscador
                $parameters_array = $search_manager->getParamsArray($input['searchers']);

                $buscadorParam = Utiles::getParamsValorXML($parameters_array,$input);

                //actualizando los parametros
                $fi_manager->update($engine,$input,$buscadorParam);
                //print_r($engine);
                //validando errores
                $errors = $fi_manager->validate($engine);
            }
            else
            {
                $errors['msg'] = 'Invalid Info Source Engine';
            }
            if (!$errors)
            {

                $fi_manager->save($engine);
                header("Location: index_finfo.php");
            }
            $tmpl->assign('errors', $errors);
            $tmpl->assign('info_source', $engine);

            $tmpl->assign('searchers', $search_manager->getAll());

            //obteniendo el arreglo con los parametros y sus valores
            $parametersValue_array = $fi_manager->getSearchEngineParamsArrayNew($engine);

            $tmpl->assign('parameters',Utiles::generateSearchEngineParam($parameters_array,$parametersValue_array));
            $tmpl->display('finfo_engine.tpl');
            break;

          case 'del':
            $fi_manager->delete($input['id']);
            if ($input['fmt']!='js')
            {
                header("Location: index_finfo.php");
                break;
            }
            else
            {
                echo 'Info Source Engine deleted';
            }

      }
  }


?>

