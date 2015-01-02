<?php include("../../estilos/Estilo_page.php");
  $perfiles=$_SESSION["ses_perfil"];
  $perfil=$perfiles[0];              // cargo el perfil del usuario 
  $codusr=$perfiles[1];
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
?>
<html>
 <body>
   	<div id="menumov">
		 <H2>MANTENIMIENTO DE PEDIDOS</H2>	
		<a href="./PedidoForm.php?modo=5&id=0" title="Ingresar pedido">
						  		<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
		<a href="./PedidoSeek.php" title="Buscar pedidos">
						  		<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
	</div>							
 </body>
</html>