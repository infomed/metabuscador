<html>
 <head>
  <title>Engine</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="/style.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="../../js/jquery.js"></script>
  <script type="text/javascript" src="../../js/adaptors.js"  charset="utf-8"></script>
 </head>
 <body>
 <div id="contenedor">
 <div id="logo" title="Servicio de B&uacute;squeda"></div>
  <div id="admin"> <a href="index_adaptors.php" title="Admin">Admin</a></div><br />
   <form id="engines_form" name="formDb" method="POST">
   {if $adaptor->getId() != ''}
   <input type="hidden" name="id" value="{$adaptor->getId()}"/>
   <input type="hidden" name="opr" value="upd"/>
   {else}
   <input type="hidden" name="opr" value="add"/>
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
		   <input type="text" value="{$adaptor->getName()}" name="name" />		</td>
		<td>
		  <div id="name_error" class="error">{$errors.name}</div>		</td>
	</tr>
	<tr>
		<td>
			Description:		</td>

		<td>
		   <textarea name="description" rows="10" cols="30">{$adaptor->getDescription()}</textarea>		</td>
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
		Searcher:		</td>
	  <td>
         <select name="searchers">

         {if $adaptor->getBrowserId() != ''}
           {foreach from= $searchers item=search}
             {html_options values=$search->getId() output=$search->getName() selected=$adaptor->getBrowserId()}
        {/foreach}

        {else}
           {foreach from= $searchers item=search}
             {html_options values=$search->getId() output=$search->getName()}
        {/foreach}
        {/if}
	     </select>		</td>
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
		Files:		</td>
	  <td>
         <select name="files">

         {if $adaptor->getBrowserId() != ''}
           {foreach from= $files item=file}
             {html_options values=$file output=$file selected=$adaptor->getImplementation()}
         {/foreach}

        {else}
           {foreach from= $files item=file}
             {html_options values=$file output=$file}
        {/foreach}
        {/if}
	     </select>		</td>
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
		 Class:		</td>
		<td>
		   <input type="text" value="{$adaptor->getClassName()}" name="class" />		</td>
		<td>
		  <div id="class_error" class="error">{$errors.class}</div>		</td>
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
	    <input id="save" type="submit" value="Save">	 </td>
    </tr>
     <td>
	   {$message}	 </td>
    </tr>
</table>
   </form>
   </div>
 </body>
</html>
