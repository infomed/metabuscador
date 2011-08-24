<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>AdaptorEngineManager</title>
 <link href="/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../js/jquery.js"></script>
<style type="text/css">
</style>

</head>
<body>
 <div id="contenedor">
 <div id="logo" title="Servicio de B&uacute;squeda"></div>
 <br />
<form id="adaptors_form" method="POST">
<input type="hidden" name="opr" value="del" />
<div class="error">{$errors.msg}</div>
 <table id="listado">
 	<tr>
		<td class="list">
			Adaptors List
		</td>
	</tr>
	<tr>
		<td style="height:8px;">
		</td>
	</tr>
	<tr>
		<td>
		{if count($adaptors) gt 0}
          <ul>
           {foreach from=$adaptors item=adaptor}
            <li><input type="radio" name="id" value="{$adaptor->getId()}" /><a href="index_adaptors.php?opr=get&id={$adaptor->getId()}">{$adaptor->getName()}</a></li>

			{/foreach}
		 <ul>
	  {else}
         No adaptors defined yet
	   {/if}
       </td>
	</tr>
	<tr>
		<td>
		<input type="submit" name="accion" value="Delete" id="submit_button"/>
		<!--Link para Adicionar nuevos Adaptadores-->
		<a class="add" href="index_adaptors.php?opr=add">Add</a>
		</td>
	</tr>

	<tr>
		<td style="height:20">
		</td>
	</tr>
 </table>
</form>
</div>
</body>
</html>


