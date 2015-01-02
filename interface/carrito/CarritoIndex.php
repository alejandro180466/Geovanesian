<?php
include("../../estilos/Estilo_page.php");
session_start();
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil!="A" || $codusr==""){
  		header("location:../../index.php");
		exit();
}
?>
<html>
 <head>
  <title>CARRITO DE COMPRAS</title>
  <script>
	function cargarInfoin(op){
		if(op==1){
			formCarIndex.action="../../interface/carrito/VerCarrito.php";
		}else if(op==2){
			formCarIndex.action="../../interface/carrito/IlistaFactura.php";
		}else if(op==3){
			formCarIndex.action="../../index.php";
		}
		formCarIndex.submit();
	}
  </script>
 </head>
 <body>
 	<H1><center>TUS TRANSACCIONES</center></H1>
	<form name="formCarIndex" method="POST" action="">
		<input type="hidden" name="txtmodo"  id="txtmodo"  value="1">
		<table align="center">
		   <tr align="center">
			 <td><input type="image" src="../../iconos/shoppingcarbig.png" border="0" onClick="cargarInfoin(1)";></td>
			 <td><input type="image" src="../../iconos/formatbullets.png"  border="0" onClick="cargarInfoin(2)";></td>
			 <td><input type="image" src="../../iconos/arrowright2.png"    border="0" onClick="cargarInfoin(3)";></td>
		  </tr>	
		  <tr align="center">
			 <td>TU CARRITO</td>
			 <td>TUS FACTURAS</td>
			 <td>VOLVER</td>
		  </tr>
		</table>
	</form>
 </body>
</html>