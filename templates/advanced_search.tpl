<html>
<head>
<title>Search Service</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/info_source.js"  charset="utf-8"></script>
<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="buscadorAV">
<div id="wrap" title="Servicio de B&uacute;squeda"><div id="logo"></div>
<div id="advance" title="B&uacute;squeda simple"><a href="main_search.php">B&uacute;squeda simple</a></div>
</div>
<form name="formDb" method="POST">
<div id="operadores">
<h5>B&uacute;squeda avanzada</h5>
		<div id="despegable"> 
		<input class="small" type="text" size="20" value="" name="queries"/>
         <select name="searchers" onChange="selectBrowser(true)">

         {if $first_engine->id != ''}
          {foreach from=$search_engines item=engine}
          {html_options values=$engine->id output=$engine->name selected=$first_engine->id}
          {/foreach}
        {else}
           {foreach from=$search_engines item=engine}
          {html_options values=$engine->id output=$engine->name selected=$engine->id}
          {/foreach}
        {/if}
	     </select>
         <input width="11" type="submit" height="11" align="absmiddle" alt="Buscar" title="Buscar"/>
  		</div>
  		</div>
   <div id="parametros">
    <!--Aqui va el fielset con los parametros-->
    {if $parameters != ''}
      	<div>
      		<fieldset name="parameters" id="parameters" style="width:auto" style="border:none">
       		{$parameters}
      		</fieldset>
   		</div>
	{/if}    </div>
  
 </form>
  </div>
</body>

</html>




