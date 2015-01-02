<?php include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
$link=Conecta();   //en Persistencia.php
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function Validar(form){    //Validación del formulario 
		var modo=form.modo.value;
				
		if(form.txtdes.value.length <6 ){ //controla que el nombre no este vacío.
      		 alert("Tiene que escribir la mercaderia sin espacios al inicio y ser un nombre valido"); 
			 form.txtdes.focus();
			 return; 
    	} 
				
		if(form.txtuni.value.length<1 ){ 
      		 alert("Ingrese la unidad"); 
			 form.txtuni.value="";
      	 	 form.txtuni.focus();
			 return; 
		}

		form.submit();
		return false;
	}
	</script>			
 </head>
<body><DIV id="formulario">
<?php
if($_POST){
 $modo=$_POST['modo'];  //MODO=1 INGRESA   MODO=2 modifica  y  MODO=3 elimina
}else{
 $modo=$_GET['modo'];
}  
$ssql="select * from tasaiva t where 1=1 order by id_iva asc";
$rres=mysql_query($ssql,$link);       //realizo la consulta
if($modo==2 ||$modo==3 || $modo==4){           
 	$id=$_POST['id'];
	
	$sql="select cod_mer ,des_mer , uni_mer, cat_mer, iva_mer ,
					stock_mer , fecha_mer, min_mer , peso_mer , precio_mer
						from mercaderia
			where cod_mer=".$id;
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	$iva_tasa=$row['iva_mer'];
	
	
	
	//FreeResp($res);    // en Persistencia.php
	//Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	   $titulo=" MODIFICAR MERCADERIA";
	   $boton="MODIFICAR";
	}elseif($modo==3){
	   $titulo="ELIMINAR MERCADERIA"; 
	   $boton="ELIMINAR";
	}elseif($modo==4){
		$titulo="VER MERCADERIA"; 
	    $boton="SALIR";
	}	  
 }else{
	 $titulo="ALTA DE MERCADERIA";
	 $boton="INGRESAR";
 } 
?>
<h2><center><?php echo $titulo; ?><img src='../../iconos/box_48.png' border="0"></center></h2>
<form name="form2" action="../../dominio/mercaderias/MercaderiaMant.php" method="POST" >
 <center>
 <TABLE  width="50%" CELLSPACING="1"  CELLPADDING="1" style="font-size:12px">
    <tr>
		<td>Descripción :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtdes" ID="txtdes" VALUE="" SIZE="35" MAXLENGTH="45"/>
      		<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtdes" VALUE="<?PHP echo $row['des_mer'];?>" SIZE="45" MAXLENGTH="45"/>
			<?php } ?>	*				<!--		onkeypress="return permiteconespacios(event,'car_num)"-->
		</td>
    </tr>
	<tr>	 														
		</td>
		<td>Unidad :</td>
		<td><?php if($modo==1){?>
				<INPUT TYPE="text" NAME="txtuni" VALUE=" " SIZE="15" MAXLENGTH="15" />
	  						<!--			onkeypress="return permite(event,'car_num')"/-->
			<?php }else{ ?>
				<INPUT TYPE="text" NAME="txtuni" VALUE="<?PHP echo $row['uni_mer'];?>" SIZE="15" MAXLENGTH="15" />
	  						<!--			onkeypress="return permite(event,'car_num')"/-->
			<?php } ?> *
		</td>
	</tr>
	<tr>
		<td>Codigo ID :</td>
		<td><?php if($modo==1){?>
					<INPUT TYPE="text"  NAME="numpeso"  VALUE=""  SIZE="20" MAXLENGTH="20"/>
							<!--			onkeypress="return permiteconespacios(event,'car_num')"/-->
			<?php }else{ ?>
					<INPUT TYPE="text"  NAME="numpeso"  VALUE="<?php echo $row['peso_mer'];?>"  SIZE="20" MAXLENGTH="20"/>
							<!--			onkeypress="return permiteconespacios(event,'car_num')"/-->
			<?php } ?>*				
		</td>
	</tr>
    <tr>
		<td>Iva :</td>
		<td><?php if($modo==1){ 
						echo "<select name='numiva'>";
							echo "<option value='' selected='selected'>sin seleccionar</option>";
							  $resultado=mysql_query($ssql); 
							  while ($fila=mysql_fetch_row($resultado)){ 
									echo "<option value='$fila[1]'>$fila[1]";
							  } 
							  echo "</select>";
							  Desconecta($link);
			?>*
		</td>	
				<!--INPUT TYPE="text" NAME="numiva"  VALUE="" SIZE="2" MAXLENGTH="2" 
	 									onkeypress="return permite(event,'num')"/-->
			<?php }else{ 
						echo "<select name='numiva'>";
							echo "<option selected='selected'>".$iva_tasa."</option>";
							  $resultado=mysql_query($ssql); 
							  while ($fila=mysql_fetch_row($resultado)){ 
									echo "<option value='$fila[1]'>$fila[1]";
							  } 
						echo "</select>";
							  Desconecta($link);?>
	            <!--INPUT TYPE="text" NAME="numiva"  VALUE="<?php //echo $row['iva_mer'];?>" SIZE="2" MAXLENGTH="2" /->
	 							<!--		onkeypress="return permite(event,'num')"/ -->
			<?php } ?>								
		</td> 												
	</tr>
	<tr>													
		<td>Stock :</td>
		<td><?php if($modo==1){?> 
				<input type="text" name="numstock" value="" size="8" maxlength="8"
	 																 onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
				<input type="text" name="numstock" value="<?php echo $row['stock_mer'];?>" size="8" maxlength="8"
	 																 onkeypress="return permite(event,'num')"/>
			<?php } ?> *
			Stock mínimo:
			<?php if($modo==1){?> 
				<input type="text" name="nummin" value="" size="4" maxlength="4"
		 															 onkeypress="return permite(event,'num')"/>
		 	<?php }else{ ?>
				<input type="text" name="nummin" value="<?php echo $row['min_mer'];?>" size="4" maxlength="4" onkeypress="return permite(event,'num')"/>
			<?php } ?>	*														 
		</td>
	</tr>
    <tr>
		<td>Fecha RESET stock :</td>
		<td><?php if($modo==1){?>	
				<input type="text" name="fecstock" value="" size="10" maxlength="10"/>
			<?php }else{ ?>
				<input type="text" name="fecstock" value="<?php echo $row['fecha_mer'];?>" size="10" maxlength="10"/>
			<?php } ?>	 *
		</td>
    </tr>
	 <tr>
		<td>Precio Básico :</td>
		<td><?php if($modo==1){?>
				<input type="text" name="numprecio" value="" size="10" maxlength="10"/>
			<?php }else{ ?>
				<input type="text" name="numprecio" value="<?php echo $row['precio_mer'];?>" size="10" maxlength="10"/>*
			<?php } ?>*
		</td>
    </tr>
 </TABLE>  
 </center>
         <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ; ?>"/>
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario ?>
		  	<input type="hidden" name="numcod" value="<?php echo $row['cod_mer'];?>" />
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE="<?php echo $boton ;?>" onClick="Validar(this.form)";/>
 <?php   if($modo==1){ ?>
		    <input type="reset" value="LIMPIAR" />
 <?php	 } ?>	 
		</center>  
 </FORM>
 </body>
</html>