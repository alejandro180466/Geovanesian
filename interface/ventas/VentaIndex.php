<?php include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
?>
<html>
  <body>
   	<div id="menumov"> 
	     <H2>LISTADOS DE VENTAS</H2>
		<a href="./VentaSeek_M.php" title="Consulta por articulo">
				<img src='../../iconos/search102.png' border="0"/>ARTICULOS
		</a>
		<a href="./VentaSeek_C.php" title="Consulta ventas de articulos por cliente" >
	  		  <img src='../../iconos/search102.png' border="0"/>CLIENTES
		</a>
	</div>							
  </body>
</html>