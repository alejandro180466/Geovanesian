<?php
include_once("../../dominio/Persistencia.php");
include_once("../../dominio/facturas/FacturaClass.php");
include_once("../../dominio/facturas/FacturaLineaClass.php");
include_once("../../dominio/facturas/CarroVentaClass.php");
include_once("../../dominio/pedidos/PedidoClass.php");
if(!isset($_SESSION)){     session_start(); }
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0];               // perfil
$codusr=$perfiles[1];               // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
	//header("location:../../index.php");	exit();
}
$modo=$_POST['modo'];
$idfac=$_POST['id'];
   if ($modo=="1"){
	   $idfac=0;
	   $idped=$_SESSION['ses_pedido'];
	   $serfac="A";
	   $numfac=0;
	   $fecfac= date("Y/m/d"); 
	   $numcli=$_POST['numcli'];
	   $tipfac=$_POST['txttipdoc'];
	   $nulfac="N";
	   $subfac=$_POST['numsub'];
	   $ivafac=$_POST['numivaS'];
	   $totfac=$subfac+$ivafac;
	   $plafac=1;
	   $sucursal=$_POST['sucursal'];
	   //---------------
	   $fecpedido="";
	   $fecentrega="";
	   $estado="";
	   $memo=" ";
	   $tippedido=" ";
   }
   if($modo=="3"){   // eliminar factura
   	   $idped=0;//$_SESSION['ses_pedido'];
	   $serfac="";
	   $numfac=0;
	   $fecfac="";// date("Y/m/d"); 
	   $numcli=""; //$_POST['numcli'];
	   $tipfac="";//$_POST['txttipdoc'];
	   $nulfac="N";
	   $subfac="";//$_POST['numsub'];
	   $ivafac="";//$_POST['numivaS'];
	   $totfac=0; //$subfac+$ivafac;
	   $plafac=0;
	   $memo="";
	   $sucursal="";
   }
   if($modo=="5" ){ ///PARA INGRESO MANUAL
   	   $idfac=0;
	   $idped=0;
	   $serfac=$_POST['numser'];
	   $numfac=$_POST['numfac'];
	   $fecfac=$_POST['fecfac']; 
	   $numcli=$_POST['numcli'];
	   $tipfac=$_POST['txttipdoc'];
	   $nulfac="N";
	   $subfac=$_POST['numsub'];
	   $ivafac=$_POST['numiva'];
	   $totfac=$subfac+$ivafac;
	   $plafac=1;
	   $memo=" ";
	   $sucursal="";
   }
   $fac=new Factura($idfac,$idped,$serfac,$numfac,$fecfac,$numcli,$tipfac,$nulfac,$subfac,$ivafac,$totfac,$plafac,$memo,$sucursal);
   if($modo!="6"){
	   if($modo!=5){
 	      $idfac=$fac->getidfac();	 //consulta la id de la nueva factura	
		  $ped=new Pedido($idped ,$numcli ,$fecpedido ,$fecentrega ,$estado ,$memo ,$fecfac, $tippedido);
	   }
	   if($modo=="5"){
	      $fac->setidfac(siguienteID("contadores","id_fac"));
		  $fac->FacturaAdd();
		  echo "<script>window.location='../../interface/facturas/FacturaIndex.php';</script>";
	   }	  
    }	   
//---------------------------------------------------------------					
   if($modo=="1"){  //ALTA
   		if(($ped->getestado())!="FACTURADO"){
			$existe=FacturaExiste($numfac);
			if($existe==0){	
				$fac->FacturaAdd();           // alta de encabezado de factura
				$ped->PedidoEst("FACTURADO"); // cambia el estado a FACTURADO al pedido
				$_SESSION['ses_carroventa']->guardarCarritof();
			}else{
				$_SESSION['ses_error']="YA HAY UN DOCUMENTO EMITIDO CON ESTE NUMERO";
			}	
		}else{
			$_SESSION['ses_error']="EL PEDIDO YA FUE FACTURADO";
		}
	}
	if($modo=="2"){ //MODI
		$fac->FacturaNull();
		//echo "<script>window.location='../../dominio/facturas/SeekPag.php';</script>";	
		echo "<script>history.go(-1);</script>";
		exit();
	}
	if($modo=="3"){  //BAJA
		$fac->FacturaDel();	
		//echo "<script>window.location='../../dominio/facturas/SeekPag.php';</script>";
		echo "<script>history.go(-1);</script>";
		exit();
	}
	
	if ($modo=="6"){  // SETEA EL NUMERO DE FACTURA
	    $nuevo=$_POST['numfac'];
		cambiarID("contadores","id_numfac",$nuevo);//permite asignar nuevo id a la tabla
		echo "<script>window.location='../../interface/facturas/FacturaIndex.php';</script>";
    }
?>