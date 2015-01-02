<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
}
$sql="select num_cli, raz_cli , dir_cli , tel_cli from cliente where 1=1 order by raz_cli asc";
?>
<html>
  <head>
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
   <script languaje="javascript"> 
   function Validobusqueda(form){
		var desde=form.fecini.value;
		var hasta=form.fecfin.value;
		form.action="../../dominio/facturas/MantSeek.php";
				
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
	<H2><img src='../../iconos/search102.png'/>FACTURAS</H2>
  <TABLE  align="center" >     
   <form name="formBusco" method="POST" > 
      <TR bordercolor="#FFFFFF">
		<TD>Nº documento :</TD>
	    <TD><INPUT TYPE="text" NAME="numdoc" VALUE="" SIZE="6" MAXLENGTH="6" 
					TITLE="debe ingresar el numero" onKeyPress="return permite(event,'num')"/>ej: 45890</td>
	 </TR>
     <TR bordercolor="#FFFFFF">
		<TD>Razón social :</TD>
		<td><?php  	 echo "<select name='txtraz'>";
			 		   echo "<option value='' selected='selected'>sin seleccionar</option>";
					   $link=Conecta();
			           $resultado=mysql_query($sql); 
					   Desconecta($link);
					   while ($fila=mysql_fetch_row($resultado)){ 
							echo "<option value='$fila[1]'>$fila[1]";	
					   } 
				 	 echo "</select>";
				       ?>		
		 </td>  
	 </TR>
	  
	 <TR bordercolor="FFFFFF">
	    <TD>RUT    :</TD>
	    <TD><INPUT TYPE="text" NAME="numrut" VALUE="" SIZE="12" MAXLENGTH="12" 
		            title="rut debe ingresar 12 numeros" onKeyPress="return permite(event,'num')"/></TD>
		
	 </TR>

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
			
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecini"  VALUE=""  SIZE="10" MAXLENGTH="10"
		                                   title="EL FORMATO DEBE SER aaaa-mm-dd"/>ej: 2010-12-24 </td>
	 </tr>
	 <tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
	  	 <TD><INPUT TYPE="text" NAME="fecfin"  VALUE=""  SIZE="10" MAXLENGTH="10"/>formato: aaaa-mm-dd</td>
	 </tr>
	 	 <tr bordercolor="FFFFFF"><TD>Tipo Transacción:</td>												
	   <td><select name="txttipmov" value="" size="1" >
  				<option value="" selected="selected">sin seleccionar</option>
				<option value="FACTURA CONTADO">FACTURA CONTADO</option>
  				<option value="FACTURA CREDITO">FACTURA CREDITO</option>
				<option value="DEVOLUCION CONTADO">DEVOLUCION CONTADO</option>
				<option value="NOTA DE CREDITO">NOTA DE CREDITO</option>
				<option value="NOTA DEVOLUCION">NOTA DEVOLUCION</option>
				<option value="NOTA REMITO">NOTA REMITO</option>
				<option value="RECIBO PAGO">RECIBO DE PAGO</option>
				<option value="SALDO INICIAL">SALDO INICIAL</option>
		  </select></td>
		  
	  </TR>
	 <tr>
	    <td><input type="button" name="seek" id="seek" value="BUSCAR" 
		               title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO" onClick="Validobusqueda(this.form)";></td>
		
		<TD><input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO"></td>
	 </tr>
	</form>		
 </TABLE>
  </div>
  </body>
</html>