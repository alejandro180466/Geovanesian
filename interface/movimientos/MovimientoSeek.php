<?php
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php"); exit();}
$link=Conecta();   //en Persistencia.php
$sql="SELECT raz_pro,num_pro FROM proveedor WHERE 1=1 ORDER BY raz_pro";
$res=mysql_query($sql,$link);       //realizo la consulta
if (mysql_num_rows($res)!=0){      //encontro registro?
	$row=mysql_fetch_array($res);  //cargo resultado en $row.
}
Desconecta($link); 
?>
<html>
 <head>
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
   <script languaje="javascript" > 
   function Validobusqueda(form){
		var desde=form.fecini.value;
		var hasta=form.fecfin.value;
						
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
   <center><H2><img src='../../iconos/search102.png'/>MOVIMIENTOS</H2></center>
  <TABLE align="center" >     
   <form name="formBusco" method="POST" action="../../dominio/movimientos/SeekMant.php" >
    <TR bordercolor="#FFFFFF">
		<TD>Número movimiento :</TD>
	    <TD><INPUT TYPE="text" NAME="numid" VALUE="" SIZE="10" MAXLENGTH="10"/> ej: 128</td>
	</TR>
    <TR bordercolor="#FFFFFF">
		<TD>Razón social :</TD>
		<td><?php
				echo "<select name='txtraz'>";
			 	    echo "<option value='' selected='selected'>sin seleccionar ...</option>";
				    $link=Conecta();
			        $resultado=mysql_query($sql); 
					Desconecta($link);
					while ($fila=mysql_fetch_row($resultado)){ 
						echo "<option value='$fila[0]'>$fila[0]";	
					} 
				echo "</select>";
			?>		
		</td> 
	</TR>
	<TR bordercolor="FFFFFF">
	   <TD>Direccion :</TD>
	   <TD><INPUT TYPE="text" NAME="txtdir" VALUE=""  SIZE="30" MAXLENGTH="40" title="La direccion puede ser parcial"/></TD>
	</TR>
	<TR bordercolor="FFFFFF">
	    <TD>Departamento:</TD>
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
	<tr bordercolor="FFFFFF"><TD>Transacción:</td>												
	   <td><select name="txttipmov" value="" size="1" >
  				<option value="" selected="selected">sin seleccionar</option>
				<option value="factura contado"   >FACTURA CONTADO</option>
  				<option value="factura crédito"   >FACTURA CREDITO</option>
				<option value="devolución contado">DEVOLUCION CONTADO</option>
				<option value="nota crédito"      >NOTA DE CREDITO</option>
				<option value="nota devolución"   >NOTA DEVOLUCION</option>
				<option value="nota remito"       >NOTA REMITO</option>
				<option value="recibo pago"       >RECIBO DE PAGO</option>
				<option value="saldo inicial"     >SALDO INICIAL</option>
		  </select></td>
	</TR>
	<TR bordercolor="FFFFFF">
     <td>Rubro :</td>
	 <td >
       <?php
	   $sql2="select * FROM rubro WHERE est_rubro='HABILITADO' ORDER BY des_rubro asc";
	   $link=Conecta();
	   $resultado=mysql_query($sql2);
	   if (!isset($modo)){
			$modo=0;
	   }
		echo "<select name='txtrub'>";
			echo "<option value='' selected='selected'>"."sin seleccionar"."</option>";
	            while ($row2=mysql_fetch_array($resultado)){ 
				    echo "<option value=".$row2['des_rubro'].">".$row2['des_rubro']."</option>";
			    } 
		echo "</select>";
		Desconecta($link);		  ?>
      </td>
	</tr>
	<tr bordercolor="FFFFFF"><TD>Desde fecha:</td>
	  	<TD><INPUT TYPE="text" NAME="fecini"  ID="fecini" VALUE=""  SIZE="10" MAXLENGTH="10"
						title="EL FORMATO DEBE SER aaaa-mm-dd"/>ej: 2010-12-24 </td>
	</tr>
	<tr bordercolor="FFFFFF"><TD>Hasta fecha:</td>
	  	<TD><INPUT TYPE="text" NAME="fecfin" ID="fecfin" VALUE=""  SIZE="10" MAXLENGTH="10" 
						title="EL FORMATO DEBE SER aaaa-mm-dd"/>formato : aaaa-mm-dd</td>
	</tr>
	<tr bordercolor="FFFFFF"><TD>Objetivo:</td>
	  	<TD><INPUT TYPE="radio" NAME="rutina" ID="rutina" VALUE="1" CHECKED="checked" 
					TITLE="muestra todos los movimientos según filtros"/>estados
			<INPUT TYPE="radio" NAME="rutina" ID="rutina" VALUE="2" TITLE="muestra solo compras a proveedores"/>compras
			<INPUT TYPE="radio" NAME="rutina" ID="rutina" VALUE="3" TITLE="muestra solo los pagos a proveedores"/>pagos
		</TD>
	</tr>
	<tr bordercolor="FFFFFF"><TD>Tipo:</td>
	  	<TD><INPUT TYPE="radio" NAME="tipo" ID="tipo" VALUE="1" CHECKED="checked" 
					TITLE="muestra todos los movimientos según filtros"/>resumen
			<!--INPUT TYPE="radio" NAME="tipo" ID="tipo" VALUE="2" TITLE="muestra solo los totales"/>saldo -->
		</TD>
	</tr>
   </TABLE>
   <input type="button" name="seek" id="seek" value="BUSCAR" 
				title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO" onClick="Validobusqueda(this.form)";>
   <input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO"></td>
  </form>
 </id>
 </body>
</html>