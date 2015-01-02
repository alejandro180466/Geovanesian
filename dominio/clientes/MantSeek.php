<?php include("../../dominio/Persistencia.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
//session_register('ses_sql');
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php"); exit();
}

  $Vnum=$_POST['numcli']; 
  $Vraz=$_POST['txtraz'];         //razon social
  $Vrut=$_POST['numrut'];        //rut proveedor
  $Vdir=$_POST['txtdir'];       //direccion
  $Vcity=$_POST['txtcity'];    //departamento
  $criterio="Criterio : ";    
  $sql="SELECT num_cli, raz_cli, rut_cli, dir_cli, dep_cli, tel_cli, fax_cli, cel_cli, mail_cli, cont_cli, ent_cli
				 	 FROM cliente WHERE 1=1 ";
  					 
  if($Vnum!="" ){ $sql.=" AND (num_cli like '$Vnum')" ;  $criterio.=" cliente : ".$Vnum." ";       }
  if($Vraz!="" ){ $sql.=" AND (raz_cli like '$Vraz%')";  $criterio.=" razon social : ".$Vraz." ";  }
  if($Vrut!="" ){ $sql.=" AND (rut_cli like '$Vrut%')";  $criterio.=" rut : ".$Vrut." ";           } 
  if($Vdir!="" ){ $sql.=" AND (dir_cli like '$Vdir%')";  $criterio.=" direccion : ".$Vdir." ";     }  
  if($Vcity!=""){ $sql.=" AND (dep_cli = '$Vcity')";     $criterio=" departamento : ".$Vcity." ";  } 

  $sql.=" ORDER BY raz_cli ASC";	
$_SESSION['ses_sql']=$sql;
$_SESSION['ses_criterio']=$criterio;
header('location:../../dominio/clientes/SeekPag.php');
if($perfil=="A"){  header('location:../../dominio/clientes/SeekPag.php');}
if($perfil=="P"){  header('location:../../dominio/pdf/SeekPagCliPdf.php');     }

?>