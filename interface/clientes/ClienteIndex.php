<?php include("../../estilos/Estilo_page.php");
  $perfiles=$_SESSION["ses_perfil"];
  $perfil=$perfiles[0];              // cargo el perfil del usuario 
  $codusr=$perfiles[1];
if($perfil!="A" || $codusr==""){header("location:../../index.php");	exit();}
?>
<html>
 <body>
 	<div id="menumov" > 
		<h2>MANTENIMIENTO DE CLIENTES</H2>
		<a href="./ClienteForm.php?modo=1" title="Ingresar Cliente">
						  		<img src='../../iconos/document_add_81.png'  border="0"/>INGRESAR</a>
		<a href="./ClienteSeek.php" title="Buscar Cliente">
						  		<img src='../../iconos/search81.png'  border="0"/>BUSCAR</a>
	</div>							
 </body>
</html>