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
			case 0 :													 // nueva 
				document.forms["formbusqueda"].action="../../interface/formulates/FormulateSeek.php"; 
				break
			case 2 :
				document.forms["formbusqueda"].modo.value=2;            //modificar 
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/formulates/FormulateForm.php";
				break;
			case 3 :
				document.forms["formbusqueda"].modo.value=3;            //eliminar
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/formulates/FormulateMant.php";
				break;
			case 4 :
				document.forms["formbusqueda"].modo.value=4;            //ver
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../interface/formulates/FormulateForm.php";
				break;
			case 6 :
				document.forms["formbusqueda"].modo.value=6;   //ver salidas de mercaderia x articulo +cliente
				document.forms["formbusqueda"].id.value=id;
				document.forms["formbusqueda"].action="../../dominio/pdf/SeekPagFormulatePdf.php";
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
?>  
   <center>
   <h3>RESULTADO DE LA BUSQUEDA DE FORMULAS<img src="../../iconos/Search.png" border="0"/></h3>
<?php
    if($total_registros>0){	?>
 		<TABLE style="font-size:12px" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor="#FF9900" > 
		  <tr align="center" >
             <td>CANTIDAD</td><td>UNIDAD</td><td>DESCRIPCION</td><td>CATEGORIA</td>
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
			$totalingredientes=$totalkg=$contador=0;
			while($row=mysql_fetch_array($result)){
				if($contador==0 || $ingrediente!=$row["id_insumo"] ){
					$totalingredientes++;
					$totalkg=$totalkg+$row["cant_partida"];
					$id=$row["id_partida"];
					printf("<tr align='center' bgcolor='#FFFFFF'>
								<td>".$row["cant_partida"]."</td>
								<td>".$row["uni_insumo"]."</td>
								<td>".$row["des_insumo"]."</td>
								<td>".$row["cat_insumo"]."</td>
								");
							if($perfil!="C"){				
								printf("<td><input type='image' src='../../iconos/Editmini.png'
												title='MODIFICAR ' border=0	  onclick=ver(2,$id);></td>
										<td><input type='image' src='../../iconos/Deletep.png' border=0
												title='ELIMINAR ' onclick=ver(3,$id);></td>			
										<td><input type='image' src='../../iconos/monitorMINI.png' 
													title='VER ' border=0	onclick=ver(4,$id);></td>");
							}							 
				} 
				$contador++;
				$ingrediente=$row["id_insumo"]; 
			} 
		 ?>
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
    </center>
  </body>
</html>