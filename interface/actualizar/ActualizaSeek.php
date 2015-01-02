<?php include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
}
$sql="select * from cliente where 1=1 order by raz_cli asc";
$ssql="select m.cod_mer ,m.des_mer from mercaderia m where 1=1 order by m.des_mer asc";
$link=Conecta();
?>
<html>
 <head>
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
 </head>  
 <body>
  <br></br>
  <CENTER><font style="font-size:24px;">BUSCADOR DE ACTUALIZACIONES DE PRECIOS</font></CENTER>
  <TABLE align="center" cellpadding="2" cellspacing="2"  width="40%" >     
   <form name="formBusco" method="POST" action="../../dominio/actualizar/MantSeek.php"> 
     <TR bordercolor="#FFFFFF">
		<TD>Razón social :</TD>
	  	<td><?php echo "<select name='numcli'>";
					echo "<option value='' selected='selected'>sin seleccionar</option>";
			          $result=mysql_query($sql); 
					  while ($fila=mysql_fetch_row($result)){ 
						   echo "<option value='$fila[0]'>$fila[1]";
					  } 
					echo "</select>";
			?>
		</td>
	 </TR>
	 <tr bordercolor="FFFFFF"><TD>Producto:</td>
	    <td>
     	 <?php echo "<select name='nummer'>";
				  echo "<option value='' selected='selected'>sin seleccionar</option>";
			         $resultado=mysql_query($ssql); 
					  while ($fila=mysql_fetch_row($resultado)){ 
					  	echo "<option value='$fila[0]'>$fila[1]";
					  } 
		   	   echo "</select>";
			   Desconecta($link);
		 ?>
		</td>
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecini"  VALUE=""  SIZE="10" MAXLENGTH="10"title="EL FORMATO DEBE SER aaaa/mm/dd"/>
		     ej: 2010/12/24
		 </td>
	  </tr>
	  <tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecfin"  VALUE=""  SIZE="10" MAXLENGTH="10"/>
		     formato : aaaa / mm / dd</td>
	  </tr>
	 <tr>
	    <td><input type="submit" name="seek" id="seek" value="BUSCAR" title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO"></td>
		<TD align="right"><input type="reset" value="LIMPIAR" title="VACIAR EL FROMULARIO"></td>
	 </tr>
	</form>		
 </TABLE>
 
  </body>
</html>