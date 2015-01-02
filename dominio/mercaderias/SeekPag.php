<?php	include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/PaginadorClass.php");
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
$sql=$_SESSION['ses_sql'];
?>
<html>
 <head>
  <script>
  	function ver(op,id){
		switch(op){
			case 0 :													 // nueva busqueda
				document.forms["formbusqueda"].action="../../interface/mercaderias/MercaderiaSeek.php"; 
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar proveedor
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/mercaderias/MercaderiaForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar proveedor
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/mercaderias/MercaderiaMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver proveedor
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/mercaderias/MercaderiaForm.php";
				break;
			case 5 :
				document.forms["formbusqueda"].modo.value=5;   //ver salidas de mercaderia x articulo +cliente
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/mercaderias/MantSeek2.php";
				break;
			case 6 :
				document.forms["formbusqueda"].modo.value=6;   //ver salidas de mercaderia x articulo +cliente
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagMerPdf.php";
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
  //------------------------------------------------------- ?> 
  <div id="tablaresultado"> 
    <h3>RESULTADO DE LA BUSQUEDA DE MERCADERIAS<img src="../../iconos/Search.png" border="0"/></h3>
    <?php
    if($total_registros>0){	?>
 		<TABLE BORDER="0" CELLSPACING="0" CELLPADDING="0 " bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>DESCRIPCION</td><td>UNIDAD</td><td>Codigo ID</td>
			 <td>DISPONIBLE</td><td>MINIMO</td><td>NIVEL</td>
			<?php  
		    if($perfil!="C"){  ?>	 
			 <td>MOD</td><td>VER</td>
			<?php 
			}  ?>
			<td></td>
          </tr>
			<form name="formbusqueda" method="post" action=""   >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
			while($row=mysql_fetch_array($resultados)){
				$stock= $prod= $ped= $stockbajo= $preparado= $facturado= $entregado=0;
				$mostrar="";
				$id=$row['cod_mer'];
				$fechareset=$row['fecha_mer']; //fecha de reset
				$stockini=$row['stock_mer'];
         		$minmer=$row['min_mer'];
				//------------------------------ busqueda de las producciones
				$sqlprod="select cod_mer, can_prod, fec_prod from produccion where cod_mer=$id";
				$produc=mysql_query($sqlprod,$link);
				if (mysql_num_rows($produc)>0){
					while($rowp=mysql_fetch_array($produc)){
						$fechaprod=$rowp['fec_prod'];
					   if($fechaprod>=$fechareset){  //toma solo producciones posteriores al reset
						   $prod=$prod+$rowp['can_prod'];
					   }	   
				    }
				}
				//------------------------------ busqueda de los pedidos recibidos
				$sqlped="SELECT l.cod_mer, l.cant_pedido, l.id_pedido , p.id_pedido , p.fec_pedido , p.est_pedido
									FROM pedidolinea l, pedido p
										WHERE l.id_pedido=p.id_pedido
										  AND l.cod_mer = '$id'
										  AND p.fec_pedido >= '$fechareset'";
				$pedidos=mysql_query($sqlped,$link);
				if(mysql_num_rows($pedidos)>0){
					while($rowped=mysql_fetch_array($pedidos)){
					    $fechapedido=$rowped['fec_pedido'];
					    if($fechapedido>=$fechareset){  //toma solo pedidos posteriores al reset 
						   $ped=$ped+$rowped['cant_pedido'];
						   if($rowped['est_pedido']=="PREPARADO"){
						 	    $preparado=$preparado+$rowped['cant_pedido'];
						   }
						   if($rowped['est_pedido']=="FACTURADO"){
								$facturado=$facturado+$rowped['cant_pedido'];
						   }
						   if($rowped['est_pedido']=="ENTREGADO"){
								$entregado=$entregado+$rowped['cant_pedido'];
						   }
						}	
				    }
				}
				//------------------------------ despliegue de los datos de la mercaderia
				$stock=$stockini+$prod-$entregado-$facturado;           //$ped;
				$disponible=$stock-$preparado;
				$mostrar="EN DEPOSITO => DISPONIBLE : ".$disponible ." PREPARADO : ".$preparado." "." FACTURADO : ".$facturado;
				$stockbajo=$stock-$minmer;
				$mensaje ="";
				if($stockbajo<0){
					$mensaje="MUY BAJO";
				}elseif($stockbajo==0 || $stockbajo<5){
					$mensaje="BAJO";
				}elseif($stockbajo>=5){
				   if($stockbajo>=20){
				   	 $mensaje="BUENO";	
				   }else{
					 $mensaje="NORMAL";
				   }	
				}
				printf("<tr align='center' bgcolor='#FFFFFF'>
					   		<td>".$row["des_mer"]."</td>
			    			<td>".$row["uni_mer"]."</td>
					    	<td>".$row["peso_mer"]."</td>
					    	<td title='".$mostrar."'>".$stock."</td>
							<td title='STOCK MINIMO SUGERIDO SEGUN EL ARTICULO'>".$minmer."</td>
							<td title='CALIFICA EL NIVEL DE STOCK'>".$mensaje."</td>");
				if($perfil!="C"){				
					printf("<td><input type='image' src='../../iconos/Editmini.png'
									  title='MODIFICAR FICHA DE MERCADERIA' border=0
									 	 onclick=ver(2,$id);></td>
						<td><input type='image' src='../../iconos/monitorMINI.png' 
									 title='VER MERCADERIA' border=0
									     onclick=ver(4,$id);></td>");
			    }							 
				printf("<td><input type='image' src='../../iconos/delivery_30.png' 
								 title='TODOS LOS PEDIDOS DE ESTE ARTICULO' border=0
									     onclick=ver(5,$id);></td>
						</tr>");
			}  ?>
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION IMPRESA" onClick='ver(6,0)'/>
	   </form >
	   <?php
   }else{
	   echo("NO HAY MERCADERIAS REGISTRADOS CON ESTE CRITERIO");
   }
   Desconecta($link); ?> 
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