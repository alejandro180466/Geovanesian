<?php
include("../../dominio/Persistencia.php");
include("../../dominio/clientes/ClienteClass.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");		exit();
}
   $numcli=$_POST['numcli'];
   $razcli=$_POST['txtraz']; 
   $rutcli=$_POST['numrut']; 
   $dircli=$_POST['txtdir'];
   $depcli=$_POST['txtcity'];
   $telcli=$_POST['numfono'];
   $telcli2=$_POST['numfono2'];
   $faxcli=$_POST['numfax'];
   $celcli=$_POST['numcel'];
   $mailcli=$_POST['txtmail'];
   $contcli=$_POST['txtcont'];
   $entrega=$_POST['txtentrega'];
   $pago=$_POST['txtpago'];
   $comenta=$_POST['txtcomenta'];
   $fpago=$_POST['txtfpago'];
   $plazo=$_POST['numplazo'];
   
   $modo=$_POST['modo'];

   if($_POST['sucursal']==""){
		$sucursal = " ";
   }else{
		$sucursal = $_POST['sucursal'];
   } 		
     
   
   if($modo==3){
		$numcli=$_POST['id'];
   }
   $cli=new Cliente($numcli,$razcli,$rutcli,$dircli,$depcli,$telcli,$telcli2,$faxcli,$celcli,
					$mailcli,$contcli,$entrega,$pago,$comenta,$fpago,$plazo,$sucursal);
   if($rutcli=="X"){
   		$existe=0;
   }else{
   		$existe=$cli->ClienteExiste($rutcli);
   }		
   
   if($modo=="1"){  //ALTA
   		if($existe==0){
			$cli->ClienteAdd();
			if($cli->getsucursal()==1){
				$_SESSION['ses_numcli']=$cli->getnumcli();
				$_SESSION['ses_modo']=$modo;
				header("location:../../interface/sucursales/SucursalForm.php");
				exit();
			}
		}else{
			$_SESSION["ses_error"]="YA EXISTE ESTE USUARIO";
		}
		header("location:../../interface/clientes/ClienteIndex.php");
   	}
	if($modo=="2"){ //MODI
	   $cli->ClienteMod();
	   echo "<script>history.go(-2);</script>";
       exit;
	}
	if($modo=="3"){  //BAJA
		$cli->ClienteDel();	
		header("location:".$_SERVER['HTTP_REFERER']);	
	}
	if($modo=="4"){   //VISTA
	   echo "<script>history.go(-2);</script>";
       exit;
	}
?>