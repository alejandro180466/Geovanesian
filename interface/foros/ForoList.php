<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
//session_start();
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
  	function Editaction(modo,id){
		switch(modo){
			case 1 :    //agregar
				document.forms["FormForoList"].modo.value=1;
				document.forms["FormForoList"].action="ForoForm.php";
				break;
			case 2 :	//modificar
				document.forms["FormForoList"].modo.value=2;
				document.forms["FormForoList"].action="ForoForm.php"; 
				break;
			case 3 :    //borrar
				document.forms["FormForoList"].modo.value=3;
				document.forms["FormForoList"].action="ForoForm.php";
				break;
			case 4 :    //mostrar foro
				document.forms["FormForoList"].modo.value=4;
				document.forms["FormForoList"].action="ForoVer.php";
				break;
		}
		document.forms["FormForoList"].id.value=id;
		document.forms["FormForoList"].submit();
	}
   </script>
 <body>
<?php
  $link=Conecta();
  if($perfil=="A"){
      $sql="select cod_foro, tem_foro, est_foro ,fec_foro from foro order by cod_foro";
  }else{
  	  $sql="select cod_foro, tem_foro, est_foro ,fec_foro from foro
	  							where est_foro like 'ACTIVO' order by cod_foro";
  }	 
  $result=ejecutarConsulta($sql,$link);
	?>
	<H1><CENTER>LISTADO DE FOROS <img src='../../iconos/Foro.png' border="0"></CENTER></H1>
	<TABLE  width="60%" align="center" style="font-size:12px" BORDER=0    CELLSPACING=1  CELLPADDING=1 bgcolor="#FF9900" >
	   <form name="FormForoList"  method="POST" >
	   		<input type="hidden" name="modo">
			<input type="hidden" name="id">
		<tr><td>            <center>TEMA   </center></td>
		    <td width="10%"><center>INICIO </center></td>
		<?php if($perfil=="A"){?>
			<td width="10%"><center>ESTADO </center></td>
		    <td width="6%" style="font-size:10px"> <center>EDITAR </center> </td>
			<td width="6%" style="font-size:10px"> <center>BORRAR </center> </td>
		<?PHP } ?>
	    	<td width="6%" style="font-size:10px"><center>VER</center></td>
		</tr>
 <?php		
	while($row = mysql_fetch_array($result)) {
		$id=$row['cod_foro'];
			if ($perfil=="A"){ // si es admin
			      printf("<tr align='center'>
				           <td bgcolor=#FFFFFF>".$row["tem_foro"]." </td>
						   <td bgcolor=#FFFFFF>".$row["fec_foro"]." </td>
						   <td bgcolor=#FFFFFF >".$row["est_foro"]." </td>
					       <td><input type='image' src='../../iconos/Editp.png'   border=0  onclick='Editaction(2,$id);'></td>
					       <td><input type='image' src='../../iconos/Deletep.png' border=0  onclick='Editaction(3,$id);'></td>
						   <td><input type='image' src='../../iconos/monitor.png' border=0  title='VER Y PARTICIPAR DEL FORO'         												                                  onclick='Editaction(4,$id);'></td>
						  </tr>");
    		}else{// si es promotor
				 printf("<tr align='center'>
				           <td bgcolor=#FFFFFF>".$row["tem_foro"]." </td>
						   <td bgcolor=#FFFFFF>".$row["fec_foro"]." </td>
					       <td><input type='image' src='../../iconos/monitor.png' border=0  title='VER Y PARTICIPAR DEL FORO'
						   			onclick='Editaction(4,$id);'></td>
						  </tr>");
			}		  		  				
	}
  	FreeResp($result);
	Desconecta($link);
	
 ?>
     <TR bgcolor="#FFCC33"><td align="center">AGREGAR FORO <INPUT type="image" src="../../iconos/Addp.png"  border=0 onClick="Editaction(1,0);"></TD></TR>
   </form>
 </table>

  </body>
</html>