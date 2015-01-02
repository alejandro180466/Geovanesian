<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
}
$ssql="select m.cod_mer ,m.des_mer from mercaderia m where 1=1 order by m.des_mer asc";
$link=Conecta();
?>
<html>
  <head>
   <link href="../../estilos/estilo.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
  </head>
 <body>
   <div id="buscador"> 
     <H2><img src='../../iconos/search102.png'/>MERCADERIAS</H2>
 <TABLE align="center">     
   <form name="formBusco" method="POST" action="../../dominio/mercaderias/MantSeek.php"> 
     <TR bordercolor="#FFFFFF">
		<TD>Articulo:</TD>
		<td>
     	<?php echo "<select name='txtdes'>";
					echo "<option value='' selected='selected'>sin seleccionar</option>";
			          $resultado=mysql_query($ssql); 
					  while ($fila=mysql_fetch_row($resultado)){ 
						  	echo "<option value='$fila[1]'>$fila[1]";
					  } 
					  echo "</select>";
					  Desconecta($link);
		?>
		</td>	 
	 </TR>
	 <TR bordercolor="FFFFFF">
	    <TD>Unidad :</TD>
	    <TD><INPUT TYPE="text" NAME="txtuni" VALUE="" SIZE="15" MAXLENGTH="15" title="Puede ser parcial o vacío"/></TD>
	 </TR>
     <TR bordercolor="FFFFFF">
	   <TD>Codigo ID :</TD>
	   <TD><INPUT TYPE="text" NAME="numpeso" VALUE=""  SIZE="20" MAXLENGTH="20" title="Puede ser parcial o vacio"/></TD>
	 </TR>
	</TABLE>
	<input type="submit" name="seek" id="seek" value="BUSCAR" title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO">
	<input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO">
   </form>		
  </id>
 </body>
</html>