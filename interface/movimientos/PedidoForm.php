<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
session_start();
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){
	header("location:../../index.php");
	exit();
}
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form){             //Validación del formulario 
		var modo=form.modo.value;
				
		var rut=form.numrut.value;          //validacion del RUT
		var rutlargo=form.numrut.value.length;
		var isnum=esnumeroentero(rut);
		
		if(rutlargo!=12 || isnum==false){ 
      		 alert("El rut debe contener solo numeros (12 digitos)"); 
			 form.numrut.value="";
      	 	 form.numrut.focus();
			 return; 
		}
				
		if (form.txttipmov.value==0){       //validar tipo de documento
			alert("DEBE SELECCIONAR UN TIPO DE DOCUMENTO");
			form.txttipmov.focus();
			return;
		} 
		if (form.txtmoneda.length==0){      //validar tipo de moneda
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
	$sql="select cod_mov, fec_mov, tip_mov, num_mov, rut_pro, val_mov, mon_mov
						 from movimiento 
			              where cod_mov ='$id'";
						  
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	FreeResp($res);    // en Persistencia.php
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	 ?><H2><CENTER>MODIFICAR MOVIMIENTO<img src='../../iconos/document_add_102.png' border="0"></CENTER></H2><?php
	   $boton="MODIFICAR";
	}elseif($modo==3){
	  ?><H2><CENTER>ELIMINAR MOVIMIENTO<img src='../../iconos/document_add_102.png' border="0"></CENTER></h2><?php 
	    $boton="ELIMINAR";
	}elseif($modo==4){
		?><H2><CENTER>FICHA MOVIMIENTO<img src='../../iconos/document_add_102.png' border="0"></CENTER></h2><?php 
	    $boton="SALIR";
	}
			  
 }else{
	 $ssql="select p.raz_pro ,p.rut_pro from proveedor p where 1=1 order by p.raz_pro asc";
	 $link=Conecta();
	 ?><H2><CENTER>INGRESAR PEDIDO<img src='../../iconos/document_add_102.png' border="0">
	 			<font size="2">(*)campos obligatorios</font></CENTER>
	   </H2><?php
	   $boton="INGRESAR";
 } 
?>
<form name="form1" action="../../dominio/pedidos/PedidoMant.php" method="POST">
 <center>
 <TABLE border="2" width=60% CELLSPACING=1  CELLPADDING=1 >
    <tr>
      <td>Fecha</td>
	  <td><input type="text" name="fecmov" value="<?PHP echo $row['fec_mov'];?>" size="10" maxlength="10"/>*</td></tr>
	<tr>													
	  <td>Tipo movimiento</td>
	  <td><select name="txttipmov" value="<?PHP echo $row['tip_mov'];?>" size="1" >
  				<option value="<?PHP echo $row['tip_mov'];?>"><?PHP echo $row['tip_mov'];?></option>
				<option value="factura contado">FACTURA CONTADO</option>
  				<option value="factura crédito">FACTURA CREDITO</option>
				<option value="devolución contado">DEVOLUCION CONTADO</option>
				<option value="nota crédito">NOTA DE CREDITO</option>
				<option value="nota devolución">NOTA DEVOLUCION</option>
				<option value="nota remito">NOTA REMITO</option>
				<option value="recibo pago">RECIBO DE PAGO</option>
				<option value="saldo inicial">SALDO INICIAL</option>
		  </select>*</td></tr>
    <tr>
     <td>Nºdocumento</td>
	 <td><input type="text" name="numdoc"  value="<?PHP echo $row['num_mov'];?>" size="12" maxlength="12" 
	 								onkeypress="return permiteconespacios(event,'num_car')"/>*</td></tr>
	<tr>	 														
	 <td>RAZON SOCIAL</td>
	 <td>
     <?php  if($modo==1){ ?>
			 <?php	echo "<select name='numrut'>"; 
						$resultado=mysql_query($ssql); 
						while ($fila=mysql_fetch_row($resultado)){ 
							if ($fila[0]==$row['rut_pro']){ 
								echo "<option selected value='$fila[1]'>$fila[0]";	
							}else{ 
								echo "<option value='$fila[1]'>$fila[0]";	
							} 
						} 
						echo "</select>";
						Desconecta($link); ?>	 
			  
  	  <?php	}else{ ?>
				<input type="text" name="numrut"  value="<?PHP echo $row['rut_pro'];?>" size="12" maxlength="12"/>
	  <?php } ?>
	 </td>		
   </tr>		 
   <tr>
     <td>Monto</td>
	 <td><input type="text" name="nummonto" value="<?PHP echo $row['val_mov'];?>" size="12" maxlength="12"
	 								onkeypress="return permite(event,'num')"/>*</td></tr>
   <tr> 	 
	 <td>Moneda</td>
	 <td><select name="txtmoneda" value="<?PHP echo $row['mon_mov'];?>" size="1">
	 			<option value="<?PHP echo $row['mon_mov'];?>"><?PHP echo $row['mon_mov'];?></option>
				<option value="Peso">PESO</option>
  				<option value="Dolar">DOLAR</option>
				<option value="Euro">EURO</option>
		 </select>*</td></tr>
 </TABLE>
 </center>
         <input type="hidden" name="modo" value="<?php echo $modo; ?>">
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numcodmov" value="<?PHP echo $row['cod_mov'];?>" >
 <?php   }else{ ?>
 			<input type="hidden" name="numcodmov" value=0 />
<?php    }  ?>	
 		 <center>
		 <input type="button" value=<?php echo $boton ?> onClick="ValidarForm(this.form)">
 <?php   if($modo==1){ ?>
		     <input type="reset" value="LIMPIAR" />
 <?php	 } ?> </center>	 
		 
 </FORM>

 </body>
</html>