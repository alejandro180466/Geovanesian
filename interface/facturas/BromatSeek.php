<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
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
		form.action="../../dominio/facturas/BromatMantSeek.php";
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
   <br></br>
   <CENTER><font style="font-size:24px;">CRITERIOS PARA TASA BROMATOLOGICA</font></CENTER>
   
   <TABLE align="center" cellpadding="3" cellspacing="3" >     
   <form name="formBusco" method="post" > 
	 <TR bordercolor="FFFFFF">
	    <TD>Departamento :</TD>
		<TD><select name="txtcity" size="1" >
							<option value="" selected="selected">sin seleccionar</option>
  							<option value="ARTIGAS"       >ARTIGAS</option>
							<option value="CANELONES"     >CANELONES</option>
							<option value="CERRO LARGO"   >CERRO LARGO</option>
							<option value="COLONIA"       >COLONIA</option>
							<option value="DURAZNO"       >DURAZNO</option>
							<option value="FLORES"        >FLORES</option>
							<option value="FLORIDA"       >FLORIDA</option>
							<option value="LAVALLEJA"     >LAVALLEJA</option>
						    <option value="MALDONADO"     >MALDONADO</option>
						    <option value="MONTEVIDEO"    >MONTEVIDEO</option>
                        	<option value="PAYSANDU"      >PAYSANDU</option>
						    <option value="RIO NEGRO"     >RIO NEGRO</option>
							<option value="RIVERA"        >RIVERA</option>
						    <option value="ROCHA"         >ROCHA</option>
							<option value="SALTO"         >SALTO</option>
						    <option value="SAN JOSE"      >SAN JOSE</option>
						    <option value="SORIANO"       >SORIANO</option>
							<option value="TACUAREMBO"    >TACUAREMBO</option>
							<option value="TREINTA Y TRES">TREINTA Y TRES</option>
				</select></td>
		 <td style="font-size:12px" >elegir del listado</td>		
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecini"  id="fecini" VALUE=""  SIZE="10" MAXLENGTH="10"
		                                   title="EL FORMATO DEBE SER aaaa/mm/dd"/></td>
		 <td style="font-size:12px">ej: 2010/12/24 </td>
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecfin"  id="fecfin" VALUE=""  SIZE="10" MAXLENGTH="10"/></TD>
		 <td style="font-size:12px">formato : aaaa / mm / dd</td>
	 </tr>
  	 <tr>
	    <td><input type="button" name="seek" id ="seek" value ="BUSCAR" 
				title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO" onClick="Validobusqueda(this.form);"/>
		</td>
	    <td></td>
		<TD><input type="reset" value="LIMPIAR" title="VACIAR EL FROMULARIO"></td>
	 </tr>
	</form>		
 </TABLE>
 </body>
</html>