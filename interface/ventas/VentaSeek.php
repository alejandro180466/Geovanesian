<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");  exit();
}
$ssql="select m.cod_mer ,m.des_mer from mercaderia m where 1=1 order by m.des_mer asc";
$link=Conecta();
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
	function Validobusqueda(form){
		var desde=form.fecini.value;
		var hasta=form.fecfin.value;
		form.action="../../dominio/ventas/SeekMant.php";
				
		if (desde!=""){
			if (Validafecha(desde)==false){;
				form.fecini.value="";
				form.fecini.focus();
				return;
			}
		}
		if (hasta!=""){
			if (Validafecha(hasta)==false){;
				form.fecfin.value="";
				form.fecfin.focus();
				return;
			}
		}
		form.submit();
		return false;
	}
   </script>
 </head> 
 <body>
   <div id="buscador">
	<H2>BUSCADOR DE VENTAS<img src='../../iconos/search102.png'/></H2>
	<TABLE align="center" > 
		<form name="formBusco" method="POST" >
		<TR bordercolor="#FFFFFF">
			<TD>Articulo:</TD>
			<td>
				<?php echo "<select name='txtcodmer'>";
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
		<TR bordercolor="FFFFFF">
			<TD>Categoria :</TD>
			<TD><select name="txtcat" size="1" >
					<option value="" selected="selected">sin seleccionar</option>
  					<option value="DULCES"         >DULCES</option>
  					<option value="MERMELADAS"     >MERMELADAS</option>
					<option value="PANADERIA"      >PANADERIAS</option>
					<option value="PASTAS DE FRUTA">PASTAS DE FRUTA</option>
				</select>
			</td>
			<td style="font-size:12px" >elegir del listado</td>		
		</tr>
		<tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
			<TD><INPUT TYPE="text" NAME="fecini"  ID="fecini" VALUE=""  SIZE="10" MAXLENGTH="10" title="EL FORMATO DEBE SER aaaa-mm-dd"/></td>
			<td style="font-size:12px">ej: 2010-12-24 </td>
		</tr>
		<tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
			<TD><INPUT TYPE="text" NAME="fecfin"  ID="fecfin" VALUE=""  SIZE="10" MAXLENGTH="10" title="EL FORMATO DEBE SER aaaa-mm-dd"/></TD>
			<td style="font-size:12px">formato : aaaa-mm-dd</td>
		</tr>
		<tr>
			<td><input type="button" name="seek" id="seek" value="BUSCAR"
				title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO" onClick="Validobusqueda(this.form)";></td>
			<td></td>
			<TD><input type="reset" value="LIMPIAR" title="VACIAR EL FROMULARIO"></td>
		</tr>
	</form>		
	</TABLE>
  </id>
 </body>
</html>