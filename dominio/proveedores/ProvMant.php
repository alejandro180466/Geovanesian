<?php
include("../../dominio/Persistencia.php");
include("../../dominio/proveedores/ProveedorClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
$modo=$_POST['modo'];      //ACCION SOLICITADA

if($modo!="3"){
   $numpro=$_POST['numpro'];  //ID
   $razpro=$_POST['txtraz'];
   $nompro=$_POST['txtcom']; 
   $rutpro=$_POST['numrut']; 
   $dirpro=$_POST['txtdir'];
   $deppro=$_POST['txtcity'];
   $rubro=$_POST['txtrub'];
   $telpro=$_POST['numfono'];
   $faxpro=$_POST['numfax'];
   $celpro=$_POST['numcel'];
   $conpro=$_POST['txtcon'];
   $mailpro=$_POST['txtmail'];
   $bankpro=$_POST['txtbank'];
}
if($modo=="3"){
	$numpro=$_POST['id'];
	$razpro=$nompro=$rutpro=$dirpro=$deppro=$rubro=$telpro=$faxpro=$celpro=$conpro=$mailpro=$bankpro="";
}
  
$prov=new Proveedor($numpro,$razpro,$nompro,$rutpro,$dirpro,$deppro,$rubro,$telpro,$faxpro,$celpro,$conpro,$bankpro,$mailpro);
   
  if($rutpro=="X"){
   		$existe=0;
   }else{
   		$existe=$prov->ProveedorExiste($rutpro);
   }	
      
   if($modo=="1"){  //ALTA
   		if($existe==0){
		
		    $prov->ProveedorAdd();
		}else{
			$_SESSION["ses_error"]="YA EXISTE ESTE USUARIO";
		}
		header("location:../../interface/proveedores/ProvIndex.php");
   	}
	if($modo=="2"){ //MODI
		$prov->ProveedorMod();	
		echo "<script>history.go(-2);</script>";        exit();		
	}
	if($modo=="3"){  //BAJA
		$prov->ProveedorDel();	
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	if($modo=="4"){   //VISTA
		echo "<script>history.go(-2);</script>";        exit();	
	}
?>