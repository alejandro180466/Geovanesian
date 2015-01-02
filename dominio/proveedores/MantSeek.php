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
  $Vraz=$_POST['txtraz'];     //razon social
  $Vnom=$_POST['txtnom'];
  $Vrut=$_POST['numrut'];     //rut proveedor
  $Vdir=$_POST['txtdir'];     //direccion
  $Vcity=$_POST['txtcity'];   //departamento
  $Vrubro=$_POST['txtrub'];
      
  $sql="select p.num_pro, p.raz_pro, p.nom_pro, p.rut_pro, p.dir_pro, p.dep_pro, p.cat_insumo , p.tel_pro, p.fax_pro, p.cel_pro,
  				 p.mail_pro
				 	 from proveedor p  where 1=1 ";
  if($Vraz!=""  ){	$sql.=" and (p.raz_pro like '%$Vraz%')";    }
  if($Vnom!=""  ){	$sql.=" and (p.nom_pro like '%$Vnom%')";    }
  if($Vrut!=""  ){	$sql.=" and (p.rut_pro like '$Vrut%')";     } 
  if($Vdir!=""  ){	$sql.=" and (p.dir_pro like '%$Vdir%')";    }  
  if($Vcity!="" ){ 	$sql.=" and (p.dep_pro like '$Vcity')";     }
  if($Vrubro!=""){  $sql.=" and (p.cat_insumo like '$Vrubro%')";}

  $sql.=" order by p.raz_pro asc";	
  $_SESSION['ses_sql']=$sql;
if($perfil=="A"){  header('location:../../dominio/proveedores/SeekPag.php');}
if($perfil=="P"){  header('location:../../dominio/proveedores/SeekPag.php');}		//header('location:../../dominio/pdf/SeekPagProvPdf.php'); }   
?>