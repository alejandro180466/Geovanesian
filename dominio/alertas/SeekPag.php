<?php	include("../../interface/documentos/DocumentoIndex.php");
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
				document.forms["formbusqueda"].action="../../interface/alertas/AlertaSeek.php";  // nueva busqueda
				break;
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/alertas/AlertaForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/alertas/AlertaMant.php";
				break;
			case 6 :
				document.forms["formbusqueda"].modo.value=6;            //pdf
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/alertas/AlertaMant.php";
				break;
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
  $link=Conecta();                                  // en Persistencia.php 
  $registros =20;
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
  //-------------------------------------------------------  
?><div id="tablaresultado">
	<h3>RESULTADO DE LA BUSQUEDA DE ALERTAS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
	if($total_registros>0){	?>
 		<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="2" bgcolor="#FF9900" > 
			<tr align="center" >
				<td>VENCE</td><td>CONCEPTO</td><td>INGRESADO</td>
				<td>ESTADO</td><td>MODIF</td><td>BORRA</td>
			</tr>
			<form name="formbusqueda" method="post" >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			while($row=mysql_fetch_array($resultados)){
				$id=$row['alertas_id'];
				if ($row['estado']=="P"){
					$estado="PENDIENTE";		
				}elseif($row['estado']=="E"){
					$estado="EJECUTADO";
				}elseif($row['estado']=="C"){
					$estado="CANCELADO";
				}elseif($row['estado']==""){
					$estado="";
				}	
				printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row["vence"]."</td><td>".$row["concepto"]."</td>
				        	<td>".$row["hoy"]."</td><td>".$estado."</td>
				    		<td><input type='image' src='../../iconos/Editmini.png' border=0
											 title='MODIFICAR ' onclick=ver(2,$id);></td>
							<td><input type='image' src='../../iconos/Deletep.png' border=0
											 title='ELIMINAR ' onclick=ver(3,$id);></td>
						</tr>");
			}
			Desconecta($link);	?>
			<tr><td></td></tr>
			<tr><td colspan="8" bgcolor='#FFFFFF'><?php echo $criterio;?></td></tr>
		</table>
        <?php
	}else{
	   echo("NO HAY ALERTAS CON ESTE CRITERIO");
	} ?>
   	</form>	 
		<div id="paginador">
			<?php	$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
					$mostrar=$paginar->Armado();		echo $mostrar;			?>
		</div>
	</div>
  </body>
</html>