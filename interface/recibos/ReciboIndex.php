<?php include("../../interface/documentos/DocumentoIndex.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil!="A" || $codusr==""){header("location:../../index.php");	exit();}
?>
<html>
  <body>
    
	<div id="menumov">
		<H2>MANTENIMIENTO DE NUESTROS RECIBOS</H2>
		<a href="../../interface/recibos/ReciboForm.php?modo=1&id=0"  title="INGRESAR RECIBOS" >
									<img src='../../iconos/document_add_81.png' border="0"/> INGRESAR</a>
		
		<a href="../../interface/recibos/ReciboSeek.php" title="Buscar RECIBO">
									<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
	</div>							
 </body>
</html>