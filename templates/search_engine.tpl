<html>
 <head>
  <title>Engine</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="../../style.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="../../js/jquery.js"></script>
   <script type="text/javascript" src="../../js/info_source.js"  charset="utf-8"></script></head>
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
  <div id="admin"> <a href="index.php" title="Admin">Admin</a></div><br />
   <form id="post" method="POST" enctype="multipart/form-data">
   {if $engine->getId() != ''}
   <input type="hidden" name="id" value="{$engine->getId()}" />
   <input type="hidden" name="opr" value="upd" />
   {else}
   <input type="hidden" name="opr" value="add" />
   {/if}
   <div class="error">{$errors.msg}</div>

   <table>
 		<tr>
		<td style="height:8px;">		</td>
	</tr>
	<tr>
		<td>
		  Name:		</td>
		<td>
		  <input type="text" value="{$engine->getName()}" name="name" />		</td>
		<td>
		  <div id="name_error" class="error">{$errors.name}</div>		</td>
	</tr>
	<tr>
		<td>
			Description:		</td>

		<td>
		   <textarea name="description" rows="10" cols="30">{$engine->getDescription()}</textarea>   		</td>
		<td>
		 <div id="description_error" class="error">{$errors.description}</div>		</td>
	</tr>
	<tr>
		<td colspan="3" style="height:8px;"></td>
	</tr>
	<tr>
		<td colspan="3" style="height:2px;background-color:#6AB13C"></td>
	</tr>
	<tr>
		<td colspan="3" style="height:8px;"></td>
	</tr>
	<tr>
		<td>
		Upload SearchEngine Files:		</td>
	   <td>
        <input type="hidden" name="MAX_FILE_SIZE" value="100000">
        <input name="userfile" type="file" value="browser"></td>
		<td>
		   <div id="upload_error" class="error">{$errors.upload}</div>
		   <div id="unzip_error" class="error">{$errors.unzip}</div>		</td>
	</tr>
	<tr>
		<td colspan="3" style="height:8px;"></td>
	</tr>
	<tr>
		<td colspan="3" style="height:2px;background-color:#6AB13C"></td>
	</tr>
	<tr>
		<td colspan="3" style="height:8px;"></td>
	</tr>
	<tr>
	 <td>
	     </td>
		<td>
		<input id="save" type="submit" value="Save" />	
	    <input id="cancel" type="submit" name="cancel"value="Cancel" />	 </td>
    </tr>
	<tr>
	
    </tr>
	<tr>	 
    <td>
	    <div id="copy_error" class="error">{$errors.copy}</div>
		<div id="delete_error" class="error">{$errors.delete}</div>	</td>
     <td>
	   {$message}	 </td>
    </tr>
</table>
   </form>
   </div>
 </div>
 </div>
 </body>
</html>

