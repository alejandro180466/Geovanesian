<?php
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}
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
  </head> 
 <body>
   
  <div id="buscador"> 
	<H2><img src='../../iconos/search102.png'/>PROVEEDORES</H2>
  <TABLE align="center">   
   <form name="formBusco" method="POST" action="../../dominio/proveedores/MantSeek.php"> 
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
	 <TR bordercolor="#FFFFFF">
		<TD>Nombre comercial :</TD>
	    <TD><INPUT TYPE="text" NAME="txtnom" VALUE="" SIZE="30" MAXLENGTH="40" TITLE="Que contenga ...."/></TD>
		
	 </TR>
	 <TR bordercolor="FFFFFF">
	    <TD>RUT    :</TD>
	    <TD><INPUT TYPE="text" NAME="numrut" VALUE="" SIZE="12" MAXLENGTH="12" title="rut debe ingresar 12 numeros"
											onkeypress="return permite(event,'num')"/></TD>
		
	 </TR>
     <TR bordercolor="FFFFFF">
	   <TD>Direccion :</TD>
	   <TD><INPUT TYPE="text" NAME="txtdir" VALUE=""  SIZE="30" MAXLENGTH="40" title="Que contenga , puede ser parcial"/></TD>
	  
	 </TR>
	 <TR bordercolor="FFFFFF">
	    <TD>Departamento :</TD>
		<TD><select name="txtcity" size="1" >
							<option value="" selected="selected">sin seleccionar ...</option>
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
	  <TR bordercolor="FFFFFF">
	   <TD>Rubro :</TD>
	   <td>
       <?php
	   $sql="select * FROM rubro WHERE est_rubro='HABILITADO' ORDER BY des_rubro ASC";
	   $link=Conecta();
	   $resultado=mysql_query($sql);
	 	echo "<select name='txtrub'>";
			echo "<option value=''>"."sin seleccionar ..."."</option>";
	            while ($row=mysql_fetch_array($resultado)){ 
				    echo "<option value=".$row['des_rubro'].">".$row['des_rubro']."</option>";
			    } 
		echo "</select>";
		Desconecta($link);		  
		?>
      </td>
	 </TR>
	</TABLE>
	<input type="submit" name="seek" id="seek" value="BUSCAR" title="REALIZAR BUSQUEDA SEGUN CRITERIO SELECCIONADO">
	<input type="reset" value="LIMPIAR" title="VACIAR EL FORMULARIO">
  </form>		
 </div>
</body>
</html>