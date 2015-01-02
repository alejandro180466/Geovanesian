<?php include("../../dominio/Persistencia.php");
	$sql="mysqldump --opt bondulce_pentisol > copia_seguridad.sql";
	$link=Conecta();
	$res=ejecutarConsulta($sql,$link);
	Desconecta($link);
?>