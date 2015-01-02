<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
$sql=$_SESSION['ses_sql'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/actualizar/ActualizaSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/actualizar/ActualizaForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/actualizar/ActualizaMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/actualizar/ActualizaMant.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;            
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagActPdf.php";
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
   $indicepag = 10;
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
  $total_paginas = ceil($total_registros / $registros); 	
  //------------------------------------------------------- 
 ?><div id="tablaresultado"> 
   <h3>RESULTADO DE LA BUSQUEDA DE ACTUALIZACIONES DE PRECIOS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
 if($total_registros>0){	?>
 		<TABLE style="font-size:14px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
		     <td>Nº</td><td>FECHA</td><td>RAZON SOCIAL</td><td>PRODUCTO</td><td>MONEDA</td>
			 <td>PORCENTAJE</td><td>PRECIO</td><td>MODALIDAD</td><td>MODI</td><td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			while($row=mysql_fetch_array($resultados)){
				$id=$row["id_update"];
				$mensaje="";//$row['mem_pedido'];
				
		    	printf("<tr align='center' bgcolor='#FFFFFF'>
							<td>".$row["id_update"]."</td>
					   		<td>".$row["fecha_update"]."</td>
			    			<td>".$row["raz_cli"]."</td>
							<td>".$row["des_mer"]."</td>
				        	<td>"."              "."</td>
					    	<td>".$row["porcent_update"]."</td>
							<td>".$row["uni_update"]."</td>
							<td>".$row["cat_update"]."</td>
					        <td><input type='image' src='../../iconos/editmini.png' border=0
											 title='CAMBIAR EL PRECIO' onclick=ver(2,$id);></td>
							<td><input type='image' src='../../iconos/monitorMINI.png' border=0
											 title='VER FICHA DEL PRECIO  MENSAJE:".$mensaje." ' onclick=ver(4,$id);></td>
						</tr>");

			}  ?>
			<tr><td></td></tr>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<!--input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' /-->
	   </form >
	   <?php
   }else{
	   echo("NO HAY ACTUALIZACIONES REGISTRADAS CON ESTE CRITERIO");
   }
   Desconecta($link); ?>
   <div id="paginador">
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag3.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
        ?>	
	</div>
   </div>
  </body>
</html>