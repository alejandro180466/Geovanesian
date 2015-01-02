<?php
include("../../dominio/Persistencia.php");
session_start();
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];  // perfil
$codusr=$perfiles[1];  // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
}
?>
<html>
 <head>
  <title>LISTA DE FACTURAS</title>
 </head>
 <body>
	<h1 align="center">TUS FACTURAS</h1>
 	<br>
	<table align="center" border="0" width="40%" cellpadding="0" cellspacing="0"  bgcolor='#FF9900'>
		<tr bgcolor="#FF9933" align="center">
			<td>Nro</td>
			<td>Fecha</td>
			<td>Hora</td>
			<td width="10%">Monto</td>
			<td>Moneda</td>
		</tr>
		<?php
		$link=Conecta();
		$subtotal=0;
		$detalle="";
		$sql2="select f.id_fac, f.fecha_fac, hora_fac, importe_fac, moneda_fac ,f.cod_user
						 		from factura f
								 where f.cod_user like'$codusr' order by f.id_fac asc"; 
		$rs2=ejecutarConsulta($sql2,$link);
		while($fila2=mysql_fetch_array($rs2)){
				$id=$fila2['id_fac'];          
				$fec=$fila2['fecha_fac'];       
				$hours=$fila2['hora_fac'];     
				$importe=$fila2['importe_fac'];
				$moneda=$fila2['moneda_fac'];
				$total=$total+$importe;
				 
				print ("<tr bgcolor='#FFFFFF'><td align='center'>".$id."</td>
			            <td align='center'>".$fec.   "</td> 
						<td align='center'>".$hours. "</td>
						<td align='left'>".number_format($importe,0)."</td>
						<td align='center'>".$moneda."</td>
					</tr>");
		}
		print("<tr><td></td><td></td><td>"."TOTAL"."</td><td align='rigth'>".number_format($total,0)."</td></tr>");
		FreeResp($rs2);
		Desconecta($link);
		?>	  		
  </table>
  <CENTER><a href="CarritoIndex.php"><img src="../../iconos/arrowright2.png" border="0" align="absmiddle"></a></CENTER>
  <CENTER>VOLVER</CENTER>
 </body>
</html>