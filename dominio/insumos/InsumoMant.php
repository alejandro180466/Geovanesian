<?php	include("../../dominio/Persistencia.php");
include("../../dominio/insumos/InsumoClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
$modo=$_POST['modo'];
if($modo!=3){
   $idinsumo=$_POST['id'];
   $desinsumo=$_POST['txtdes'];
   $detinsumo=$_POST['txtdet'];
   $catinsumo=$_POST['txtcat'];
   $uniinsumo=$_POST['txtuni'];
   $stockinsumo=$_POST['numstock'];
   $fecstock=$_POST['fecstock'];
   $ivainsumo=$_POST['numiva'];
}
if($modo==3){
	$idinsumo=$_POST['id'];
	$desinsumo=$detinsumo=$catinsumo=$uniinsumo=$stockinsumo=$fecstock=$ivainsumo="";
}      
$ins=new Insumo($idinsumo,$desinsumo,$detinsumo,$catinsumo,$uniinsumo,$stockinsumo,$fecstock,$ivainsumo);
    
    if($modo=="1"){  //ALTA
   		$ins->InsumoAdd();
		header("location:../../interface/insumos/InsumoIndex.php");
   	}
	if($modo=="2"){ //MODI
		$ins->InsumoMod();	
		echo "<script>history.go(-2);</script>";        exit();		
	}
	if($modo=="3"){  //BAJA
		$ins->InsumoDel();	
		header("location:".$_SERVER['HTTP_REFERER']);		
  	}
	if($modo=="4"){   //VISTA
		echo "<script>history.go(-2);</script>";        exit();	
	}
?>