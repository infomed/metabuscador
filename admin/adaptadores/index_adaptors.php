<?php

  require_once '../../config.php';
  require '../../libs/adaptors_engines.lib.php';
  require '../../libs/search_engines.lib.php';
  require '../../libs/utiles.lib.php';

  $template = '';
  $tmpl = new SmartyCustom;

  $adaptor_manager = new AdaptorEngineManager($mdb);
  $search_manager = new SearchEngineManager($mdb);

  $opr='';
  $errors= array();

  if ("GET" == $_SERVER['REQUEST_METHOD'])
  {
    $input = $_GET;

   $opr=isset($input['opr'])?$input['opr']:'';

    switch ($opr)
    {
         case 'get':

           $engine = $adaptor_manager->get($input['id']);

           if (!$engine)
           {
                $errors['msg'] = 'Invalid Adaptor Engine';
                $tmpl->assign('adaptors', $adaptor_manager->getAll());
                $template = 'adaptor_engine_list.tpl';
           }
           else
           {
              //obteniendo el buscador para el adaptador seleccionado
              $search_id = $engine->getBrowserId();
              $search_engine= $search_manager->get($search_id);

              $tmpl->assign('adaptor', $engine);
              $tmpl->assign('searchers', $search_manager->getAll());
              $tmpl->assign('files', Utiles::getPHPFiles($dir."/adaptadores"));
              $template = 'adaptor_engine.tpl';
           }
           $tmpl->assign('errors', $errors);
           $tmpl->display($template);
           break;
         case 'add':
           $tmpl->assign('adaptor', new AdaptorEngine('', '', '', '', '', ''));
           $tmpl->assign('errors', $errors);
           $tmpl->assign('searchers', $search_manager->getAll());
           $tmpl->assign('files', Utiles::getPHPFiles($dir."/adaptadores"));
           $tmpl->display('adaptor_engine.tpl');
           break;
         default:
           $tmpl->assign('adaptors', $adaptor_manager->getAll());
           $tmpl->assign('errors', $errors);
           $tmpl->display('adaptor_engine_list.tpl');
    }
  }
  else
  {
      $input = $_POST;

      switch ($input['opr'])
      {
          case 'add':

            $engine = new AdaptorEngine($input['name'], $input['description'],$input['files'], $input['class'], $input['searchers'],'');

            $errors = $adaptor_manager->validate($engine);
            if (!$errors)
            {
                $adaptor_manager->save($engine);
                header("Location: index_adaptors.php");
            }
            $tmpl->assign('errors', $errors);
            $tmpl->assign('adaptor', $engine);
            $tmpl->assign('searchers', $search_manager->getAll());
            $tmpl->assign('files', Utiles::getPHPFiles($dir."/adaptadores"));

            $tmpl->display('adaptor_engine.tpl');
            break;

          case 'upd':

            $engine = $adaptor_manager->get($input['id']);

            if ($engine)
            {
                //actualizando los parametros
                $adaptor_manager->update($engine,$input);
                $errors = $adaptor_manager->validate($engine);
            }
            else
            {
                $errors['msg'] = 'Invalid Adaptor Engine';
            }
            if (!$errors)
            {

                $adaptor_manager->save($engine);
                header("Location: index_adaptors.php");
            }
            $tmpl->assign('errors', $errors);
            $tmpl->assign('adaptor', $engine);
            $tmpl->assign('searchers', $search_manager->getAll());
            $tmpl->assign('files', Utiles::getPHPFiles($dir."/adaptadores"));

            $tmpl->display('adaptor_engine.tpl');
            break;

          case 'del':
            $adaptor_manager->delete($input['id']);
            if ($input['fmt']!='js')
            {
                header("Location: index_adaptors.php");
                break;
            }
            else
            {
                echo 'Adaptor Engine deleted';
            }

      }
  }


?>