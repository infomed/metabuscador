<?php
include('head.php');
?>
<script type="text/javascript" src="../../sitios/core/js/smt-aux.min.js"></script>
<script type="text/javascript" src="../../sitios/core/js/smt-record.min.js"></script>
<script type="text/javascript">
try
{
smt2.record({
    recTime: 300,
    disabled: false,
    trackingServer: "http://www.sld.cu/sitios",
    storageServer: "http://smt.sld.cu/core/",
    warn: false,
    warnText: "Estamos realizando pruebas de usabilidad en nuestro sitio. Si no ha sido seleccionado, por favor, presione CANCELAR y continue navegando normalmente."
});
}
catch(err){}
</script>
<?php
$plantilla= 'rehabilitacion_buscar_770.pgt';
include($docroot.'body.php');
include($docroot.'foot.php');
?>

