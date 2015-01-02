<?php include("../../dominio/Persistencia.php");
session_start();
$Vcod=$_POST['txtins'];      // id
$Vrubro=$_POST['txtrub'];    // rubro
$Vfecini=$_POST['fecini'];   // fecha de inicio
$Vfecfin=$_POST['fecfin'];   // fecha de fin
$Vtipo =$_POST['txttip'];    // tipo
   
$sql="SELECT s.id_stock, s.id_insumo, s.cant_stock, s.fec_stock, s.tip_stock, s.num_pro,
  				i.id_insumo, i.des_insumo, i.uni_insumo, i.cat_insumo
				 	 FROM stock s , insumo i 
				 	     WHERE 1=1 AND (s.id_insumo = i.id_insumo)";
							
$criterio=" Criterio : ";
  
if($Vcod!=""   ){	$sql.=" AND (s.id_insumo like '$Vcod')"   ;	$criterio.=" id: ".$Vcod." ";       }
if($Vrubro!="" ){	$sql.=" AND (i.cat_insumo like '$Vrubro')";	$criterio.=" Categoria: ".$Vrubro." " ; }
if($Vtipo!="")  { $sql.=" AND (s.tip_stock like '$Vtipo')"  ; $criterio.=" Tipo: ".$Vtipo." ";    } 
if($Vfecini!=""){	$sql.=" AND (s.fec_stock >='$Vfecini')"   ; $criterio.=" desde : ".$Vfecini." ";}
if($Vfecfin!=""){ $sql.=" AND (s.fec_stock <='$Vfecfin')"   ;	$criterio.=" hasta : ".$Vfecfin." ";}
 
$sql.=" ORDER BY s.fec_stock ASC , ";	
$_SESSION['ses_sql']=$sql;       // guardo en varialble de sesion
$_SESSION['ses_criterio']=$criterio;
header('location:../../dominio/entradas/SeekPag.php');
?>