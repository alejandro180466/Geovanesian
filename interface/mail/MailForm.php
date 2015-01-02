<?php
include("../../estilos/Estilo_page.php");
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valor de perfil que vienen de UserLogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0];              // carga en variable el perfil del usuario
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
	exit();
}
?>  
<html>
 <body>
  <br>
    <form action="../../dominio/mail/email.php" method="POST">
		<table bgcolor="#FFFFFF" align="center" width="50%" border="0">
			<TR><td>MAIL DEL SITIO:</td>
			    <td><input type="text" name="txtdirsit" id="txtdirsit" value="info@bondulce.com" size="40" disabled="DISABLED"></td></tr>
				
			<tr><td>MAIL USUARIO:</td>
			    <td><input type="text" name="txtdircli" id="txtdircli" value="" size="40" ></td></tr>
			
			<tr><td>FORMATO:</td>
			    <td><input type="radio" name="tipo" id="tipo" value="plano" checked>texto plano
		            <input type="radio" name="tipo" id="tipo" value="html" >Html</td></tr>
					
			<tr><td>TITULO:</td> 
			    <td><input type="text" name="txttitulo" id="txttitulo" value=""/></td></tr>
						
			<tr><td>MENSAJE:</td> 
			    <td><textarea rows=4 cols=50 name="txtmensaje"></textarea></td></tr>
				
			<tr><td><input type="submit" value="ENVIAR"></td></tr>
		</table>
	</form>
 
 </body>
</html>