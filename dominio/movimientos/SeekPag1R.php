<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
$sqlrubro=$_SESSION['ses_rubro'];
$criterio=$_SESSION['ses_criterio'];
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
				document.forms["formbusqueda"].modo.value=2;            //modificar compra o pago
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //borrar compra o pago
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/movimientos/MovimientoMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver RESUMEN EN PANTALLA
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/movimientos/SeekPag1.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=4;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagSaldosProveedoresPdf.php";
				break;	
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
	<center><h3>RESULTADO SALDOS DE CUENTA CON PROVEEDORES</h3>
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
	// busqueda de los proveedores de cada rubro
	$porrubro=mysql_query($sqlrubro,$link);
	$total_rubro=mysql_num_rows($porrubro);
	$total_paginas=ceil($total_rubro/$registros);
		
	if($total_rubro>0){	?>
		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="2" CELLPADDING="2" bgcolor="#FF9900" width="40%"> 
			<tr align="center" >
				<td>RAZON SOCIAL</td><td>PESOS</td><td>DOLARES</td><td>VER</td>
			</tr>
			<form name="formbusqueda" method="post" action=""  >
	    <?php
		$totalP = $totalD = 0;
		while($rub=mysql_fetch_array($porrubro)){
			$saldoP = $saldoD =	$compraPcr = $compraDcr = $montoD = $montoP = $reciboP = $reciboD=0;   
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
			}?>
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
				<tr align='center' bgcolor='#FFFFFF'>
					<td><?php echo $nom;?></td>
					<td align='right'><?php echo number_format($saldoP,2) ;?></td>
					<td align='right'><?php echo number_format($saldoD,2) ;?></td>
					<td><input type='image' src='../../iconos/monitorMINI.png' border=0
							title='VER RESUMEN DE CUENTA' onclick=ver(4,$id);></td>
				</tr>
			<?php
			$totalP=$totalP+$saldoP;
		    $totalD=$totalD+$saldoD;
		} ?>
			
		<tr><td colspan=1><?php echo $criterio; ?></td>
			<td colspan=1 align='right'><?php echo number_format($totalP,2); ?></td>
			<td colspan=1 align='right'><?php echo number_format($totalD,2); ?></td>
			
		</tr>
		</table>
			<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
			<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
		 </form>
	<?php
	}else{
		echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
	}	
    Desconecta($link);?>
	<div id="paginador">
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag1R.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
		?>
	</div>	
    </center>
  </body>
</html>