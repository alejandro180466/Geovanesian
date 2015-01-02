<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
include("../../dominio/CronometroClass.php");$tiempo= New getmicrotime;
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/pedidos/PedidoSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar pedido
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/pedidos/PedidoForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar pedido
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pedidos/PedidoMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver pedido
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pedidos/PedidoMant.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagPedPdf.php";
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
  	$inicio=0; 
    $pagina=1;
  }
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  Desconecta($link);
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?> <div id="tablaresultado">
	<h3>RESULTADO DE LA BUSQUEDA DE PEDIDOS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
  if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
		     <td>Nº</td><td>FECHA</td><td>RAZON SOCIAL</td><td>TELEFONO</td><td>ESTADO</td>
			 <td>PARA EL</td><td>MODI</td><td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			while($row=mysql_fetch_array($resultados)){
				$id=$row["id_pedido"];
				$mensaje=$row['mem_pedido'];
				$ruta="../../copiaspdf/pedidospdf/".$id.".pdf";
				$existepdf=is_file('../../copiaspdf/pedidospdf/'.$id.'.pdf');
				if ($existepdf){
					$ruta="../../copiaspdf/pedidospdf/".$id.".pdf";
					$link="<a href=".$ruta."><IMG src='../../iconos/monitorMINI.png' border=0
							                       title='VER PEDIDO en formato PDF'</a>";
				}else{
					$ruta ="";
					$link="SIN PDF";
				} 
				printf("<tr align='center' bgcolor='#FFFFFF'>
							<td>".$row["id_pedido"]."</td>
					   		<td>".$row["fec_pedido"]."</td>
			    			<td>".$row["raz_cli"]."</td>
				        	<td>".$row["tel_cli"]."</td>
					    	<td>".$row["est_pedido"]."</td>
							<td>".$row["ent_pedido"]."</td>
					        <td><input type='image' src='../../iconos/Editmini.png' border=0
											 title='CAMBIAR EL ESTADO DEL PEDIDO' onclick=ver(2,$id);></td>
							<td>".$link."</td>
					    </tr>");
			}  ?>
			<tr><td></td></tr>
			<tr><td colspan='3'><?php echo $criterio;?></td><td></td><td colspan="2"><?php echo $tiempo->vertiempo();?></td></tr>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
	   </form >
	   <?php
   }else{
	   echo("NO HAY PEDIDOS REGISTRADOS CON ESTE CRITERIO");
   } ?>
   	<div id="paginador" >
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
        ?>
	</div>
	</div>
  </body>
</html>