<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include('../../dominio/pdf/class.ezpdf.php');
if(!isset($_SESSION)){ 
    session_start(); 
}
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
				document.forms["formbusqueda"].action="../../interface/producciones/ProduccionForm.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/producciones/ProduccionForm.php";
				break;
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
  $link=Conecta();                                  // en Persistencia.php 
  $registros =9;
  if (!$pagina){ 
    $inicio=0; 
    $pagina=1; 
  }else { 
    $inicio=($pagina - 1)*$registros; 
  }
 
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
 
  $totallotes=0;
  $totalunidades=0;   
  $totalkg=0;
  
  while($row=mysql_fetch_array($result)){
  		$totallotes = $totallotes + $row['lot_prod'];
		$totalunidades = $totalunidades + $row['can_prod'];
		$kglinea = $row['can_prod']* $row['peso_mer'];
		$totalkg = $totalkg + $kglinea;	
			
  } 
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?>  
   <center>
   <h3>RESULTADO BUSQUEDA DE PRODUCCCIONES<img src="../../iconos/Search.png" border="0"/></h3>
  <?php
  if($total_registros>0){
     $pdf =& new Cezpdf('a4');
	 $pdf->selectFont('../../dominio/pdf/fonts/courier.afm');
	
     $pdf->ezText("Ejemplo de inclusión de imagenes en pdf\n\n",10);
   	 ?>
  	 <form name="formbusqueda" method="post" action="">
				<input type="hidden" name="modo">
				<input type="hidden" name="id"> 
	 <?php		
 	 $pdf->ezText("<TABLE style='font-size:12px' BORDER='0' CELLSPACING='0' CELLPADDING='1' bgcolor='#FF9900' > 
		    <tr align='center'  style='font-size:10px'>
              <td>FECHA</td>
		 	  <td>CATEGORIA</td>
			  <td>LOTES</td>
			  <td>ARTICULO</td>
			  <td>ENVASE</td>
			  <td>UNIDADES</td>
		 	  <td>KG</td>
			 </tr>");
		
			while($row=mysql_fetch_array($resultados)){
				$id=$row['num_prod'];
				$kg=$row['can_prod']*$row['peso_mer'];
		    	$pdf->ezText("<tr align='center' bgcolor='#FFFFFF' >
						   		<td>".$row["fec_prod"]."</td>
			    				<td>".$row["cat_mer"]."</td>
								<td>".$row["lot_prod"]."</td>
				   		     	<td>".$row["des_mer"]."</td>
								<td>".$row["uni_mer"]."</td>
					    		<td>".$row["can_prod"]."</td>
				   		 		<td>".$kg."</td>
							  </tr>");
			}  
			$pdf->ezText("<tr bgcolor='#FFFFFF'><td colspan='10'><hr></hr></td></tr>  
				<tr style='text-align:center' bgcolor='#FFFFFF'>
					<td colspan='2'>Total lotes :</td>
					<td>".$totallotes."</td>
					<td colspan='2' align='right'>Totales:</td>
					<td>".$totalunidades."</td>
					<td>".$totalkg."</td>
					<td colspan='3' align='left'>kg</td>
				</tr>
			</table>"); ?>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'>
	   </form >  
	   <?php
	   $pdf->ezStream();
   }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
   }
	//FreeResp($result);
	if($total_registros){
		echo "<center>";
		if(($pagina - 1) > 0){
			echo "<a href='SeekPag.php?pagina=".($pagina-1)."'>< Anterior</a> ";
		}
		for ($i=1; $i<=$total_paginas; $i++){ 
			if ($pagina == $i){
				echo "<b>".$pagina."</b> "; 
			} else {
				echo "<a href='SeekPag.php?pagina=$i'>$i</a> "; 
			}	
		}
		if(($pagina + 1)<=$total_paginas){
			echo " <a href='SeekPag.php?pagina=".($pagina+1)."'>Siguiente ></a>";
		}
		echo "</center>";
		echo "<BR>"."<center>"."PARA VER EL MOVIMIENTO DAR CLICK SOBRE EL ICONO ".
								"<img src='../../iconos/monitorMINI.png' border='0'/>"."</center"."</BR>";
		echo "<a href='../../dominio/producciones/PagImp.php'>IMPRIMIR</a> "; 					
	}
	Desconecta($link); 
    include("../../estilos/Estilo_pie.php");  ?>
    </center>
  </body>
</html>
