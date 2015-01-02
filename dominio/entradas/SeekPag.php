<?php 
include("../../estilos/Estilo_page.php");
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
				document.forms["formbusqueda"].action="../../interface/entradas/EntradaSeek.php"; 
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/entradas/EntradaForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/entradas/EntradaMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/entradas/EntradaForm.php";
				break;
		
			case 6 :
				document.forms["formbusqueda"].modo.value=6;   //ver salidas de mercaderia x articulo +cliente
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagEntPdf.php";
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
  
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
?> <div id="tablaresultado">
      <h3>RESULTADO DE LA BUSQUEDA DE ENTRADAS <img src="../../iconos/Search.png" border="0"/></h3>
<?php
     
  if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>FECHA</td>
		 	 <td>DESCRIPCION</td>
			 <td>CANTIDAD</td>
		 	 <td>UNIDAD</td>
			 <td>CATEGORIA</td>
			 <td>TIPO</td>
			 <?php  
		    if($perfil!="C"){  ?>	 
			 <td>MOD</td>
			 <td>DEL</td>
			 <td>VER</td>
			 
			<?php 
			}  ?>
			 <td></td>
          </tr>
			<form name="formbusqueda" method="post" action=""   >
				<input type="hidden" name="modo"/>
				<input type="hidden" name="id"/>
  		    <?php
  		    while($row=mysql_fetch_array($resultados)){
				$id=$row["id_stock"];
				$tipo=$row["tip_stock"];
				if($tipo=="E"){
					$mostrar="EGRESO";
				}elseif($tipo=="I"){
					$mostrar="INGRESO";
				}else{
					$mostrar="CONSUMO";
				}
				//if($tipo=="E" || $tipo=="I"){
					printf("<tr align='center' bgcolor='#FFFFFF'>
								<td>".$row["fec_stock"]."</td>
								<td>".$row["des_insumo"]."</td>
								<td>".$row["cant_stock"]."</td>
								<td>".$row["uni_insumo"]."</td>
								<td>".$row["cat_insumo"]."</td>
								<td>".$mostrar."</td>
					");
					if($perfil!="C"){				
						printf("<td><input type='image' src='../../iconos/Editmini.png'
											  title='MODIFICAR FICHA DE ENTRADA' border=0
												 onclick=ver(2,$id);></td>
								 <td><input type='image' src='../../iconos/Deletep.png'
											 title='ELIMINAR ENTRADA'	border=0
												 onclick=ver(3,$id);></td>				 
								<td><input type='image' src='../../iconos/monitorMINI.png' 
											 title='VER ENTRADA' border=0
												 onclick=ver(4,$id);></td></tr>");
					}
				// }
			}?>	
		</table>
		<input type="button" value="NUEVA BUSQUEDA" onClick='ver(0,0)'/>
		<input type="button" value="VERSION IMPRESA" onClick='ver(6,0)'/>
	   </form >
	   <?php
   }else{
	   echo("NO HAY ENTRADAS REGISTRADOS CON ESTE CRITERIO");
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