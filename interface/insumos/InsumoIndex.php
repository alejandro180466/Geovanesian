<?php include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
?>
<html>
  <body>
    <div id="menumov" > 
		<H2>MANTENIMIENTO DE INSUMOS</H2>
		<a href="../../interface/insumos/InsumoForm.php?modo=1" title="Ingresar Insumo">
						  		<img src='../../iconos/document_add_81.png' />INGRESAR</a>
		<a href="./InsumoSeek.php" title="Buscar Insumo">
						  		<img src='../../iconos/search81.png' />BUSCAR</a>
	</div>							
 </body>
</html>