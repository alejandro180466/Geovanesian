<?php
include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
session_start();
$sql=$_SESSION['ses_sql'];
$fecini=$_SESSION['ses_fecini'];
$criterio=$_SESSION['ses_criterio'];
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){	header("location:../../index.php");		exit();}	
$link=Conecta();                                  // en Persistencia.php 
$registros=2000;
$result=mysql_query($sql,$link);
$total_registros=mysql_num_rows($result);
$saldoP=0;    +$saldoD=0;   $compraPcr=0; $compraDcr=0;   //+
$reciboP=0;   $reciboD=0;   //-
if($fecini==""){$fecini="0000-00-00";}
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
  $resultados=ejecutarConsulta($sql,$link);	
  Desconecta($link);
  //-------------------------------------------------------  
  if($total_registros>0){	
        $pdf= new Cezpdf('a4');
		$pdf->ezSetCmMargins(1,1,2,1); //top,bottom,left,right
		$pdf->selectFont('font/courier.afm');
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
		$pdf->ezText($criterio,10,array('left'=>4));		 
 		$titles = array('ide'=>'ID',			// tittulos de la tabla
						'fec'=>'FECHA',         
		 	 			'raz'=>'RAZON SOCIAL',
						'tip'=>'T.MOVIMIENTO',
		 				'num'=>'NºDOC',
						'con'=>'CONTADO',
						'deb'=>'DEBE',
						'hab'=>'HABER',
						'salp'=>'SALDO $',
						'sald'=>'SALDO U$S',
		 				'mon'=>'moneda'				
					  );
		$options = array('xPos'=>'center',				// opciones para la tabla
		                 'width'=>560,
						 'shaded'=>0,
						 'fontSize'=>8,
						 'cols'=>array('ide'=>array('justification'=>'right'),
									   'fec'=>array('justification'=>'center'),
									   'raz'=>array('left'=>60),
									   'tip'=>array('left'=>36),
									   'num'=>array('justification'=>'right'),
									   'con'=>array('justification'=>'right'),
									   'deb'=>array('justification'=>'right'),
									   'hab'=>array('justification'=>'right'),
									   'salp'=>array('justification'=>'right'),
									   'sald'=>array('justification'=>'right'),
									   'mon'=>array('justification'=>'left')));
		$saldoP=0; $saldoD=0;					  			  	
		while($row=mysql_fetch_array($resultados)){
			$id=$row['cod_mov'];
			//EVALUAR TIPO DE DOCUMENTO PARA ELEGIR UBICACION DEL VALOR
			$contado=0; $contadoP=0; $haberP=0; $debeP=0; 
			if($row['mon_mov']=="Peso"){
				if($row["tip_mov"]=="saldo inicial"){
						$saldoP=saldoP+$row['val_mov'];
				}elseif($row["tip_mov"]=="factura crédito"){
						$debeP=$row["val_mov"];
						$saldoP=$saldoP+$debeP;
				}elseif($row["tip_mov"]=="recibo pago" ){
						$haberP=$row["val_mov"];
						$saldoP=$saldoP-$haberP;
				}elseif($row["tip_mov"]=="nota crédito"){
						$haberP=$row["val_mov"];
						$saldoP=$saldoP-$haberP;
				}elseif($row["tip_mov"]=="factura contado"){
						$contadoP=$row["val_mov"];
				}
			}
			$contadoD=0; $haberD=0; $debeD=0; 
			if($row['mon_mov']=="Dolar"){
				if($row["tip_mov"]=="saldo inicial"){
						$saldoD=saldoD+$row['val_mov'];
				}elseif($row["tip_mov"]=="factura crédito"){
						$debeD=$row["val_mov"];
						$saldoD=$saldoD+$debeD;
				}elseif($row["tip_mov"]=="recibo pago" ){
						$haberD=$row["val_mov"];
						$saldoD=$saldoD-$haberD;
				}elseif($row["tip_mov"]=="nota crédito"){
						$haberD=$row["val_mov"];
						$saldoD=$saldoD-$haberD;
				}elseif($row["tip_mov"]=="factura contado"){
						$contadoD=$row["val_mov"];
				}
			}
			if($row['mon_mov']=="Peso"){
			    if($row["tip_mov"]=="factura contado"){
				   $contado=$contadoP;
				}   
				$debe=$debeP;
				$haber=$haberP;
			}elseif($row['mon_mov']=="Dolar"){
						if($row["tip_mov"]=="factura contado"){
							$contado=$contadoD;
						}	   
						$debe=$debeD;
						$haber=$haberD;
			}
			//PARA EVITAR MOSTRAR EXECSOS DE CEROS
			$mcontado="";$mdebe="";$mhaber=""  ;$msaldoP=""  ;$msaldoD="";
			
			if($contado!=0){	$mcontado=number_format($contado,2); }
			if($debe!=0)   {	$mdebe =number_format($debe,2);      }
			if($haber!=0)  {	$mhaber=number_format($haber,2);     }
			if($saldoP!=0) {	$msaldoP=number_format($saldoP,2);   }
			if($saldoD!=0) {	$msaldoD=number_format($saldoD,2);   }
			//if($fecini<=$row["fec_mov"]){	 // controla ingreso de fecha de inicio		
				//CONTENIDO DE CADA LINEA			
				$data[]=array('ide'=>$row["cod_mov"],   
							  'fec'=>$row["fec_mov"],
							  'raz'=>$row["raz_pro"],
							  'tip'=>$row["tip_mov"],
							  'num'=>$row["num_mov"],
							  'con'=>$mcontado,
							  'deb'=>$mdebe,
							  'hab'=>$mhaber,
							  'salp'=>$msaldoP,
							  'sald'=>$msaldoD,
							  'mon'=>$row["mon_mov"]);
				$contado=$debe=$haber=0;
			//}		
		} 
		$pdf->ezTable($data,$titles,'DETALLE DE LOS MOVIMIENTOS',$options);
		$pdf->ezText(" ");
		$pdf->ezText("PESOS - Total comprado en $ ".number_format($compraPcr,2)." Saldo a pagar en $ ".number_format($saldoP,2)."",12,array('left'=>4                     ));
		$pdf->ezText(" ");
		$pdf->ezText("DOLARES - Total comprado US ".number_format($compraDcr,2)." Saldo a pagar en US ".number_format($saldoD,2)."",12,array('left'=>4));
		$pdf->ezStream();
   }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
   }
?>