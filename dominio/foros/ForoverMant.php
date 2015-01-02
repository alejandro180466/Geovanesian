<?php
include("../../dominio/foros/ForoverClass.php");
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
	exit();
}
 $op=$_POST['op'];
 $idpart=$_POST['numpart'];
 $coduser=$_POST['numuser'];
 $fecpart=$_POST['txtfecha'];
 $timepart=$_POST['txthora'];
 $codforo=$_POST['numforo'];
 $opinforo=$_POST['txtopinion'];
 
 $Comento=new ForoVer($idpart,$coduser,$fecpart,$timepart,$codforo,$opinforo);
     if($op==1){ //INGRESAR
 	    $Comento->PartForoAdd();
     }
     if($op==3){ //eliminar
   	    $Comento->PartForoDel(1);
     }
 header("location:../../interface/foros/ForoList.php");
?>