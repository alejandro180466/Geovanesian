<?php include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
//manejo de variables de sesion
session_start();
$sqlFT=$_SESSION['ses_sqlFT'];
$sqlRT=$_SESSION['ses_sqlRT'];
$fecini=convertirFormatoFecha2($_SESSION['ses_fecINI']);
$fecfin=convertirFormatoFecha2($_SESSION['ses_fecFIN']);
if ($fecfin=="" || $fecfin>date('Y-m-d')){
	$fecfin=date('Y-m-d');
}
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
  		header("location:../../index.php");		exit();
}

$link=Conecta();                                  // en Persistencia.php 
//consultas de facturas
$resultM=mysql_query($sqlFT,$link);
$total_registrosM = mysql_num_rows($resultM);
//consulta de recibos
$resultR=mysql_query($sqlRT,$link);
$total_registrosR = mysql_num_rows($resultR);
$i=0; $j=0;
//------------------------------------- calculos totales  tabla factura
  if ($total_registrosM>0){
    $total_registrosM=0;	$Tcompra=0; $Tdebe=0;   $Thaber=0; $importe=0;
    while($row=mysql_fetch_array($resultM)){
		$tipdoc=$row['tip_fac'];
		$importe=$row['tot_fac'];
		if($tipdoc=="SALDO INICIAL"){
			++$total_registrosM;
			$Tcompra=$Tcompra+$importe;
			$Tdebe=$Tdebe+$importe;
		}elseif($tipdoc=="FACTURA CREDITO" ){
			++$total_registrosM;
			$Tcompra=$Tcompra+$importe;
			$Tdebe=$Tdebe+$importe;
		}elseif($tipdoc=="DEVOLUCION CONTADO"){
			++$total_registrosM;	
			$Tcompra=$Tcompra-$importe;
		}elseif($tipdoc=="NOTA DE CREDITO" ){
			++$total_registrosM;
			$Tcompra=$Tcompra-$importe;
			$Tdebe=$Tdebe+$importe;
		}elseif($tipdoc=="FACTURA CONTADO" ){
			++$total_registrosM; 
			$Tcompra=$Tcompra+$importe;
		}
	}		
  }
  $resultados=ejecutarConsulta($sqlFT,$link);
  //-------------------------------------- calculos totales tabla recibo
  if ($total_registrosR>0){
     while($row=mysql_fetch_array($resultR)){
		$importe=$row['tot_recibo'];
		$Thaber=$Thaber+$importe;
	}
    $resultados2=ejecutarConsulta($sqlRT,$link);	
  }
  Desconecta($link); 
  //$total_paginas = ceil(($total_registrosM+$total_registrosR)/$registros); 	 
  //--------------------------------------------------------------------------------------------------------- 
    if($total_registrosM>0){
		$saldo=0; $Afacturas= array();  $Arecibos= array();  $compra=0; $ocultar="";
		//despliegue de facturas	
		while($row=mysql_fetch_array($resultados)){
		    $contado=" ";     $debe=" " ;    $haber=" ";
			$id=$row['id_fac'];		$fname=$row['num_fac'];		$nulfac=$row['nul_fac'];
			$existepdf=is_file('../../../copiaspdf/facturaspdf/'.$fname.'.pdf');
			if ($existepdf){
				$ruta="localhost/copiaspdf/facturaspdf/".$fname.".pdf";
				$link="ver pdf" ;
			}else{
				$ruta ="";		$link="";
			}
			$fecha=$row['fec_fac'];
			$numdoc=$row['ser_fac'].$row['num_fac'];
			$tipdoc=$row['tip_fac'];
			$monto=$row['tot_fac'];
			$anula=$row['nul_fac'];
			$razonsocial=$row['raz_cli'];
			$id=$row['num_cli'];
			$mail=$row['mail_cli'];
			$direccion=$row['dir_cli'];
			//----------------------------------------------------
			if($row['tel_cli']=="")  {$telefono="";	 }else{	$telefono="Teléfono : ".$row['tel_cli'];   }
			if($row['fax_cli']=="")  {$fax="";	     }else{	$fax=" Fax : ".$row['fax_cli']; 	       }
			if($row['mail_cli']==" "){$mail=" ";     }else{	$mail=" Mail : ".$row['mail_cli'];	       }
			if($row['dir_cli']=="")  {$direccion=" ";}else{	$direccion=" Dirección : ".$row['dir_cli'];}
			//---------------------------------------------------
		    if($tipdoc=="SALDO INICIAL" || $tipdoc=="FACTURA CREDITO" || $tipdoc=="NOTA DE CREDITO" || 
			                               $tipdoc=="FACTURA CONTADO" || $tipdoc=="DEVOLUCION CONTADO" ){						
			   	if($tipdoc=="SALDO INICIAL"){
					$saldo=$saldo+$monto;	//$compra=$compra+$saldo;
				}elseif($tipdoc=="FACTURA CREDITO" ){
					$debe=$monto;
					$saldo=$saldo+$debe;	$compra=$compra+$debe; 
				}elseif($tipdoc=="DEVOLUCION CONTADO"){
					$compra=$compra-$monto;	
					 if($monto==0){
						$contado=" ";
					}else{
						$contado=$monto*(-1);
					} 								
				}elseif($tipdoc=="NOTA DE CREDITO" ){
					$haber=$monto;
					$saldo=$saldo-$haber;	$compra=$compra-$haber;  
				}elseif($tipdoc=="NOTA DEVOLUCION" ){
					$compra=$compra-$monto;
				}elseif($tipdoc=="NOTA REMITO" ){
				}elseif($tipdoc=="RECIBO PAGO" ){
					$saldo=$saldo-$monto;	$recibo=$recibo-$monto;
				}elseif($tipdoc=="FACTURA CONTADO" ){
					$compra=$compra+$monto;
                    if($monto==0){
						$contado=" ";
					}else{
						$contado=$monto;
					}
				}
				$i++;
				$Afacturas[$i][1] = $fecha;
				$Afacturas[$i][2] = $tipdoc;
				$Afacturas[$i][3] = $numdoc;
				$Afacturas[$i][4] = $contado;
				$Afacturas[$i][5] = $debe;
				$Afacturas[$i][6] = $haber;
				$Afacturas[$i][7] = $saldo;
				$Afacturas[$i][8] = $link;
			}
        }			
	}
	// despligue de recibos
	if($total_registrosR>0){
		while($row2=mysql_fetch_array($resultados2)){
			$fecha=$row2['fec_recibo'];
			$tipdoc="RECIBO DE PAGO";
			$numdoc=$row2['num_recibo'];
			$haber=$row2['tot_recibo'];
			$j++;
			$Arecibos[$j][1] = $fecha;
			$Arecibos[$j][2] = $tipdoc;
			$Arecibos[$j][3] = $numdoc;
			$Arecibos[$j][4] = " ";
			$Arecibos[$j][5] = " ";
			$Arecibos[$j][6] = $haber;
			$Arecibos[$j][7] = " ";
			$Arecibos[$j][8] = " ";
		}
	}
	// establecer orden de despliegue segun fecha
	$totallineas=$i+$j;
	$k=0; $m=1;  $n=1;   $saldo=0;
			
    if($totallineas>0){	
		$pdf= new Cezpdf('a4');
		$io=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->ezSetCmMargins(2,2,2,2); //top,bottom,left,right
		$pdf->selectFont('font/courier.afm');
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("");
		$pdf->ezText("Cliente : ".$razonsocial." "." ".$id."  ",12,array('left'=>4));
		$pdf->ezText($telefono." ".$fax." ".$mail." ".$direccion." ",9,array('left'=>4));
		$pdf->ezText(" "); 
		$criterio="Criterio : ";
		if($fecini!=""){$criterio.=$fecini." ";}
		$criterio.=" hasta " .$fecfin ."";
		$pdf->ezText($criterio,8,array('left'=>310));
 		$titles = array('fec'=>'FECHA','tip'=>'TIPO DOCUMENTO','num'=>'NºDOC','con'=>'CONTADO','deb'=>'DEBE',
						'hab'=>'HABER','sal'=>'SALDO' ,'lin'=>''
						);
		$options = array('xPos'=>'center',				// opciones para la tabla
		                 'width'=>468,
						 'shaded'=>0,
						 'fontSize'=>8,
						 'cols'=>array('fec'=>array('justification'=>'center'),
									   'tip'=>array('left'=>36),
									   'num'=>array('justification'=>'right'),
									   'con'=>array('justification'=>'right'),
									   'deb'=>array('justification'=>'right'),
									   'hab'=>array('justification'=>'right'),
									   'sal'=>array('justification'=>'right'),
									   'lin'=>array('link'=>'')
									   ));   
		//--------------------------------------------------------------------------------------------
		while($k<=$totallineas){
			++$k;
			if (($Afacturas[$m][1]<=$Arecibos[$n][1]) && ($m<=$i)){
				$contado = $Afacturas[$m][4];  $debe = $Afacturas[$m][5];  $haber = $Afacturas[$m][6];
				if($contado!=" ") {  $contado=number_format($Afacturas[$m][4],2);                     }
				if($Afacturas[$m][2]=="SALDO INICIAL"){ $saldo=$Afacturas[$m][7];                     }
				if($debe!=" "   ) {  $saldo=$saldo+$debe;   $debe=number_format($Afacturas[$m][5],2); }
				if($haber!=" "  ) {  $saldo=$saldo-$haber;  $haber=number_format($Afacturas[$m][6],2);}
				$fec = $Afacturas[$m][1];
				$tip = $Afacturas[$m][2];
				$num = $Afacturas[$m][3];
				$con = $contado;
				$deb = $debe;
				$hab = $haber;
				$sal = number_format($saldo,2);
				$lin = "";
				++$m;
				
			}elseif($n<=$j){
				$haber=$Arecibos[$n][6]; $saldo=$saldo-$haber;	$haber=number_format($haber,2);
				$fec = $Arecibos[$n][1];
				if ($fec<$fecini){
					$tip = "SALDO ANTERIOR";
					$num = "";
					$con = "";
					$deb = "";
					$hab = "";
					
					$proxfechaR=$Arecibos[$n+1][1];
					if ($proxfechaR>$fecini){
						$siguienteR=1;
					}
					
				}else{
					$tip = $Arecibos[$n][2];
					$num = $Arecibos[$n][3];
					$con = $Arecibos[$n][4];
					$deb = $Arecibos[$n][5];
					$hab = $haber;
				}
				$sal = number_format($saldo,2);
				$lin = "";	
			    ++$n;
				
			}elseif($m<=$i){
				$contado = $Afacturas[$m][4];   $debe = $Afacturas[$m][5];  $haber = $Afacturas[$m][6];
				if($contado!=" "){  $contado=number_format($Afacturas[$m][4],2);                     }
				if($debe!=" ")   {  $saldo=$saldo+$debe;   $debe=number_format($Afacturas[$m][5],2); }
				if($haber!=" ")  {  $saldo=$saldo-$haber;  $haber=number_format($Afacturas[$m][6],2);}
				$fec = $Afacturas[$m][1];
				if ($fec<$fecini){
					$tip = "SALDO ANTERIOR";
					$num = "";
					$con = "";
					$deb = "";
					$hab = "";
					
					$proxfechaF=$Afacturas[$m+1][1];
					if ($proxfechaF>$fecini){
						$siguienteF=1;
					}
					
				}else{
					$tip = $Afacturas[$m][2];
					$num = $Afacturas[$m][3];
					$con = $contado;
					$deb = $debe;
					$hab = $haber;
				}	
				$sal = number_format($saldo,2);
				$lin = ""; 
			    ++$m;
			}
		    //CONTENIDO DE CADA LINEA
            if($k<=$totallineas){
				if($fec>$fecfin){
				
				}elseif($fec>$fecini){
				    $data[]= array('fec'=>$fec,'tip'=>$tip,'num'=>$num,'con'=>$con,
								   'deb'=>$deb,'hab'=>$hab,'sal'=>$sal,'lin'=>$lin);
				}elseif($fec<$fecini){
							if(($tip=="RECIBO DE PAGO") && $siguienteR==1){
									$data[]= array('fec'=>$fec,'tip'=>$tip,'num'=>$num,'con'=>$con,
								   'deb'=>$deb,'hab'=>$hab,'sal'=>$sal,'lin'=>$lin);
							}
							if($siguienteF==1){
									$data[]= array('fec'=>$fec,'tip'=>$tip,'num'=>$num,'con'=>$con,
								   'deb'=>$deb,'hab'=>$hab,'sal'=>$sal,'lin'=>$lin);						
							
							}	  
				}				  
			}			
	    } 
		$pdf->ezTable($data,$titles,'RESUMEN DE CUENTA DEL CLIENTE ',$options);
		$pdf->ezText(" ");
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>3));
		$pdf->ezText(" ");
		$pdf->ezText(" Saldo al ".date("d/m/Y")."......... $ ".number_format($saldo,2)."",10,array('left'=>260));
		$pdf->ezText(" ");
		$pdf->ezText("Ante cualquier duda comunicarse con : LETICIA RIOS ",9,array('left'=>3));
		$pdf->ezText(" ");
		$pdf->ezText(" tel:22965169 o cel:093993256 de Lunes a Viernes de 8 a 16 hs",8,array('left'=>3));
		$pdf->ezText(" mails: pentisol@adinet.com.uy  o leticia.rios@bondulce.com ",8,array('left'=>3));
		
		$pdf->ezStream();  
		//GUARDAR EL ESTADO DE CUENTA GENERADO
		$pdfcode=$pdf->ezOutput();    
		$fp=fopen('../../../copiaspdf/estadoctaspdf/'.$razonsocial.'.pdf','wb');      
        fwrite($fp,$pdfcode);fclose($fp);  
    }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
    } ?>
