<?php 
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
$sql=$_SESSION['ses_sql'];
 if(isset($_SESSION['ses_perfil'])){
	$perfiles=$_SESSION["ses_perfil"]; // datos del usuario
	$perfil=$perfiles[0]; //perfil
	$nombre=$perfiles[2]; //nombre
 }
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoSeek.php";  // nueva busqueda
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            // modificar
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            // eliminar
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoForm.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            // ver 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/movimientos/MovimientoForm.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=4;            // pdf
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagPdf3.php";
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
  	$inicio=0; 
    $pagina=1;
  } 
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
    
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?><center>
   <h3>RESULTADO DE LA BUSQUEDA DE PAGOS A PROVEEDORES<img src="../../iconos/Search.png" border="0"/></h3>
<?php 
  if($total_registros>0){	?>
  		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td><td>RAZON SOCIAL</td><td>NºDOCUMENTO</td><td>PESOS</td><td>DOLARES</td>
		 	 <td>MOD</td><td>DEL</td><TD>VER</TD>
		  </tr>
			<form name="formbusqueda" method="post" action=""  >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			$totalP =  $totalD = $reciboP = $reciboD = 0; 
			while($row=mysql_fetch_array($resultados)){
				$id = $row['cod_mov'];	$moneda = $row['mon_mov'];
				if($moneda=="Peso"){
					$reciboP = $row['val_mov'];
					$totalP = $totalP + $reciboP;
					$rP = number_format($reciboP,2);
					$rD = " ";
				}elseif($moneda=="Dolar"){
					$reciboD = $row['val_mov'];
					$totalD = $totalD + $reciboD;
					$rD = number_format($reciboD,2);
					$rP = " ";
				}
				if($nombre=="Alejandro"){
					printf("<tr align='center' bgcolor='#FFFFFF'>
								<td>".$row["fec_mov"]."</td>
								<td>".$row["raz_pro"]."</td>
								<td>".$row["num_mov"]."</td>
								<td>".$rP."</td>
								<td>".$rD."</td>
								<td><input type='image' src='../../iconos/Editmini.png' border=0
												 title='MODIFICAR MOVIMIENTO' onclick=ver(2,$id);></td>
								<td><input type='image' src='../../iconos/Deletep.png' border=0
												 title='ELIMINAR MOVIMIENTO' onclick=ver(3,$id);></td>
								<td><input type='image' src='../../iconos/monitorMINI.png' border=0
												 title='VER FICHA DEL MOVIMIENTO' onclick=ver(4,$id);></td>				 
							</tr>");
				}else{
					printf("<tr align='center' bgcolor='#FFFFFF'>
								<td>".$row["fec_mov"]."</td>
								<td>".$row["raz_pro"]."</td>
								<td>".$row["num_mov"]."</td>
								<td>".$rP."</td>
								<td>".$rD."</td>
								<td></td>
								<td></td>
								<td><input type='image' src='../../iconos/monitorMINI.png' border=0
												 title='VER FICHA DEL MOVIMIENTO' onclick=ver(4,$id);></td>				 
							</tr>");
                }				
							
			}  ?>
			<tr><td></td></tr>
			<tr style="text-align:center" bgcolor="#FFFFFF">
				<td >PESOS  </td><td colspan=2>Total pagado :</td>
				<td colspan=5><?php echo number_format($totalP,2);?></td>
				
			</tr>
			<tr style="text-align:center" bgcolor="#FFFFFF">
			    <td>DOLARES</td><td colspan=2>Total pagado :</td>
				<td colspan=5><?php echo number_format($totalD,2) ;?></td>
				
			</tr>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
	   </form>
	   <?php
    }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
    }
    Desconecta($link);?>
	<div id="paginador">
		<?php
			$paginar= new Paginador($total_paginas,5,"SeekPag3.php",$pagina);
			$mostrar=$paginar->Armado();
			echo $mostrar;
        ?>	
	</div> 
   </center>
  </body>
</html>