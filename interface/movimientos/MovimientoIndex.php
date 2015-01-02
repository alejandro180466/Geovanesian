<?php include("../../estilos/Estilo_page.php"); 
  $perfiles=$_SESSION["ses_perfil"];
  $perfil=$perfiles[0];              // cargo el perfil del usuario 
  $codusr=$perfiles[1];
if($perfil!="A" || $codusr==""){
	header("location:../../index.php");	exit();
}
?>
<html>
 <body>
   	<div id="menumov" > 
	    <H2>MOVIMIENTOS DE COMPRAS</H2>
		<a href="./MovimientoForm.php?modo=1&id=0" title="Ingresar movimiento">
									<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
		<a href="./MovimientoSeek.php" title="Buscar documentos de proveedores">
									<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
	</div>							
 </body>
</html>