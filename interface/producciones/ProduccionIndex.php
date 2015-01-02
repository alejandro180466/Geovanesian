<?php
include("../../estilos/Estilo_page.php");
//session_start();
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
?>
<html>
  <body>
  	<div id="menumov" > 
		<H2><CENTER> MANTENIMIENTO PRODUCCION </CENTER></H2>
		<a href="../../interface/producciones/ProduccionForm.php?modo=1&rechazo=0&id=1" title="Ingresar Producción">
						  		<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
		<a href="../../interface/producciones/ProduccionForm.php?modo=1&rechazo=1&id=1" title="RECHAZAR MERCADERIA POR CALIDAD">
						  		<img src='../../iconos/recycle_81.png' />RECHAZAR</a>  
	
		<a href="./ProduccionSeek.php" title="Buscar Produccion">
						  		<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
	</div>							
  </body>
</html>