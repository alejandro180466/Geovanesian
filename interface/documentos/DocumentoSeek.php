<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
}
$ssql="select num_cli, raz_cli , dir_cli , tel_cli from cliente where 1=1 ORDER BY raz_cli ASC";
$link=Conecta();

?>
<html>
  <head>
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
  </head> 
 <body>
  <div id="buscador">
  <H2><img src='../../iconos/search102.png'/>ESTADOS DE CUENTA</H2> 
  <TABLE align="center" cellpadding="1" cellspacing="1" >     
   <form name="formBusco" method="POST" action="../../dominio/documentos/MantSeek.php"> 
      <TR bordercolor="#FFFFFF">
		<TD>Razón social :</TD><td><?php
		        echo "<select name='numcli' size='1'>";
			 		   echo "<option value='' selected='selected'>sin seleccionar</option>";
			           $resultado=mysql_query($ssql); 
						while ($fila=mysql_fetch_row($resultado)){ 
							echo "<option value='$fila[0]'>$fila[1]";	
						} 
						echo "</select>";
				    	Desconecta($link);
			?>		
	    </TD> 
	 </TR>
	<tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecini"  VALUE=""  SIZE="10" MAXLENGTH="10"
		                                   title="EL FORMATO DEBE SER aaaa-mm-dd"/>ej:2010-12-24 </td>
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecfin"  VALUE=""  SIZE="10" MAXLENGTH="10"/>formato: aaaa-mm-dd</td>
	 </tr>
	</TABLE>
	<input type="submit" name="seek" id="seek" value="BUSCAR" 
		               title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO">
	<input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO">
   </form>		
  </DIV>
</body>
</html>