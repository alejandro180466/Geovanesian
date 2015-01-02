<?php	include("../../dominio/Persistencia.php");
include("../../dominio/pedidos/PedidoClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2]; // carga en variable el nombre del usuario
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
$modo=$_POST['modo'];
  if($modo==5){
     $idpedido=0;
	 $numcli=$_POST['numcli'];
	 $fecpedido= date( "Y/n/j" );
	 $fecentrega=$_POST['fecentrega'];
	 $estado=$_POST['txtestado'];
	 $memo=$_POST['txtmemo'];
	 $fecfactura="";
  }elseif($modo==3 || $modo==4){  //ELIMINAR O VER
     $idpedido=$_POST['id'];	
	 $numcli=0;    
	 $fecpedido="";
	 $fecentrega="";
	 $estado="";
	 $memo=""; 
	 $fecfactura="";
  }elseif($modo==2){              // MODIFICAR
  	 $idpedido=$_POST['id'];
	 $numcli=0;
	 $fecpedido="";
	 $fecentrega=$_POST['fecentrega'];
	 $estado=$_POST['txtestado'];
	 $memo=$_POST['txtmemo'];
	 $fecfactura="";
  }
  $ped=new Pedido($idpedido,$numcli,$fecpedido,$fecentrega,$estado,$memo,$fecfactura,$nombre);
  if($modo==5){  // INGRESA EL PEDIDO
		session_register('ses_pedido');
		$ped->PedidoAdd();
   		$_SESSION['ses_pedido']=$ped->getidpedido();
		header('location:../../interface/carrito/VerCarrito.php?modo=5');
		exit();
  }
  if($modo==4){  // VER EL PEDIDO
		session_register('ses_pedido');
		$_SESSION['ses_pedido']=$idpedido;
		header('location:../../interface/carrito/VerCarrito.php?modo=4');
		exit();
  }
  if($modo==2){ //MODIFICAR
  		$ped->PedidoMod();
		session_register('ses_pedido');
		$_SESSION['ses_pedido']=$idpedido;
		header('location:../../interface/carrito/VerCarrito.php?modo=4');
		exit();
  }
  if($modo==3){  //BAJA
		$ped->PedidoDel();
		$link=Conecta();
		$sql="delete from pedidolinea where id_pedido=$idpedido";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
  }
header("location:../../interface/pedidos/PedidoIndex.php");
?>