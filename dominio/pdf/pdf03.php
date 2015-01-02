<?php
include("../../dominio/carrito/CarritoClass.php");
include("../../dominio/Persistencia.php");
include('class.ezpdf.php');
session_start();
//------------ BUSCA DATOS DEL CLIENTE 
	$idpedido=$_SESSION['ses_pedido'];
	$sql="SELECT p.num_cli , p.id_pedido, p.fec_pedido, p.est_pedido, p.mem_pedido ,
				 c.num_cli, c.raz_cli
				 	 FROM pedido p ,cliente c
						WHERE p.num_cli=c.num_cli AND p.id_pedido=$idpedido" ;
	$link=Conecta();
	$res=mysql_query($sql,$link); 
	while($row=mysql_fetch_array($res)){
		$razcli=$row['raz_cli'];
		$fecped=$row['fec_pedido'];
		$estado=$row['est_pedido'];
		$memo=$row['mem_pedido'];
	}
	Desconecta($link);
	
	//------------ BUSCA LINEAS DEL PEDIDO INGRESADO ANTERIORMENTE
	
		$sqllineas="SELECT l.id_pedido, l.id_pedidolinea, l.cod_mer, l.cant_pedido,
							m.cod_mer, m.des_mer
							FROM pedidolinea l, mercaderia m
							WHERE l.cod_mer=m.cod_mer AND l.id_pedido=$idpedido";
		$link=Conecta();
		$reslinea=mysql_query($sqllineas,$link);
		$cantlin=mysql_num_rows($reslinea);
		if($cantlin>0){
			while($rowl=mysql_fetch_array($reslinea)){
				$idlinea=$rowl['id_pedidolinea'];
				$idpedido=$rowl['id_pedido'];
				$articulo=$rowl['des_mer'];
				$codmer=$rowl['cod_mer'];
				$cantidad=$rowl['cant_pedido'];
				$linea= new Linea($idlinea,$idpedido,$articulo,$codmer,$cantidad);    //ingresa nueva line
				$_SESSION['ses_carro']->agregar($linea);
			}	
		}
		Desconecta($link);
//------------- COMIENZA ARMADO DE PDF	

				
    $pdf =& new Cezpdf('a4');
    $pdf->selectFont('fonts/courier.afm');
//------------ GENERA LA VISTA DE LOS DATOS DEL CLIENTE
    $pdf->ezText("<b>NºPEDIDO:".$idpedido." Cliente:".$razcli."</b>\n",14);
	
	$pdf->ezText("<b>Fecha :".$fecped." Estado :".$estado."</b>\n",14);
	
	$pdf->ezText("<b>Comentario :".$memo."</b>\n",14);

    $titles = array('cod'=>'<b>Codigo</b>',
	                'art'=>'<b>Articulo</b>',
					'can'=>'<b>Cantidad</b>',
					'vacio1'=>'<b>Lotes</b>',
					'vacio2'=>'<b>Anotacion</b>');
    $options= array('xPos'=>'center','width'=>500,'shaded'=>1);
	$cantlineas=$_SESSION['ses_carro']->cantidadLineas();
	  if($cantlineas>0){
		    //------------------------------------GENERA LA VISTA DE LAS LINEAS
		    $listalineas=$_SESSION['ses_carro'];
			$total=0;
			
			$cant_lin=0;		
			for($i=0 ; $i < $cantlineas ; $i++){
				$idlinea=$listalineas->Devidlinea($i);
				if($idlinea!=0){
					$cant_lin++; 
					$codmer= $listalineas->Devcodmer($i);
					$articulo= $listalineas->Devarticulo($i);
					$cantidad= $listalineas->Devcantidad($i); 
					$data[] = array('cod'=>$codmer,
					                'art'=>$articulo,
									'can'=>$cantidad,
									'vacio1'=>'',
									'vacio2'=>'');
				}
			}
			$pdf->ezTable($data,$titles,'',$options);
			$pdf->ezText("<b>Cantidad de articulos :".$cant_lin."</b>\n",12,array('left'=>4));
	   }
$pdf->ezText("<b>FECHA DE IMPRESION :".date("d/m/Y")." HORA :".date("H:i:s")."</b>\n",10,array('left'=>4));	   
$pdf->ezStream();
?>