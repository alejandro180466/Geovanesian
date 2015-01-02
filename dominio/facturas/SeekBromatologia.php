<?php 
//include("../../estilos/Estilo_page.php");
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
session_start();
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/facturas/BromatSeek.php";  // nueva busqueda
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
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagBromatPdf.php";
				break;
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
  $link=Conecta();                                  // en Persistencia.php 
  $registros =11;
  if (!$pagina){ 
    $inicio=0; 
    $pagina=1; 
  }else { 
    $inicio=($pagina - 1)*$registros; 
  }
 // echo $sql;
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
 /*
  while($row=mysql_fetch_array($result)){
			$tipdoc=$row['tip_fac'];
			$anula=$row['nul_fac'];
			$catmer=$row['cat_mer'];
			if($row['nul_fac']=="N"&& $tipdoc!="NOTA REMITO" && $tipdoc!="NOTA DEVOLUCION"){//CONTROLA QUE LOS DOCUMENTOS NO ESTEN ANULADOS
				if($row['cat_mer']!="ENVASES"){
				 	if($tipdoc=="FACTURA CREDITO" || $tipdoc=="FACTURA CONTADO"){               //CONTROLA TIPO DE DOCUMENTO
					   		 $montolinea=$row['cant_lin']*$row['uni_lin'];
							 if($row['des_lin']>0){
							     $descuento=($montolinea/100)*$row['des_lin'];
							     $montolinea=$montolinea-$descuento;
							 }	 
							 $total=$total+$montolinea;
					}elseif($tipdoc=="DEVOLUCION CONTADO" || $tipdoc=="NOTA DE CREDITO"){
							 $montolinea=$row['cant_lin']*($row['uni_lin'])*(-1);
							  if($row['des_lin']>0){
							     $descuento=($montolinea/100)*$row['des_lin'];
							     $montolinea=$montolinea-$descuento;
							 }	 			
							 $total=$total-$montolinea;
					}
					$fecha=$row['fec_fac'];
					$numdoc=$row['ser_fac'].$row['num_fac'];
					$descrip=$row['des_mer'];
					$cantidad=$row['cant_lin'];
					$monto=number_format($montolinea,2);	   				
					
				}	
			}
  } */
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?><center><h3>RESULTADO DEL CALCULO PARA PAGO DE TASA BROMATOLOGICA</h3>
<?php
  if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td>
			 <td>Nº DOC</td>
		 	 <td>TIPO DOC</td>
			 <td>MERCADERIA</td>
			 <TD>UNIDADES</TD>
			 <td>IMPORTE</td>
		 	 <td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" action=""   >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			$total=0;
			while($row=mysql_fetch_array($resultados)){
				$id=$row['id_fac'];
				$fname=$row['num_fac'];
				$nulfac=$row['nul_fac'];
				$ruta="../../dominio/facturas/facturaspdf/".$fname.".pdf";
				$tipdoc=$row['tip_fac'];
				if($nulfac=="N" && $tipdoc!="NOTA REMITO" && $tipdoc!="NOTA DEVOLUCION"){ 
				   if($row['cat_mer']!="ENVASES"){
						if($tipdoc=="FACTURA CREDITO" || $tipdoc=="FACTURA CONTADO"){ //CONTROLA TIPO DE DOCUMENTO
					   		 $montolinea=$row['cant_lin']*$row['uni_lin'];
							  if($row['des_lin']>0){
							     $descuento=($montolinea/100)*$row['des_lin'];
							     $montolinea=$montolinea-$descuento;
							 }	 			
							 $total=$total+$montolinea;
						}elseif($tipdoc=="DEVOLUCION CONTADO" || $tipdoc=="NOTA DE CREDITO"){
							 $montolinea=$row['cant_lin']*$row['uni_lin'];
							  if($row['des_lin']>0){
							     $descuento=($montolinea/100)*$row['des_lin'];
							     $montolinea=$montolinea-$descuento;
							 }
                             $total=$total-$montolinea;
						}
						$fecha=$row['fec_fac'];
						$numdoc=$row['ser_fac'].$row['num_fac'];
						$descrip=$row['des_mer'];
					    $cantidad=$row['cant_lin'];
						$monto=number_format($montolinea,2);
										
						printf("<tr align='center' bgcolor='#FFFFFF'>
								    <td>".$fecha."</td>
									<td>".$numdoc."</td>
									<td>".$tipdoc."</td>
									<td>".$descrip."</td>
									<td>".$cantidad."</td>
									<td align='right'>".number_format($montolinea,2)."</td>
									<td><a href=".$ruta."><IMG src='../../iconos/monitorMINI.png' border=0
												 title='VER FACTURA en formato PDF'</a></td>
						</tr>");
					}
				}
			}  
			$apagar=$total*0.02;  //importe a pagar ?>
			<tr style="text-align:center" >
				<td >PESOS  </td>
				<td colspan="2">Total VENDIDO : </td><td><?php echo number_format($total,2) ;?></td>
				<td colspan="2">Total A PAGAR : </td><td><?php echo number_format($apagar,2) ;?></td>
			</tr>
			<tr><td colspan="7"><?php echo $criterio?></tr></tr>
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
	//FreeResp($result);
	if($total_registros){
		echo "<center>";
		if(($pagina - 1) > 0){
			echo "<a href='SeekPag.php?pagina=".($pagina-1)."'>< Anterior</a> ";
		}
		for ($i=1; $i<=$total_paginas; $i++){ 
			if ($pagina == $i){
				echo "<b>".$pagina."</b> "; 
			} else {
				echo "<a href='SeekPag.php?pagina=$i'>$i</a> "; 
			}	
		}
		if(($pagina + 1)<=$total_paginas){
			echo " <a href='SeekPag.php?pagina=".($pagina+1)."'>Siguiente ></a>";
		}
		echo "</center>";
		echo "<BR>"."<center>"."VER PDF DE LA FACTURA SOBRE EL ICONO A UN LADO ".
								"<img src='../../iconos/monitorMINI.png' border='0'/>"."</center"."</BR>";
	}
	Desconecta($link); 
      ?>
    </center>
  </body>
</html>
