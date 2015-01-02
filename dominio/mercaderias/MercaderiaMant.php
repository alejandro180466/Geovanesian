<?php
include("../../dominio/Persistencia.php");
include("../../dominio/mercaderias/MercaderiaClass.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
$modo=$_POST['modo'];
if($modo!=3){ 
   $nummer=$_POST['numcod'];
   $desmer=$_POST['txtdes']; 
   $unimer=$_POST['txtuni'];   ///codigo del proveedor
   $catmer="";
   $ivamer=$_POST['numiva'];
   $stockmer=$_POST['numstock'];
   $fecha=$_POST['fecstock'];
   $minimo=$_POST['nummin'];
   $pesomer=$_POST['numpeso'];
   $precio=$_POST['numprecio'];     	
}
if($modo==3){
	$numer=$_POST['id'];
	$desmer=$unimer=$catmer=$ivamer=$stockmer=$fecha=$minimo=$pesomer=$precio="";
}   
 
$mer=new Mercaderia($nummer,$desmer,$unimer,$catmer,$ivamer,$stockmer,$fecha,$minimo,$pesomer,$precio);
$existe=$mer->MercaderiaExiste($nummer); 
   if($modo=="1"){  //ALTA
   		if($existe==0){
			$mer->MercaderiaAdd();
		}else{
			$_SESSION["ses_error"]="YA EXISTE ESTE CODIGO";
		}
		header("location:../../interface/mercaderias/MercaderiaIndex.php");
   	}
	if($modo=="2"){ //MODI
		$mer->MercaderiaMod();
		echo "<script>history.go(-2);</script>";
		exit();		
	}
	if($modo=="3"){ //BAJA
		$mer->MercaderiaDel();	
		header("location:".$_SERVER['HTTP_REFERER']);	
  	}
	if($modo=="4"){ //VISTA
		echo "<script>history.go(-2);</script>";
        exit();	
	}
?>