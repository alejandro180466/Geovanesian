<?php include("../../dominio/Persistencia.php");
session_start();
session_register('ses_sql');
  $Vcli=$_POST['nummcli']; 
  $Vdes=$_POST['txtcodmer'];  //descripcion de mercaderia
  $Vfecini=$_POST['fecini'];  // fecha de inicio
  $Vfecfin=$_POST['fecfin'];  // fecha de fin
       
  // busqueda en mercaderia , facturalinea y factura    
  $sql="select m.cod_mer, m.des_mer, m.uni_mer, m.cat_mer, m.iva_mer, m.stock_mer, m.peso_mer,
  				 f.id_faclinea, f.id_fac, f.cod_mer, f.cant_lin, f.uni_lin ,f.des_lin ,
					d.id_fac, d.fec_fac, d.ser_fac, d.num_fac , d.num_cli ,d.tip_fac, d.nul_fac
				 	 FROM mercaderia m , facturalinea f , factura d
				 	     WHERE 1=1 AND (m.cod_mer = f.cod_mer)
								   AND (f.id_fac = d.id_fac)
								   AND (d.nul_fac LIKE 'N')
								   AND (d.tip_fac NOT LIKE 'NOTA REMITO')
								   AND (d.tip_fac NOT LIKE 'NOTA DE DEVOLUCION')";
  $criterio="Criterio : ";
 
  if($Vdes!=""   ){	$sql.=" and (f.cod_mer like '$Vdes')"; $criterio.="codigo mercaderia : ".$Vdes ; }
  if($Vfecini!=""){	$sql.=" and (d.fec_fac >='$Vfecini')"; $criterio.=" desde ".$Vfecini;            }
  if($Vfecfin!=""){ 
	$sql.=" and (d.fec_fac <='$Vfecfin')";
	
	$criterio.=" hasta ".$Vfecfin;
  }else{
	$criterio.=" hasta ".date("d/m/Y");
  }
  $sql.=" ORDER BY d.num_fac ASC";
  $criterio.=" ordenado por factura.";
 	
  $_SESSION['ses_criterio']=$criterio;	
  $_SESSION['ses_sql']=$sql;
header('location:../../dominio/ventas/SeekPag.php');
?>