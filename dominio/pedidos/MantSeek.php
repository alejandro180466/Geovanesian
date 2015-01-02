<?php include("../../dominio/Persistencia.php");
session_start();
session_register('ses_sql');
session_register('ses_criterio');
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}

  $Vid=$_POST['numid'];
  $Vraz=$_POST['txtraz'];       // razon social
  //$Vnumcli=$_POST['numcli'];
  $Vest=$_POST['txtestado'];
  $Vfecini=$_POST['fecini'];    // fecha de inicio
  $Vfecfin=$_POST['fecfin'];    // fecha de fin
  
  $criterio="Criterio búsqueda : ";
  
  $sql="select c.num_cli , c.raz_cli , c.rut_cli , c.dir_cli , c.dep_cli , c.tel_cli ,
  				 p.id_pedido , p.num_cli , p.fec_pedido , p.est_pedido , p.mem_pedido , p.ent_pedido , p.fec_factura
				 	 from cliente c , pedido p
				 	     where 1=1 and (c.num_cli = p.num_cli)";
						 
  					 
  if($Vid!=""    ){	$sql.=" and (p.id_pedido like '$Vid')";    $criterio.="ID del pedido : ".$Vid." "; }
  if($Vraz!=""   ){	$sql.=" and (c.raz_cli like '$Vraz%')";    $criterio.="razón social : ".$Vraz." "; }
  if($Vest!=""   ){	$sql.=" and (p.est_pedido like '$Vest')";  $criterio.="estado : ".$Vest." ";       }
  if($Vfecini!=""){	$sql.=" and (p.fec_pedido >='$Vfecini')";  $criterio.="desde : ".$Vfecini." ";     }
  if($Vfecfin!=""){ $sql.=" and (p.fec_pedido <='$Vfecfin')";  $criterio.="hasta : ".$Vfecfin." ";     }
  
  $sql.=" order by p.id_pedido asc";	
  $_SESSION['ses_sql']=$sql;
  $_SESSION['ses_criterio']=$criterio;
  header('location:../../dominio/pedidos/SeekPag.php');
  if($perfil=="A"){  header('location:../../dominio/pedidos/SeekPag.php');}
  if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagPedPdf.php');     }
?>