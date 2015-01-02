<?php
include("../../dominio/usuarios/UserClass.php");
session_start();                    // en todo lugar que se necesite
if($_POST['modo']!=1){
	$perfiles=$_SESSION["ses_perfil"];    //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
	$perfil=$perfiles[0]; // perfil
	$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
	if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
	}
}
   $codigo=$_POST['numcodigo'];
   $nombre=$_POST['txtnombre']; 
   $apellido=$_POST['txtapellido']; 
   $direc=$_POST['txtdirec'];  
   $fono=$_POST['numfono'];
   $email=$_POST['txtemail'];
   $city=$_POST['txtcity'];
   $fnac=$_POST['txtfnac'];
   $pass=$_POST['txtpass1'];
   $perfil=$_POST['txtperfil'];
   	
   $modo=$_POST['modo'];
   $usu=new Usuario($codigo,$nombre,$apellido,$direc,$fono,$email,$city,$fnac,$pass,$perfil);
   $existe=$usu->existeUsuario($codigo); 
   if($modo=="1"){  //ALTA
   		if($existe==0){
			$usu->UserAdd();
			header("location:../../dominio/usuarios/UserCheck.php?txtnombre=$nombre&txtpassword=$pass");
			exit();
		}else{
			$_SESSION["ses_error"]="YA EXISTE ESTE USUARIO";
		}
   	}
	if($modo=="2"){ //MODI
		$usu->UserMod();			
	}
	if($modo=="3"){  //BAJA
		$usu->UserDel();			
	}
	header("location:../../interface/usuarios/UserIndex.php");
?> 