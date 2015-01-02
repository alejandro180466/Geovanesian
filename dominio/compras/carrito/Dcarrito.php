<?php
include_once("../../dominio/carrito/CarritoClass.php");
include_once("../../dominio/Persistencia.php"); 
session_start();
$_SESSION["ses_error"]="";
$modo=$_POST['modo'];
$codmer = $_POST['codmer'];     //id del articulo
$cantidad = $_POST['numcant'];   //cantidad de unidades del articulo
	
if ($modo==4){  //COMPRA  
	$link=Conecta();
	$sql="SELECT cod_mer , des_mer from mercaderia WHERE cod_mer like '$codmer'";
	$rs = ejecutarConsulta($sql,$link);
	Desconecta($link);
	while($row = mysql_fetch_array($rs)){
		$articulo = $row['des_mer'];     // descripcion del articulo 
		$idlinea=siguienteID("contadores","id_pedidolinea");
		$idpedido=$_SESSION['ses_pedido'];
				
		$linea= new Linea($idlinea,$idpedido,$articulo,$codmer,$cantidad);    //ingresa nueva line
		$_SESSION['ses_carro']->agregar($linea);
		echo "<script>window.location='../../interface/carrito/VerCarrito.php';</script>";
	}
}elseif($modo==3){ //eliminar solo la linea
	$link=Conecta();
	$idpedido=$_SESSION['ses_pedido'];
	$sql="DELETE from pedidolinea WHERE cod_mer='$codmer' AND id_pedido='$idpedido'";
	$borro= ejecutarConsulta($sql,$link);
	Desconecta($link);
    $_SESSION['ses_carro']->eliminar($codmer);
	echo "<script>window.location='../../interface/carrito/VerCarrito.php';</script>";
	
}elseif($modo==1){ //guardar

	$_SESSION['ses_carro']->guardarCarrito();
	session_unregister('ses_carro');
	session_unregister('ses_pedido');  // ver si anda
	echo "<script>window.location='../../interface/pedidos/PedidoIndex.php';</script>";
		
}elseif($modo==5){ //limpiar o vaciar el carrito manteniendo el cliente
	$link=Conecta();
	$idpedido=$_SESSION['ses_pedido'];
	$sql="DELETE from pedidolinea WHERE id_pedido=$idpedido";
	$borro= ejecutarConsulta($sql,$link);
	Desconecta($link);
	
    session_unregister('ses_carro');
	echo "<script>window.location='../../interface/carrito/VerCarrito.php';</script>";
	
}elseif($modo==6){ //sale del carrito temporalemnte
	echo "<script>window.location='../../index.php';</script>";
	
}elseif($modo==7){ //borra el pedido completamente
	$link=Conecta();
	$idpedido=$_SESSION['ses_pedido'];
	$sql="DELETE from pedidolinea WHERE id_pedido=$idpedido";
	$borro= ejecutarConsulta($sql,$link);
		
	$sql="DELETE from pedido WHERE id_pedido=$idpedido";
	$borrol= ejecutarConsulta($sql,$link);
	Desconecta($link);
	
    session_unregister('ses_carro');
	echo "<script>window.location='../../interface/pedidos/PedidoIndex.php';</script>";
	
}elseif($modo==8){ //guardar y vista del pedido a imprimir
	$_SESSION['ses_carro']->guardarCarrito();
	echo "<script>window.location='../../dominio/pdf/pdfpedido.php';</script>";
	//echo "<script>window.location='../../interface/carrito/VerCarrito.php';</script>";
	
}elseif($modo==19){ //futura impresion
    echo "<script>window.location='../../interface/facturas/FacturaForm.php';</script>";
}
?>