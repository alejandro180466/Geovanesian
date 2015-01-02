<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/precios/PrecioSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar pedido
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/precios/PrecioForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar pedido
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/precios/PrecioMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver pedido
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/precios/PrecioMant.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagPrePdf.php";
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
?>  
   <center>
   <h3>RESULTADO DE LA BUSQUEDA DE PRECIOS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
     
  if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
		     <td>Nº</td>
             <td>FECHA</td>
		 	 <td>RAZON SOCIAL</td>
			 <td>PRODUCTO</td>
			 <td>MONEDA</td>
			 <td>PRECIO</td>
			 <td>MODI</td>
			 <td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			while($row=mysql_fetch_array($resultados)){
				$id=$row["id_pre"];
				$mensaje="";//$row['mem_pedido'];
				
		    	printf("<tr align='center' bgcolor='#FFFFFF'>
							<td>".$row["id_pre"]."</td>
					   		<td>".$row["fec_pre"]."</td>
			    			<td>".$row["raz_cli"]."</td>
							<td>".$row["des_mer"]."</td>
							<td>".$row["moneda_pre"]."</td>
				        	<td>".$row["val_pre"]."</td>
					    	<td><input type='image' src='../../iconos/Editmini.png' border=0
											 title='CAMBIAR EL PRECIO' onclick=ver(2,$id);></td>
							<td><input type='image' src='../../iconos/monitorMINI.png' border=0
											 title='VER FICHA DEL PRECIO  MENSAJE:".$mensaje." ' onclick=ver(4,$id);></td>
						</tr>");

			}  ?>
			<tr><td></td></tr>
			<tr><td colspan="8"><?php echo $criterio;?></td></tr>
		
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
	   </form >
	   <?php
   }else{
	   echo("NO HAY PRECIOS REGISTRADOS CON ESTE CRITERIO");
   }
	Desconecta($link);
    if($total_registros){
		echo "<center>";
		$desde = $pagina;
		$hasta = $pagina+$indicepag;
		
		if(($pagina-$indicepag)<0){
			$desde =1;
		}else{
			$desde = $pagina-$indicepag;
		}
		
		if($pagina > $indicepag){
			echo "<a href='SeekPag.php?pagina=".($desde)."'>< Anterior</a> ";
		}
		if($hasta>$total_paginas){
			$hasta=$total_paginas;
		}
		for ($i=$desde; $i<=$hasta; $i++){ 
			if ($pagina == $i){
				echo "<b>".$pagina."</b> "; 
			} else {
				echo "<a href='SeekPag.php?pagina=$i'>$i</a> "; 
			}	
		}
		if(($i + 1)<=$total_paginas){
			echo " <a href='SeekPag.php?pagina=".($i)."'>Siguiente ></a>";
		}
		echo "</center>";
		echo "<BR>"."<center>"."PARA VER EL PRECIO DAR CLICK SOBRE EL ICONO A UN LADO ".
								"<img src='../../iconos/monitorMINI.png' border='0'/>"."</center"."</BR>";
	}
	 
      ?>
    </center>
  </body>
</html>