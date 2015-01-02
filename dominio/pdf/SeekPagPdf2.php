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
  $link=Conecta();                                  // en Persistencia.php 
  $resultados=ejecutarConsulta($sql,$link);
  $total_registros=mysql_num_rows($resultados);
  
  $compraPcr=0;   $compraDcr=0; //+
  $reciboP=0;     $reciboD=0;   //-
  $totexeP =0; $totexeD =0; $totminP =0; $totminD = 0; $totbasP =0; $totbasD=0;
  $ivaminP = 0; $ivaminD=0; $ivabasP =0;   $ivabasD=0;
  //-------------------------------------------------------  
  if($total_registros>0){	
        $pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->ezSetCmMargins(1,2,2,1); //top,bottom,left,right
		$pdf->selectFont('font/courier.afm');
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
		$pdf->ezText($criterio,10,array('left'=>4));
		
 		$titles = array('ide'=>'ID','fec'=>'FECHA','raz'=>'RAZON SOCIAL','tip'=>'T.MOVIMIENTO','num'=>'NºDOC',
						'imp'=>'IMPORTE','tas'=>'IVA%','ivap'=>'IVA $','ivad'=>'IVA U$S','mon'=>'moneda' );
						
		$options = array('xPos'=>'center','width'=>560,'shaded'=>0,'fontSize'=>8,
						 'cols'=>array('ide'=>array('justification'=>'right'),
									   'fec'=>array('justification'=>'center'),
									   'raz'=>array('left'=>60),
									   'tip'=>array('left'=>36),
									   'num'=>array('justification'=>'right'),
									   'imp'=>array('justification'=>'right'),
									   'tas'=>array('justification'=>'right'),
									   'ivap'=>array('justification'=>'right'),
									   'ivad'=>array('justification'=>'right'),
									   'mon'=>array('justification'=>'left')));   
		$ivaP=0; $ivaD=0;					  			  	
		while($row=mysql_fetch_array($resultados)){
			$id=$row['cod_mov'];$tipdoc=$row['tip_mov'];$moneda=$row['mon_mov'];$tipiva=$row['val_iva'];
				
			//EVALUAR TIPO DE DOCUMENTO PARA ELEGIR UBICACION DEL VALOR
			$contado=0; $contadoP=0; $haberP=0; $debeP=0; 	$ivaP=0;   $ivaD=0;
			if($row['mon_mov']=="Peso"){ // -----------------------si la moneda es peso
				if($row["tip_mov"]=="factura crédito"){
						$debeP=$row["val_mov"];	$compraPcr=$compraPcr+$debeP;
						if($tipiva==22.00){
							$ivaP=($debeP/122)*22;	$ivabasP=$ivabasP+$ivaP;	$totbasP=$totbasP+$debeP;	
						}elseif($tipiva==10.00){
							$ivaP=($debeP/110)*10;	$ivaminP=$ivaminP+$ivaP;	$totminP=$totminP+$debeP;
						}elseif($tipiva==0.00){
							$ivaP=0;			$ivaminP=$ivaminP+$ivaP;	$totexeP=$totexeP+$debeP;
						}
						
				}elseif($row["tip_mov"]=="recibo pago" ){
						$haberP=$row["val_mov"];
						
				}elseif($row["tip_mov"]=="nota crédito"){
						$haberP=$row["val_mov"];	$compraPcr=$compraPcr+$haberP;
						if($tipiva==22.00){
							$ivaP=($haberP/122)*22;		$ivabasP=$ivabasP-$ivaP;	$totbasP=$totbasP-$debeP;			
						}elseif($tipiva==10.00){
							$ivaP=($haber/110)*10;		$ivaminP=$ivaminP-$ivaP;	$totminP=$totminP-$debeP;
						}elseif($tipiva==0.00){
							$ivaP=0;				$ivaexeP=0;					$totexeP=$totexeP-$debeP;
						}
				}elseif($row["tip_mov"]=="factura contado"){
						$contadoP=$row["val_mov"];	$compraPcr=$compraPcr+$contadoP;
						if($tipiva==22.00){
							$ivaP=($contadoP/122)*22;		$ivabasP=$ivabasP+$ivaP;	$totbasP=$totbasP+$contadoP;		
						}elseif($tipiva==10.00){
							$ivaP=($contadoP/110)*10;		$ivaminP=$ivaminP+$ivaP;	$totminP=$totminP+$contadoP;
						}elseif($tipiva==0.00){
							$ivaP=0;					$ivaexeP=0;					$totexeP=$totexeP+$contadoP;
						}
				}elseif($row["tip_mov"]=="devolución contado"){
						$contadoP=$row["val_mov"];	$compraPcr=$compraPcr+$contadoP;
						if($tipiva==22.00){
							$ivaP=($contadoP/122)*22;	$ivabasP=$ivabasP-$ivaP;	$totbasP=$totbasP-$contadoP;		
						}elseif($tipiva==10.00){
							$ivaP=($contadoP/110)*10;	$ivaminP=$ivaminP-$ivaP;	$totminP=$totminP-$contadoP;
						}elseif($tipiva==0.00){
							$ivaP=0;				$ivaexeP=0;		$totexeP=$totexeP-$contadoP;
						}
				}		
			}
			$contadoD=0; $haberD=0; $debeD=0; 
			if($row['mon_mov']=="Dolar"){  //----------------------- si la moneda es dolar
				if($row["tip_mov"]=="factura crédito"){
						$debeD=$row["val_mov"];	$compraDcr=$compraDcr+$debeD;
						if($tipiva==22.00){
							$ivaD=($debeD/122)*22;		$ivabasD=$ivabasD+$ivaD;	$totbasD=$totbasD+$debeD;
						}elseif($tipiva==10.00){
							$ivaD=($debeD/110)*10;		$ivaminD=$ivaminD+$ivaD;	$totminD=$totminD+$debeD;
						}elseif($tipiva==0.00){
							$ivaD=0;	$ivaexeD=0;	$totexeD=$totexeD+$debeD;
						}
						
							
				}elseif($row["tip_mov"]=="recibo pago" ){
						$haberD=$row["val_mov"];
						
				}elseif($row["tip_mov"]=="nota crédito"){
						$haberD=$row["val_mov"];	$compraDcr=$compraDcr-$haberD;
						if($tipiva==22.00){
							$ivaD=($debeD/122)*22;		$ivabasD=$ivabasD-$ivaD;	$totbasD=$totbasD-$debeD;	
						}elseif($tipiva==10.00){
							$ivaD=($debeD/110)*10;		$ivaminD=$ivamind-$ivaD;	$totminD=$totminD-$debeD;
						}elseif($tipiva==0.00){
							$ivaD=0;	$ivaexeD=0;	$totexeD=$totexeD+$debeD;
						}
									
				}elseif($row["tip_mov"]=="factura contado"){
						$contadoD=$row["val_mov"];	$compraDcr=$compraDcr+$contadoD;
						if($tipiva==22.00){
							$ivaD=($contadoD/122)*22;	$ivabasD=$ivabasD+$ivaD;	$totbasD=$totbasD+$contadoD;	
						}elseif($tipiva==10.00){
							$ivaD=($contadoD/110)*10;	$ivaminD=$ivaminD+$ivaD;	$totminD=$totminD+$contadoD;
						}elseif($tipiva==0.00){
							$ivaD=0;	$ivaexeD=0;	$totexeD=$totexeD+$contadoD;
						}
				}elseif($row["tip_mov"]=="devolución contado"){
						$contadoD=$row["val_mov"];	$compraPcr=$compraPcr+$contadoD;
						if($tipiva==22.00){
							$ivaD=($contadoD/122)*22;	$ivabasD=$ivabasD-$ivaD;	$totbasD=$totbasD-$contadoD;		
						}elseif($tipiva==10.00){
							$ivaD=($contadoD/110)*10;	$ivaminD=$ivaminD-$ivaD;	$totminD=$totminD-$contadoD;
						}elseif($tipiva==0.00){
							$ivaD=0;				$ivaexeD=0;					$totexeD=$totexeD-$contadoD;
						}
				}		
			}
			if($row['mon_mov']=="Peso"){ //--------------------si la moneda es pesos
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
			//PARA EVITAR MOSTRAR EXCESO DE CEROS
			$mivaP=""  ;$mivaD="";
			if($ivaP!=0){	$mivaP=number_format($ivaP,2);   }
			if($ivaD!=0){	$mivaD=number_format($ivaD,2);   }
			$importe = number_format($row["val_mov"],2);
			if(($row["tip_mov"]=="devolución contado") || ($row["tip_mov"]=="nota crédito")){
				$importe = number_format($row["val_mov"]*(-1),2);
				if($ivaP!=0){	$mivaP=number_format($ivaP*(-1),2);   }
				if($ivaD!=0){	$mivaD=number_format($ivaD*(-1),2);   }
			}
			//CONTENIDO DE CADA LINEA
				$data[]=array('ide'=>$row["cod_mov"],   'fec'=>$row["fec_mov"],
							  'raz'=>$row["raz_pro"],   'tip'=>$row["tip_mov"],
						      'num'=>$row["num_mov"],   'imp'=>$importe,
			                  'tas'=>$row["val_iva"],   'ivap'=>$mivaP,
				              'ivad'=>$mivaD,      	    'mon'=>$row["mon_mov"]);  
		} 
		$pdf->ezTable($data,$titles,'DETALLE DE LAS COMPRAS',$options);
		$pdf->ezText(" ");  
		
		$ivapesos = $ivaminP+$ivabasP;
		$ivadolares = $ivaminD+$ivabasD;
				
		$pdf->ezText("PESOS  total comprado en $ ".number_format($compraPcr,2).
		             " iva $ ".number_format($ivapesos,2)."",12,array('left'=>0));
		$pdf->ezText("DOLAR  total comprado en U$"."S ".number_format($compraDcr,2).
		             " iva U$"."S ".number_format($ivadolares,2)."",12,array('left'=>0));
		$pdf->ezText(" ");
		
		$pdf->ezText("COMPRAS EXENTAS",12,array('left'=>0));
		$pdf->ezText("PESOS  total $ ".number_format($totexeP,2),10,array('left'=>0));
		$pdf->ezText("DOLAR  total U$"."S ".number_format($totexeD,2),10,array('left'=>0));
		$pdf->ezText(" ");   
		
		$pdf->ezText("COMPRAS TASA MINIMA",12,array('left'=>0));
		$pdf->ezText("PESOS  total $ ".number_format($totminP,2).
		             " iva $ ".number_format($ivaminP,2)."",10,array('left'=>0)); 
		//echo $totminD;			  
		//------------------------------------------------------------------------------------		 
		$pdf->ezText("DOLAR  total U$"."S ".number_format($totminD,2).
		             " iva U$"."S ".number_format($ivaminD,2),10,array('left'=>0));   
					 
		$pdf->ezText(" ");  
		
		$pdf->ezText("COMPRAS TASA BASICA",12,array('left'=>0));
		$pdf->ezText("PESOS  total $ ".number_format($totbasP,2).
		             " iva $".number_format($ivabasP,2)."",10,array('left'=>0));
					 
		$pdf->ezText("DOLAR  total U$"."S ".number_format($totbasD,2).
		             " iva U$"."S ".number_format($ivabasD,2)." ",10,array('left'=>0));  
		
		$pdf->ezStream();  
   }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
   }
?>