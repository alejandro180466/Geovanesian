<?php 
include("../../estilos/Estilo_page.php");
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
				document.forms["formbusqueda"].action="../../interface/ventas/VentaSeek_C.php";  // nueva busqueda
				break
			
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/ventas/VentaIndex.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;            //generar PDF
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagVentaArtPdf.php";
				break;	
				
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
    $link=Conecta();  // en Persistencia.php 
   $registros = 9;
  
  if(isset($_GET['pagina'])){
	$pagina=$_GET['pagina'];
	$inicio=($pagina - 1)*$registros;
  }else{
  	$inicio=0; 
    $pagina=1;
  }
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  $totalunidades=0;   
  $totalkg=0;
  	while($row=mysql_fetch_array($result)){
		$id=$row['id_fac'];	$nulfac=$row['nul_fac'];	$tipdoc=$row['tip_fac'];
		if($tipdoc=="FACTURA CREDITO" || $tipdoc=="FACTURA CONTADO"){ //CONTROLA TIPO DE DOCUMENTO
			$kglinea = $row['cant_lin']* $row['peso_mer'];
			$totalkg = $totalkg + $kglinea;	
			$totalunidades = $totalunidades + $row['cant_lin'];
		}elseif($tipdoc=="DEVOLUCION CONTADO" || $tipdoc=="NOTA DE CREDITO"){
			$kglinea = $row['cant_lin']* $row['peso_mer']*(-1);
			$totalkg = $totalkg + $kglinea;	
			$totalunidades = $totalunidades - $row['cant_lin'];
		}
	} 
	$sql.=" LIMIT $inicio , $registros";
	$resultados=ejecutarConsulta($sql,$link);	
	Desconecta($link);
	$total_paginas = ceil($total_registros / $registros); 	
	//-------------------------------------------------------  ?>  
   <div id="tablaresultado">
	<h3>RESULTADO BUSQUEDA DE VENTAS POR ARTICULO<img src="../../iconos/Search.png" border="0"/></h3>
  <?php
  if($total_registros>0){	?>
  		<form name="formbusqueda" method="post" action="">
				<input type="hidden" name="modo">
				<input type="hidden" name="id"> 
		<?php		
 		print("<TABLE style='font-size:12px' BORDER='0' CELLSPACING='2' CELLPADDING='2' bgcolor='#FF9900' > 
		    <tr align='center'  style='font-size:10px'>
              <td>FECHA</td><td>TIPO DOCUMENTO</td><td>NUMERO</td><td>CATEGORIA</td><td>ARTICULO</td>
			  <td>ENVASE</td><td>UNIDADES</td><td>KG</td><td>VER</td>
            </tr>");
		while($row=mysql_fetch_array($resultados)){
			$id=$row['id_fac'];	$nulfac=$row['nul_fac'];	$tipdoc=$row['tip_fac'];
			if($tipdoc=="FACTURA CREDITO" || $tipdoc=="FACTURA CONTADO"){ //CONTROLA TIPO DE DOCUMENTO
				$kglinea = $row['cant_lin']* $row['peso_mer'];
			}elseif($tipdoc=="DEVOLUCION CONTADO" || $tipdoc=="NOTA DE CREDITO"){
				$kglinea = $row['cant_lin']* $row['peso_mer']*(-1);
			}
			// genera vinculo con el pdf de la factura
			$fname=$row['num_fac'];
			$nulfac=$row['nul_fac'];
			$existepdf=is_file('../../../copiaspdf/facturaspdf/'.$fname.'.pdf');
			if ($existepdf){
				$ruta="../../../copiaspdf/facturaspdf/".$fname.".pdf";
				$link="<a href=".$ruta."><IMG src='../../iconos/monitorMINI.png' border=0
											   title='VER FACTURA en formato PDF'</a>";
			}else{
				$ruta ="";
				$link="SIN PDF";
			} 
			// imprime la linea
			print("<tr align='center' bgcolor='#FFFFFF' >
						<td>".$row["fec_fac"]."</td>
						<td>".$row["tip_fac"]."</td>
						<td>".$row["ser_fac"]." ".$row["num_fac"]."</td>
						<td>".$row["cat_mer"]."</td>
						<td>".$row["des_mer"]."</td>
						<td>".$row["uni_mer"]."</td>
						<td>".$row["cant_lin"]."</td>
						<td>".$kglinea."</td>
						<td>".$link."</td>
					</tr>");
	}
	print("<tr bgcolor='#FFFFFF'><td colspan='11'><hr></hr></td></tr>  
		   <tr style='text-align:center' bgcolor='#FFFFFF'>
				<td colspan='2' align='right'>Total unidades:</td>
				<td>".$totalunidades."</td>
				<td colspan='2' align='right'>Total kg:</td>
				<td>".$totalkg."</td>
				<td colspan='4' align='left'></td>
			</tr>
		</table>"); ?>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'>
		<input type="button" value="VERSION IMPRESA" onClick='ver(5,0)'>
	   </form >  
	   <?php
   }else{
	   echo("NO HAY VENTAS REGISTRADOS CON ESTE CRITERIO");
   }	 ?>
	<div id="paginador">
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag_C.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
        ?>
	</div>	
   </div>
  </body>
</html>