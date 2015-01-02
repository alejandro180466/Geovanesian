<?php
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/alertas/AlertaClass.php");

$sql="SELECT * FROM alertas WHERE estado='P' ORDER BY vence ASC";
$link=Conecta();
	$result=mysql_query($sql,$link);
	$total_registros=mysql_num_rows($result);
Desconecta($link);
?>
<html>
	<body>
		<div id="tablaresultado">
			<?php
			if($total_registros>0){	?>
				<BR>
				<H3>ALERTAS PRIORITARIAS</H3>
				<TABLE align="center">
				<?php
				$todasalertas=array();
				$n=0; $r=0; $a=0; $v=0; $b=0;       $i=0;
				while($row=mysql_fetch_array($result)){
					$esta = new Alerta($row['alertas_id'],$row['concepto'],$row['detalle'],$row['hoy'],$row['vence'],$row['previo'],'','');
					$color = $esta->Alertar();
					if($color=='verde'){
						$alertasverde[$v]=$esta;	
						echo "<tr><td><img src='../../iconos/Green_60.png' border='0'/></td><td>".$alertasverde[$v]->getconcepto()."<td>VENCE : ".$alertasverde[$v]->getvence()."</td></tr>";
						$v++;
					}
					if($color=='amarillo'){
						$alertasamarillo[$a]=$esta;
						echo "<tr><td><img src='../../iconos/Yellow_60.png' border='0'/></td><td>".$alertasamarillo[$a]->getconcepto()."<td>VENCE : ".$alertasamarillo[$a]->getvence()."</td></tr>";
						$a++;
					}
					if($color=='naranja'){
						$alertasnaranja[$n]=$esta;
						echo "<tr><td><img src='../../iconos/Orange_60.png' border='0'/></td><td>".$alertasnaranja[$n]->getconcepto()."<td>VENCE : ".$alertasnaranja[$n]->getvence()."</td></tr>";
						$n++;
					}
					if($color=='rojo'){
						$alertasrojo[$r]=$esta;
						echo "<tr><td><img src='../../iconos/Red_60.png' border='0'/></td><td>".$alertasrojo[$r]->getconcepto()."<td>VENCE : ".$alertasrojo[$r]->getvence()."</td></tr>";
						$r++;
					}
					$i++;
				}?>
				</table><?php	
			}?>	
		</div>	
	</body>
</html>