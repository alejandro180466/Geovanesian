<?php	include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");

$sql="select num_cli, raz_cli , dir_cli , tel_cli from cliente where 1=1 order by raz_cli asc";

?>
<html>
 <head>
   <script type="text/javascript" src="../../dominio/funciones.js"></script>
 </head>  
 <body>
  
  <div id="buscador"> 
	<H2><img src='../../iconos/search102.png'/>CLIENTES</H2>
  <TABLE align="center"  >     
   <form name="formBusco" method="POST" action="../../dominio/clientes/MantSeek.php">
	<TR bordercolor="#FFFFFF">
		<TD>Razón social :</TD>
		<td><?php  	 echo "<select name='numcli'>";
			 		   echo "<option value='' selected='selected'>sin seleccionar</option>";
					   $link=Conecta();
			           $resultado=mysql_query($sql); 
					   Desconecta($link);
					   while ($fila=mysql_fetch_row($resultado)){ 
							echo "<option value='$fila[0]'>$fila[1]";	
					   } 
				 	 echo "</select>";
				       ?>		
		 </td>  
	 </TR>	 
	 <TR>	
	 	<TD>Razón social :</TD>
	    <TD><INPUT TYPE="text" NAME="txtraz" ID="txtraz" VALUE="" SIZE="30" MAXLENGTH="40"/></TD>
	 </TR>
	 <TR bordercolor="FFFFFF">
	    <TD>RUT    :</TD>
	    <TD><INPUT TYPE="text" NAME="numrut" ID="numrut" VALUE="" SIZE="12" MAXLENGTH="12" title="rut debe ingresar 12 numeros"
											onkeypress="return permite(event,'num')"/></TD>
	 </TR>
     <TR bordercolor="FFFFFF">
	   <TD>Direccion :</TD>
	   <TD><INPUT TYPE="text" NAME="txtdir" ID="txtdir" VALUE=""  SIZE="30" MAXLENGTH="40" title="La direccion puede ser parcial"/></TD>
	 </TR>
	 <TR bordercolor="FFFFFF">
	    <TD>Departamento :</TD>
		<TD><select NAME="txtcity" ID="txtcity" size="1" >
				<option value="" selected="selected">sin seleccionar</option>
  				<option value="ARTIGAS"       >ARTIGAS    </option>
				<option value="CANELONES"     >CANELONES  </option>
				<option value="CERRO LARGO"   >CERRO LARGO</option>
				<option value="COLONIA"       >COLONIA    </option>
				<option value="DURAZNO"       >DURAZNO    </option>
				<option value="FLORES"        >FLORES     </option>
				<option value="FLORIDA"       >FLORIDA    </option>
				<option value="LAVALLEJA"     >LAVALLEJA  </option>
			    <option value="MALDONADO"     >MALDONADO  </option>
			    <option value="MONTEVIDEO"    >MONTEVIDEO </option>
               	<option value="PAYSANDU"      >PAYSANDU   </option>
			    <option value="RIO NEGRO"     >RIO NEGRO  </option>
				<option value="RIVERA"        >RIVERA     </option>
			    <option value="ROCHA"         >ROCHA      </option>
				<option value="SALTO"         >SALTO      </option>
			    <option value="SAN JOSE"      >SAN JOSE   </option>
			    <option value="SORIANO"       >SORIANO    </option>
				<option value="TACUAREMBO"    >TACUAREMBO </option>
				<option value="TREINTA Y TRES">TREINTA Y TRES</option>
			</select>
		 </td>
	 </tr></TABLE>
	 <input type="submit" name="seek" id="seek" value="BUSCAR" title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO">
	 <input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO">
	</form>		
 </id>
 </body>
</html>