<?php 
include("../../dominio/Persistencia.php");
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}
session_register('ses_sql');

  $Vraz=$_POST['txtraz'];       //razon social
  $Vrut=$_POST['numrut'];       //direccion
  $Vcity=$_POST['txtcity'];     //departamento
  $Vtipmov=$_POST['txttipmov'];  //tipo de movimiento
  $Vfecini=$_POST['fecini'];   // fecha de inicio
  $Vfecfin=$_POST['fecfin'];
  if($Vfecini!=""){
	  $Vfecfin = date( "Y/n/j" );
  } 	  
      
  $sql="SELECT c.raz_cli , c.rut_cli , c.dep_cli , c.num_cli ,
  					f.fec_fac, f.num_cli , f.tip_fac , f.iva_fac , f.id_fac , f.num_fac, f.ser_fac, f.nul_fac 
						FROM cliente c , factura f WHERE 1=1 AND (c.num_cli = f.num_cli)";
 
  if($Vraz!=""){
		$sql.=" AND (c.raz_cli like '%$Vraz%')";
  }
  if($Vcity!=""){                                   
	$sql.=" AND (c.dep_cli like '$Vcity')"; 
  } 
  if($Vtipmov!=""){                                   
	$sql.=" AND (f.tip_fac like '$Vtipmov')"; 
  } 
  if($Vfecini!=""){                                 
  	$sql.=" AND (f.fec_fac >='$Vfecini')";
  }
  if($Vfecfin!=""){ 
    $sql.=" AND (f.fec_fac <='$Vfecfin')";        
  }
  $sql.=" ORDER BY f.id_fac ASC";	
  $_SESSION['ses_sql']=$sql;
  if($perfil=="A"){  header('location:../../dominio/facturas/SeekPag.php');     }
  if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagFacturaPdf.php');}
?>