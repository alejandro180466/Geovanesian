<?php include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){  	header("location:../../index.php");  exit();}
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
	 <H2><img src='../../iconos/search102.png'/>VENTA MERCADERIA</H2>
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
			</TR>
		
			<tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
				<TD><INPUT TYPE="text" NAME="fecini"  ID="fecini" VALUE=""  SIZE="10" MAXLENGTH="10" title="EL FORMATO DEBE SER aaaa-mm-dd"/>
					ej: 2010-12-24 </td>
			</tr>
			<tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
				<TD><INPUT TYPE="text" NAME="fecfin"  ID="fecfin" VALUE=""  SIZE="10" MAXLENGTH="10" title="EL FORMATO DEBE SER aaaa-mm-dd"/>
					formato : aaaa-mm-dd</td>
			</tr>
		  </TABLE>
			<input type="button" name="seek" id="seek" value="BUSCAR"
			title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO" onClick="Validobusqueda(this.form)";>
			<input type="reset" value="LIMPIAR" title="VACIAR EL FROMULARIO">
		</form>		
    </id>
 </body>
</html>