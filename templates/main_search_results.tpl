<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
<style type="text/css">
</style>
<link href="style.css" rel="stylesheet" type="text/css">

</head>
<body>
<form id="result" method="POST">

 <table>
	<tr>
		<td style="height:8px;">
		</td>
	</tr>
	<tr>
	  <td>
	    {if $result.total eq 0}
            "No se encontraron resultados"
        {else}
          {$result.total}
           {foreach name=outer item=result from=$result.results}
        <hr />
           {foreach key=key item=item from=$result}
               {$key}: {$item}<br />
          {/foreach}
           {/foreach}
       {/if}

       </td>
      </tr>
     <tr>
		<td>
		    <a href="main_search.php">Back</a>
		</td>
	</tr>
 </table>

</form>
</body>
</html>
