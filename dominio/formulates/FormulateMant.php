<?php
include("../../dominio/Persistencia.php");
include("../../dominio/formulates/FormulateClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}


$modo=$_POST['modo'];

if($modo==1 ||$modo==2 ){
	$nummer=$_POST['nummer'];
	$fecha=$_POST['fecini'];
	$numins=$_POST['numins'];
	$numcant=$_POST['numcant'];
	$mer=new Formulate("",$nummer,$numins,$numcant,$fecha);
	$existe=$mer->FormulateExiste($nummer); 
}else{	
	$id=$_POST['id'];
	$mer=new Formulate($id,"","","","");
}	

   if($modo=="1"){  //ALTA
   		$mer->FormulateAdd();
		$_SESSION["ses_error"]="INGRESADO NUEVA FORMULACION";
		header("location:../../interface/formulates/FormulateForm.php?modo=1");
		
   	}
	if($modo=="2"){ //MODI
		$mer->FormulateMod();
		echo "<script>history.go(-2);</script>";        exit();		
	}
	if($modo=="3"){ //BAJA
		$mer->FormulateDel();	
		header("location:".$_SERVER['HTTP_REFERER']);	
  	}
	if($modo=="4"){ //VISTA
		echo "<script>history.go(-2);</script>";        exit();	
	}
?>