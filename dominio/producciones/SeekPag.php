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
				document.forms["formbusqueda"].action="../../interface/producciones/ProduccionSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modi
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/producciones/ProduccionForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //delete
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/producciones/ProduccionMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/producciones/ProduccionMant.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;            //ver aviso
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagProdPdf.php";
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
  $totallotes=$totalunidades=$totalkg=0;
  
  while($row=mysql_fetch_array($result)){
  		$totallotes = $totallotes + $row['lot_prod'];
		$totalunidades = $totalunidades + $row['can_prod'];
		$kglinea = $row['can_prod']* $row['peso_mer'];
		$totalkg = $totalkg + $kglinea;	
  } 
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  Desconecta($link);
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?><div id="tablaresultado">
	<h3>RESULTADO BUSQUEDA DE ENTRADAS<img src="../../iconos/Search.png" border="0"/></h3>
  <?php
  if($total_registros>0){	?>
  		<form name="formbusqueda" method="post" action="">
			<input type="hidden" name="modo">
			<input type="hidden" name="id"> 
		<?php		
 		print("<TABLE style='font-size:12px' BORDER='0' CELLSPACING='0' CELLPADDING='1' bgcolor='#FF9900' > 
		    <tr align='center'  style='font-size:10px'>
              <td>FECHA</td>
			  <td>ARTICULO</td>
			  <td>UNIDAD</td>
			  <td>CANTIDAD</Td>
			  <td>MOD</td>
			  <td>DEL</td>
			</tr>");
		while($row=mysql_fetch_array($resultados)){
			$id=$row['num_prod'];
			print("<tr align='center' bgcolor='#FFFFFF' >
				   		<td>".$row["fec_prod"]."</td>
			   		   	<td>".$row["des_mer"]."</td>
						<td>".$row["uni_mer"]."</td>
				    	<td>".$row["can_prod"]."</td>
			    		<td><input type='image' src='../../iconos/Editmini.png' border='0'
											 title='MODIFICAR ENTRADA'
											 onclick='ver(2,$id)'></td>
						<td><input type='image' src='../../iconos/Deletep.png' border='0'
											 title='ELIMINAR ENTRADA'
											 onclick='ver(3,$id)'></td>
					</tr>");
		}  
		print("<tr bgcolor='#FFFFFF'><td colspan='11'><hr></hr></td></tr>  
				<tr style='text-align:center' bgcolor='#FFFFFF'>
					<td colspan='1'></td>
					<td></td>
					<td colspan='2' align='right'>Totales:</td>
					<td>".$totalunidades."</td>
					<td colspan='2' align='center'></td>
				</tr>
			</table>"); ?>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'>
		<input type="button" value="VERSION IMPRESA" onClick='ver(5,0)'>
	   </form >  
	   <?php
   }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
   } ?>
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