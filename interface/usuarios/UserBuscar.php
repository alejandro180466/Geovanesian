<?php
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];    //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
}
?>
<html>
 <body>
   <?php include("../../estilos/Estilo_page.php"); ?>
  <center>
  <H1>BUSCADOR DE USUARIOS<img src="../../iconos/Search.png"><img src="../../iconos/Users.png"></H1>
  <h2>ELEGIR CRITERIO DE BUSQUEDA</h2>
  </center>
  <TABLE align="center" cellpading="1" cellspacing="1" bgcolor="#FF9900" >     
   <form name="form2" method="POST" action="UserBuscado.php" >
     <TR><TD>CAMPOS</TD><TD></TD><TD>Empiece</TD><TD>Contenga</TD> 
	 
        <TR><TD>Nombre :</TD><TD><INPUT TYPE="text" NAME="nombre"   VALUE=""  SIZE="20" MAXLENGTH="30"></TD>
			<TD><center><INPUT TYPE="radio" name="tiponom" value="E"></TD>
			<TD><center><INPUT TYPE="radio" name="tiponom" value="C"></TD></TR>
			
		<TR><TD>Apellido :</TD><TD><INPUT TYPE="text" NAME="apellido" VALUE=""  SIZE="20" MAXLENGTH="30"></TD>
			<TD><center>  <INPUT TYPE="radio" name="tipoapell" value="E"></TD>
			<TD><center>  <INPUT TYPE="radio" name="tipoapell" value="C"></TD></TR>
				
  		<TD>Departamento :</TD><TD><select name="city"  value="" size="1" >
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
							</select></td></tr>						
                  						
  		<TD>Perfil :</TD><TD><select name="perfil"  value="" SIZE="1">
												<option value="" selected="selected">sin seleccionar</option>
  							  					<option value="A">ADMINISTRADOR</option>
							 					<option value="C">CLIENTE      </option>
							  					<option value="P">PROMOTOR     </option>
					     	 			</select></TD>
			
		<tr><td><input type="submit" name="seek" id="seek" value="BUSCAR"></td><TD><input type="reset" value="LIMPIAR"></td></tr>																	 	</form>		
 </TABLE>

 
 </body>
</html>



