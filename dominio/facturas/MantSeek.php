<?php 
include("../../dominio/Persistencia.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
session_register('ses_sql');        //sql
session_register('ses_criterio');   //criterio de busqueda
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}

  $Vnum=$_POST['numdoc'];
  $Vraz=$_POST['txtraz'];       //razon social
 
  $Vrut=$_POST['numrut'];       //direccion
  $Vcity=$_POST['txtcity'];     //departamento
  $Vtipmov=$_POST['txttipmov'];  //tipo de movimiento
  $Vfecini=$_POST['fecini'];   // fecha de inicio
  $Vfecfin=$_POST['fecfin'];
      
  $sql="SELECT c.raz_cli , c.rut_cli , c.dep_cli , c.num_cli , 
  					f.fec_fac, f.num_cli , f.tip_fac , f.iva_fac , f.id_fac , f.tot_fac , f.num_fac, f.nul_fac, f.ser_fac	
				 	 FROM cliente c , factura f 
				 	     WHERE 1=1 AND (c.num_cli = f.num_cli)";
			
  $criterio="Criterio : ";			
						 
   if($Vnum!=""){
		$sql.=" AND (f.num_fac like '$Vnum')";
		$criterio.="Numero de documento: ".$Vnum." ";
  }
  if($Vraz!=""){
		$sql.=" AND (c.raz_cli like '%$Vraz%')";
		$criterio.="Razón social : ".$Vraz." ";
  }
  if($Vcity!=""){                                   
	$sql.=" AND (c.dep_cli like '$Vcity')";
    $criterio.="Departamento : ".$Vcity." ";  	
  } 
  if($Vtipmov!=""){                                   
	$sql.=" AND (f.tip_fac like '$Vtipmov')";
    $criterio.="Tipo de documento : ".$Vtipmov." ";	
  } 
  if($Vfecini!=""){                                 
  	$sql.=" AND (f.fec_fac >='$Vfecini')";
	$criterio.="desde: ".$Vfecini." ";
  }
  if($Vfecfin!=""){ 
    $sql.=" AND (f.fec_fac <='$Vfecfin')";
    $criterio.="hasta: ".$Vfecfin." "; 	
  }
  $sql.=" ORDER BY f.num_fac ASC";	
  
  $_SESSION['ses_sql']=$sql;
  $_SESSION['ses_criterio']=$criterio;

  if($perfil=="A"){  header('location:../../dominio/facturas/SeekPag.php');     }
  if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagFacturaPdf.php');}
?>
