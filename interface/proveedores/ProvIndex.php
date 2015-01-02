<?php include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];              // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil!="A" || $codusr==""){header("location:../../index.php");	exit();}

?>
<html>
  <body>
  	<div id="menumov" > 
		<H2>MANTENIMIENTO DE PROVEEDORES</H2>
		<a href="./ProvForm.php?modo=1" title="Ingresar Proveedor">
						  		<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
		<a href="./ProvSeek.php" title="Buscar proveedores">
						  		<img src='../../iconos/search81.png' border="0" />BUSCAR</a>
	</div>							
  </body>
</html>