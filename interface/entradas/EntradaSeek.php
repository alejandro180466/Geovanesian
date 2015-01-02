<?php	include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){  	header("location:../../index.php"); exit();}
$sql_insumo="select * from insumo  where 1=1 order by des_insumo asc";
$sql_rubro="SELECT * FROM rubro WHERE 1=1 ORDER BY des_rubro ASC";
$link=Conecta();
?>
<html>
  <head>
   <link href="../../estilos/estilo.css" rel="stylesheet" type="text/css" />
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
  </head>
 <body>
   <H2>BUSCADOR DE ENTRADAS<img src='../../iconos/search102.png'/></H2>
 <TABLE align="center"  cellpadding="3" cellspacing="3"  width="40%" bordercolor="#FF9933" border="0" style="font-size:12px">     
   <form name="formBusco" method="POST" action="../../dominio/entradas/MantSeek.php"> 
    <TR bordercolor="#FFFFFF">
		<TD>Insumo:</TD>
		<td><?php
				echo "<select name='txtins'>";
					echo "<option value='' selected='selected'>sin seleccionar</option>";
					$res_insumo=mysql_query($sql_insumo); 
					while ($fila=mysql_fetch_row($res_insumo)){ 
						echo "<option value='$fila[0]'>$fila[1]";
					} 
				echo "</select>";
			?>
		</td>	 
	</TR>
	<TR bordercolor="FFFFFF">
	    <TD>Desde fecha : </TD>
	    <TD><INPUT TYPE="text" NAME="fecini" VALUE="" SIZE="10" MAXLENGTH="10" title="formato : AAAA-MM-DD"/></TD>
	</TR>
	<TR bordercolor="FFFFFF">
	    <TD>Hasta fecha : </TD>
	    <TD><INPUT TYPE="text" NAME="fecfin" VALUE="" SIZE="10" MAXLENGTH="10" title="formato : AAAA-MM-DD"/></TD>
	</TR>
    <TR bordercolor="FFFFFF">
	    <TD>Rubro :</TD>
		<td><?php echo "<select name='txtrub'>";
					echo "<option value='' selected='selected'>sin seleccionar</option>";
					$res_rub=mysql_query($sql_rubro); 
					while ($fila=mysql_fetch_row($res_rub)){ 
						echo "<option value='$fila[1]'>$fila[1]";
					} 
					echo "</select>";
					Desconecta($link);
			?>
		</td>
	</tr>
	<tr><td>Tipo :</td>
		<td><select name="txttip" VALUE=" " size="1" >
				<option value="" >seleccionar</option>
				<option value="I">INGRESO</option>
				<option value="C">CONSUMO</option>
				<option value="E">EGRESO</option>
			</select>
		</td>
	</tr>
	<tr>
	    <td><input type="submit" name="seek" id="seek" value="BUSCAR" title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO"></td>
		<td></td>
		<TD><input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO"></td>
	</tr>
   </form>		
  </TABLE>
 </body>
</html>