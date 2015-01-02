<?php
session_start();
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/proveedores/ProveedorClass.php");

$perfiles=$_SESSION["ses_perfil"]; //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0];              //perfil Administrador,Promotor o Cliente
$usuario=$perfiles[1];             //id del usuario cod_user
if($perfil=="" || $usuario==""){
  	header("location:../../index.php");
}	
?> 
<html>
 <head>
  <script>
  	function cambiaraction(op,id){
		switch(op){
			case 1 :
				document.forms["FormProvList"].modo.value=1;       //ingreso 
				//document.forms["FormProvList"].action="../../interface/proveedores/ProvForm.php"
				break;
			case 2 :	
				document.forms["FormProvList"].modo.value=2;       //modificacion
				document.forms["FormProvList"].id.value=id;
				//document.forms["FormProvList"].action="../../dominio/proveedores/ProvMant.php"
				break;
			case 3 :
				document.forms["FormProvList"].modo.value=3;       //eliminacion
				document.forms["FormProvList"].id.value=id;
				//document.forms["FormProvList"].action="../../dominio/proveedores/ProvMant.php"
				break;
			case 4 :
				document.forms["FormProvList"].modo.value=4;      //ver ficha proveedor
				document.forms["FormProvList"].id.value=id;
				break;
		}
	    document.forms["FormProvList"].submit();
	} 
 	</script>
 </head>
 <body>
  <?php
  $numpro=0;	$razpro="";	$rutpro="";	$dirpro="";	$deppro="";  $telpro=0;	$faxpro=0;	$celpro=0;	$mailpro="";
  $Los_Proveedores=new Proveedor($numpro,$razpro,$rutpro,$dirpro,$deppro,$telpro,$faxpro,$celpro,$mailpro);
  $result=$Los_Proveedores->TusProveedores();
  	
  ?><H1><CENTER>LISTADO DE PROVEEDORES</CENTER></H1>
  <TABLE align="center" style="font-size:12px" width="60%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor="#FF9900">
  		<form name="FormProvList" action="../../interface/proveedores/ProvForm.php" method="POST" >
	  		<input type="hidden" name="modo">
			<input type="hidden" name="id">
				
<?php $total_registros=mysql_num_rows($result);
	  if ($total_registros>0){ ?>
	  	<tr align="center" style="font-size:10px">
		    <td>RAZON SOCIAL</td>
		   	<td>DIRECCION</td>
			<td>TELEFONO</td>
			<td>FAXSIMIL</td>
			<td>MOVIL</td>
			<td style="font-size:9px">MODI</td>
		    <td style="font-size:9px">ELIMINA</td>
			<td style="font-size:9px">VISTA</td>
		</tr> 
<?php   while($row = mysql_fetch_array($result)){
		  $id=$row['num_pro'];
		  print("<tr align='center' bgcolor='#FFFFFF'>
					 <td style='font-size:12px' >".$row["raz_pro"]." </td>
					 <td style='font-size:12px' >".$row["dir_pro"]." </td>
			         <td style='font-size:11px' >".$row["tel_pro"]." </td>
					 <td style='font-size:11px' >".$row["fax_pro"]." </td>
			         <td style='font-size:11px' >".$row["cel_pro"]." </td>
			         <td><input type='image' src='../../iconos/editmini.png' title='MODIFICAR FICHA DEL PROVEEDOR' 
					 									border=0 onclick=cambiaraction(2,$id);></td>
			         <td><input type='image' src='../../iconos/deletep.png'  title='ELIMINAR PROVEEDOR' 
					 									border=0 onclick=cambiaraction(3,$id);></td>
					 <td><input type='image' src='../../iconos/monitormini.png' title='VER FICHA DEL PROVEEDOR'
					  									border=0 onclick=cambiaraction(4,$id);></td>
			     </tr>");
		}		 
      }else{ 
		echo "<center>"."NO HAY PROVEEDORES REGISTRADOS"."</center>";
	  }	?>
	    </form>
	</table>
	
	  <?php	if($perfil!="" || $usuario!=""){ ?>
  	             <a href="ProvForm.php?modo=1" title="AGREGAR UN NUEVO PROVEDOR">
				 			<img src="../../iconos/Palette.png" border="0"/>
				 			<font size="3" color="#000000">NUEVO PROVEEDOR</font>
				 </a>
	  <?php }?>	 
	</p>										
	<hr></hr>
  </body>
</html>