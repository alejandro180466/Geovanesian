<?php 
include("../../dominio/Persistencia.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
//session_register('ses_sql');
//session_register('ses_criterio');

  $Vnumcli=$_POST['numcli'];       // razon social
  $Vdes=$_POST['nummer'];
  $Vmoneda=$_POST['txtmoneda'];
  $Vfecini=$_POST['fecini'];      // fecha de inicio
  $Vfecfin=$_POST['fecfin'];      // fecha de fin
  
  if($Vfecini!=""){
	  $Vfecfin = date( "Y/n/j" );
  } 	  
  $sql="select c.num_cli , c.raz_cli , c.tel_cli,
  				 p.id_pre , p.val_pre , p.cod_mer , p.num_cli , p.fec_pre, p.moneda_pre,
				   m.cod_mer , m.des_mer, m.cat_mer
				 	 FROM cliente c , precio p , mercaderia m
				 	     WHERE 1=1 
						 AND (c.num_cli = p.num_cli)
						 AND (p.cod_mer = m.cod_mer)";
  
  $criterio="Criterio : ";
  
  if($Vnumcli!=""){
		$sql.=" and (p.num_cli ='$Vnumcli')";
		$criterio.="Nº cliente : ".$Vnumcli." "; 
  }
  if($Vdes!=""){
		$sql.=" and (p.cod_mer ='$Vdes')";
		$criterio.="Articulo : ".$Vdes." ";
  }
  if($Vmoneda!=""){
		$sql.=" and (p.moneda_pre ='$Vmoneda')";
		$criterio.="Moneda : ".$Vmoneda." ";
  }
  if($Vfecini!=""){                                 
  	$sql.=" and (p.fec_pre >='$Vfecini')";
	$criterio.="Desde : ".$Vfecini." ";
  }
  if($Vfecfin!=""){ 
    $sql.=" and (p.fec_pre <='$Vfecfin')";        
	$criterio.="Hasta : ".$Vfecfin." ";
  }
  $sql.=" order by p.id_pre asc";
  $_SESSION['ses_criterio']=$criterio;   
  $_SESSION['ses_sql']=$sql;
  header('location:../../dominio/precios/SeekPag.php');
?>