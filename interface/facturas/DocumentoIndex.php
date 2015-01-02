<?php
include("../../estilos/Estilo_page.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){
	header("location:../../index.php");
	exit();
}
?>
<html>
  <body>
    <H2><CENTER> MANTENIMIENTO DE NUESTROS DOCUMENTOS  <img src='../../iconos/figurita.png' border="0"/></CENTER></H2>
	<div id="menucli" style="text-align:center"> 
		<a href="../recibos/ReciboIndex.php" title="RECIBOS" >
									<img src='../../iconos/document_add_102.png' border="0"/> RECIBOS</a>

		<a href="./FacturaIndex.php" title="FACTURAS">
									<img src='../../iconos/search102.png' border="0"/>FACTURAS</a>
	</div>							
 </body>
</html>