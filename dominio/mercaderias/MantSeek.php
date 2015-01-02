<?php
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

  $Vdes=$_POST['txtdes'];       
  $Vuni=$_POST['txtuni'];     
  $Vpeso=$_POST['numpeso'];    
  $Vcat=$_POST['txtcat'];    
      
  $sql="select cod_mer, des_mer, uni_mer, cat_mer, iva_mer, stock_mer, fecha_mer , min_mer ,peso_mer
  					 from mercaderia 
					 		where 1=1";
  $criterio="Criterio : ";							
  
  							
  if($Vdes!="" ){	$sql.=" and (des_mer like '$Vdes%')";  	$criterio.=" Producto :".$Vdes." ";   }
  if($Vuni!="" ){	$sql.=" and (uni_mer like '$Vuni%')";  	$criterio.=" Unidad : ".$Vuni." ";    } 
  if($Vpeso!=""){	$sql.=" and (peso_mer like '$Vpeso%')";	$criterio.=" Peso : ".$Vpeso." ";     }  
  if($Vcat!="" ){   $sql.=" and (cat_mer like '$Vcat')";   	$criterio.=" Categoria : ".$Vcat." "; } 

  $sql.=" order by des_mer asc";
  
  $criterio.=" ordenado por mercaderia";
  	
  $_SESSION['ses_sql']=$sql;
  $_SESSION['ses_sql']=$sql;
  if($perfil=="A"){  header('location:../../dominio/mercaderias/SeekPag.php');}
  if($perfil=="P" || $perfil=="C"){  header('location:../../dominio/pdf/SeekPagMerPdf.php');     }
?>