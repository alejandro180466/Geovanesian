<?php
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valor de perfil que vienen de UserLogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0];              // carga en variable el perfil del usuario
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
	exit();
}

$tipo=$_POST['tipo'];

$txtdirsit=$_POST['txtdirsit'];        
$txtdircli=$_POST['txtdircli'];
$txttitulo=$_POST['txttitulo'];
$txtmensaje=$_POST['txtmensaje'];

if($txtdircli!=""){
   if($tipo=="plano"){
		mail($txtdircli,$txttitulo,$txtmensaje,$txtdirsit);
   }else{
 		mail($txtdircli,'<html><head><title>$txttitulo</title></head><body><h1>$txtmensaje</h1></body></html>content-type:text/html\N',$txtdirsit);  				
   }
}
header("location:../../index.php");
exit(); 	
?>