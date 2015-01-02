<?php	include("../../dominio/Persistencia.php");
session_start();
$Vcity=$_POST['txtcity'];     //departamento
$Vfecini=$_POST['fecini'];   // fecha de inicio
$Vfecfin=$_POST['fecfin'];   // fecha fin
        
$sql="SELECT f.id_fac, f.ser_fac, f.num_fac, f.fec_fac, f.num_cli, f.tip_fac, f.nul_fac, f.sucursal_id,
  					c.num_cli, c.dep_cli,
							l.id_faclinea, l.id_fac, l.cod_mer, l.uni_mer, l.des_mer, l.uni_lin, l.cant_lin, l.des_lin,
							    m.cod_mer, m.des_mer, m.cat_mer
									FROM factura f , cliente c, facturalinea l, mercaderia m
											WHERE 1=1 AND (c.num_cli=f.num_cli) 
													AND (f.id_fac=l.id_fac)
													AND (l.cod_mer=m.cod_mer)
													AND (f.nul_fac LIKE 'N')
													AND (f.tip_fac NOT LIKE 'NOTA REMITO') 
													AND (f.tip_fac NOT LIKE 'NOTA DE DEVOLUCION')
													AND (m.cat_mer NOT LIKE 'ENVASES')";
													
$sql2="SELECT dep_suc, sucursal_id FROM sucursal WHERE dep_suc = ".$Vcity."  ORDER BY dep_suc ASC  ";					
$criterio="Criterio : ";								 
					
  if($Vcity!=""){                                   
	//$sql.=" AND (c.dep_cli like '$Vcity')"; 
	$criterio.="Departamento : ".$Vcity." ";
  } 
  if($Vfecini!=""){                                 
  	$sql.=" AND (f.fec_fac >='$Vfecini')";
	$criterio.="Desde : ".$Vfecini." ";
  }
  if($Vfecfin!=""){ 
    $sql.=" AND (f.fec_fac <='$Vfecfin')";
    $criterio.="Hasta : ".$Vfecfin." "; 	
  }
  $sql.=" ORDER BY f.ser_fac+f.num_fac ASC";
  $_SESSION['ses_city']=$Vcity;
  $_SESSION['ses_sql']=$sql;
  $_SESSION['ses_sql2']=$sql2;
  $_SESSION['ses_criterio']=$criterio;
  header('location:../../dominio/pdf/SeekPagBromatPdf.php');
?>