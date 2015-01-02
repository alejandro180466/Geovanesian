<?php include("../../dominio/Persistencia.php");
session_start();
session_register('ses_sql');
session_register('ses_criterio');

  $Vnum=$_POST['id'];
  $Vconcepto=$_POST['txtconcepto'];
  $Vestado=$_POST['txtestado']; 
  $Vfecini=$_POST['fecini'];   
  $Vfecfin=$_POST['fecfin'];
      
  $sql="SELECT * FROM alertas WHERE 1=1 ";
  $criterio="Criterio : ";
  
  if($Vnum!=""){
	$sql.=" AND (alerta_id like '$Vnum')";
	$criterio.="Número : ".$Vnum." ";
  }
  if($Vconcepto!=""){
	$sql.=" AND (concepto like '%$Vconcepto%')";
	$criterio.="Concepto : ".$Vconcepto." ";
  }
  if($Vestado!=""){                                   
	$sql.=" AND (estado like '$Vestado')"; 
	$criterio.="Estado : ".$Vestado." ";
  } 

  if($Vfecini!=""){                                 
  	$sql.=" AND (r.fec_recibo >='$Vfecini')";
	$criterio.="Desde : ".$Vfecini." ";
  }
  if($Vfecfin!=""){ 
    $sql.=" AND (r.fec_recibo <='$Vfecfin')";        
	$criterio.="Hasta : ".$Vfecfin." ";
  }
  $sql.=" ORDER BY vence ASC";	
  $_SESSION['ses_sql']=$sql;
  $_SESSION['ses_criterio']=$criterio;
  header('location:../../dominio/alertas/SeekPag.php');
?>