<?php include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
?>
<html>
  <body>
			
 </body>
</html>