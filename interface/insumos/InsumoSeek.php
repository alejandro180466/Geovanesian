<?php
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}
?>
<html>
 <head> 
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
 </head>  
 <body>
    
	<div id="buscador"> 
	<H2><img src='../../iconos/search102.png'/>INSUMOS</H2>
  <TABLE align="center" >     
   <form name="formBusco" method="POST" action="../../dominio/insumos/MantSeek.php"> 
     <TR bordercolor="#FFFFFF">
		<TD>Descripción :</TD>
	    <TD><INPUT TYPE="text" NAME="txtdes" VALUE="" SIZE="45" MAXLENGTH="45" title="Puede ingresar la descripcion parcial"/></TD>
	 </TR>
	 <TR bordercolor="FFFFFF">
	    <TD>Rubro :</TD>
		<TD>
       <?php
	   $sql="select * FROM rubro WHERE est_rubro='HABILITADO' ORDER BY des_rubro ASC";
	   include("../../dominio/Persistencia.php");
	   $link=Conecta();
	   $resultado=mysql_query($sql);
	 	echo "<select name='txtrub'>";
			echo "<option value=''>"."sin seleccionar.."."</option>";
	            while ($row=mysql_fetch_array($resultado)){ 
				    echo "<option value=".$row['des_rubro'].">".$row['des_rubro']."</option>";
			    } 
		echo "</select>";
		Desconecta($link);		  
		?>
      </td>	
	 </tr>
    </TABLE>
	<input type="submit" name="seek" id="seek" value="BUSCAR" title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO">
	<input type="reset" value="LIMPIAR" title="VACIAR EL FROMULARIO">
   </form>		
  </id>
 </body>
</html>