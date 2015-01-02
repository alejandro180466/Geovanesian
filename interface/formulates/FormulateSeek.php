<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){  	header("location:../../index.php");}
$ssql="select m.cod_mer ,m.des_mer from mercaderia m where 1=1 order by m.des_mer asc";
$link=Conecta();
?>
<html>
  <head>
   <link href="../../estilos/estilo.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
  </head>
 <body>
   <center><H1>BUSCADOR DE FORMULAS<img src='../../iconos/search102.png'/></H1></center>

 <TABLE align="center"  cellpadding="3" cellspacing="3"  width="40%" bordercolor="#FF9933" border="0" style="font-size:12px">     
   <form name="formBusco" method="POST" action="../../dominio/formulates/MantSeek.php"> 
     <TR bordercolor="#FFFFFF">
		<TD>Articulo:</TD>
		<td>
     	<?php echo "<select name='txtdes'>";
					echo "<option value='' selected='selected'>sin seleccionar</option>";
			          $resultado=mysql_query($ssql); 
					  while ($fila=mysql_fetch_row($resultado)){ 
						  	echo "<option value='$fila[0]'>$fila[1]";
					  } 
					  echo "</select>";
					  Desconecta($link);
		?>
		</td>	 
	   	<td style="font-size:12px">elegir de la lista</td>
	 </TR>
	 <tr>
	    <td><input type="submit" name="seek" id="seek" value="BUSCAR" title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO"></td>
		<td></td>
		<TD><input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO"></td>
	 </tr>
	</form>		
 </TABLE>
  </body>
</html>