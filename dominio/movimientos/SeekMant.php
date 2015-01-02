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
//session_register('ses_sql');
  $Vcod=$_POST['numid'];
  $Vraz=$_POST['txtraz'];      //razon social
  $Vdir=$_POST['txtdir'];      //direccion
  $Vcity=$_POST['txtcity'];    //departamento
  $Vtipmov=$_POST['txttipmov'];//tipo de movimiento
  $Vrubro=$_POST['txtrub'];    //rubro
  $Vfecini=$_POST['fecini'];   // fecha de inicio
  $Vfecfin=$_POST['fecfin'];   // fecha de fin
  $Vrutina =$_POST['rutina'];  // rutina para estados de cuentas o compras
  $Vtipo=$_POST['tipo'];       // selecciona tipo de listado uno a uno o totales , saldos
   
  $sql="SELECT m.cod_mov, m.fec_mov, m.tip_mov, m.num_mov, m.rut_pro, m.val_mov, m.mon_mov, m.rub_mov, m.val_iva,
  				 p.num_pro, p.raz_pro, p.rut_pro, p.dir_pro, p.dep_pro, p.tel_pro, p.fax_pro, p.cel_pro, p.mail_pro, p.cat_insumo
				 	 FROM movimiento m , proveedor p 
				 	     WHERE 1=1 AND (m.rut_pro = p.num_pro)";
  $criterio=" Criterio : ";
						 
  if($Vcod!=""   ){	$sql.=" AND (m.cod_mov like '$Vcod')"   ;	$criterio.=" id: ".$Vcod." ";                 }
  if($Vraz!=""   ){	$sql.=" AND (p.raz_pro like '$Vraz')" ;	$criterio.=" Empresa: ".$Vraz." " ;           }
  if($Vdir!=""   ){	$sql.=" AND (p.dir_pro like '$Vdir%')"  ; 	$criterio.=" Dirección: ".$Vdir." ";          }  
  if($Vcity!=""  ){	$sql.=" AND (p.dep_pro like '$Vcity')"  ; 	$criterio.=" Departamento: ".$Vcity." ";      } 
  if($Vtipmov!=""){ $sql.=" AND (m.tip_mov like '$Vtipmov')"; 	$criterio.=" Tipo documento: ".$Vtipmov." ";  } 
  if($Vrubro!="" ){ $sql.=" AND (m.rub_mov like '$Vrubro')" ; 	$criterio.=" Rubro: ".$Vrubro." " ;           } 
  if($Vfecini!=""){	$sql.=" AND (m.fec_mov >='$Vfecini')"   ; 	$criterio.=" desde : ".$Vfecini." " ;         }
  if($Vfecfin!=""){ $sql.=" AND (m.fec_mov <='$Vfecfin')"   ; 	$criterio.=" hasta : ".$Vfecfin." " ;         }
  if($Vrutina==3 ){$sql.=" AND (m.tip_mov = 'recibo pago' )";                                                 }
  if($Vrutina==2){
	$sql.=" AND (m.tip_mov NOT LIKE 'recibo pago' ) 
		    AND (m.tip_mov NOT LIKE 'saldo inicial')
			AND (m.tip_mov NOT LIKE 'nota remito')";
  }
  if($Vtipo==1){
	$sql.=" ORDER BY m.fec_mov ASC";         // sentencias sql finales    
  }elseif($Vtipo==2){	
	//$sql.=" ORDER BY raz_pro ASC";
  } 	
  $sqlrubro= "SELECT * FROM proveedor WHERE cat_insumo ='$Vrubro' ORDER BY raz_pro ASC"  ;
  
  $_SESSION['ses_sql']=$sql;               // guardo en varialble de sesion
  $_SESSION['ses_criterio']=$criterio;
  $_SESSION['ses_rubro']=$sqlrubro;
  $_SESSION['ses_fecini']=$Vfecini;        // para cuando la fecha inicial no corresponde al primer documento
  
if($Vrutina==1 ){  
	if($Vtipo==1){
		if($perfil=="A"){  header('location:../../dominio/movimientos/SeekPag1.php');}
		if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagPdf1.php');     }
	}elseif($Vtipo==2){
		if($perfil=="A"){  header('location:../../dominio/movimientos/SeekPag1R.php');}
		if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagSaldosProveedoresPdf.php');  }

	}	
	
}elseif($Vrutina==2){
	if($Vtipo==1){
		if($perfil=="A"){  header('location:../../dominio/movimientos/SeekPag2.php');}
		if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagPdf2.php');     }
	}else{

	}
	
}elseif($Vrutina==3 ){
	if($Vtipo==1){
		if($perfil=="A"){  header('location:../../dominio/movimientos/SeekPag3.php');}
		if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagPdf3.php');     }
	}else{

	}
}	
?>