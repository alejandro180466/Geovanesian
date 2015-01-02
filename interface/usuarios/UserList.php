 <?php
include("../../dominio/Persistencia.php");
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
  <script>
  	function cambiaraction(modo,id){
		
		switch(modo){
			case 2 :	
				document.forms["FormUserList"].modo.value=2;
				document.forms["FormUserList"].id.value=id;
				break;
			case 3 :
				document.forms["FormUserList"].modo.value=3;
				document.forms["FormUserList"].id.value=id;
				break;
		}
		document.forms["FormUserList"].action="UserForm.php";
	    document.forms["FormUserList"].submit();
	}
   </script>
 <body>
 <?php include("../../estilos/Estilo_page.php"); ?>
 <H1><CENTER>MANTENIMIENTO DE USUARIOS<img src='../../iconos/Users.png' border="0"></CENTER></H1>
<?php  

	$opcion=$_POST["opcion"];
	$link=Conecta();
	if ($perfil=="C"){
	  $result=mysql_query("select cod_user, nom_user, apellido_user ,fono_user, email_user , cod_user from user where cod_user like $codusr",$link);
	}else{
	  $result=mysql_query("select cod_user, nom_user, apellido_user ,fono_user, email_user , cod_user from user order by cod_user",$link);
	}
	if($opcion==2 || $opcion==3){
		?><H2><CENTER>BAJAS Y MODIFICACIONES</CENTER></H2><?PHP
	}elseif($opcion==4){
		?><H2><CENTER>LISTADO</CENTER></H2><?PHP
	}?> 		
    <CENTER>
	<TABLE  style="font-size:14px" BORDER=2    CELLSPACING=1  CELLPADDING=2 bgcolor="#FF9900" >
	   <form name="FormUserList"  method="POST" >
	   		<input type="hidden" name="modo">
			<input type="hidden" name="id">
		<tr><td><center><img src='../../iconos/User.png' border="0"></center></td>
		<td>Apellidos</td>
		<td><center><img src='../../iconos/Fonop.png'  border="0"></center></td>
		<td><center><img src='../../iconos/Emailp.png' border="0"></center></td>
		<td><center><img src='../../iconos/Editp.png'  border="0"></center></td>
		<?php if($perfil=="A"){?><td><center><img src='../../iconos/Deletep.png' border="0"></center></td><?PHP } ?></tr>
 <?php		
	while($row = mysql_fetch_array($result)) {
		$id=$row["cod_user"];
		if($opcion==2 || $opcion==3){ //modificaciones opcion=2    bajas opcion=3
			if ($perfil=="A"){
			      printf("<tr align='center'>
				           <td>".$row["nom_user"]."      </td>
						   <td>".$row["apellido_user"]." </td>
						   <td>".$row["fono_user"]."     </td>
					       <td>".$row["email_user"]."    </td>
					       <td><input type='image' src='../../iconos/Editp.png'   border=0  onclick='cambiaraction(2,$id);'></td>
					       <td><input type='image' src='../../iconos/Deletep.png' border=0  onclick='cambiaraction(3,$id);'></td>
						  </tr>");
					      
			}else{						// si es promotor
				 printf("<tr align='center'>
				           <td>".$row["nom_user"]."      </td>
						   <td>".$row["apellido_user"]." </td>
						   <td>".$row["fono_user"]."     </td>
					       <td>".$row["email_user"]."    </td>
					       <td><input type='image' src='../../iconos/Editp.png'   border=0  onclick='cambiaraction(2,$id);'></td>
						  </tr>");
			}		  		  				
		}elseif($opcion==4){           //listado opcion=4
				printf("<tr align='center'>
				           <td>".$row["nom_user"]."      </td>
						   <td>".$row["apellido_user"]." </td>
						   <td>".$row["fono_user"]."     </td>
					       <td>".$row["email_user"]."    </td>
					     </tr>");
		}		
	}
  	FreeResp($result);
	Desconecta($link);
 ?>
   </form>
 </table></CENTER>
 
  </body>
</html>

