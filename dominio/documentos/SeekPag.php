<?php 
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
if(!isset($_SESSION)){ 
    session_start(); 
}

$sqlFT=$_SESSION['ses_sqlFT'];
$sqlRT=$_SESSION['ses_sqlRT'];
$fecini=$_SESSION['ses_fecINI'];
$fecfin=$_SESSION['ses_fecFIN'];
$criterio=$_SESSION['ses_criterio'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/documentos/DocumentoSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //ANULAR factura
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/facturas/FacturaMant.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar factura
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/facturas/FacturaMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            // vista del pdf de la factura
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/facturas/FacturaMant.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;            //
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagEstadoCtaPdf.php";
				break;
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
  $link=Conecta();                                  // en Persistencia.php 
  $registros =15;
  if (!isset($pagina)){ 
    $inicio=0; 
    $pagina=1; 
  }else { 
    $inicio=($pagina - 1)*$registros; 
  }
  //consultas de facturas
  $resultM=mysql_query($sqlFT,$link);
  $total_registrosM = mysql_num_rows($resultM);
  //consulta de recibos
  $resultR=mysql_query($sqlRT,$link);
  $total_registrosR = mysql_num_rows($resultR);
   
  // calculos totales  tabla factura
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
  //calculos totales tabla recibo
  if ($total_registrosR>0){
     while($row=mysql_fetch_array($resultR)){
		$importe=$row['tot_recibo'];
		$Thaber=$Thaber+$importe;
	}
    $resultados2=ejecutarConsulta($sqlRT,$link);	
  }
  Desconecta($link); 
  $total_paginas = ceil(($total_registrosM+$total_registrosR)/$registros);
  //-------------------------------------------------------  ?>  
   <center>
   <h3><?php echo "ESTADO DE CUENTA ";?></h3>
<?php
    if($total_registrosM>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td><td>TIPO DOCUMENTO</td><td>NºDOC</td><td>CONTADO</td><td>DEBE</td><td>HABER</td><td>SALDO</td><td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" action=""   >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			$saldo=0; $Afacturas= array(); $i=0; $Arecibos= array(); $j=0;
		   //despliegue de facturas	
		   
			while($row=mysql_fetch_array($resultados)){
			    $contado=" ";     $debe=" " ;    $haber=" ";
				$id=$row['id_fac'];		$fname=$row['num_fac'];		$nulfac=$row['nul_fac'];
				$existepdf=is_file('../../../copiaspdf/facturaspdf/'.$fname.'.pdf');
				if ($existepdf){
					$ruta="../../../copiaspdf/facturaspdf/".$fname.".pdf";
					$link="<a href=".$ruta."><IMG src='../../iconos/monitorMINI.png' border=0
							                       title='VER FACTURA en formato PDF'</a>";
				}else{
					$ruta ="";
					$link="SIN PDF";
				}
				$fecha=$row['fec_fac'];
				$numdoc=$row['ser_fac'].$row['num_fac'];
				$tipdoc=$row['tip_fac'];
				$monto=$row['tot_fac'];
				$anula=$row['nul_fac'];
			    if($tipdoc=="SALDO INICIAL" || $tipdoc=="FACTURA CREDITO" || $tipdoc=="NOTA DE CREDITO" || 
				                               $tipdoc=="FACTURA CONTADO" || $tipdoc=="DEVOLUCION CONTADO" ){						
				   
					if($tipdoc=="SALDO INICIAL"){
						$saldo=$saldo+$monto;	$compra=$compra+$saldo;
					}elseif($tipdoc=="FACTURA CREDITO" ){
						$debe=$monto;
						$saldo=$saldo+$debe;	$compra=$compra+$debe; 
					}elseif($tipdoc=="DEVOLUCION CONTADO"){
						$compra=$compra-$monto;		                        
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
					if($fecha>=$fecini ||){
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
						//$saldo=$saldo-$haber;
						if($row2['fec_recibo']>=$fecini){
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
			}
			// establecer orden de despliegue segun fecha
			$totallineas=$i+$j;
			$k=0; $m=1;  $n=1;   $saldo=0;
			while($k<=$totallineas){
			    $k++;  
				if ($Afacturas[$m][1]<=$Arecibos[$n][1] && ($m<=$i)){
					$contado = $Afacturas[$m][4];
				       $debe = $Afacturas[$m][5];
					  $haber = $Afacturas[$m][6];
					if($contado!=" "){  $contado=number_format($Afacturas[$m][4],2);                     }
					if($Afacturas[$m][2]=="SALDO INICIAL"){ $saldo=$Afacturas[$m][7];                   }
					if($debe!=" ")   {  $saldo=$saldo+$debe;   $debe=number_format($Afacturas[$m][5],2); }
					if($haber!=" ")  {  $saldo=$saldo-$haber;  $haber=number_format($Afacturas[$m][6],2);}
					$Afacturas[$m][0]="<tr align='center' bgcolor='#FFFFFF'>
										<td>".$Afacturas[$m][1]."</td>
										<td>".$Afacturas[$m][2]."</td>
										<td>".$Afacturas[$m][3]."</td>
										<td align='right'>".$contado."</td>
										<td align='right'>".$debe."</td>
										<td align='right'>".$haber."</td>
										<td align='right'>".number_format($saldo,2)."</td>
										<td>".$Afacturas[$m][8]."</td>
									   </tr>";
				    printf($Afacturas[$m][0]);
					++$m;  					
				}elseif($n<=$j){
					$haber=$Arecibos[$n][6];
					$saldo=$saldo-$haber;
					$haber=number_format($haber,2);
					$Arecibos[$n][0]="<tr align='center' bgcolor='#FFFFFF'>
										<td>".$Arecibos[$n][1]."</td>
										<td>".$Arecibos[$n][2]."</td>
										<td>".$Arecibos[$n][3]."</td>
										<td align='right'>".$Arecibos[$n][4]."</td>
										<td align='right'>".$Arecibo[$n][5]."</td>
										<td align='right'>".$haber."</td>
										<td align='right'>".number_format($saldo,2)."</td>
										<td>".""."</td>
									   </tr>";
					printf($Arecibos[$n][0]);
					++$n;  
					}elseif($m<=$i){
						$contado = $Afacturas[$m][4];
				        $debe = $Afacturas[$m][5];
					    $haber = $Afacturas[$m][6];
						if($contado!=" "){  $contado=number_format($Afacturas[$m][4],2);                     }
						if($debe!=" ")   {  $saldo=$saldo+$debe;   $debe=number_format($Afacturas[$m][5],2); }
						if($haber!=" ")  {  $saldo=$saldo-$haber;  $haber=number_format($Afacturas[$m][6],2);}
						$Afacturas[$m][0]="<tr align='center' bgcolor='#FFFFFF'>
												<td>".$Afacturas[$m][1]."</td>
												<td>".$Afacturas[$m][2]."</td>
												<td>".$Afacturas[$m][3]."</td>
												<td align='right'>".$contado."</td>
												<td align='right'>".$debe."</td>
												<td align='right'>".$haber."</td>
												<td align='right'>".number_format($saldo,2)."</td>
												<td>".$Afacturas[$m][8]."</td>
											   </tr>";
						printf($Afacturas[$m][0]);
						++$m;  		
					}
			}?> 
			<tr style="text-align:center" >
				<td >PESOS  </td>
				<td colspan="2">Total VENDIDO : </td><td><?php echo number_format($Tcompra,2) ;?></td><td></td>
				<td colspan="1">    </td>
				<td><?php echo "Saldo: ". number_format($saldo,2) ;?></td>
			</tr>
			<tr bgcolor='#FFFFFF'><td colspan="9"><?php echo $criterio ;?></td></tr>
		</table>
		<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
	   <?php
    }else{
	   echo("NO HAY DOCUMENTOS EMITIDOS CON ESTE CRITERIO"); ?>
	   <br></br>
	   <?php  
    } ?>
         <input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)';/> 
	 </form>
	 <?php
	if($total_registrosM){ ?>
		<div id="paginador">
			<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
			?>	
		</div>
		<?php
	}      ?>
    </center>
  </body>
</html>