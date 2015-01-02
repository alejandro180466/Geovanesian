<?php include("../../dominio/Persistencia.php");
session_start();
session_register('ses_sql');

  $Vdes=$_POST['txtdes'];       
  $Vcat=$_POST['txtrub'];    
      
  $sql="select i.id_insumo, i.des_insumo , i.det_insumo , i.cat_insumo , i.uni_insumo , i.stock_insumo , i.fecha_insumo , i.iva_insumo
					from insumo i 
						WHERE 1=1 ";
					 
  if($Vdes!=""){    $sql.=" and (des_insumo like '%$Vdes%')"; }
  if($Vcat!=""){  	$sql.=" and (cat_insumo like '$Vcat')";   } 

  $sql.=" order by des_insumo asc";	
  $_SESSION['ses_sql']=$sql;
header('location:../../dominio/insumos/SeekPag.php');
?>