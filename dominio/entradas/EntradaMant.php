<?php	include("../../dominio/Persistencia.php");
include("../../dominio/entradas/EntradaClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
$modo=$_POST['modo'];
if($modo!=3){ 
   $id   = $_POST['id'];       //id stock
   $ins  = $_POST['txtins'];   //id insumo
   $cant = $_POST['numuni'];   //cantidad
   $fecha= $_POST['txtfecha']; //fecha
   $tipo = $_POST['txttip'];   //tipo 
   $prov = "";//$_POST[''];    //id proveedor
}
if($modo==3){
	$id=$_POST['id'];
	$ins=$cant=$fecha=$tipo=$prov="";
}   
$ent = new Entrada($id,$ins,$cant,$fecha,$tipo,$prov);
   if($modo=="1"){  //ALTA
   		$ent->EntradaAdd();
		$_SESSION["ses_error"]="ENTRADA INGRESADA";
		header("location:../../interface/entradas/EntradaForm.php?modo=1");
   	}
	if($modo=="2"){ //MODI
		$ent->EntradaMod();
		echo "<script>history.go(-2);</script>";        exit();		
	}
	if($modo=="3"){ //BAJA
		$ent->EntradaDel();	
		header("location:".$_SERVER['HTTP_REFERER']);	
  	}
	if($modo=="4"){ //VISTA
		echo "<script>history.go(-2);</script>";        exit();	
	}
?>