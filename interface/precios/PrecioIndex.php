<?php include("../../estilos/Estilo_page.php");
  $perfiles=$_SESSION["ses_perfil"];
  $perfil=$perfiles[0];              // cargo el perfil del usuario 
  $codusr=$perfiles[1];
if($perfil!="A" || $codusr==""){header("location:../../index.php");	exit();}
?>
<html>
 <body>
  	<div id="menumov" > 
	    <H2>MANTENIMIENTO DE PRECIOS</H2> 
		<a href="./PrecioForm.php?modo=1&id=0" title="Ingresar precios por cliente">
						  		<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
		<a href="./PrecioSeek.php" title="Buscador de precios ">
						  		<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
		<a href="../../interface/actualizar/ActualizaIndex.php" title="Actualización global de precios">
						  		<img src='../../iconos/actualizar_81.png' border="0"/>ACTUALIZAR</a>						
	</div>							
 </body>
</html>