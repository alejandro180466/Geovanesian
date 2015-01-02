<?php include("../../interface/documentos/DocumentoIndex.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil!="A" || $codusr==""){
	header("location:../../index.php");	exit();
}
?>
<html>
  <body>
	<div id="menumov"">
		<H2>MANTENIMIENTO DE FACTURAS</H2>
		<a href="../../interface/facturas/FacturaForm.php?modo=1&id=0" title="Ingreso Manual de facturas" >
									<img src='../../iconos/document_add_81.png' border="0"/></a>
									
		<a href="../../interface/facturas/FacturaSeek.php" title="Buscar Factura">
									<img src='../../iconos/search81.png' border="0"/></a>
									
		<a href="../../interface/facturas/BromatSeek.php" title="Calcular Tasa Bromatologica">
									<img src='../../iconos/tasa_81.png' border="0"/></a>
									
		<a href="../../interface/facturas/FacturaSetForm.php" title="Setear Serie y Numero de documentos emitidos">
									<img src='../../iconos/reset.png' border="0"/></a>							
	</div>							
 </body>
</html>