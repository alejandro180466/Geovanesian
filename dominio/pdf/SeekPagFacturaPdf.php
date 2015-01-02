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
	header("location:../../index.php");		exit();
}	
$link=Conecta();                     //en Persistencia.php 
$result=mysql_query($sql,$link);
$total_registros=mysql_num_rows($result);
  //-------------------------------------------------------  
  if($total_registros>0){	
        $pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,32,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
		$pdf->ezText($criterio,10,array('left'=>6));
						 
 		$titles = array('fec'=>'FECHA','fac'=>'NºDOC','raz'=>'RAZON SOCIAL','tip'=>'TIPO DOCUMENTO',
						'imp'=>'IMPORTE','iva'=>'IVA');
						
		$options = array('xPos'=>'center','width'=>580,'shaded'=>1,'fontSize'=>6 );// opciones para la tabla
		
		$saldoP=0;     $compraPcr=0;    $reciboP=0;        $iva=0;				 
		while($row=mysql_fetch_array($result)){
		  if($row['nul_fac']=="N"){
				$tipdoc=$row['tip_fac'];
				$montoP=$row['tot_fac'];
				$anula=$row['nul_fac'];
				$montoD=0;		
			if($tipdoc=="SALDO INICIAL"){
				$saldoP=$saldoP+$montoP;	$compraPcr=$compraPcr+$saldoP;
				$importe=number_format($row['tot_fac'],2);

			}elseif($tipdoc=="FACTURA CREDITO" ){
				$saldoP=$saldoP+$montoP;	$compraPcr=$compraPcr+$montoP;
				$iva=$iva+$row['iva_fac'];
				$importe=number_format($row['tot_fac'],2);
				$ival=number_format($row['iva_fac'],2);
				
			}elseif($tipdoc=="DEVOLUCION CONTADO"){
				$compraPcr=$compraPcr-$montoP;
				$importe=number_format($row['tot_fac']*(-1),2);
				$ival=number_format($row['iva_fac']*(-1),2);
				$iva=$iva-$row['iva_fac'];
				
			}elseif($tipdoc=="NOTA DE CREDITO"){
				$saldoP=$saldoP-$montoP;	$compraPcr=$compraPcr-$montoP;
				$iva=$iva-$row['iva_fac'];
				$importe=number_format($row['tot_fac']*(-1),2);
			    $ival=number_format($row['iva_fac']*(-1),2);
				
			}elseif($tipdoc=="NOTA DEVOLUCION"){
			    $importe=" ";	$ival=" ";
								
			}elseif($tipdoc=="NOTA REMITO" ){
				$importe=" ";  $ival=" ";
								
			}elseif($tipdoc=="RECIBO PAGO" ){
				$saldoP=$saldoP-$montoP;	$reciboP=$reciboP-$montoP;
			
			}elseif($tipdoc=="FACTURA CONTADO" ){
				$compraPcr=$compraPcr+$montoP; 
				$iva=$iva+$row['iva_fac'];
				$importe=number_format($row['tot_fac'],2);
			    $ival=number_format($row['iva_fac'],2);
			}
		}else{
			$importe="Anulado";
			$ival="Anulado";
			$tipdoc=$row['tip_fac'];
			$montoP=0;
		}
		//CONTENIDO DE CADA LINEA			
		$data[]=array('fec'=>$row["fec_fac"],   
					  'fac'=>$row["num_fac"],
					  'raz'=>$row["raz_cli"],
		    		  'tip'=>$row["tip_fac"],
			          'imp'=>$importe,
					  'iva'=>$ival);
		$options=array('xPos'=>'center',     
	    	          'width'=>500,                 //ancho de la tabla 586
					  'shaded'=>0,                  // intercala lineas blncas y negras 
					  'showLines'=>1,               // mostrar u ocultar lineas
					  'rowGap'=>1,
				   	  'showHeadings'=>1,            //mostrar u ocultar titulos de columnas
				      'cols'=>array('fec'=>array('justification'=>'center'),
					  'fac'=>array('justification'=>'center'),
					  'raz'=>array('left'=>80),
					  'tip'=>array('center'=>60),
				      'imp'=>array('justification'=>'right'),
					  'iva'=>array('justification'=>'right'))); 		  
	} 
	$pdf->ezTable($data,$titles,'DETALLE DE LOS DOCUMENTOS EMITIDOS - FACTURAS',$options);
	$pdf->ezStopPageNumbers(1,1,$i);
	$pdf->ezText(" ");
	$pdf->ezText("  Total VENDIDO : $ ". number_format($compraPcr,2)." Iva Ventas : $ ".number_format($iva,2)."",10,array('left'=>4)) ;
	$pdf->ezStream();
   }else{
	   echo("NO HAY COBRANZAS REGISTRADAS CON ESTE CRITERIO");
   } ?>
