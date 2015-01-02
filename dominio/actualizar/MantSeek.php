<?php 
include("../../dominio/Persistencia.php");
session_start();
session_register('ses_sql');
  $Vnumcli=$_POST['numcli'];    // id del cliente
  $Vdes=$_POST['nummer'];       // id de la mercaderia
  $Vcatmer=$_POST['txtcatmer']; //categoria de la mercaderia 
  $Vfecini=$_POST['fecini'];    // fecha de inicio
  $Vfecfin=$_POST['fecfin'];    // fecha de fin
  
  if($Vfecini!="" && $Vfecfin==""){
	  $Vfecfin = date( "Y/n/j" );
  } 	  
  $sql="SELECT c.num_cli , c.raz_cli, 
  				    m.cod_mer , m.des_mer, m.cat_mer,
				        a.id_update, a.num_cli, a.cat_mer , a.nom_user, a.porcent_update,
					        a.uni_update, a.cat_update, a.cod_mer, a.fecha_update
							 	FROM cliente c , mercaderia m, actualiza a
				 	                WHERE 1=1 
						                AND (c.num_cli = a.num_cli)
											AND (a.cod_mer = m.cod_mer)";
 
  if($Vnumcli!=""){	$sql.=" AND (a.num_cli ='$Vnumcli')";       }
  if($Vdes!="")   {	$sql.=" AND (a.cod_mer ='$Vdes')";          }
  if($Vcatmer!=""){ $sql.=" AND (m.cat_mer ='$Vcatmer')";       }
  if($Vfecini!=""){	$sql.=" AND (a.fecha_update >='$Vfecini')"; }
  if($Vfecfin!=""){ $sql.=" AND (a.fecha_update <='$Vfecfin')"; }
  $sql.=" ORDER BY a.id_update ASC";	
  $_SESSION['ses_sql']=$sql;
    
  header('location:../../dominio/actualizar/SeekPag.php');
?>