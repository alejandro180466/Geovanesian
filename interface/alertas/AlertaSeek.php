<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){  	header("location:../../index.php"); exit();}
$_SESSION['ses_pagina']=1;
?>
<html>
  <head>
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
   <script languaje="javascript"> 
   
	function Validobusqueda(form){
		var desde=form.fecini.value;
		var hasta=form.fecfin.value;
		form.action="../../dominio/alertas/MantSeek.php";
				
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
    <BR></BR>
	<div id="tabla buscador">
		<CENTER><font style="font-size:24px;">BUSCADOR DE ALERTAS</font></CENTER>
		<TABLE align="center" >     
		   <form name="formBusco"  method="POST" > 
				<TR bordercolor="#FFFFFF">
					<TD>Concepto :</TD>
					<TD><INPUT TYPE="text" NAME="txtconcepto" id="txtconcepto" VALUE="" SIZE="30" MAXLENGTH="40" 
																				TITLE="Que comience por ...."/></TD>
					
				</TR>
				<TR bordercolor="FFFFFF">
					<TD>ESTADO :</TD>
					<TD><select name="txtestado" size="1" >
							<option value="" selected="selected">sin seleccionar</option>
							<option value="P" >PENDIENTE</option>
							<option value="C" >CANCELADO</option>
							<option value="E" >EJECUTADO</option>
						</select></td>
				</tr>
				<tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
					 <TD><INPUT TYPE="text" NAME="fecini"  id="fecini"  SIZE="10" MAXLENGTH="10"
								title="EL FORMATO DEBE SER aaaa/mm/dd" />ej: 2010-12-24
					</TD>
				</tr>
				<tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
					<TD><INPUT TYPE="text" NAME="fecfin"  VALUE=""  SIZE="10" MAXLENGTH="10"/>
						formato : aaaa-mm-dd
					</TD>
				</tr>
		</TABLE>
				<input type="button" name="seek" id="seek" value="BUSCAR" 
				   title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO" onClick="Validobusqueda(this.form)";>
				<input type="reset" value="LIMPIAR" title="VACIAR EL FROMULARIO">
				
				
			</form>	
	</div>
  </body>
</html>