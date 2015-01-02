<?php include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
include("../../dominio/stocks/StockClass.php");
$sql=$_SESSION['ses_sql'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :													 // nueva busqueda
				document.forms["formbusqueda"].action="../../interface/insumos/InsumoSeek.php"; 
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar insumoS
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/insumos/InsumoForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar insumo
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/insumos/InsumoMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver insumo
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/insumos/InsumoForm.php";
				break;
			case 6 :
				document.forms["formbusqueda"].modo.value=6;   //ver salidas de mercaderia x articulo +cliente
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagInsPdf.php";
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
  
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------?>  
   <center>
   <h3>RESULTADO DE LA BUSQUEDA DE INSUMOS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
  if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>DESCRIPCION</td><td>DETALLE</td><td>CATEGORIA</td><td>UNIDAD</td><td>STOCK</td>
		 	 <td>FECHA</td><td>IVA</td><td>MOD</td><td>DEL</td><td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" action=""   >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
  		    while($row=mysql_fetch_array($resultados)){
				$endeposito=0;
				$id=$row['id_insumo'];
				$stockini=$row['stock_insumo'];
				$fechaini=$row['fecha_insumo'];
				$stock=new Stock("",$id,"","","","");
				$endeposito=$stockini+$stock->Consumido($fechaini);
				
  		    	print("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row["des_insumo"]."</td><td>".$row["det_insumo"]."</td>
					    	<td>".$row["cat_insumo"]."</td><td>".$row["uni_insumo"]."</td>
				    		<td>".$endeposito.       "</td><td>".$row["fecha_insumo"]."</td>
							<td>".$row["iva_insumo"]."</td>
							<td><input type='image' src='../../iconos/Editmini.png'
									     title='MODIFICAR FICHA DE INSUMO' border=0
										 	 onclick=ver(2,$id);></td>
						    <td><input type='image' src='../../iconos/Deletep.png'
										 title='ELIMINAR INSUMO'	border=0
										 	 onclick=ver(3,$id);></td>
							<td><input type='image' src='../../iconos/monitorMINI.png' 
										 title='VER INSUMO' border=0
										     onclick=ver(4,$id);></td>
						</tr>");
			}  ?>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION IMPRESA" onClick='ver(6,0)'/>
	   </form >
	   <?php
   }else{
	   echo("NO HAY INSUMOS REGISTRADOS CON ESTE CRITERIO");
   }
	//Desconecta($link);  ?>
	<div id="paginador">
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
        ?>
	</div>
   </center>
  </body>
</html>