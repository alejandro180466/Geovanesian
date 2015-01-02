<?php 
include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
session_start();
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
	exit();
}
$link=Conecta();                                  // en Persistencia.php 
$result=mysql_query($sql,$link);
$total_registros=mysql_num_rows($result);
 
  //-------------------------------------------------------  
  if($total_registros>0){	
  		$pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6, array('left'=>4));
		$pdf->ezText($criterio,9,array('left'=>6));
			 
 		$titles = array('des'=>'DESCRIPCION',         // tittulos de la tabla
		 	 			'uni'=>'UNIDAD',
						'pes'=>'PESO',
		 				'cat'=>'CATEGORIA',
						'sto'=>'DISPONIBLE',
		 				'min'=>'MINIMO',
						'niv'=>'NIVEL'
					   );
		$options = array('xPos'=>'center',
		                 'width'=>550,
						 'shaded'=>1,
						 'cols'=>array('des'=>array('justification'=>'left'),
										'uni'=>array('justification'=>'left'),
										'pes'=>array('justification'=>'center'),
										'cat'=>array('justification'=>'center'),
										'sto'=>array('justification'=>'right'),
										'min'=>array('justification'=>'right'),
										'niv'=>array('justification'=>'center')));
 			
  		while($row=mysql_fetch_array($result)){
			$stock=$prod=$ped=$stockbajo=$preparado=$facturado=0; $mostrar="";
			$id=$row['cod_mer'];
			$fechareset=$row['fecha_mer']; //fecha de reset
			$stockini=$row['stock_mer'];
			$minmer=$row['min_mer'];
			//------------------------------ busqueda de las producciones
			$sqlprod="select cod_mer, can_prod, fec_prod from produccion where cod_mer=$id";
			$produc=mysql_query($sqlprod,$link);
			if (mysql_num_rows($produc)>0){
				while($rowp=mysql_fetch_array($produc)){
					$fechaprod=$rowp['fec_prod'];
				   if($fechaprod>=$fechareset){  //toma solo producciones posteriores al reset
					   $prod=$prod+$rowp['can_prod'];
				   }	   
			    }
			}
			//------------------------------ busqueda de los pedidos recibidos
			$sqlped="SELECT l.cod_mer, l.cant_pedido, l.id_pedido , p.id_pedido , p.fec_pedido , p.est_pedido
									FROM pedidolinea l, pedido p
										WHERE l.id_pedido=p.id_pedido AND l.cod_mer=$id AND p.fec_pedido >='$fechareset'" ;
			$pedidos=mysql_query($sqlped,$link);
			if(mysql_num_rows($pedidos)>0){
				while($rowped=mysql_fetch_array($pedidos)){
				    $fechapedido=$rowped['fec_pedido'];
				   if($fechapedido>=$fechareset){  //toma solo pedidos posteriores al reset 
					 $ped=$ped+$rowped['cant_pedido'];
					 if($rowped['est_pedido']=="PREPARADO"){
					 	$preparado=$preparado+$rowped['cant_pedido'];
					 }
					 if($rowped['est_pedido']=="FACTURADO"){
					 	$facturado=$facturado+$rowped['cant_pedido'];
					 }
					 $mostrar="EN DEPOSITO  PREPARADO : ".$preparado." "."FACTURADO : ".$facturado;
			   }	
			}
		}
		//------------------------------ despliegue de los datos de la mercaderia
		$stock=$stockini+$prod-$preparado-$facturado;
		$stockbajo=$stock-$minmer;
		if($stockbajo<0){
			$mensaje="MUY BAJO";
		}elseif($stockbajo==0 || $stockbajo<5){
			$mensaje="BAJO";
		}elseif($stockbajo>=5){
		   if($stockbajo>=20){
		    	 $mensaje="BUENO";	
		   }else{
				 $mensaje="NORMAL";
		   }	
		}
		//'STOCK DESCUENTA LOS PEDIDOS PENDIENTES DE ENTREGA'
		$data[] =array('des'=>$row["des_mer"],
			    	   'uni'=>$row["uni_mer"],
					   'pes'=>$row["peso_mer"],
					   'cat'=>$row["cat_mer"],
					   'sto'=>number_format($stock,0),
					   'min'=>number_format($minmer,0),
					   'niv'=>$mensaje
				      );
  }
		$pdf->ezTable($data,$titles,'LISTADO DE MERCADERIAS Y STOCK DISPONIBLE',$options);
		$pdf->ezText(" ");
		$pdf->ezText("DISPONIBLE = stock - pedidos preparados o pedidos facturados",8,array('left'=>4));
		$pdf->ezText(" ");
		$pdf->ezText("MINIMO = stock minimo recomendado en condiciones optimas de venta",8,array('left'=>4));
		$pdf->ezText(" ");
		$pdf->ezText(" ",10,array('left'=>4));
		$pdf->ezStream();
	  
   }else{
	   echo("NO HAY MERCADERIAS REGISTRADOS CON ESTE CRITERIO");
   }
Desconecta($link);
?>
   