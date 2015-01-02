<?php
include_once("../../dominio/carrito/CarritoClass.php");
include_once("../../dominio/Persistencia.php");
include_once("../../dominio/pedidos/PedidoClass.php");
include_once("../../dominio/facturas/CarroVentaClass.php");
include_once("../../dominio/facturas/FacturaClass.php");
include_once("../../dominio/facturas/FacturaLineaClass.php");
if(!isset($_SESSION)){     session_start(); }
$_SESSION["ses_error"]="";
$modo= $_POST['modo'];
// datos para facturalinea y pedidolinea
$cantidad = $_POST['numcant'];   //cantidad de unidades del articulo
$codmer   = $_POST['codmer'];    //id del articulo
$precio   = $_POST['numprec'];   //precio unitario
$descuento= $_POST['descuento'];
$iva= $_POST['iva'];             //iva del articulo de la linea de la factura
$idpedido=$_SESSION['ses_pedido'];
$cantlin=0;
if(isset($_POST['dircli'])){
	$_SESSION['ses_sucursal']=$_POST['dircli'];
}
$tipfac=$_POST['txttipdoc'];
if($tipfac!=""){	$_SESSION["ses_tipdoc"]=$tipfac;}
if(!isset($tipfac)) { $tipfac=""; }

$txtmemo=$_POST['txtmemo'];
if($txtmemo!=""){	$_SESSION["ses_memo"]=$txtmemo;}

$memo=$_POST['txtmemo'];

if ($modo==4){  //agrega una nueva linea a las lineas del carrito del pedido y de la factura 
	$descuento= $_POST['numdesc'];   //% de descuento en el articulo de la linea
	$link=Conecta();
	$sql="SELECT  id_pedido, num_cli   FROM pedido WHERE id_pedido=$idpedido";  
	$idcli  = ejecutarConsulta($sql,$link);
	$rowcli=mysql_fetch_array($idcli);
	$idcliente=$rowcli['num_cli'];
	
	$sql="SELECT m.cod_mer , m.des_mer, m.uni_mer , m.precio_mer, m.iva_mer , p.num_cli , p.cod_mer, p.val_pre
					FROM mercaderia m , precio p 
					  WHERE m.cod_mer=$codmer
					    AND p.cod_mer=m.cod_mer
						AND p.num_cli=$idcliente";
						
	$rs = ejecutarConsulta($sql,$link);
	$cantlin=mysql_num_rows($rs);
	Desconecta($link);
	if($cantlin<1 || $cantlin=""){
		$sql="SELECT m.cod_mer , m.des_mer, m.uni_mer , m.precio_mer, m.iva_mer 
					FROM mercaderia m  WHERE m.cod_mer=$codmer";
		$link=Conecta();			 
		$rs = ejecutarConsulta($sql,$link);
		$cantlin=mysql_num_rows($rs);
		Desconecta($link);
	}
	while($row = mysql_fetch_array($rs)){
		//---------------------------------nueva linea en el pedido
		$articulo = $row['des_mer'];
        $unidad = $row['uni_mer'];		
		$idlinea=siguienteID("contadores","id_pedidolinea");
		$linea= new Linea($idlinea,$idpedido,$articulo,$codmer,$cantidad); //ingresa la nueva linea en el pedido
		$_SESSION['ses_carro']->agregar($linea);
		//---------------------------------nueva linea en la factura
		$_SESSION['ses_error']=""; //QUITARRRRRRRRRRRRRRRRRR
		if($_SESSION["ses_error"]!="LA MERCADERIA SELECCIONADA YA SE INGRESO"){
			$idlin=siguienteID("contadores","id_faclinea");
			$idfac=$_SESSION['ses_idfac'];
			if($precio==0 || $precio==""){    $precio=$row['val_pre'];    }	  
			if($precio==0 || $precio==""){	  $precio=$row['precio_mer']; }
			if($tipfac=="NOTA REMITO" || $tipfac=="NOTA DE DEVOLUCION"){
				$precio=$descuento=$iva="";
			}
			$nuevalinea=new FacturaLinea( $idlin,$idfac,$codmer,$cantidad,$unidad,$articulo,$precio,$descuento,$iva,"N" );
			$nuevalinea->FacturaLineaAdd();
			//$_SESSION['ses_carroventa']->agregarf($nuevalinea);
		} 
	}
	echo "<script>window.location='../../interface/facturas/VerFactura.php';</script>";
}elseif($modo==42){                  //agrega una nueva linea libre en factura 
	$descuento= $_POST['numdesc'];   //% de descuento en el articulo de la linea
	//---------------------------------nueva linea en la factura
	$_SESSION['ses_error']=""; //QUITARRRRRRRRRRRRRRRRRR
	if($_SESSION["ses_error"]!="LA MERCADERIA SELECCIONADA YA SE INGRESO"){
		$idlin=siguienteID("contadores","id_faclinea");
		$idfac=$_SESSION['ses_idfac'];
		if($precio==0 || $precio==""){		    $precio=$row['val_pre'];	}
		if($precio==0 || $precio==""){			$precio=$row['precio_mer'];	}
		if($tipfac=="NOTA REMITO" || $tipfac=="NOTA DE DEVOLUCION"){
			$precio=$descuento=$iva="";
		}
		$codmer=0;
		$unidad="";
		$articulo=$_POST['txtarticulo'];    //id del articulo
		$nuevalinea=new FacturaLinea( $idlin,$idfac,$codmer,$cantidad,$unidad,$articulo,$precio,$descuento,$iva,"N" );
		$nuevalinea->FacturaLineaAdd();
	}
	echo "<script>window.location='../../interface/facturas/VerFactura.php?modo=9';</script>";
}elseif($modo==2){    //editar campos permitidos la linea seleccionada
	$descuento=$_POST['descuento'];
	$idfac=$_SESSION['ses_idfac'];
	$link=Conecta();
	$sql="UPDATE facturalinea SET des_lin='$descuento' WHERE id_fac='$idfac' AND cod_mer='$codmer'";
	$modifico = ejecutarConsulta($sql,$link);
	Desconecta($link);
	echo "<script>window.location='../../interface/facturas/VerFactura.php?modo=9';</script>";
	
}elseif($modo==8){    //editar campo cantidad de la linea seleccionada
	$idfac=$_SESSION['ses_idfac'];
	$link=Conecta();
    $sql="UPDATE facturalinea SET cant_lin='$cantidad' WHERE id_fac='$idfac' AND cod_mer='$codmer'";
	$modifico = ejecutarConsulta($sql,$link);
	Desconecta($link);
	echo "<script>window.location='../../interface/facturas/VerFactura.php?modo=9';</script>";	

}elseif($modo==3){ // ELIMINAR LINEAS DEL PEDIDO Y DE LA FACTURA
	$link=Conecta();
	$sql="DELETE from pedidolinea WHERE cod_mer='$codmer' AND id_pedido='$idpedido'";
	$borro1= ejecutarConsulta($sql,$link); //1
	$_SESSION['ses_carro']->eliminar($codmer);
	$idfac=$_SESSION['ses_idfac'];
	$sql="DELETE FROM facturalinea WHERE cod_mer='$codmer' AND id_fac='$idfac'";
	$borro2= ejecutarConsulta($sql,$link); //2
	Desconecta($link);
	echo "<script>window.location='../../interface/facturas/VerFactura.php';</script>";
}elseif($modo==1){ //guardar carrito de pedido y factura
    $_SESSION['ses_carro']->guardarCarrito(); //-- guardar las lineas del pedido
	// ------------------------------------------- guardar la factura
	$idfac   =$_SESSION['ses_idfac'];
	$idped   =$_SESSION['ses_pedido'];	
	$serfac  ="A";
	$numfac  =actualID('contadores','id_numfac')+1;//siguienteID("contadores","id_numfac"); // el numero de factura se ingresa solo al imprimir 
	$fecfac  =date("Y/m/d");       //fecha de hoy
	$numcli  =$_POST['numcli'];    //id del cliente 
	$tipfac  =$_POST['txttipdoc']; //tipo de documento
	$memo=$_POST['txtmemo'];
	$plafac=$_POST['numplazo'];
	$nulfac ="N";
	//$subfac=           // $_SESSION['ses_subtotal'];
	$subfac=$_POST['numsub'];$ivafac=$_POST['numivaS'];	$totfac=($subfac + $ivafac);  
	//-----------------------
	$fecpedido="";	   $fecentrega="";	   $estado="";	   	   $tippedido=" ";
    $ped=new Pedido($idpedido ,$numcli ,$fecpedido ,$fecentrega ,$estado ,$memo ,$fecfac, $tippedido);
	//-----------------------
	if($tipfac=="NOTA REMITO" || $tipfac=="NOTA DE DEVOLUCION"){
		$totfac=""; $ivafac=""; $subfac="";
	}
	$totfac=redondea_sindecimal($totfac);
	$sucursal=$_SESSION['ses_sucursal'];
	$fac = new Factura($idfac,$idped,$serfac,$numfac,$fecfac,$numcli,$tipfac,$nulfac,$subfac,$ivafac,$totfac,$plafac,$memo,$sucursal);
	//-----------------------
	if(($ped->getestado())!="FACTURADO"){
	   	$fac->FacturaAdd();           // alta de encabezado de factura
		$ped->PedidoEst("FACTURADO"); // cambia el estado a FACTURADO al pedido
	}else{
		$_SESSION['ses_error']="EL PEDIDO YA FUE FACTURADO";
	}
	echo "<script>window.location='../../interface/facturas/VerFactura.php?modo=1';</script>";
}elseif($modo==5){       //VACIAR EL PEDIDO Y LA FACTURA MANTENIENDO EL CLIENTE
	$link=Conecta();
	$sql="DELETE from pedidolinea WHERE id_pedido=$idpedido";
	$borro= ejecutarConsulta($sql,$link);
	$idfac=$_SESSION['ses_idfac'];
	$sql="DELETE FROM facturalinea WHERE id_fac='$idfac'";
	$borro2= ejecutarConsulta($sql,$link); 
	Desconecta($link);
	session_unregister('ses_carro');
	session_unregister('ses_carroventa');
	session_unregister('ses_idfac');
	session_unregister('ses_sucursal');
	echo "<script>window.location='../../interface/facturas/VerFactura.php';</script>";
}elseif($modo==6){             //sale de la factura al pedido carrito temporalemnte
     echo "<script>window.location='../../interface/carrito/VerCarrito.php';</script>"; 
}elseif($modo==7){             //BORRA EL PEDIDO Y FACTURA DEFINITIVAMENTE
	$link=Conecta();
	$sql="DELETE from pedidolinea WHERE id_pedido=$idpedido"; //borra lineas del pedido
	$borro= ejecutarConsulta($sql,$link);
	$sql="DELETE from pedido WHERE id_pedido=$idpedido";      //borra pedido
	$borrol= ejecutarConsulta($sql,$link);
	$idfac=$_SESSION['ses_idfac'];
	$sql="DELETE from facturalinea WHERE id_fac=$idfac";      //borra lineas de la factura
	$borrol= ejecutarConsulta($sql,$link);
	$sql="DELETE from factura WHERE id_fac=$idfac";           //borra factura
	$borrol= ejecutarConsulta($sql,$link);
	Desconecta($link);
		unset ($_SESSION['ses_carro']); 
	unset ($_SESSION['ses_carroventa']);
	unset ($_SESSION['ses_idfac']); 
	unset ($_SESSION['ses_numfac']);
	unset ($_SESSION['ses_pedido']); 
	unset ($_SESSION['ses_sucursal']); 
    unset ($_SESSION['ses_tipdoc']);
	unset ($_SESSION['ses_memo']);
	unset ($_SESSION['ses_error']);
	unset ($_SESSION['ses_memo']);
	unset ($_SESSION['ses_tipdoc']);
	echo "<script>window.location='../../Index.php';</script>";
}elseif($modo==83){            //salir y borrar variables de sesion
	unset ($_SESSION['ses_carro']); 
	unset ($_SESSION['ses_carroventa']);
	unset ($_SESSION['ses_idfac']);
	unset ($_SESSION['ses_numfac']);
	unset ($_SESSION['ses_pedido']); 
	unset ($_SESSION['ses_sucursal']);
	unset ($_SESSION['ses_tipdoc']);
	unset ($_SESSION['ses_memo']);
	unset ($_SESSION['ses_error']);
	unset ($_SESSION['ses_memo']);
	unset ($_SESSION['ses_tipdoc']);
	//echo "ENTRO";
	echo "<script>window.location='../../Index.php';</script>";
}?>