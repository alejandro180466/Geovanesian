<?php 
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/recibos/ReciboSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar recibo
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/recibos/ReciboForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar recibo
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/recibos/ReciboMant.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=4;            //
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagRecibosPdf.php";
				break;
			case 6 :
				document.forms["formbusqueda"].modo.value=6;            //anular recibo
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/recibos/ReciboMant.php";
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
  	$inicio=0;     $pagina=1;
  }
  //echo $pagina;
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?> <div id="tablaresultado">
		<h3>RESULTADO DE LA BUSQUEDA DE RECIBOS EMITIDOS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
  if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td><td>RAZON SOCIAL</td><td>NºRECIBO</td><td>IMPORTE</td>
			 <td>ESTADO</td><td>MODIF</td><td>ANULA</td><td>BORRA</td>
		  </tr>
			<form name="formbusqueda" method="post" >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			$totalcobranza=0;			$contarecibo=0;
			while($row=mysql_fetch_array($resultados)){
				$id=$row['id_recibo']; $fono=$row['tel_cli'];
				if ($row['nul_recibo']=="S"){
					$estado="ANULADO";		$importe="-------";
				}else{
					$estado="OK";
					$totalcobranza=$totalcobranza+$row['tot_recibo'];
					$importe=number_format($row['tot_recibo'],2);
					$contarecibo++;
				}
				printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row["fec_recibo"]."</td>
			    			<td title='fono : ".$fono."'>".$row["raz_cli"]."</td>
				        	<td>".$row["num_recibo"]."</td>
					    	<td align='right'>".$importe."</td>
							<td>".$estado."</td>
				    		<td><input type='image' src='../../iconos/Editmini.png' border=0
											 title='MODIFICAR ' onclick=ver(2,$id);></td>
							<td><input type='image' src='../../iconos/anular_27.png' border=0
											 title='ANULAR ' onclick=ver(6,$id);></td>				 
							<td><input type='image' src='../../iconos/Deletep.png' border=0
											 title='ELIMINAR ' onclick=ver(3,$id);></td>
						</tr>");
			}  ?>
			<tr><td></td></tr>
			<tr style="text-align:center" >
				<td >PESOS  </td>
				<td>Cantidad de cobranzas :</td><td><?php echo $contarecibo ;?></td>
				<td colspan="1">Total cobranzas : </td><td><?php echo number_format($totalcobranza,2);?></td><td></td>
			</tr>
			<tr><td colspan="8" bgcolor='#FFFFFF'><?php echo $criterio;?></td></tr>
		</table>
		<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
        <?php
   }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO"); ?>
	   <br></br>
	   <?php
   } ?>
   		 <input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
	</form>	 
	<?php 
	Desconecta($link); ?>
	<div id="paginador">
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
        ?>
	</div>
   </div>
  </body>
</html>