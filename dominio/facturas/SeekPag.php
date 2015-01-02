<?php 
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
if(isset($_SESSION['ses_perfil'])){
	$perfiles=$_SESSION["ses_perfil"]; // datos del usuario
	$perfil=$perfiles[0]; //perfil
	$nombre=$perfiles[2]; //nombre
 }
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/facturas/FacturaSeek.php";  // nueva busqueda
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
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagFacturaPdf.php";
				break;
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
  $link=Conecta();  // en Persistencia.php 
   $registros = 12;
   
  if(isset($_GET['pagina'])){
	$pagina=$_GET['pagina'];
	$inicio=($pagina - 1)*$registros;
  }else{
  	$inicio=0;     $pagina=1;
  }

  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  $saldoP=$saldoD=$compraPcr=$compraDcr=$reciboP=$reciboD=$iva=0;
  while($row=mysql_fetch_array($result)){
			$tipdoc=$row['tip_fac'];
			$montoP=$row['tot_fac'];
			$anula=$row['nul_fac'];
			$montoD=0;		
					
			if($tipdoc=="SALDO INICIAL"){
				$saldoP=$saldoP+$montoP;	$compraPcr=$compraPcr+$saldoP;
				
			}elseif($tipdoc=="FACTURA CREDITO" && $anula=="N"){
				$saldoP=$saldoP+$montoP;	$compraPcr=$compraPcr+$montoP;  $iva=$iva+$row['iva_fac'];
			}elseif($tipdoc=="DEVOLUCION CONTADO" && $anula=="N"){
				$compraPcr=$compraPcr-$montoP;		                        $iva=$iva-$row['iva_fac'];
			}elseif($tipdoc=="NOTA DE CREDITO" && $anula=="N"){
				$saldoP=$saldoP-$montoP;	$compraPcr=$compraPcr-$montoP;  $iva=$iva-$row['iva_fac'];
			}elseif($tipdoc=="NOTA DEVOLUCION" && $anula=="N"){
				$compraPcr=$compraPcr-$montoP;
			}elseif($tipdoc=="NOTA REMITO" && $anula=="N"){
								
			}elseif($tipdoc=="RECIBO PAGO" && $anula=="N"){
				$saldoP=$saldoP-$montoP;	$reciboP=$reciboP-$montoP;
			}elseif($tipdoc=="FACTURA CONTADO" && $anula=="N"){
				$compraPcr=$compraPcr+$montoP;                              $iva=$iva+$row['iva_fac']; 
			}
   }
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);
  Desconecta($link); 
  $total_paginas = ceil($total_registros / $registros); 	
  //------------------------------------------------------- ?>  
   <div id="tablaresultado">
	<h3>RESULTADO DE LA BUSQUEDA DE DOCUMENTOS EMITIDOS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
    if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td><td>RAZON SOCIAL</td><td>TIPO DOCUMENTO</td><td>NºDOC</td><td>IMPORTE</td>
		 	 <td>IVA</td><td>ANULAR</td><td>DEL</td><td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" action=""   >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			while($row=mysql_fetch_array($resultados)){
				$id=$row['id_fac'];
				$fname=$row['num_fac'];
				$nulfac=$row['nul_fac'];
				$existepdf=is_file('../../copiaspdf/facturaspdf/'.$fname.'.pdf');
				if ($existepdf){
					$ruta="../../copiaspdf/facturaspdf/".$fname.".pdf";
					$link="<a href=".$ruta."><IMG src='../../iconos/monitorMINI.png' border=0
							                       title='VER FACTURA en formato PDF'</a>";
				}else{
					$ruta ="";
					$link="SIN PDF";
				}
            if($nombre=="Alejandro"){				
				if($nulfac=="N"){
				    printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row['fec_fac']."</td>
			    			<td>".$row['raz_cli']."</td>
				        	<td>".$row['tip_fac']."</td>
					    	<td>".$row['ser_fac'].$row['num_fac']."</td>
					    	<td align='right'>".number_format($row['tot_fac'],2)."</td>
				    		<td align='right'>".number_format($row["iva_fac"],2)."</td>
							<td><input type='image' src='../../iconos/anular_27.png' border=0
											 title='ANULAR ' onclick=ver(2,$id);></td>
							<td><input type='image' src='../../iconos/Deletep.png' border=0
											 title='ELIMINAR ' onclick=ver(3,$id);></td>
							<td>".$link."</td>
						</tr>");
				}
			}else{
				if($nulfac=="N"){
				    printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row['fec_fac']."</td>
			    			<td>".$row['raz_cli']."</td>
				        	<td>".$row['tip_fac']."</td>
					    	<td>".$row['ser_fac'].$row['num_fac']."</td>
					    	<td align='right'>".number_format($row['tot_fac'],2)."</td>
				    		<td align='right'>".number_format($row["iva_fac"],2)."</td>
							<td></td><td></td>
							<td>".$link."</td>
						</tr>");
				}
			}	
			if($nulfac=="S"){
					printf("<tr align='center' bgcolor='#FFFFFF'>
				   		<td>".$row["fec_fac"]."</td>
			   			<td>".$row["raz_cli"]."</td>
			        	<td>".$row["tip_fac"]."</td>
				    	<td>".$row["num_fac"]."</td>
				    	<td align='right'>"."-----------"."</td>
			    		<td align='right'>"."-----------"."</td>
						<td>ANULADA</td>
						<td>------</td>
						<td>------</td>
					</tr>");
			}
		}  ?>
			<tr><td></td></tr>
			<tr style="text-align:center" >
				<td >PESOS  </td>
				<td></td><td><?php // echo $saldoP ;?></td>
				<td colspan="1">Total VENDIDO : </td><td><?php echo number_format($compraPcr,2) ;?></td><td></td>
				<td colspan="2">Iva Ventas :    </td><td><?php echo number_format($iva,2) ;?></td>
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
	 <div id="paginador">
		<?php	$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
			    $mostrar=$paginar->Armado();		echo $mostrar;    ?>
	</div>
    </div>
  </body>
</html>