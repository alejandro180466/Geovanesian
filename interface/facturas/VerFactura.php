<?php 
include_once("../../dominio/carrito/CarritoClass.php");
include_once("../../dominio/Persistencia.php");
include_once("../../dominio/facturas/FacturaClass.php");
include_once("../../dominio/facturas/CarroVentaClass.php");
if(!isset($_SESSION)){     session_start(); }
include_once("../../estilos/Estilo_page.php");
//carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfiles=$_SESSION["ses_perfil"];    
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){   	header("location:../../index.php");}?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript">
  		function cargarInfo(form,codmer,modo,cantidad,descuento){

			//form.codmer.value=codmer;
			form.modo.value=modo;
			form.action="../../dominio/facturas/DcarroVenta.php";
			var mensaje;
			var enviar=true;
			var doc=form.txttipdoc.value;
			if(doc=="" && (modo==1)){
					alert("Debe elegir de la lista tipo de documento");
					form.modo.value=4;
					form.txttipdoc.focus();
					var enviar=false;
					return;
			}
			if(modo==4 ||modo==42){ // agregar linea al pedido y a la factura
			   	if (form.codmer.value=="" && modo==4){        //validar seleccion de articulo
				    alert("DEBE SELECCIONAR UN ARTICULO");
					form.codmer.focus();
					return;
				}
				var cantidad=form.numcant.value;          //validacion de cantidad
				var isnum=esnumeroentero(form.numcant.value);
				if(cantidad<=0 || isnum==false || cantidad==""){ 
					 alert("La cantidad debe ser mayor a 0 y un numero entero"); 
					 form.numcant.focus();
					 return; 
				}
				var precio=form.numprec.value;
				if(precio<0 || precio==""){
					alert("Debe ingresar numeros positivos");
					form.numprec.focus();
					return;
				}
			}else if(modo==2){                //modificar descuento en la linea
						alert("SE INGRESARA EL DESCUENTO");
						form.descuento.value=descuento;
						form.codmer.value=codmer;
								
			}else if(modo==3){                //eliminar la linea en el pedido y en la factura
						alert("SE ELIMINARA LA LINEA SELECCIONADA");
						form.codmer.value=codmer;
						
			}else if(modo==1){ //confirmar el pedido y la factura
					
			}else if(modo==5){ //vaciar el carrito
						
			}else if(modo==6){ //volver al pedido
			}else if(modo==7){ //borra el pedido completamente
			}else if(modo==81){ //imprimr el pedido en pantalla,generar un pdf.
					form.action="../../dominio/pdf/pdfpedido.php";
			}else if(modo==82){ //imprimir la factura en pantalla, generar un pdf.
					form.action="../../dominio/pdf/pdffactura.php";
			}else if(modo==83){
			
			}
			
            if(enviar=true){formVer.submit();}  	
		}
		function confirmar(mensaje){
			var resp=confirm(mensaje);
			if (resp==true){
				formVer.submit();
			}else{
				return;
			}
		}	
  </script>
 </head>
 <body>
    <?php 
	if (isset($_SESSION['ses_tipdoc'])){  // asigna tipo de factura 
		$tipdoc=$_SESSION['ses_tipdoc'];
		$mostrar=$tipdoc;
	}else{
		$tipdoc="";
		$mostrar="ELEGIR DOCUMENTO";
	}
	if (isset($_SESSION['ses_memo'])){  // asigna observaciones de la factura 
		$memo=$_SESSION['ses_memo'];
		$mostrarmemo=$memo;
	}else{
		$memo="";
		$mostrarmemo="";
	}
	?>
  <div id="factura">
	<h2>VISTA DE FACTURA DE PEDIDO Nº<?php echo $_SESSION['ses_pedido'] ;?></h2> 
	<?php	
	if($_GET){
		$modo=$_GET['modo'];  // si es 4 cargar FACTURA ya realizado
	}elseif($_POST){
		$modo=$_POST['modo'];
	}else{
		$modo=83;
	}
    //----------------- BUSCA DATOS DEL CLIENTE 
	$idpedido=$_SESSION['ses_pedido'];
	$sql="SELECT p.num_cli , p.id_pedido, p.fec_pedido, p.est_pedido, p.mem_pedido ,
				 c.num_cli, c.raz_cli, c.dir_cli, c.dep_cli, c.rut_cli, c.ent_cli, c.pag_cli,
				 c.plazo_cli, c.fpag_cli, c.suc_cli
				 	 FROM pedido p ,cliente c
						WHERE p.num_cli=c.num_cli AND p.id_pedido=$idpedido" ;
	$link=Conecta();
	$res=mysql_query($sql,$link); 
	
	//----------------- CARGA VARIABLES DE DATOS DEL CLIENTE
	while($row=mysql_fetch_array($res)){
	    $numcli=$row['num_cli'];		$razcli=$row['raz_cli']; 		$entcli=$row['ent_cli'];
		$dircli=$row['dir_cli'];		$rutcli=$row['rut_cli'];	    $pagcli=$row['pag_cli'];
		$depcli=$row['dep_cli'];		$fecped=$row['fec_pedido'];		$estado=$row['est_pedido'];
		//$memo=$row['mem_pedido']; 
		$plazo=$row['plazo_cli'];       $fpago=$row['fpag_cli'];
		$succli=$row['suc_cli'];
	}
	//----------------- SI TIENE SUCURSALES , BUSCA LAS MISMAS
	$numsuc=0;
	if($succli==1){
		$sqlsuc="SELECT * FROM sucursal WHERE num_cli= '$numcli' ORDER BY sucursal_id ASC";
		$ressuc=mysql_query($sqlsuc,$link);
		$numsuc=mysql_num_rows($ressuc);
	}
	if(isset($_SESSION['ses_sucursal'])){
		$numsuc=$_SESSION['ses_sucursal'];
		$sqlsucelegida="SELECT * FROM sucursal WHERE sucursal_id = '$numsuc' ORDER BY sucursal_id ASC";
		$elegida=mysql_query($sqlsucelegida,$link);
		while($row=mysql_fetch_array($elegida)){
			$dircli='Sucursal '.$row['nom_suc'].'-'.$row['dir_suc'];
			$depcli=$row['dep_suc'];	$telcli=$row['tel_suc'];
			$ent=$row['ent_suc'];
			$numsuc=0;
		}
	}else{
		$_SESSION['ses_sucursal']=0;
	}	
	Desconecta($link);
	//-----------------VISTA DEL ENCABEZADO DE FACTURA ?>
	<form name="formVer"  method="post" >
	<table align="center"  >
		<tr align="center">
		   <td bgcolor="#FFA346">RUT:      </td><td><?php echo $rutcli;?></td>
		   <td bgcolor="#FFA346">DOCUMENTO </td><td><select name="txttipdoc" value="" size="1" >
				<option value="<?php echo $tipdoc; ?>"><?PHP echo $mostrar;?></option>
  				<option value="FACTURA CONTADO"   >FACTURA CONTADO   </option>
  				<option value="FACTURA CREDITO"   >FACTURA CREDITO   </option>
				<option value="DEVOLUCION CONTADO">DEVOLUCION CONTADO</option>
				<option value="NOTA DE CREDITO"   >NOTA DE CREDITO   </option>
				<option value="NOTA DE DEVOLUCION">NOTA DE DEVOLUCION   </option>
				<option value="NOTA REMITO"       >NOTA REMITO       </option>
			</select>*</td>
		   <td bgcolor="#FFA346">NUMERO </td><td><?php echo "A ".(actualID('contadores','id_numfac')+1)." ";?></td>
		</TR>
		<input type="hidden" name="numfac" value="<?php echo $idfac ;?>" />
		<TR align="center">
		   <td bgcolor="#FFA346">Cliente:  </td><td><?php echo $razcli;?></td>
		   <td bgcolor="#FFA346">Fecha :   </td><td><?php echo convertirFormatoFecha($fecped);?></td>
		   <td bgcolor="#FFA346">Vence :   </td><td><?php echo suma_fechas($fecped,$plazo);?></td>
		</TR>
		<tr align="center">	
			<td bgcolor="#FFA346">Direccion:  </td>
			<td><?php 	if($numsuc==0){
							echo $dircli; 
						}else{
							echo "<select name='dircli' title='Seleccione una sucursal'>";
							   echo "<option value='' selected='selected'>seleccionar sucursal</option>";
							   		while ($fila=mysql_fetch_row($ressuc)){ 
										echo "<option value='$fila[0]'>$fila[1]"."-"."$fila[3]</option>";
									} 
							echo "</select>";
						} 
				?>
			</td>
			<td bgcolor="#FFA346">Día Pago:   </td><td><?php echo $pagcli;?></td>
			<td bgcolor="#FFA346">Forma pago :</td><td><?php echo $fpago;?></td>
		</tr>
		<tr align="center">
			<td bgcolor="#FFA346">Departamento:   </td><td><?php echo $depcli;?></td>
			<td bgcolor="#FFA346">Horario entrega:</td><td><?php echo $entcli;?></td>
			<td bgcolor="#FFA346">                </td><td><?php echo $pagcli;?></td>
		</tr>
	</table>
	<?php //------------ BUSCA LINEAS DEL PEDIDO INGRESADO ANTERIORMENTE
		$cantlineas=$_SESSION['ses_carro']->cantidadLineas();
		if($cantlineas>0){
		    //titulos del encabezado de las tablas
			echo "<table CELLSPACING='0' CELLPADDING='0' bgcolor='#FF9900' align='center'>";
            echo "<tr align='center'><td>codigo</td><td>cantidad</td>
			      <td>unidad</td><td>articulo</td><td>unitario</td><td>%DTO</td>
				  <td>subtotal</td><td>%iva</td><td>eliminar</td></tr>";
			// seteo de variables DE USO EN LOS TOTALES	  
		    $idlinea=1;$totallinea=0;$ivalinea=0;$ivatotal=0; $unitario=0;  $descuento=0;   $total=0;   $kg=0;
			$subtotal=0;$grantotal=0; $kglinea=0; $kgtotal=0; $valorlinea=0; $valordescuento=0;	 $cantlin=0; 
		    //------------------------------------GENERA LA TABLA DE LA VISTA DE LAS LINEAS
		    $listalineas=$_SESSION['ses_carro'];
			//-------------- GENERO VARIABLE DE SESSION CON IDFAC 
			if (!isset($_SESSION['ses_idfac'])){  // asigna id de factura 
					$_SESSION['ses_idfac']=siguienteID('contadores','id_fac')+1;
			}
			$idfac=$_SESSION['ses_idfac']; //IDFAC
			//---------------------------------- cargar array con lineas libres
			$sqllibre ="SELECT id_fac ,cod_mer, cant_lin, uni_mer, des_mer, uni_lin, des_lin, iva_lin,
							     nul_lin  	FROM facturalinea  WHERE cod_mer = 0 AND id_fac = $idfac";
			$link=Conecta();
			$reslibre = mysql_query($sqllibre,$link);
			$cantlibre = mysql_num_rows($reslibre);
			$Alibres = array();			$nu=0;
			while($rowL=mysql_fetch_array($reslibre)){
				$nu++;
			    $codmer=$rowL['cod_mer'];
			    $cantidad=$rowL['cant_lin'];
			    $unidad=$rowL['uni_mer'];
				$articulo=$rowL['des_mer'];
				$unitario=$rowL['uni_lin'];
				$descuento=$rowL['des_lin'];
				$iva=$rowL['iva_lin'];
				$nula=$rowL['nul_lin'];
				$id=""; // EN PRUEBA
				$Alibres[$nu] = new FacturaLinea($id,$idfac,$codmer,$cantidad,$unidad,
											     $articulo,$unitario,$descuento,$iva,$nula);
			}
			Desconecta($link);
			//----------------------------------- comienza a tomar lo cargado en el carrito de pedidos
			$cant_lin=""; // prueba
			$subtotal=$ivalinea=$ivatotal=$grantotal =0 ;
						
			for($i=0 ; $i < $cantlineas ; $i++){
				$idlinea=$listalineas->Devidlinea($i);
				if($idlinea!=0){
					$cant_lin++;	$unidad="";  $unitario=0;	$kg=0;   $estado="";    $iva=0;
					$codmer   = $listalineas->Devcodmer($i);
					$articulo = $listalineas->Devarticulo($i);
					$cantidad = $listalineas->Devcantidad($i);  
				    $sqllinea ="SELECT m.cod_mer, m.des_mer, m.peso_mer, m.uni_mer, m.iva_mer, m.precio_mer, 
										f.cod_mer, f.id_fac ,f.des_lin, f.uni_lin, f.iva_lin
											FROM mercaderia m, facturalinea f
												WHERE  f.cod_mer = $codmer  
															AND f.cod_mer = m.cod_mer
																AND f.id_fac = $idfac";
					$link=Conecta();
					$reslinea=mysql_query($sqllinea,$link);
					$cantlin=mysql_num_rows($reslinea);
					if($cantlin>0){               //************ busca en lineasfactura
					    while($rowF=mysql_fetch_array($reslinea)){
							$unidad=$rowF['uni_mer'];
							$iva=$rowF['iva_lin'];
							if($rowF['uni_lin']>0){
							    $unitario=$rowF['uni_lin'];
							}else{
							    $unitario=$rowF['precio_mer'];
							}
							$unidad=$rowF['uni_mer'];
							$unitario=$rowF['uni_lin'];
							$descuento=$rowF['des_lin'];
							$iva=$rowF['iva_mer'];
							$nula="N";
							$kg=$cantidad*$rowF['peso_mer'];
						}
					}							    
					if($cantlin==0){            //********** busca en precio para el articulo del cliente
					    $sqllinea="SELECT m.cod_mer, m.des_mer, m.peso_mer, m.uni_mer, m.iva_mer,m.precio_mer, 
											p.cod_mer, p.val_pre, p.num_cli, p.fec_pre, p.id_pre
												FROM mercaderia m, precio p 
													WHERE m.cod_mer = $codmer AND p.cod_mer=m.cod_mer
													  AND p.num_cli = $numcli" ;					  
						$link=Conecta();
						$reslinea=mysql_query($sqllinea,$link);
						$cantlin=mysql_num_rows($reslinea);
						if($cantlin>0){
							while($rowP=mysql_fetch_array($reslinea)){
								$unidad=$rowP['uni_mer'];
								$unitario=$rowP['val_pre'];
								$iva=$rowP['iva_mer'];
								$nula="N";
								if($rowP['val_pre']>0){
							        $unitario=$rowP['val_pre'];
							    }else{
							        $unitario=$rowP['precio_mer'];
							    }
							}
						}		
					}
					if($cantlin==0){   //**************si no encontro precio del cliente buscara el precio de lista
						$sqllinea="SELECT m.cod_mer, m.des_mer, m.peso_mer, m.uni_mer, m.iva_mer,m.precio_mer 
										       FROM mercaderia m
													WHERE m.cod_mer = $codmer";							  
						$reslinea=mysql_query($sqllinea,$link);
						$cantlin=mysql_num_rows($reslinea);
						while($rowM=mysql_fetch_array($reslinea)){
							$unidad=$rowM['uni_mer'];
							$unitario=$rowM['precio_mer'];
							$iva=$rowM['iva_mer'];
							$nula="N";
						}
					}
					//--------------- busco tasa iva *****************
					$sqliva2="SELECT * FROM tasaiva WHERE tip_iva LIKE '%".$iva."%' ";
					$qiva=mysql_query($sqliva2,$link);//or die("Error :" . mysql_error());
					while($rowII=mysql_fetch_array($qiva)){
						$iva=$rowII['val_iva'];
					}
					Desconecta($link);				
					//-------------- CREO OBJETO LINEA DE FACTURA
					$id=""; // EN PRUEBA
					
			        $newlinea = new FacturaLinea($id,$idfac,$codmer,$cantidad,$unidad,
												 $articulo,$unitario,$descuento,$iva,$nula);
					//calculos de lineas
					$valorlinea=$newlinea->get_cantidad()*$newlinea->get_unitario();
					$valordescuento=($valorlinea/100)*$newlinea->get_descuento();
					$valorlinea=$valorlinea-$valordescuento;
					//despliego la linea
					$cantidad=$newlinea->get_cantidad();							 
					if ($modo==9){	
						if($newlinea->FacturaLineaExiste()==0){
							$newlinea->FacturaLineaAdd(); 
						}
					}				//$_SESSION['ses_carroventa']->agregarf($newlinea);  
					print "<tr bgcolor='#FFFFFF' align='center' >
							   <td>".$newlinea->get_idmer()."</td>
							   <td align='right' ><input type='text' name='cantidad' id='cantidad' size='8' 
							   							value=".number_format($cantidad,0)." 
														 onDblClick='cargarInfo(this.form,$codmer,8,$cantidad,0)'></td>
														 
							   <td align='left'>".$newlinea->get_unidad()."</td>
							   
							   <td align='left'>".$newlinea->get_articulo()."</td>
							   
							   <td align='right'>"."<input type='text' name='unitario' id='unitario' size='6' align='right'
							   							value=".number_format($newlinea->get_unitario(),2)."></td>
														
							   <td align='center'>"."<input type='text' name='descuento' id='descuento' size='2'
							                            value=".$newlinea->get_descuento()."
                                                        title='ingresar descuento'							   
							   							onDblClick='cargarInfo(this.form,$codmer,2,0,$descuento)';>"."</td>
							   <td align='right'>".number_format($valorlinea,2)."</td>
							   <td align='right'>".$newlinea->get_iva()."</td>
							   <td>"."<input type='image' src='../../iconos/delete_16.png' border='0'
													title='eliminar esta linea' 
													onclick='cargarInfo(this.form,$codmer,3,0,0)';>"."</td>
							</tr>"; 
					$idlinea++;  //contador de lineas
					//------------ CUENTAS PARA GENERAR LOS SUBTOTALES Y TOTALES
					//$kgtotal = $kgtotal+$kg;
					$subtotal= $subtotal+$valorlinea;
					$ivalinea= ($valorlinea/100)*$newlinea->get_iva();
					$ivatotal=$ivatotal+$ivalinea;		    
					$grantotal = $subtotal+$ivatotal;
				}
			}
			//despliegue de las lineas con articulos de edicion libre
			for($i=0 ; $i < $nu ; $i++){
				$newlinea = $Alibres[$nu]; //objetos de tipo FacturaLinea en un array 
				//calculos de lineas
				$valorlinea=$newlinea->get_cantidad()*$newlinea->get_unitario();
				$valordescuento=($valorlinea/100)*$newlinea->get_descuento();
				$valorlinea=$valorlinea-$valordescuento;
				//despliego la linea
				$cantidad=$newlinea->get_cantidad();							 
				print "<tr bgcolor='#FFFFFF' align='center' >
						   <td>".$newlinea->get_idmer()."</td>
						   <td align='right' ><input type='text' name='cantidad' id='cantidad' size='8' 
								value=".number_format($cantidad,0)." 
										 onDblClick='cargarInfo(this.form,$codmer,2,$cantidad,0)'></td>
						   <td align='left'><input type='text' name='unidad' id='unidad' size='15' 
						                            value=".$newlinea->get_unidad()."></td>
						   <td align='left'>".$newlinea->get_articulo()."</td>
						   <td align='right'>"."<input type='text' name='unitario' id='unitario' size='6' align='right'
							   							value=".number_format($newlinea->get_unitario(),2)."></td>
						   <td align='center'>"."<input type='text' name='descuento' id='descuento' size='2'
						                            value=".$newlinea->get_descuento()."
                                                       title='tipear descuento y ingresarlo con un Doble Click'							   
							   							onDblClick='cargarInfo(this.form,$codmer,2,0,0)';>"."</td>
						   <td align='right'>".number_format($valorlinea,2)."</td>
						   <td align='right'>".$newlinea->get_iva()."</td>
						   <td>"."<input type='image' src='../../iconos/delete_16.png' border='0'
											title='eliminar esta linea' 
												onclick='cargarInfo(this.form,".$newlinea->get_idmer().",3)';>"."</td>
						</tr>"; 
				$idlinea++;  //contador de lineas
				//------------ CUENTAS PARA GENERAR LOS SUBTOTALES Y TOTALES
				$subtotal= $subtotal+$valorlinea;
				$ivalinea= ($valorlinea/100)*$newlinea->get_iva();
				$ivatotal=$ivatotal+$ivalinea;		    
				$grantotal = $subtotal+$ivatotal;
			}
			echo "</table>"; ?>
			<input type="hidden" name="numsub" id="numsub"  value="<?php echo $subtotal;        ?>"/>
			<input type="hidden" name="numivaS"id="numivaS" value="<?php echo $ivatotal;        ?>"/>
			<input type="hidden" name="numcli" id="numcli"  value="<?php echo $numcli;          ?>"/>
			<input type="hidden" name="numplazo" id="numplazo"  value="<?php echo $plazo;       ?>"/>
			<input type="hidden" name="txtmoneda"id="txtmoneda" value="<?php echo $moneda;      ?>"/>
			<input type='hidden' name='idlinea'  id='idlinea'   value="<?php echo $idlinea;     ?>"/>
			<input type='hidden' name='libres'  id='libres'     value="<?php echo $lineaslibres;?>"/>
			<?php 
			//redondeo de totales en factura 
			$subtotal=number_format($subtotal,2); $ivatotal=number_format($ivatotal,2); $grantotal=number_format($grantotal,2);?>
			<TABLE CELLSPACING='0' CELLPADDING='0' align='center' >
				<TR align='center' bgcolor='#FFFFFF'>
					<TD>cantidad de articulos : <?php echo $cant_lin;?></TD><TD colspan='2'>Total de kg : <?php echo $kgtotal  ;?></TD>
					<TD align='right'>Subtotal $   </td><td><?php echo $subtotal ;?></TD>
					<td></td><TD></TD><TD></td>
					<TD align='right'>Iva      $   </TD><TD><?php echo $ivatotal ;?></TD>
					<td></td><TD></TD><TD></TD>
					<TD align='right'>Total    $   </TD><TD style='font-size:14px' ><?php echo $grantotal;?></TD>
				</TR>
			</TABLE>  <?
		}else{
			echo "<CENTER>NO HAY LINEAS</CENTER>";  $subtotal=$ivatotal=$grantotal=0;
		}
		?>
	<!-- ******************************* DESPLIEGA TABLA PARA INGRESAR NUEVAS LINEAS EN LA FACTURA ****************************************************-->	
	<TABLE CELLSPACING="0"  CELLPADDING="0"  align="center" border="0">
	  <tr bgcolor="#FFA346"align='center' style="font-size:12px"><td>cantidad</td><td>articulo</td><td>precio</td><td>%desc</td><td>%iva</td><td>agregar</td></tr>
	  <tr bgcolor="#FFA346"align="center" style="font-size:12px">
	    <td><input type="text" name="numcant" alt="numcant"  size="8" maxlength="8" 
					 title="Ingrese cantidad del articulo" onKeyPress="return permite(event,'num')"/></td>
		<td><?php
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
		<td><input type="text" name="numprec" id="numprec"  value="0" size="8" maxlength="8" 
						 title="Ingrese precio unitario" onKeyPress="return permite(event,'num')"/>
		</td>
		<td><input type="text" name="numdesc" id="numdesc"  value="0"size="2" maxlength="2" 
						 title="Ingrese porcentaje de descuento" onKeyPress="return permite(event,'num')"/>
		</td>
		<td><input type="text" name="iva" id="iva"  value="22" size="2" maxlength="2" 
						 title="Ingrese porcentaje de iva" onKeyPress="return permite(event,'num')" disable="disable"/>
	    </td>
			<input type="hidden" NAME="modo" />
		<td style="font-size:11px"><input type="button" value="AGREGAR" border="0" align="absmiddle" 
						title="agregar el articulo seleccionado" onClick="cargarInfo(this.form,0,4,0,0)";/>
		</td>
	</tr>	
	<tr bgcolor="#FFA346" align="center">
		<td colspan="1"> </td>
		<td colspan="1"><input type='text' name="txtarticulo" id="txtarticulo" size="37" maxlength="45"/> </td>
		
	    <td colspan="4" style="font-size:11px"><input type="button" value="PERSONALIZADA" border="0" align="absmiddle" 
					title="agregar el articulo seleccionado" onClick="cargarInfo(this.form,0,42,0,0)";/></td>
	</tr>
	<tr style="font-size:12px">
		<td colspan="6" align="center" ><?php echo $_SESSION["ses_error"];?></td>
	</tr>
	<TR style="font-size:12px">
		<TD colspan="1" align="center">Comentarios</TD>
	    <TD colspan="5"style="font-size:12px" ><input type="text"  name="txtmemo" id="txtmemo"
														value="<?php echo $memo;?>" 
														size="100" maxlength="100" /></TD>
		<TD style="font-size:10px"></TD>
	</TR>
   </TABLE >
   <?php //--------------------------------------------- GENERA LA TABLA PARA LA VISTA DE LOS ICONOS ---------------------------------------------
	if($cantlineas>0){ ?>
        <TABLE align="center" >
            <tr align="center">
			 	<td><input type="image" src="../../iconos/buttoncheck_29.png" border="0" 
			   					title="SALIR" onClick="cargarInfo(this.form,0,83)";></td>
			    <td><input type="image" src="../../iconos/printer_29.png" border="0"
			   					title="IMPRIMIR FACTURA" onClick="cargarInfo(this.form,0,82)";></td>
				<td><input type="image" src="../../iconos/printer_29.png" border="0"
			   					title="IMPRIMIR PEDIDO" onClick="cargarInfo(this.form,0,81)";></td>
			<?php if($modo!=1){ ?>				
				<td><input type="image" src="../../iconos/acepta.png" border="0" 
			   					title="CONFIRMA FACTURA" onClick="cargarInfo(this.form,0,1)";></td>				
				<td><input type="image" src="../../iconos/bin_29.png"         border="0" 
		  						title="VACIA SOLO LAS LINEAS" onClick="cargarInfo(this.form,0,5)";></td>
			   	<td><input type="image" src="../../iconos/arrowright_29.png"  border="0" 
		 						title="VUELVE AL PEDIDO" onClick="cargarInfo(this.form,0,6)";></td>
			<?php }else{ ?>
						<td><img src="../../iconos/ok_29.png" border="0" 
			   					title="DOCUMENTO CONFIRMADO"></td>
			<?php } ?>				
				<td><input type="image" src="../../iconos/delete_32.png"  border="0" 
		   						title="BORRA TODA LA FACTURA Y EL PEDIDO" onClick="cargarInfo(this.form,0,7)";></td><td></td>
			</tr><?php
 			    if($modo==1){ ?>
					<tr align="center" style="font-size:10px" >
						<td>4- SALIR</td><td>3 IMPRIME FACTURA</td><td>2 IMRPIME PEDIDO</td><TD></TD><td>ELIMNAR TODO</td><td></td>
					</tr>
				    <?php 
				}else{ ?>
					<tr align="center" style="font-size:10px" >
						<td>4- SALIR</td><td>3 IMPRIME FACTURA</td><td>2 IMPRIME PEDIDO</td><td>1-COMENTAR Y GRABAR</td><td>VACIAR LINEAS</td><td>VOLVER AL PEDIDO</td><td>ELIMNAR TODO</td><td></td>
					</tr>
				  <?php
				} ?>
		</TABLE> 
		<?php	
	}else{	?>
		<TABLE align="center" >
            <tr><td><input type="image" src="../../iconos/arrowright_58.png" border="0" 
			                   align="absmiddle" onClick="cargarInfo(this.form,0,6)";/></td>
				<td><input type="image" src="../../iconos/delete_32.png"  border="0" 
		   						title="BORRA TODO EL PEDIDO" onClick="cargarInfo(this.form,0,7)";></td>
								
			</tr>
			<tr align"center"><td>VOLVER</td><td>ELIMINAR</td></tr>
        </TABLE> <?php
	}?>
  </form>
  </div>
 </body>
</html>