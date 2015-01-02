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
			case 0 :													 // nueva busqueda
				document.forms["formbusqueda"].action="../../interface/clientes/ClienteSeek.php"; 
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/clientes/ClienteForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/clientes/ClienteMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/clientes/ClienteForm.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;            //ver pdf
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagCliPdf.php";
				break;
		}
	    document.forms["formbusqueda"].submit();
	}
 	</script>
 </head>
 <body>
<?php 
   $link=Conecta();    $registros = 12;
   
  if(isset($_GET['pagina'])){
	$pagina=$_GET['pagina'];
	$inicio=($pagina - 1)*$registros;
  }else{
  	$inicio=0;    $pagina=1;
  }
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?><div id="tablaresultado">  
    <h3>RESULTADO DE LA BUSQUEDA DE CLIENTES<img src="../../iconos/Search.png" border="0"/></h3>
<?php
    if($total_registros>0){	?>
 		<TABLE  BORDER="0" CELLSPACING="0" CELLPADDING="1" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>RAZON SOCIAL</td><td>TELEFONO</td><td>MOVIL</td>
		 	 <td>CONTACTO</td><td>MOD</td><td>DEL</td><td>VER</td>
          </tr>
			<form name="formbusqueda" method="post" action=""  >
				<input type="hidden" name="modo">
				<input type="hidden" name="id">
  		    <?php
  		    while($row=mysql_fetch_array($resultados)){
				$id=$row['num_cli'];
  		    	printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row["raz_cli"]."</td>
							<td>".$row["tel_cli"]."</td>
							<td>".$row["cel_cli"]."</td>
					    	<td>".$row["cont_cli"]."</td>
				    		<td><input type='image' src='../../iconos/Editmini.png'
									     title='MODIFICAR FICHA DEL CLIENTE' border=0
										 	 onclick=ver(2,$id);></td>
							<td><input type='image' src='../../iconos/Deletep.png'
									     title='ELIMINAR CLIENTE' border=0
										 	 onclick=ver(3,$id);></td>
						  	<td><input type='image' src='../../iconos/monitorMINI.png' 
										 title='VER FICHA DEL CLIENTE' border=0
										     onclick=ver(4,$id);></td>
						</tr>");
			}
			Desconecta($link);?>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION PARA IMPRIMIR" onclick='ver(5,0)' />
	   </form >
	   <?php
   }else{
	   echo("NO HAY CLIENTES REGISTRADOS CON ESTE CRITERIO");
   }
    ?>
    <div id="paginador">
		<?php	$paginar= new Paginador($total_paginas,5,"SeekPag.php",$pagina);
				$mostrar=$paginar->Armado();		echo $mostrar;        ?>
	</div>
   </div>
  </body>
</html>