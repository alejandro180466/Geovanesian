<?php 
include("../../dominio/Persistencia.php");
session_start();
session_register('ses_sql');
session_register('ses_criterio');
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){  	header("location:../../index.php"); exit();}

  $Vnum=$_POST['numdoc'];
  $Vraz=$_POST['txtraz'];       //razon social
 
  $Vrut=$_POST['numrut'];       //direccion
  $Vcity=$_POST['txtcity'];     //departamento
  $Vtipmov=$_POST['txttipmov'];  //tipo de movimiento
  $Vfecini=$_POST['fecini'];   // fecha de inicio
  $Vfecfin=$_POST['fecfin'];
  $Vorden=$_POST['rutina'];
      
  $sql="SELECT c.raz_cli , c.rut_cli , c.dep_cli , c.num_cli , c.tel_cli ,
  					r.fec_recibo, r.num_cli , r.id_recibo , r.tot_recibo , r.num_recibo ,r.fec_recibo, r.nul_recibo
					  FROM cliente c , recibo r 
				 	     WHERE 1=1 AND (c.num_cli = r.num_cli)";
  $criterio="Criterio : ";						 
   if($Vnum!=""){
		$sql.=" AND (r.num_recibo like '$Vnum')";
		$criterio.="Número : ".$Vnum." ";
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
    $criterio.="Documento tipo : ".$Vtipmov." ";	
  } 
  if($Vfecini!=""){                                 
  	$sql.=" AND (r.fec_recibo >='$Vfecini')";
	$criterio.="Desde : ".$Vfecini." ";
  }
  if($Vfecfin!=""){ 
    $sql.=" AND (r.fec_recibo <='$Vfecfin')";        
	$criterio.="Hasta : ".$Vfecfin." ";
  }
  if($Vorden==1){ 
    $sql.=" ORDER BY r.fec_recibo + r.num_recibo ASC"; 
	$criterio.=" ordenado por fecha";	
  }
  if($Vorden==2){ 
    $sql.=" ORDER BY r.num_recibo  ASC";
	$criterio.=" ordenado por numero";
  }
  
  $_SESSION['ses_sql']=$sql;
  
  $_SESSION['ses_criterio']=$criterio;
  if($perfil=="A"){  header('location:../../dominio/recibos/SeekPag.php');}
  if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagRecibosPdf.php');     }
?>