<?php	include("../../dominio/Persistencia.php");
include("../../dominio/sucursales/SucursalClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}	
    $idsuc  = "";
	$numcli = $_POST['numcli'];
	$nomsuc = $_POST['txtnom']; 
	$dirsuc = $_POST['txtdir'];
	$depsuc = $_POST['txtcity'];
	$telsuc = $_POST['numfono'];
	$contsuc= $_POST['txtcont'];
	$entsuc = $_POST['txtentrega'];
      
	$modo = $_POST['modo'];
          
	$suc = new Sucursal($idsuc,$numcli,$nomsuc,$dirsuc,$depsuc,$telsuc,$contsuc,$entsuc);
      
	if($modo=="1"){  //ALTA
		$suc->SucursalAdd();
	}
	if($modo=="2"){ //MODI
	   $suc->SucursalMod();			
	}
	if($modo=="3"){  //BAJA
		$suc->SucursalDel();			
	}
	if($modo=="4"){   //VISTA
		
	}
	header("location:../../interface/sucursales/SucursalForm.php");
?>