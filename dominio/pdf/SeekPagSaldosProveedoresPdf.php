<?php include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
//manejo de variables de sesion
session_start();
$sqlrubro=$_SESSION['ses_rubro'];

// busqueda de los proveedores de cada rubro
$link=Conecta();                                  // en Persistencia.php
$porrubro=mysql_query($sqlrubro,$link);
$total_rubro=mysql_num_rows($porrubro);
$total_paginas=ceil($total_rubro/$registros);
		
if($total_rubro>0){	
	$pdf= new Cezpdf('a4');
	$io=$pdf->ezStartPageNumbers(300,30,14,'','',1);
	$pdf->ezSetCmMargins(2,2,2,2); //top,bottom,left,right
	$pdf->selectFont('font/courier.afm');
	$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
	$pdf->ezText("");
	$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s"),6, array('left'=>4));
	$criterio=$_SESSION['ses_criterio'];
	$pdf->ezText($criterio,12,array('left'=>0));
 	$titles = array('pro'=>'RAZON SOCIAL','pes'=>'PESOS','dol'=>'DOLARES');
	$options = array('xPos'=>'center',				// opciones para la tabla
	                 'width'=>468,
					 'shaded'=>0,
					 'fontSize'=>10,
					 'cols'=>array('pro'=>array('justification'=>'center'),
								   'pes'=>array('justification'=>'right'),
								   'dol'=>array('justification'=>'right')));  
	$totalP = $totalD = 0;
	while($rub=mysql_fetch_array($porrubro)){
		$saldoP = $saldoD =	$compraPcr = $compraDcr = $montoD = $montoP = $reciboP = $reciboD = 0;   
		$id=$rub['num_pro']; $nom=$rub['raz_pro'];
		// busqueda de todos los movimentos
		$sql=$_SESSION['ses_sql'];
		$sql.=" AND (m.rut_pro =$id) ORDER BY m.rut_pro"  ;
		$result=mysql_query($sql,$link);
		
		while($row=mysql_fetch_array($result)){
			$tipdoc=$row['tip_mov'];
			$moneda=$row['mon_mov'];
			if($moneda=="Peso"){
				$montoP=$row['val_mov'];
				$montoD=0;		
			}elseif($moneda=="Dolar"){
				$montoD=$row['val_mov'];
				$montoP=0;
			}		
			if($tipdoc=="saldo inicial"){
				$saldoP=$saldoP+$montoP;	$compraPcr=$compraPcr+$saldoP;
				$saldoD=$saldoD+$montoD;	$compraDcr=$compraDcr+$saldoD;
			}elseif($tipdoc=="factura crédito"){
				$saldoP=$saldoP+$montoP;	$compraPcr=$compraPcr+$montoP;
				$saldoD=$saldoD+$montoD;	$compraDcr=$compraDcr+$montoD;
			}elseif($tipdoc=="devolución contado"){
				$compraPcr=$compraPcr-$montoP;
				$compraDcr=$compraDcr-$montoD;
			}elseif($tipdoc=="nota crédito"){
				$saldoP=$saldoP-$montoP;	$compraPcr=$compraPcr-$montoP;
				$saldoD=$saldoD-$montoD;	$compraDcr=$compraDcr-$montoD;
			}elseif($tipdoc=="nota devolución"){
				$compraPcr=$compraPcr-$montoP;
				$compraDcr=$compraDcr-$montoD;	
			}elseif($tipdoc=="nota remito"){
										
			}elseif($tipdoc=="recibo pago"){
				$saldoP=$saldoP-$montoP;	$reciboP=$reciboP-$montoP;
				$saldoD=$saldoD-$montoD;	$reciboD=$reciboD-$montoD;
										
			}elseif($tipdoc=="factura contado"){
				$compraPcr=$compraPcr+$montoP;
				$compraDcr=$compraDcr+$montoD;	
			}
		}
		$pesos= number_format($saldoP,2) ;
		$dolares= number_format($saldoD,2) ;
		$data[]= array('pro'=>$nom,'pes'=>$pesos,'dol'=>$dolares);
		$totalP=$totalP+$saldoP;
		$totalD=$totalD+$saldoD;
	}//else{
		//echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
	//}
    $pdf->ezTable($data,$titles,'SALDOS DE CUENTAS POR RUBROS ',$options);
	$pdf->ezText(" ");
	$pdf->ezText(" Saldo al ".date("d/m/Y")." .............PESOS ".number_format($totalP,2).
				 " ..........DOLARES ".number_format($totalD,2)
				 ,10,array('left'=>120));
	
	$pdf->ezText(" ");
	$pdf->ezStream();  
}		
Desconecta($link);
?>