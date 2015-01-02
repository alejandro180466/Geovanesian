<?php
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");
	exit();
}	
?>
<html>
  <script>
  	function Foroaction(modo,idpart){
		switch(modo){
			case 1 :    //agregar
				document.forms["FormForo"].modo.value=1;
				break;		
			case 2 :	//modificar
				document.forms["FormForo"].modo.value=2;
				break;
			case 3 :    //borrar
				document.forms["FormForo"].modo.value=3;
				break;
		}
		document.forms["FormForo"].idpart.value=idpart;
		document.forms["FormForo"].action="ForoVerForm.php";
		document.forms["FormForo"].submit();
	}
   </script>
 <body>
<?php
  $perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
  $perfil=$perfiles[0];              // perfil
  $codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
	
  $link=Conecta();
  $idforo=$_POST['id'];                  //viene el codigo identificador del foro elegido
  $resulttema=mysql_query("select cod_foro ,tem_foro from foro where cod_foro=".$idforo."",$link);
  $rowtema=mysql_fetch_array($resulttema);
  $tema=$rowtema['tem_foro'];      //obtengo el tema del foro
  
  $result=mysql_query("select p.id_part ,p.cod_user, p.fec_part, p.time_part , p.cod_foro , p.opin_foro,
  								u.cod_user , u.nom_user 
  						 			from parforo p , user u  
									 	where p.cod_foro like '$idforo' and (p.cod_user = u.cod_user)
											 order by p.id_part desc ", $link);
 ?>
	<H1><CENTER>FORO<img src='../../iconos/Foro.png' border="0"></CENTER></H1>
	<H2><CENTER>TEMA :<?php echo $tema; ?></CENTER></H2>
	<TABLE  align="center"  width="60%" style="font-size:12px" BORDER=0 CELLSPACING=1 CELLPADDING=1 bgcolor="#FF9900" >
	   	<tr><td width="10%"><center>FECHA   </center></td>
		    <td width="6%"> <center>HORA    </center></td>
		    <td width="8%"><center>USUARIO  </center></td>
			<td width="66%"><center>OPINION </center></td>
		</tr>
		<form name="FormForo"   method="POST" >
	   		<input type="hidden" name="modo"   id="modo">
			<input type="hidden" name="idforo" id="idforo" value="<?php echo $idforo; ?>">
			<input type="hidden" name="idpart" id="idpart"> 
			<input type="hidden" name="tema" id="tema" value="<?php echo $tema; ?>">
 <?php
 	 	while($row = mysql_fetch_array($result)) {
		  $idpart=$row['id_part']; 
			if ($perfil=="A"){ // si es admin
			      printf("<tr align='center'>
				           <td bgcolor=#FFFFFF>".$row["fec_part"]. " </td>
						   <td bgcolor=#FFFFFF>".$row["time_part"]." </td>
						   <td bgcolor=#FFFFFF>".$row["nom_user"]. " </td>
						   <td bgcolor=#FFFFFF>".$row["opin_foro"]." </td>
						   <td><input type='image' src='../../iconos/Deletep.png' border=0
										title='ELIMINAR COMENTARIO A LA IZQUIERDA' onclick='Foroaction(3,$idpart);'></td>
						</tr>");
    		}else{
				 printf("<tr align='center'>
				           <td bgcolor=#FFFFFF>".$row["fec_part"]. " </td>
						   <td bgcolor=#FFFFFF>".$row["time_part"]." </td>
						   <td bgcolor=#FFFFFF>".$row["nom_user"]. " </td>
						   <td bgcolor=#FFFFFF>".$row["opin_foro"]." </td>
						</tr>");
		   }
		}   
		FreeResp($resulttema);
  	    FreeResp($result);
	    Desconecta($link);
 ?>
        <TR><TD></TD><td></td><td></td>
	    <td  bgcolor="#FFCC00" align="center">AGREGAR COMENTARIO
		 		 <INPUT type="image" src="../../iconos/Addp.png"   title="INGRESAR COMENTARIO EN EL FORO" border=0 
				 				onClick="Foroaction(1,0);"></TD></TR>
      </form>
   </table>

  </body>
</html>