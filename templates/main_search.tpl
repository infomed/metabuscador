<html>
<head>
<title>Search Service</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="search"
      href="../opensearch.xml"
      type="application/opensearchdescription+xml"
      title="11870.com" />
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="buscador">
<div id="wrap" title="Servicio de B&uacute;squeda"><div id="logo"></div>
<div id="advance" title="B&uacute;squeda avanzada"><a href="advanced_search.php">B&uacute;squeda avanzada</a></div>
</div>
<form method="POST">
<div id="operador">
<h5>Fuentes de informaci&oacute;n </h5>
		<div id="despegable"><input class="small" type="text" size="20" value="" name="queries"/>
       <select name="infosources">
         {foreach from=$infosources item=source}
          {html_options values=$source->id output=$source->name}
         {/foreach}
       </select>
       <input width="11" type="submit" height="25" align="center" alt="Buscar" title="Buscar"/>
  </div></div>

</form>
</body>

</html>




