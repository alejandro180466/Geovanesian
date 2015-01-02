<?php include("../../estilos/Estilo_page.php"); 
  $perfiles=$_SESSION["ses_perfil"];
  $perfil=$perfiles[0];              // cargo el perfil del usuario 
  $codusr=$perfiles[1];
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
?>
<html>
  <body>
  	<div id="menumov" > 
			<H2>ACTUALIZACION DE PRECIOS</H2>
		<a href="./ActualizaForm.php?modo=1&id=0" title="Ingresar actualizaciones de precios">
						  		<img src='../../iconos/document_add_102.png' border="0"/>INGRESAR</a>
		<a href="./ActualizaSeek.php" title="Buscador de actualizaciones ">
						  		<img src='../../iconos/search102.png' border="0"/>BUSCAR</a>
	</div>							
 </body>
</html>