<?php	include("../../estilos/Estilo_page.php");
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
		<H2>ENTRADAS DE INSUMOS</H2>
		<a href="../../interface/entradas/EntradaForm.php?modo=1" title="Ingresar Insumo">
									<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
		<a href="#" ><!--"./EntradaSeek.php" title="Buscar Insumo"--> 
									<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
	</div>							
 </body>
</html>