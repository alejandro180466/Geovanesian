<?php
include("ForoClass.php");
include("ForoverClass.php");
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
	exit();
}
 $op=$_POST['op'];
 $codforo=$_POST['numcodigo'];
 $temforo=$_POST['txttema'];
 $estforo=$_POST['txtestado'];
 $fecforo=$_POST['fecinicio'];
 $Tematica=new ForoW($codforo,$temforo,$estforo,$fecforo);
 
     if($op==1){ //INGRESAR
	   
 	    $Tematica->ForoAdd();
     }
     if($op==2){ //MODIFICAR
        $Tematica->ForoMod();
     }
	if($op==3){ //eliminar
	    $Tematica->ForoDel();   //elimna foro
		
		$Particip=new ForoVer($idpart,$coduser,$fecpart,$timepart,$codforo,$opinforo);
		$Particip=$Particip->PartForoDel(2);  //elimina las participaciones en foro
    }
 header("location:../../interface/foros/ForoList.php");
?>

 
 




