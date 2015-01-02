<?php include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form){             //Validación del formulario 
		var modo=form.modo.value;
		if (form.numrut.value==" "){       //validar tipo de documento
			alert("DEBE SELECCIONAR EL PROVEEDOR");
			form.numrut.focus();
			return;
		} 
		var fecha=form.fecmov.value;
		if (Validafecha(fecha)==false){;
			form.fecmov.value="";
			form.fecmov.focus();
			return;
		}
		if (form.txttipmov.value==0){       //validar tipo de documento
			alert("DEBE SELECCIONAR UN TIPO DE DOCUMENTO");
			form.txttipmov.focus();
			return;
		} 
		if (form.txtrub.value==""){      //validar tipo de moneda
			alert("DEBE SELECCIONAR UN RUBRO");
			form.txtrub.focus();
			return;
		} 
		if (form.txtmoneda.value==""){      //validar tipo de moneda
			alert("DEBE SELECCIONAR UN TIPO DE MONEDA");
			form.txtmoneda.focus();
			return;
		} 
		form.submit();
		return false;
	}
	</script>			
 </head>
<body>
 <DIV id="formulario">
<?php
if($_POST){
 $modo=$_POST['modo'];  //MODO=1 INGRESA   MODO=2 modifica  y  MODO=3 elimina
 $id=$_POST["id"];
}else{
 $modo=$_GET['modo'];
 $id=$_GET["id"];
}  
 if ($modo==2 ||$modo==3 || $modo==4){           
 	$link=Conecta();   //en Persistencia.php
	$sql="SELECT m.cod_mov ,m.fec_mov ,m.tip_mov ,m.num_mov ,m.rut_pro ,m.val_mov ,m.val_iva ,m.mon_mov, m.rub_mov,
					p.rut_pro, p.raz_pro, p.num_pro FROM movimiento m , proveedor p 
			              WHERE (m.rut_pro=p.num_pro) 
						    AND m.cod_mov ='$id'";
						  
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	FreeResp($res);    // en Persistencia.php
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	 ?><H2><CENTER>MODIFICAR MOVIMIENTO</CENTER></H2><?php
	   $boton="MODIFICAR";
	}elseif($modo==3){
	  ?><H2><CENTER>ELIMINAR MOVIMIENTO</CENTER></h2><?php 
	    $boton="ELIMINAR";
	}elseif($modo==4){
		?><H2><CENTER>FICHA MOVIMIENTO</CENTER></h2><?php 
	    $boton="SALIR";
	}
 }else{
	?><H2><CENTER>INGRESAR MOVIMIENTO</CENTER></H2><?php
	  $boton="INGRESAR";
 } 
?>
<form name="form1" action="../../dominio/movimientos/MovimientoMant.php" method="POST">
 <center>
 <TABLE width=40% CELLSPACING=1  CELLPADDING=1 style="font-size:12px" bordercolor="#FFFFFF">
    <tr>	 														
	 <td>RAZON SOCIAL</td>
	 <td>
       <?php   // tomamos como num_pro en proveedores para relacionar con el movimiento ID ACTUAL de PROVEEDORES
	   $ssql="SELECT * FROM proveedor WHERE 1=1 ORDER BY raz_pro ASC";
	   $link=Conecta();
	   if($modo==1){
	 	 	echo "<select name='numrut'>"; 
			          echo "<option value=' '>"."elegir..."."</option>";
						$resultado=mysql_query($ssql); 
						while ($row2=mysql_fetch_array($resultado)){ 
							echo "<option value=".$row2['num_pro'].">".$row2['raz_pro']."</option>";	
						}
			echo "</select>";
	   }else{
	  		echo "<select name='numrut'>"; 
			         echo "<option value='".$row['num_pro']."' selected='selected'>".$row['raz_pro']."</option>";
						$resultado=mysql_query($ssql); 
						while ($row3=mysql_fetch_array($resultado)){ 
							echo "<option value=".$row3['num_pro'].">".$row3['raz_pro']."</option>";	
						} 
			echo "</select>";
		}
		Desconecta($link); ?>*
		
	 </td>		
   </tr>	
    <tr>
		<td>Fecha</td>
		<td><?php if($modo==1){ ?>
					<input type="text" name="fecmov" title="ej:2010-12-24" 
	                value="" size="10" maxlength="10"/>
			<?php }else{ ?>	
					<input type="text" name="fecmov" title="ej:2010-12-24" 
	                value="<?PHP echo $row['fec_mov'];?>" size="10" maxlength="10"/>
			<?php } ?>	  		
	       * formato : AAAA-mm-dd
		</td>
	</tr>
	<tr>													
		<td>Tipo movimiento</td>
		<td><?php if($modo==1){ ?>
					<select name="txttipmov" value="" size="1" >
						<option value=""                  >sin seleccionar   </option>
						<option value="factura contado"   >FACTURA CONTADO   </option>
						<option value="factura crédito"   >FACTURA CREDITO   </option>
						<option value="devolución contado">DEVOLUCION CONTADO</option>
						<option value="nota crédito"      >NOTA DE CREDITO   </option>
						<option value="nota devolución"   >NOTA DEVOLUCION   </option>
						<option value="nota remito"       >NOTA REMITO       </option>
						<option value="recibo pago"       >RECIBO DE PAGO    </option>
						<option value="saldo inicial"     >SALDO INICIAL     </option>
					</select>
	  
	  
			<?php }else{ ?>
					<select name="txttipmov" value="<?PHP echo $row['tip_mov'];?>" size="1" >
						<option value="<?PHP echo $row['tip_mov'];?>"><?PHP echo $row['tip_mov'];?></option>
						<option value="factura contado"   >FACTURA CONTADO   </option>
						<option value="factura crédito"   >FACTURA CREDITO   </option>
						<option value="devolución contado">DEVOLUCION CONTADO</option>
						<option value="nota crédito"      >NOTA DE CREDITO   </option>
						<option value="nota devolución"   >NOTA DEVOLUCION   </option>
						<option value="nota remito"       >NOTA REMITO       </option>
						<option value="recibo pago"       >RECIBO DE PAGO    </option>
						<option value="saldo inicial"     >SALDO INICIAL     </option>
					</select>
			<?php } ?>		
		*</td>
	</tr>
    <tr>
		<td>Nºdocumento</td>
		<td><?php if($modo==1){ ?>
					<input type="text" name="numdoc"  value="" size="12" maxlength="12" 
	 								onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<input type="text" name="numdoc"  value="<?PHP echo $row['num_mov'];?>" size="12" maxlength="12" 
	 								onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php } ?>						
		*</td>
	</tr>
		 
	<tr>
		<td>Monto</td>
		<td><?php if($modo==1){ ?>
					<input type="text" name="nummonto" value="" size="12" maxlength="12"
	 								onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
		
					<input type="text" name="nummonto" value="<?PHP echo $row['val_mov'];?>" size="12" maxlength="12"
	 								onkeypress="return permite(event,'num')"/>
			<?php } ?>						
		*</td>
	</tr>
    <tr>
     <td>Rubro :</td>
	 <td>
       <?php
	   $sql2="select * FROM rubro WHERE est_rubro='HABILITADO' ORDER BY des_rubro asc";
	   $link=Conecta();
	   $resultado=mysql_query($sql2);
	   if($modo==1){
		 	echo "<select name='txtrub'>";
				echo "<option value=''>"."elegir..."."</option>";
		            while ($row2=mysql_fetch_array($resultado)){ 
					    echo "<option value=".$row2['des_rubro'].">".$row2['des_rubro']."</option>";
				    } 
				    echo "</select>";
				    
	   }else{
			echo "<select name='txtrub'>";
				echo "<option value='".$row['rub_mov']."' selected='selected'>".$row['rub_mov']."</option>";
				   while ($row2=mysql_fetch_array($resultado)){ 
					    echo "<option value=".$row2['des_rubro'].">".$row2['des_rubro']."</option>";
				    } 
				    echo "</select>";
				    
		}
		Desconecta($link);		  
		?>*
      </td>
   </tr>
   <tr> 	 
		<td>Moneda</td>
		<td><?php if($modo==1){ ?>
				<select name="txtmoneda" value="" size="1">
					<option value=""     >sin seleccionar</option>
					<option value="Peso" >PESO           </option>
					<option value="Dolar">DOLAR          </option>
					<option value="Euro" >EURO           </option>
				</select>
			<?php }else{ ?>
				<select name="txtmoneda" value="<?PHP echo $row['mon_mov'];?>" size="1">
					<option value="<?PHP echo $row['mon_mov'];?>"><?PHP echo $row['mon_mov'];?></option>
					<option value="Peso">PESO  </option>
					<option value="Dolar">DOLAR</option>
					<option value="Euro">EURO  </option>
				</select>
			<?php } ?>	
		*</td>
    </tr>
	<tr>
     <td>Tipo IVA :</td>
	 <td>
       <?php
	   $sql4="SELECT * FROM tasaiva WHERE 1=1 ORDER BY val_iva DESC";
	   $link=Conecta();
	   $resultado4=mysql_query($sql4);
	   if($modo==1){
	   	 	echo "<select name='txtiva'>";
				echo "<option value=' '>"."elegir..."."</option>";
		            while ($row4=mysql_fetch_array($resultado4)){ 
					    $tipo=$row4['tip_iva'];
					    echo "<option value=".$row4['val_iva'].">".$row4['tip_iva']." ".$row4['ver_iva']."</option>";
					} 
			echo "</select>"; ?>
			<?php 
		}else{
	       	echo "<select name='txtiva'>";
				echo "<option value='".$row['val_iva']."' selected='selected'>".$row['val_iva']."</option>";
				   while ($row4=mysql_fetch_array($resultado4)){ 
				   	    $tipo=$row4['tip_iva'];
					    echo "<option value=".$row4['val_iva'].">".$row4['tip_iva']." ".$row4['ver_iva']."</option>";
				   } 
			echo "</select>"; 	
	   }
	   Desconecta($link);
	   ?>		  
	 </td>
   </tr>	 
 </TABLE>
 </center>
 			 <input type="hidden" name="txtivatipo" value="<?php echo $tipo; ?>" />
             <input type="hidden" name="modo"       value="<?php echo $modo; ?>" />
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numcodmov" value="<?PHP echo $row['cod_mov'];?>" />
 <?php   }else{ ?>
 			 <input type="hidden" name="numcodmov" value=0 />
<?php    }  ?>	
 		 <center>
		     <input type="button" value=<?php echo $boton ?> onClick="ValidarForm(this.form)"/>
 <?php    if($modo==1){ ?>
		     <input type="reset" value="LIMPIAR" />
 <?php	  } 	?>
		 </center>	 
  </FORM>
 </body>
</html>