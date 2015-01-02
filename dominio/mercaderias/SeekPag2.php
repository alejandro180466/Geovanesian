<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
$sqll=$_SESSION['ses_sqll'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :													 // nueva busqueda
				document.forms["formbusqueda"].action="../../interface/mercaderias/MercaderiaSeek.php"; 
				break
			case 1 :													 // nueva busqueda
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagMerTipPdf.php"; 
				break
		}		
			
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
  $link=Conecta();                                  // en Persistencia.php 
  $registros =10;
  if(isset($_GET['pagina'])){
	$pagina=$_GET['pagina'];
	$inicio=($pagina - 1)*$registros;
  }else{
  	$inicio=0; 
    $pagina=1;
  }
  $result=mysql_query($sqll,$link);
  $total_registros=mysql_num_rows($result);
  
  $sqll.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sqll,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?><div id="tablaresultado">  
    <h3>RESULTADO DE LA BUSQUEDA DE MERCADERIAS<img src="../../iconos/Search.png" border="0"/></h3>
	<?php
    if($total_registros>0){	?>
   		<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td><td>PEDIDO</td><td>CLIENTE</td><td>ARTICULO</td><td>CANTIDAD</td>
          </tr>
		  <form name="formbusqueda" method="post" action=""  >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			$total=0;
  		    while($row=mysql_fetch_array($resultados)){
				$id=$row['cod_mer'];	
				printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row['fec_pedido']."</td>
			    			<td>".$row['id_pedido']."</td>
					    	<td>".$row['raz_cli']."</td>
							<td>".$row['des_mer']."</td>
					    	<td>".$row['cant_pedido']."</td>
						</tr>");
			}  ?>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION IMPRESA" onClick='ver(1,0)'/>
	   </form >
	   <?php
   }else{
	   echo("NO HAY PEDIDOS REGISTRADOS CON ESTE CRITERIO");
   }
   Desconecta($link);?>
   <div id="paginador">
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag2.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
        ?>
	</div>
  </div>
 </body>
</html>