<?php
include_once("../../dominio/carrito/CarritoClass.php");
include_once("../../dominio/Persistencia.php");
include_once("../../dominio/pedidos/PedidoClass.php");
include("../../estilos/Estilo_page.php");
//carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfiles=$_SESSION["ses_perfil"];    
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");	exit();
}
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript">
  		function cargarInfo(form,codmer,modo){
			//form.codmer.value=codmer;
			form.modo.value=modo;
			//alert(codmer);
			//alert(form.codmer.value);
			form.action="../../dominio/carrito/Dcarrito.php";
			var mensaje;
			if(modo==4){ // agregar linea al pedido
				if (form.codmer.value==""){        //validar seleccion de articulo
					alert("DEBE SELECCIONAR UN ARTICULO");
					form.codmer.focus();
				return;
				}
				var cantidad=form.numcant.value;    //validacion de la cantidad
				var isnum=esnumeroentero(form.numcant.value);
				if(cantidad<=0 || isnum==false || cantidad==""){ 
					 alert("La cantidad debe ser mayor a 0 y un numero entero"); 
					 form.numcant.focus();
					 return; 
				 }
								
			}else if(form.modo.value==3){ //eliminar
						form.codmer.value=codmer;		
			}else if(form.modo.value==1){ //confirmar el pedido
				
			}else if(form.modo.value==5){ //vaciar el carrito
				
			}else if(modo==6){ //salir al menu principal
			
			}else if(modo==7){ //borra el pedido completamente
			
			}else if(modo==8){ //imprimr el pedido en pantalla,generar un pdf.
					
			}else if(modo==9){ //toma la info de cliente y lineas para facturar
					form.action="../../interface/facturas/VerFactura.php";
			}				
			formVer.submit();  	
		}
		function confirmar(mensaje){
			var resp=confirm(mensaje);
			if (resp==true){
				formVer.submit();
			}
		}	
  </script>
 </head>
 <body>
    <h2 align="center"><?php echo "PEDIDO Nº ".$_SESSION['ses_pedido'] ;?></h2> 
	<?php
	$modo=" ";
	if($_GET){
		$modo=$_GET['modo'];  // si es 4 cargar pedido ya realizado
	}
	$idpedido=$_SESSION['ses_pedido'];
	if($_POST){
		$modo=$_POST['modo'];
		$idpedido=$_POST['id'];
	}
	//------------ BUSCA DATOS DEL CLIENTE 
	
	$sql="SELECT p.num_cli , p.id_pedido, p.fec_pedido, p.est_pedido, p.mem_pedido ,
				 c.num_cli, c.raz_cli
				 	 FROM pedido p ,cliente c
						WHERE p.num_cli=c.num_cli AND p.id_pedido=$idpedido" ;
	$link=Conecta();
	$res=mysql_query($sql,$link); 
	while($row=mysql_fetch_array($res)){
	    $numcli=$row['num_cli'];
		$razcli=$row['raz_cli'];
		$fecped=$row['fec_pedido'];
		$estado=$row['est_pedido'];
		$memo=$row['mem_pedido'];
	}
	Desconecta($link);
	//------------ BUSCA LINEAS DEL PEDIDO INGRESADO ANTERIORMENTE DE ESTE PEDIDO
	if($modo==4 || $modo==2 ){
		$sqllineas="SELECT l.id_pedido, l.id_pedidolinea, l.cod_mer, l.cant_pedido,
							m.cod_mer, m.des_mer, m.peso_mer 
							FROM pedidolinea l, mercaderia m
							WHERE l.cod_mer=m.cod_mer AND l.id_pedido=$idpedido";
		$link=Conecta();
		$reslinea=mysql_query($sqllineas,$link);
		$cantlin=mysql_num_rows($reslinea);
		if($cantlin>0){
			while($rowl=mysql_fetch_array($reslinea)){
				$idlinea=$rowl['id_pedidolinea'];
				$idpedido=$rowl['id_pedido'];
				$articulo=$rowl['des_mer'];
				$codmer=$rowl['cod_mer'];
				$cantidad=$rowl['cant_pedido'];
				$linea= new Linea($idlinea,$idpedido,$articulo,$codmer,$cantidad);  //ingresa nueva line
				$_SESSION['ses_carro']->agregar($linea);
			}	
		}
		Desconecta($link);
	}
	//------------ BUSCA SI FIGURAN PPEDIDOS PENDEINTES DE ESTE CLIENTE
	$fecentrega=" ";
	$fecfactura=" ";
	$tippedido=" ";
	$estadop=" ";
	//$mostrarpendientes=" ";
	//$pedidospendientes = new Pedido($idpedido ,$numcli ,$fecped ,$fecentrega ,$estadop ,$memo ,$fecfactura, $tippedido);
	//$estadop="PENDIENTE";
	//$cantidadpendientes=$pedidospendientes->PedidoPen($estadop)-1;
	/*if($cantidadpendientes==0){
		$mostrarpendientes="NO TIENE PEDIDOS PENDIENTES";
	}elseif($cantidadpendientes==1){
		$mostrarpendientes="EL CLIENTE TIENE ".$cantidadpendientes." PEDIDO PENDIENTE";
	}elseif($cantidadpendientes>=2){
		$mostrarpendientes="EL CLIENTE TIENE ".$cantidadpendientes." PEDIDOS PENDIENTES";
	}*/
	//------------ GENERA LA TABLA PARA LA VISTA DE LOS DATOS DEL CLIENTE
	?>
	<table align="center"  border="0"  width="50%" style="font-size:12px">
		<tr align="center">
			<td bgcolor="#FFA346">Cliente:</td><td><?php echo $razcli;?></td>
			<td bgcolor="#FFA346">Fecha :</td><td><?php echo $fecped;?></td>
		</tr>
		<tr align="center">
			<td bgcolor="#FFA346">estado:</td><td><?php echo $estado;?></td>
		    <td bgcolor="#FFA346">Comentario:</td><td><?php echo $memo;?></td>
		</tr>
	</table>
 	<form name="formVer"  method="post" >
	    <CENTER> 
		<?php
		$cantlineas=$_SESSION['ses_carro']->cantidadLineas();
		$cant_lin=0;
		if($cantlineas>0){
		    //------------------------------------GENERA LA TABLA DE LA VISTA DE LAS LINEAS
		    $listalineas=$_SESSION['ses_carro'];
			$total=0;
			print("<table align='center' width='50%' border='0'  bgcolor='#FF9900'  style='font-size:12px'>
					<tr align='center'><td>codigo</td><td>Articulo</td><td>Cantidad</td><td>Eliminar</td></tr>");
			$cant_lin=0;		
			for($i=0 ; $i < $cantlineas ; $i++){
				$idlinea=$listalineas->Devidlinea($i);
				if($idlinea!=0){
					$cant_lin++; 
					$codmer= $listalineas->Devcodmer($i);
					$articulo= $listalineas->Devarticulo($i);
					$cantidad= $listalineas->Devcantidad($i); 
					print("<tr align='center' bgcolor='#FFFFFF'><td>".$codmer."</td>
								<td>".$articulo."</td>
								<td>".$cantidad."</td>
								<td>"."<input type='image' src='../../iconos/delete_16.png' border='0'
												title='eliminar esta linea' 
												onclick='cargarInfo(this.form,$codmer,3)';>"."</td>
							</tr>");
				}
			}
			print("</table><br><font size='4px'>"."Cantidad de articulos : ".$cant_lin."</font>");		
		}else{
			print("No hay articulos en el carrito");
		}
		//print("<br><font size='3px'>".$mostrarpendientes."</font>");
		?>
		</CENTER>
		<?php
		//--------------------- GENERA LA TABLA PARA LA VISTA DE LOS ICONOS
		if($cant_lin>0){ ?>
           <TABLE align="center"  style="font-size:10px" width="50%">
             <tr align="center">
			   <td><?php if($perfil=="A" || $perfil=="P"){ ?>
			       <input type="image" src="../../iconos/number_29.png" border="0" 
			   					title="FACTURAR EL PEDIDO" onClick="cargarInfo(this.form,0,9)";> <?php } ?> </td>
			   <td><input type="image" src="../../iconos/buttoncheck_29.png" border="0" 
			   					title="CONFIRMA EL PEDIDO" onClick="cargarInfo(this.form,0,1)";></td>
			   <td><input type="image" src="../../iconos/printer_29.png" border="0" 
			   					title="IMPRIMIR PEDIDO" onClick="cargarInfo(this.form,0,8)";></td>				
			   <td><input type="image" src="../../iconos/bin_29.png"         border="0" 
			   						title="VACIA SOLO LAS LINEAS" onClick="cargarInfo(this.form,0,5)";></td>
	           <td></td>
			   <td><input type="image" src="../../iconos/delete_32.png"  border="0" 
			   						title="BORRA TODO EL PEDIDO" onClick="cargarInfo(this.form,0,7)";></td>
			 </tr>
			 <tr align="center" style="font-size:10px" >
			   <td><?php if($perfil=="A" || $perfil=="P"){ ?>FACTURAR<?php } ?></td>
			   <td>CONFIRMAR</td><td>IMPRIMIR</td><td>VACIAR</td><td></td><td>ELIMNAR</td>
			 </tr>
           </TABLE> 
		<?php	
		}else{	?>
			<TABLE align="center" style="font-size:10px" width="50%">
              <tr align="center">
			    <td>
			    </td>
				<td>
					<input type="image" src="../../iconos/delete_32.png"  border="0" 
			   						title="BORRA TODO EL PEDIDO" onClick="cargarInfo(this.form,0,7)";>
				</td>
			 </tr>
			 <tr align="center"> 
			   <td> </td>
			   <td>ELIMINAR</td>
			 </tr>
           </TABLE> 
<?php	}	?>
	
	<TABLE border="0" width="50%" CELLSPACING="0"  CELLPADDING="0"  align="center" style="font-size:12px">
	  <tr>
	      <td align="center">Articulo</td>
	      <td align="center">Cantidad</td>
		</tr><tr>
		<td align="center"><?php
			$ssql="SELECT cod_mer, des_mer FROM mercaderia  WHERE 1=1 ORDER BY des_mer asc";
			$link=Conecta();
			echo "<select name='codmer' title='Seleccione un articulo desplegando la lista'>";
			   echo "<option value='' selected='selected'>sin seleccionar</option>";
			   $resul=mysql_query($ssql,$link); 
				while ($fila=mysql_fetch_row($resul)){ 
					if ($fila[0]==$row['des_mer']){
						echo "<option selected value='$fila[0]'>$fila[1]";	
					}else{ 
						echo "<option value='$fila[0]'>$fila[1]";	
					} 
				} 
				echo "</select>";
				Desconecta($link); ?>
		</td>
		<td align="center"><input type="text" name="numcant" alt="numcant"  size="8" maxlength="8" 
					 title="Ingrese cantidad del articulo" onKeyPress="return permite(event,'num')"/>
		</td>
            <input type="hidden" NAME="modo" />
	    <td><input type="button" value="AGREGAR" border="0" align="absmiddle" 
					title="agregar el articulo seleccionado" onClick="cargarInfo(this.form,0,4)";/>
		</td>
	  </tr>
	  <tr>
	    <td></td>
	    <td align="left"><?php echo $_SESSION["ses_error"];?></td>
	  </tr>
	  </form>
    </TABLE >
  </body>
</html>