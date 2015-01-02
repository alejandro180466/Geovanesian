<?php
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];    //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
}
?>
<html>
 <body>
  <?php include("../../estilos/Estilo_page.php"); ?>
   <center>
  <h2>RESULTADO DE LA BUSQUEDA</h2>
  <?php
  include("../../dominio/Persistencia.php");
  $bTipNom=$_POST["tiponom"];      $bnombre=$_POST["nombre"];
  $bTipApell=$_POST["tipoapell"];  $bapell=$_POST["apellido"];
  $bcity=$_POST["city"];
  $bperfil=$_POST["perfil"];
  $link=Conecta(); // en Persistencia.php
  $sql="select nom_user, apellido_user ,fono_user,email_user, direc_user ,fnac_user, city_user, perfil_user from user where 1=1";
 
  if($bcity!=""){
	$sql.=" and (city_user like '$bcity')";
  }
  if($bperfil!=""){
  	$sql.=" and (perfil_user like '$bperfil')";
  }
  if($bnombre!=" "){
	if($bTipNom=="C"){
		$sql.=" and (nom_user like '%$bnombre%')";
	}else{
		$sql.=" and (nom_user like '$bnombre%')";
	}	
  }
  if($bapell!=" "){
	if($bTipApell=="C"){
		$sql.=" and (apellido_user like '%$bapell%')";
	}else{
		$sql.=" and (apellido_user like '$bapell%')";
	}	
  }
  $result=mysql_query($sql,$link);
  $nro=mysql_num_rows($result);
  if($nro>0){
  		?>
 		<center>
		<TABLE  style="font-size:14px" BORDER=2 CELLSPACING=1 CELLPADDING=3 bgcolor="#FF9900"> 
			<tr align="center" ><td><img src='../../iconos/user.png' border="0"></td>
		 	<td>Apellidos</td>
		 	<td><img src='../../iconos/fonop.png' border="0"></td>
			<td><center><img src='../../iconos/emailp.png' border="0"></center></td>
		 	<td>Dirección</td>
			<td>Departamento</td>
		 	<td>fecha nacimiento</td>
			<td>Perfil</td>
			</tr>
  		<?php
  		while($row = mysql_fetch_array($result)) {
  			printf("<tr><td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>",
					    $row["nom_user"],$row["apellido_user"],$row["fono_user"],$row["email_user"],
						$row["direc_user"],$row["city_user"],$row["fnac_user"],$row["perfil_user"]);
  		}
		?></table><?php
	}else{
		echo("NO HAY USUARIOS REGISTRADOS CON ESTE CRITERIO");
	}
	FreeResp($result); // en Persistencia.php
	Desconecta($link); // en Persistencia.php
    ?>
  </body>
</html>


