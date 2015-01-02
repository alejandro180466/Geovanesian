<?php
include("../../estilos/Estilo_page.php");
include("../../dominio/facturas/FacturaLineaClass.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
}	
//------------ BUSCA DATOS DEL CLIENTE 
	$idpedido=$_SESSION['ses_pedido'];
	$sqlcliente="SELECT p.num_cli , p.id_pedido, p.fec_pedido, p.est_pedido, p.mem_pedido , p.tip_pedido,
				          c.num_cli, c.raz_cli, c.rut_cli,c.dir_cli,c.dep_cli,c.tel_cli 
				 	         FROM pedido p ,cliente c
						          WHERE p.num_cli=c.num_cli AND p.id_pedido=$idpedido" ;
	$link=Conecta();
	$res=mysql_query($sqlcliente,$link); 
	Desconecta($link);
	while($row=mysql_fetch_array($res)){
	    $numcli=$row['num_cli'];
		$razcli=$row['raz_cli'];
		$rutcli=$row['rut_cli'];
		$dircli=$row['dir_cli'];
		$depcli=$row['dep_cli'];
		$telcli=$row['tel_cli'];
		$fecped=$row['fec_pedido'];
		$estado=$row['est_pedido'];
		$memo=$row['mem_pedido'];
		$tipeado=$row['tip_pedido'];
	}
	
//------------ BUSCA LINEAS DEL PEDIDO INGRESADO ANTERIORMENTE, BUSCA DATOS EN TABLA MERCADERIA Y PRECIO
	
   $sqllineas="SELECT l.id_pedido, l.id_pedidolinea, l.cod_mer, l.cant_pedido,
							m.cod_mer, m.des_mer, m.uni_mer, m.iva_mer,
							  p.cod_mer, p.val_pre, p.num_cli, p.fec_pre
							 FROM pedidolinea l, mercaderia m , precio P
						        	WHERE  l.id_pedido = $idpedido 
									   AND l.cod_mer = m.cod_mer 
									   AND p.cod_mer = m.cod_mer
									   AND p.num_cli = $numcli ";

//------------ GENERA LA VISTA DE LOS DATOS DEL CLIENTE
    echo "NºCLIENTE:".$numcli." Cliente:".$razcli."";
	echo "RUT:".$rutcli." ";
	echo "Direccion :".$dircli." Estado :".$depcli." ";
	echo "telefono  :".$telcli."";
										  
	$link=Conecta();
	$reslinea=mysql_query($sqllineas,$link);
	$cantlin=mysql_num_rows($reslinea);
	$laslineas=array();
	$contador=0;
	$total=0;
	$iva=0;
	if($cantlin>0){
	        
			echo"Cod"."cant"."unidad"."descrip"."unit"."desc"."subtotal"."%iva";
			while($row2=mysql_fetch_array($reslinea)){
				$idlinea = $row2['id_pedidolinea'];
				$idpedido= $row2['id_pedido'];    
				$unidad  = $row2['uni_mer'];      //unidad de venta
				$articulo= $row2['des_mer'];      //descripcion de la mercadera
				$codmer  = $row2['cod_mer'];      //codigo de la mercaderia
				$unilin  = $row2['val_pre'];      //precio unitario 
				$cantlin = $row2['cant_pedido'];  //cantidad de unidades
				$ivalin  = $row2['iva_mer'];      //tasa de iva de la mercaderia
				$nullin  = 'A';
				$totallinea = $cantlin*$unilin;
				$ivalinea = ($totallinea/100)*$ivalin;
				$iva     = $iva+$ivalinea;
				$total   = $total+$totallinea;
				$grantotal= $iva+$total;
			}
			$flinea= new FacturaLinea($idlinea,$idfac,$codmer,$unilin,$cantlin,$ivalin,$nullin);
			$contador++;
			$laslineas[$contador]=$flinea;
	}
	Desconecta($link);
?>