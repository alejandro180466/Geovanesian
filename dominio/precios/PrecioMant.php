<?php  include("../../dominio/Persistencia.php");
include("../../dominio/precios/PrecioClass.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0];               // perfil
$codusr=$perfiles[1];               // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
$modo=$_POST['modo'];
if($modo=="1" || $modo=="2" ){
   $idpre  = $_POST['id'];   	$valpre = $_POST['numval'];    $codmer = $_POST['nummer'];
   $numcli = $_POST['numcli'];  $fecpre = $_POST['fecpre'];	   $moneda = $_POST['txtmoneda']; 
}   
if($modo=="3" || $modo=="4" ){
	$idpre=$_POST['id'];	$valpre = $codmer = $numcli = $fecpre = $moneda ="";
}
$pre=new Precio($idpre,$valpre,$codmer,$numcli,$fecpre,$moneda);
      
   if($modo=="1"){  //ALTA
        if($pre->PrecioExiste($numcli,$codmer)==0){ //si no existe
			$pre->PrecioAdd();
		}
		header("location:../../index.php");//interface/precios/PrecioIndex.php");
	}
	if($modo=="2"){ //MODI
	    $pre->PrecioMod(); 
		echo "<script>history.go(-2);</script>";  exit();
	}
	if($modo=="3"){ //BAJA
		$pre->PrecioDel();
		header("location:".$_SERVER['HTTP_REFERER']);		
  	}
	if($modo=="4"){ //VISTA
		echo "<script>history.go(-2);</script>";  exit();
	}
?>