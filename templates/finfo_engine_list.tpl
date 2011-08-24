<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Info Sources Manager</title>
<script type="text/javascript" src="../../js/jquery.js"></script>
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
 <div id="contenedor">
 <div id="logo" title="Servicio de B&uacute;squeda"></div>
 <br />
<form id="sources_form" method="POST">
<input type="hidden" name="opr" value="del" />
<div class="error">{$errors.msg}</div>
 <table id="listado">
 	<tr>
		<td class="list">
			Info Source List
		</td>
	</tr>
	<tr>
		<td style="height:8px;">
		</td>
	</tr>
	<tr>
		<td>
		{if count($info_sources) gt 0}
          <ul>
           {foreach from=$info_sources item=source}
            <li><input type="radio" name="id" value="{$source->getId()}" /> <a href="index_finfo.php?opr=get&id={$source->getId()}">{$source->getName()}</a></li>

			{/foreach}
		 </ul>
	  {else}
         No information sources defined yet
	   {/if}
       </td>
	</tr>
	<tr>
		<td>
		<input type="submit" name="accion" value="Delete" id="submit_button"/>
		<!--Link para Adicionar nuevas fuentes de Informacion-->
			<a class="add" href="index_finfo.php?opr=add">Add</a>
		</td>
	</tr>	

	<tr>
		<td style="height:20">
		</td>
	</tr>
 </table>
</form>
 </div>
</div>
</div>
 </body>
</html>



