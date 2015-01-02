<?php
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
}
?>
<html>
 <head>
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
      <script languaje="javascript"> 
   
	function Validobusqueda(form){
		var desde=form.fecini.value;
		var hasta=form.fecfin.value;
		form.action="../../dominio/pedidos/MantSeek.php";
				
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
	<H2><img src='../../iconos/search102.png'/>PEDIDOS</H2>
  <TABLE align="center">     
   <form name="formBusco" method="POST" > 
   	 <TR bordercolor="#FFFFFF">
		<TD>Número de pedido :</TD>
	    <TD><INPUT TYPE="text" NAME="numid" VALUE="" SIZE="6" MAXLENGTH="6" 
												onkeypress="return permite(event,'num')"/>
		ej: 1123 </td>
	 </TR>
     <TR bordercolor="#FFFFFF">
		<TD>Razón social :</TD>
	    <TD><INPUT TYPE="text" NAME="txtraz" VALUE="" SIZE="30" MAXLENGTH="40"/></TD>
		
	 </TR>
	
	 <tr bordercolor="#FFFFFF">
	 	<TD>Estado :</TD>
	    <TD><select name="txtestado" VALUE="" size="1">
  					<option value="">seleccionar ..</option>
					<option value="PENDIENTE">PENDIENTE</option>
					<option value="PREPARADO">PREPARADO</option>
					<option value="FACTURADO">FACTURADO</option>
					<option value="ENTREGADO">ENTREGADO</option>
			</select></TD>
	
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecini"  VALUE=""  SIZE="10" MAXLENGTH="10"title="EL FORMATO DEBE SER aaaa-mm-dd"/>
 		     ej: 2010-12-24 </td>
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecfin"  VALUE=""  SIZE="10" MAXLENGTH="10"/>formato : aaaa-mm-dd</td>
	 </tr>
	 <tr>
	    <td><input type="button" name="seek" id="seek" value="BUSCAR"
			title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO"onClick="Validobusqueda(this.form)";></td>
	
		<TD><input type="reset" value="LIMPIAR" title="VACIAR EL FROMULARIO"></td>
	 </tr>
	</form>		
 </TABLE>
 </id>
  </body>
</html>