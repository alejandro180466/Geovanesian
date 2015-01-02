<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginarClass.php");
$sql=$_SESSION['ses_sql'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoForm.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoForm.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=4;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagPdf.php";
				break;	
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
  $link=Conecta();                                  // en Persistencia.php 
  $registros =12;
  if(isset($_GET['pagina'])){
	$pagina=$_GET['pagina'];
	$inicio=($pagina - 1)*$registros;
  }else{
  	$inicio=0; 
    $pagina=1;
  } 
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  
  $saldoP=$saldoD=$compraPcr=$compraDcr=$reciboP=$reciboD=0; 
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
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?> <div id="tablaresultado"> 
	<h3>RESULTADO DE LA BUSQUEDA DE MOVIMIENTOS<img src="../../iconos/Search.png" border="0"/></h3>
<?php 
	if($total_registros>0){	?>
  		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td><td>RAZON SOCIAL</td><td>TIPO MOVIMIENTO</td><td>NºDOCUMENTO</td>
			 <td>IMPORTE</td><td>MONEDA</td><td>MOD</td><td>DEL</td><td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" action=""  >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			while($row=mysql_fetch_array($resultados)){
				$id=$row['cod_mov'];
		    	printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row["fec_mov"]."</td>
			    			<td>".$row["raz_pro"]."</td>
				        	<td>".$row["tip_mov"]."</td>
					    	<td>".$row["num_mov"]."</td>
					    	<td>".number_format($row["val_mov"],2)."</td>
				    		<td>".$row["mon_mov"]."</td>
							<td><input type='image' src='../../iconos/Editmini.png' border=0
											 title='MODIFICAR MOVIMIENTO' onclick=ver(2,$id);></td>
							<td><input type='image' src='../../iconos/Deletep.png' border=0
											 title='ELIMINAR MOVIMIENTO' onclick=ver(3,$id);></td>
							<td><input type='image' src='../../iconos/monitorMINI.png' border=0
											 title='VER FICHA DEL MOVIMIENTO' onclick=ver(4,$id);></td>
						</tr>");
			}
			Desconecta($link);?>
			<tr><td></td></tr>
			<tr style="text-align:center" bgcolor="#FFFFFF">
				<td >PESOS  </td><td >Total comprado :</td><td><?php echo number_format($compraPcr,2);?></td>
				<td>Saldo a pagar :</td><td><?php echo number_format($saldoP,2) ;?></td><td colspan="4"></td>
			</tr>
			<tr style="text-align:center" bgcolor="#FFFFFF">
			    <td>DOLARES</td><td>Total comprado :</td><td><?php echo number_format($compraDcr,2) ;?></td>
			    <td>Saldo a pagar :</td><td><?php echo number_format($saldoD,2) ;?><td><td colspan="3"></td>
			</tr>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
	    </form>
	    <?php
    }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
    }     ?>
	<div id="paginador">
		<?php	$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
				$mostrar=$paginar->Armado();	echo $mostrar;		?>	
	</div>
  </div>
 </body>
</html>