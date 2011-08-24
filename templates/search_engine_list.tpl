<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Search Engines Manager</title>
<script type="text/javascript" src="../../js/jquery.js"></script>
<style type="text/css">
</style>
<link href="../../style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="headerDiv" style="height:100px;widht:100%;background-color:#dddddd;padding-right:50px;padding-top:10px;"> SERVICIO DE BUSQUEDA -- ADMINISTRACION
  <a href="?a=logout" style="float:right;">Salir</a>
  </div>
  <div id="content" style="float:left;min-width:985px;">
<div id="leftMenu" style="background-color:dddddd;padding:3px;-moz-background-clip:border;-moz-background-inline-policy:continuous;-moz-background-origin:padding;float:left;margin-right:5px;min-height:680px;width:180px;padding-left:10px;line-height:15pt;font-size:10pt;">
<a href="../buscadores/index.php">Buscadores</a> </br>
<a href="../fi/index.php">Fuentes de informaci&oacute;n</a>
</div>
<div id="centerColumn" style="float:left;margin-right:12px;margin-top:10px;width:700px">
<div id="buscadorE">
<div id="wrap" title="Servicio de B&uacute;squeda"><div id="logo"></div>
<div id="advance" title="B&uacute;squeda simple"><a href="/main_search.php">B&uacute;squeda simple</a></div>
</div>
<form id="engines_form" method="POST">
<input type="hidden" name="opr" value="del" />
<div class="error">{$errors.msg}</div>
 <table id="listado">
 	<tr>
		<td class="list">
			Search Engines List
		</td>
	</tr>
	<tr>
		<td style="height:8px;">
		</td>
	</tr>
	<tr>
		<td>
		{if count($engines) gt 0}
          <ul>
           {foreach from=$engines item=engine}
            <li><input class="radio" type="radio" name="id" value="{$engine->getId()}" /><a href="index.php?opr=get&id={$engine->getId()}">{$engine->getName()}</a></li>

			{/foreach}
		 <ul>
	  {else}
         No search engines defined yet
	   {/if}
       </td>
	</tr>
	<tr>
		<td >
		<input type="submit" name="accion" value="Delete" id="submit_button"/>
		  <!--Link para Adicionar nuevos buscadores-->
			<a class="add" href="index.php?opr=add">Add Engine</a>
		</td>
	</tr>
		<tr>
		<td>
		  
		</td>
	</tr>	
 </table>
</form>
</div>
</body>
</div>
</div>
</body>
</html>
