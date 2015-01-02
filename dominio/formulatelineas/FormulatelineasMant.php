<?php
include("../../dominio/Persistencia.php");
include("../../dominio/formulates/FormulateClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
$modo=$_POST['modo'];
$nummer=$_POST['nummer'];
$fecha=$_POST['fecini'];

$mer=new Formulate("",$nummer,"","",$fecha);
$existe=$mer->FormulateExiste($nummer); 
   if($modo=="1"){  //ALTA
   		if($existe==0){
			$mer->FormulateAdd();
			$_SESSION["ses_error"]="INGRESANDO NUEVA FORMULACION";
			header("location:../../interface/formulates/FormulateForm.php?modo=2");
		}else{
			$_SESSION["ses_error"]="YA EXISTE ESTE CODIGO";
			header("location:../../interface/formulates/FormulateIndex.php?modo=1");
			
		}
		//echo $_SESSION["ses_error"];
		
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