<?php include("../../dominio/Persistencia.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}
session_register('ses_sql');
   
  $Vdes=$_POST['txtcodmer'];  //descripcion de mercaderia
  $Vfecini=$_POST['fecini'];  // fecha de inicio
  $Vfecfin=$_POST['fecfin'];  // fecha de fin
  $criterio=" Criterio :";     
  // busqueda en mercaderia y produccion con campo comun COD_MER    
  $sql="select m.cod_mer, m.des_mer, m.uni_mer, m.cat_mer, m.iva_mer, m.stock_mer, m.peso_mer,
  				 p.num_prod, p.fec_prod, p.can_prod, p.lot_prod , p.cod_mer, p.lot_esca
				 	 from mercaderia m , produccion p 
				 	     where 1=1 and (m.cod_mer = p.cod_mer)";
 
  
  if($Vdes!=""   ){	$sql.=" and (p.cod_mer like '$Vdes')";  	$criterio.=" Producto :".$Vdes." ";    }
  
  if($Vfecini!=""){	$sql.=" and (p.fec_prod >='$Vfecini')";  	$criterio.=" desde el : ".$Vfecini." ";}
   
  if($Vfecfin!=""){ $sql.=" and (p.fec_prod <='$Vfecfin')"; 	$criterio.=" hasta el : ".$Vfecfin." ";}
  	
  $sql.=" order by p.fec_prod asc";
  
  $criterio.=" ordenado por fecha.";	
  
  $_SESSION['ses_sql']=$sql;
  $_SESSION['ses_criterio']=$criterio;
  if($perfil=="A" || $perfil=="C"){  header('location:../../dominio/producciones/SeekPag.php');}
  if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagProdPdf.php');     }
?>