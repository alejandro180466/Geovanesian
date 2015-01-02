<?php include("../../estilos/Estilo_page.php");
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
		 <H2>MANTENIMIENTO DE MERCADERIAS</H2>
	    <?php 
	    if($perfil!="C"){   ?>
		    <a href="../../interface/mercaderias/MercaderiaForm.php?modo=1" title="Ingresar Mercaderia">
									<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
		    <?php							
		} ?>
		<a href="./MercaderiaSeek.php" title="Buscar Mercaderia">
									<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
	</div>							
 </body>
</html>