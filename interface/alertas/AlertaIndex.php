<?php include("../../interface/documentos/DocumentoIndex.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil!="A" || $codusr==""){
	header("location:../../index.php");	exit();
}
?>
<html>
  <body>
	<div id="menumov" > 
		 <H2><CENTER>MANTENIMIENTO DE ALERTAS</CENTER></H2>
		<a href="../../interface/alertas/AlertaForm.php?modo=1"  title="INGRESAR ALERTA" >
									<img src='../../iconos/document_add_81.png' border="0"/> INGRESAR</a>
		
		<a href="../../interface/alertas/AlertaSeek.php" title="BUSCAR ALERTA">
									<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
		<a href="../../dominio/alertas/AlertaControl.php" title="BUSCAR ALERTA">
									<img src='../../iconos/alert_81.png' border="0"/>ALERTAS</a>							
	</div>							
 </body>
</html>