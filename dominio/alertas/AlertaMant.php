<?php	include_once("../../dominio/Persistencia.php");
include_once("../../dominio/alertas/AlertaClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; 				// perfil
$codusr=$perfiles[1];				// carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
   $modo=$_POST['modo'];
   if ($modo=="1"){     			//ALTA
   	   $id=0;
	   $hoy=date("Y/m/d");
   }else{
	   $id=$_POST['id'];
	   $hoy=$_POST['fechoy'];
   }
   $concepto= $_POST['txtconcepto'];
   $detalle = $_POST['txtdet'];
   $vence = $_POST['fecvence'];
   $previo = $_POST['numprevio'];
   $estado=$_POST['txtestado'];
   $memo= $_POST['txtmemo'];
   $aler=new Alerta($id,$concepto,$detalle,$hoy,$vence,$previo,$estado,$memo);
//---------------------------------------------------------------					
    if($modo=="1"){        //ALTA
		$aler->AlertaAdd();
		
	}
	if($modo=="2"){        //MODI
		$aler->AlertaMod();	
		
	}
	if($modo=="3"){        //BAJA
		$aler->AlertaDel();	
		
	}
	header("location:../../interface/alertas/AlertaIndex.php");
?>