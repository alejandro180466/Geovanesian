<?php
include_once("../../dominio/Persistencia.php");
include_once("../../dominio/recibos/ReciboClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
   $modo=$_POST['modo'];
   $idrec=$_POST['id'];
   $nulrec="N";
   $_SESSION['ses_error']="";
   if ($modo=="1"){       //ALTA
   	   $idrec=0;
   }
   $fecrec = $_POST['fecrec'];
   $numrec = $_POST['numrec'];
   $numcli = $_POST['numcli'];
   $totrec = $_POST['numtotal'];
   $memorec= $_POST['txtmemo'];
   
   $rec=new Recibo($idrec,$numrec,$fecrec,$numcli,$totrec,$memorec,$nulrec);
//---------------------------------------------------------------					
    if($modo=="1"){        //ALTA
		$existe = $rec->ReciboExiste($numrec);
		if($existe==0){
		    $rec->ReciboAdd();
			$_SESSION['ses_error']="EL RECIBO ANTERIOR SE INGRESO CORRECTAMENTE";
			header("location:../../interface/recibos/ReciboForm.php?modo=1&id=0");
		}else{
			$_SESSION['ses_error']="EL RECIBO ANTERIOR YA EXISTE";
			header("location:../../interface/recibos/ReciboForm.php?modo=1&id=0");
		}	
	}
	if($modo=="2"){        //MODI
		$rec->ReciboMod();
		echo "<script>history.go(-2);</script>";   exit();
		
	}
	if($modo=="3"){        //BAJA
		$rec->ReciboDel();
		$_SESSION['ses_error']="EL RECIBO SELECCIONADO FUE BORRADO";
		header("location:".$_SERVER['HTTP_REFERER']);
	}
	if($modo=="6"){        //ANULA RECIBO
	    $rec->ReciboNul();
		$_SESSION['ses_error']="EL RECIBO SELECCIONADO FUE ANULADO";
		header("location:".$_SERVER['HTTP_REFERER']);
	}
?>