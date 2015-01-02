<?php
include("../../dominio/Persistencia.php");
include("../../dominio/movimientos/MovimientoClass.php");
if(!isset($_SESSION)){ 
    session_start(); 
}
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
   $codmov=$_POST['numcodmov'];
   $fecmov=$_POST['fecmov']; 
   $tipmov=$_POST['txttipmov']; 
   $nummov=$_POST['numdoc'];
   $numrut=$_POST['numrut']; // en realidad aca es num_pro de PROVEEDOR 
   $valmov=$_POST['nummonto'];
   $monmov=$_POST['txtmoneda'];
   $iva=$_POST['txtiva']; // valor en %
   $rubro=$_POST['txtrub']; 
   $modo=$_POST['modo'];
   
   if($modo==3){
		$codmov=$_POST['id'];
		$fecmov=$tipmov= $nummov= $numrut= $valmov= $monmov= $iva= $rubro= "";
   }
              
   $mov=new Movimient($codmov, $fecmov, $tipmov, $nummov, $numrut, $valmov, $monmov, $iva ,$rubro);
   if($modo!=1){
   	   $existe=1;     //$mov->MovimientoExiste();
   }else{
   	   $existe=0;	
   }
                 
   if($modo==1){  //ALTA
         if($existe==0){
		   	$mov->MovimientoAdd();
	     }else{
			
		 }
		 echo"<script>window.location='../../interface/movimientos/MovimientoForm.php?modo=1&id=0'</script>";
		 exit();
   }
   if($modo==2){ //MODI
   		$mov->MovimientoMod();
		echo "<script>history.go(-2);</script>";
        exit();
   }
   if($modo==3){  //BAJA
		$mov->MovimientoDel();
		echo "<script>history.go(-1);</script>";
		exit();
   }
   if($modo==4){
		echo "<script>history.go(-2);</script>";
        exit();
   }
?>