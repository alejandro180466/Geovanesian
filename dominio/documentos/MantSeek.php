<?php 
include("../../dominio/Persistencia.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}

$Vnum=$_POST['numcli'];
$Vrut=$_POST['numrut'];       
$Vfecini=$_POST['fecini'];   // fecha de inicio
$Vfecfin=$_POST['fecfin'];   // fecha de finalizado
  
    $sqlFT="SELECT c.raz_cli , c.rut_cli , c.dep_cli , c.num_cli , c.raz_cli, c.tel_cli, c.fax_cli, c.mail_cli, c.dir_cli,
  					f.fec_fac, f.num_cli , f.tip_fac , f.iva_fac , f.id_fac , f.tot_fac , f.num_fac, f.nul_fac, f.ser_fac
					   	FROM cliente c , factura f 
				 	    	 WHERE 1=1 AND (c.num_cli = f.num_cli) 
									   AND (f.nul_fac = 'N')
							           AND (f.tip_fac !='NOTA REMITO') 
							           AND (f.tip_fac !='NOTA DE DEVOLUCION') ";
  							 
    $sqlRT="SELECT * FROM recibo WHERE 1=1  AND nul_recibo='N'";  
 						 
  if($Vnum!=""){
		$sqlFT.=" AND (c.num_cli = '$Vnum')";
		$sqlRT.=" AND (num_cli = '$Vnum')";
  }
  $sqlFT.=" ORDER BY f.fec_fac ASC";	
  $sqlRT.=" ORDER BY fec_recibo ASC";
    
  $_SESSION['ses_sqlFT']=$sqlFT;
  $_SESSION['ses_sqlRT']=$sqlRT;
  $_SESSION['ses_fecINI']=$Vfecini;
  $_SESSION['ses_fecFIN']=$Vfecfin;
  header('location:../../dominio/pdf/SeekPagEstadoCtaPdf.php');
  
 
?>