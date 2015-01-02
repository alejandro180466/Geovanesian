<?php
include("../../dominio/carrito/CarritoClass.php");
include("../../dominio/facturas/FacturaLineaClass.php");
include("../../dominio/Persistencia.php");
include('class.ezpdf.php');
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
/*if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
}*/	
//------------ BUSCA DATOS DEL CLIENTE 
	$idpedido=$_SESSION['ses_pedido'];
	$sqlcliente="SELECT p.num_cli , p.id_pedido, p.fec_pedido, p.est_pedido, p.mem_pedido , p.tip_pedido,
				          c.num_cli, c.raz_cli, c.rut_cli,c.dir_cli,c.dep_cli,c.tel_cli 
				 	         FROM pedido p ,cliente c
						          WHERE p.num_cli=c.num_cli AND p.id_pedido=$idpedido" ;
	$link=Conecta();
	$res=mysql_query($sqlcliente,$link); 
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
	Desconecta($link);
	
//------------ BUSCA LINEAS DEL PEDIDO INGRESADO ANTERIORMENTE, BUSCA DATOS EN TABLA MERCADERIA Y PRECIO
	
		$sqllineas="SELECT l.id_pedido, l.id_pedidolinea, l.cod_mer, l.cant_pedido,
							m.cod_mer, m.des_mer , m.iva_mer ,
							   p.id_pre , p.val_pre , p.cod_mer
							      FROM pedidolinea l, mercaderia m, precio p 
						        	WHERE l.cod_mer=m.cod_mer AND
									      l.cod_mer=p.cod_mer AND
										   l.id_pedido=$idpedido
										      ORDER BY l.id_pedidolinea ASC";
		$link=Conecta();
		$reslinea=mysql_query($sqllineas,$link);
		$cantlin=mysql_num_rows($reslinea);
		$laslineas=array();
		$contador=0;
		if($cantlin>0){
			while($rowl=mysql_fetch_array($reslinea)){
				$idlinea=$rowl['id_pedidolinea'];
				$idpedido=$rowl['id_pedido'];
				$articulo=$rowl['des_mer'];
				$codmer=$rowl['cod_mer'];
				$unilin=$row1['val_pre'];
				$cantlin=$rowl['cant_pedido'];
				$ivalin=$row1['iva_mer'];
				$nullin='A';                       
				$flinea= new FacturaLinea($idlinea,$idfac,$codmer,$unilin,$cantlin,$ivalin,$nullin);    //ingresa nueva line
				$contador++;
				$laslineas[$contador]=$flinea;
			}	
		}
		Desconecta($link);
//------------- COMIENZA ARMADO DE PDF	
    $pdf =& new Cezpdf('a4');
    $pdf->selectFont('fonts/courier.afm');
	$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
//------------ GENERA LA VISTA DE LOS DATOS DEL CLIENTE
    $pdf->ezText("NºCLIENTE:".$numcli." Cliente:".$razcli."\n",12,array('left'=>4));
	$pdf->ezText("RUT:".$rutcli."\n",12,array('left'=>4));
	$pdf->ezText("Direccion :".$dircli." Estado :".$depcli."\n",12,array('left'=>4));
	$pdf->ezText("<b>telefono: :".$telcli."</b>\n",12,array('left'=>4));
  /* 
	if($cantlin>0){
		    //------------------------------------GENERA LA VISTA DE LAS LINEAS
		    $total=0;
			$cant_lin=0;
			$cant_uni=0;
					
			for($i=0 ; $i < $cantlineas ; $i++){
				$idlinea=$listalineas->Devidlinea($i);
				if($idlinea!=0){
					$cant_lin++;
					$codmer= $listalineas->Devcodmer($i);
					$articulo= $listalineas->Devarticulo($i);
					$cantidad= $listalineas->Devcantidad($i); 
					$cant_uni=$cant_uni+$cantidad;
					$data[] = array('cod'=>$codmer,
					                'art'=>$articulo,
									'can'=>$cantidad,
									'vacio1'=>' ',
									'vacio2'=>' ');
				}
			}
			$titles = array('cod'=>'<b>Codigo</b>',
	                'art'=>'<b>Articulo</b>',
					'can'=>'<b>Cantidad</b>',
					'vacio1'=>'<b> Nº Lotes </b>',
					'vacio2'=>'<b> Anotacion </b>');
					
            $options= array('xPos'=>'center','width'=>510,'shaded'=>1);
			
			$pdf->ezTable($data,$titles,'DETALLE DEL PEDIDO',$options);
			$pdf->ezText();
			$pdf->ezText("<b>Cantidad de articulos:".$cant_lin." Cantidad de unidades:".$cant_uni."</b>\n",10,array('left'=>4));
	   }
//$pdf->ezText("TIPEADO POR:".$tipeado."\n",10,array('left'=>4));
//$pdf->ezText("FECHA DE IMPRESION :".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."\n",10,array('left'=>4));
//$pdf->ezText("PREPARADO POR : __________________________",10,array('left'=>4));	   */
$pdf->ezStream();
?>