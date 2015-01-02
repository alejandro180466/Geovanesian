<?php
include("../../dominio/carrito/CarritoClass.php");
include("../../dominio/Persistencia.php");
include('class.ezpdf.php');
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0]; $codusr=$perfiles[1];  $nombre=$perfiles[2];
if($perfil=="" || $codusr==""){
  header("location:../../index.php");
  exit();
}	//------------ BUSCA DATOS DEL CLIENTE 
	$idpedido=$_SESSION['ses_pedido'];
	$sql="SELECT p.num_cli , p.id_pedido, p.fec_pedido, p.est_pedido, p.mem_pedido , p.tip_pedido,
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
		$tipeado=$row['tip_pedido'];
	}
	Desconecta($link);
//------------ BUSCA LINEAS DEL PEDIDO INGRESADO ANTERIORMENTE
		$sqllineas="SELECT l.id_pedido, l.id_pedidolinea, l.cod_mer, l.cant_pedido,
							m.cod_mer, m.des_mer, m.peso_mer
							 FROM pedidolinea l, mercaderia m
							     WHERE l.cod_mer=m.cod_mer AND l.id_pedido=$idpedido";
		$link=Conecta();
		$reslinea=mysql_query($sqllineas,$link);
		$cantlin=mysql_num_rows($reslinea);
		if($cantlin>0){
		    $kg=0;
		    while($rows=mysql_fetch_array($reslinea)){
				$idlinea=$rows['id_pedidolinea'];
				$idpedido=$rows['id_pedido'];
				$articulo=$rows['des_mer'];
				$codmer=$rows['cod_mer'];
				$cantidad=$rows['cant_pedido'];
				$kg=$kg+($rows['peso_mer']*$cantidad);
				$linea= new Linea($idlinea,$idpedido,$articulo,$codmer,$cantidad);    //ingresa nueva line
				$_SESSION['ses_carro']->agregar($linea);
			}	
		}
		Desconecta($link);
//------------- COMIENZA ARMADO DE PDF	
    $pdf =& new Cezpdf('a5');
    $pdf->selectFont('fonts/courier.afm');
	$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
//------------ GENERA LA VISTA DE LOS DATOS DEL CLIENTE
    $pdf->ezText("NºPEDIDO:".$idpedido." Cliente:".$razcli."\n",10,array('left'=>4));
	$pdf->ezText("Fecha solicitud :".$fecped." Estado :".$estado."\n",10,array('left'=>4));
	$pdf->ezText("Comentario :".$memo."\n",9,array('left'=>4));
   	$cantlineas=$_SESSION['ses_carro']->cantidadLineas();
	  if($cantlineas>0){
		    //------------------------------------GENERA LA VISTA DE LAS LINEAS
		    $listalineas=$_SESSION['ses_carro'];
			$total=0; $cant_lin=0; $cant_uni=0;		
			for($i=0 ; $i < $cantlineas ; $i++){
				$idlinea=$listalineas->Devidlinea($i);
				if($idlinea!=0){
					$cant_lin++;
					$articulo= $listalineas->Devarticulo($i);
					$cantidad= $listalineas->Devcantidad($i);
					$cant_uni=$cant_uni+$cantidad;
					$data[] = array('art'=>$articulo,'can'=>$cantidad,'vacio1'=>' ','vacio2'=>' ');
				}
			}
			$titles = array('art'=>'Articulo','can'=>'Cant','vacio1'=>'Nºlotes','vacio2'=>'Anotacion');
	        $options= array('xPos'=>'center','width'=>350,'shaded'=>1); 
			$pdf->ezTable($data,$titles,'DETALLE DEL PEDIDO',$options);
			$pdf->ezText("");
			$pdf->ezText("<b>Cantidad de articulos:".$cant_lin." </b>\n",10,array('left'=>4));
			$pdf->ezText("<b>Cantidad de unidades:".$cant_uni."</b>\n",10,array('left'=>4));
			$pdf->ezText("<b>Kg: ".$kg."</b>\n",12,array('left'=>4));
	   }
$pdf->ezText("TIPEADO POR:".$tipeado."\n",9,array('left'=>4));
$pdf->ezText("FECHA DE IMPRESION :".date("d/m/Y")." HORA:".date("H:i:s")."\n",9,array('left'=>4));
$pdf->ezText("IMPRESO POR:".$nombre."\n",9,array('left'=>4));
$pdf->ezText("PREPARADO POR : __________________________",9,array('left'=>4));	   
$pdf->ezStream();
?>