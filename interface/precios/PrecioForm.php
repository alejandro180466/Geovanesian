<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form,modo){    //Validación del formulario 
		form.modo.value=modo;
		if (form.numcli.value==0){       //validar CLIENTE
			alert("DEBE SELECCIONAR UN CLIENTE");
			form.numcli.focus();
			return;
		} 
		if (form.nummer.value==0){       //validar PRODUCTO
			alert("DEBE SELECCIONAR UN PRODUCTO");
			form.nummer.focus();
			return;
		} 
		var fecha=form.fecpre.value;
		if (Validafecha(fecha)==false){;
			alert("INGRESAR LA FECHA DE VIGENCIA");
			form.fecpre.focus();
			return;
		}
		if (form.numval.value<=0){        //validar departamento
			alert("INGRESAR EL PRECIO ESPECIAL");
			form.numval.focus();
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
 $modo=$_POST['modo'];  
 $id=$_POST['id'];
}else{
 $modo=$_GET['modo'];
 $id=$_GET['id'];
}
$link=Conecta();
$sqlmoneda="SELECT * FROM moneda ORDER BY moneda_nombre ASC";
if ($modo==1){ //ingresar precio nuevo
	$sqlcli="select * FROM cliente WHERE 1=1 ORDER BY raz_cli ASC";
	$sqlmer="select * FROM mercaderia WHERE 1=1 ORDER BY des_mer ASC";
	$boton="INGRESAR";
	$titulo="INGRESO DEL PRECIO";
	
}elseif($modo==2){ //modificar
    $boton="MODIFICAR";
	$titulo="MODIFICAR EL PRECIO";
    $sql="SELECT c.num_cli, c.raz_cli,
					 p.id_pre , p.num_cli , p.fec_pre , p.cod_mer , p.val_pre , p.moneda_pre,
					  m.cod_mer , m.des_mer
						FROM cliente c , precio p , mercaderia m
							WHERE c.num_cli = p.num_cli
							  AND p.cod_mer = m.cod_mer
							  AND p.id_pre = '$id'";
	$pedi=ejecutarConsulta($sql,$link);
    $row=mysql_fetch_array($pedi);						  
}							  
?>
<DIV id="formulario">
	<CENTER><H2><?php echo $titulo;?></H2></CENTER>
	<form name="form1" action="../../dominio/precios/PrecioMant.php" method="POST">
    <TABLE CELLSPACING="1"  CELLPADDING="1"  >
      <tr>
        <td>Razón social :</td>
		<td>
		  <?php echo "<select name='numcli'>";
			 if($modo==1){
			    echo "<option value='' selected='selected'>sin seleccionar</option>";
			 	$resultadocli=mysql_query($sqlcli); 
				while ($fila=mysql_fetch_row($resultadocli)){ 
					echo "<option value='$fila[0]'>$fila[1]";	
				} 
			 }else{
			     echo "<option value=".$row['num_cli']."selected='selected'>".$row['raz_cli']."</option>";
			     $resultadocli=mysql_query($sqlcli); 
				 while ($fila=mysql_fetch_row($resultadocli)){ 
					if ($fila[0]==$row['raz_cli']){
						echo "<option selected value='$fila[0]'>$fila[1]";	
					}else{ 
						echo "<option value='$fila[0]'>$fila[1]";	
					} 
				 } 
			    
			 }		
			 echo "</select>";
		 ?>	* 
	    </td>
      </tr>
      <tr>
        <td>Producto: </td>
	    <td>
		  <?php
		    if($modo==1){
		       echo "<select name='nummer'>";
				echo "<option value='' selected='selected'>sin seleccionar</option>";
			    $resultadomer=mysql_query($sqlmer); 
				while ($fila=mysql_fetch_row($resultadomer)){ 
				    echo "<option value='$fila[0]'>$fila[1]";	
				}
				echo "</select>";
		   	    Desconecta($link);
			 }else{ ?>
			 	<input type="text" value="<?php echo $row['des_mer']; ?>" size=45 disabled="disabled"/>
				<input type="hidden" name="nummer" id="nummer" value="<?php echo $row['cod_mer'];?>" />			
			 <?php 	
			 }
			 
			 ?>*
		 </td>
	 </tr>
	 <tr> 	 
  		<td>Fecha vigencia:</td>
		<td><?php if($modo==1){ ?>
						<input type="text" name="fecpre" id="fecpre" size="10" maxlength="10" value=""  />
			<?php }else{ ?>
						<input type="text" name="fecpre" id="fecpre" size="10" maxlength="10" 
										value="<?php echo $row['fec_pre'];?>"  />*
			<?php } ?>
			
			 formato: aaaa-mm-dd</td>
	  </tr>
	  <tr>
		<td>Moneda :</td>
		<td><?php	$link=Conecta();
					if($modo==1){ 
						echo "<select name='txtmoneda'>";
							echo "<option value='' selected='selected'>sin seleccionar</option>";
							  $resmoneda=mysql_query($sqlmoneda); 
							  while ($fila=mysql_fetch_row($resmoneda)){ 
									echo "<option value='$fila[1]'>$fila[1]";
							  } 
							  echo "</select>";
 			?>*
		</td>	
			<?php }else{ 
						echo "<select name='txtmoneda'>";
							echo "<option selected='selected'>".$row['moneda_pre']."</option>";
							  $resmoneda=mysql_query($sqlmoneda); 
							  while ($fila=mysql_fetch_row($resmoneda)){ 
									echo "<option value='$fila[1]'>$fila[1]";
							  } 
						echo "</select>";
							  ?>
			<?php } 
			Desconecta($link);
			?>								
		</td> 												
	</tr>
	  <tr> 	 
  	     <td>Precio unitario:</td>
		 <td><?php if($modo==1){ ?>
				     <input type="text" name="numval" value="" size="10" maxlength="10" />
			 <?php }else{ ?>
						<input type="text" name="numval" value="<?PHP echo $row['val_pre'];?>" size="10" maxlength="10" />
			 <?php } ?>* formato: 123.50 </td>
	  </tr>
	
    </TABLE>
	      <input type="hidden" name="id"   value="<?php echo $id ;?>" />
          <input type="hidden" name="modo" value="<?php echo $modo ; ?>" />
 		  <center>
		   <INPUT TYPE="button" VALUE="<?php echo $boton;?>" onClick="ValidarForm(this.form,<?php echo $modo;?>)"/>
				<?php    if($modo==1){ ?>
					<input type="reset" value="LIMPIAR" />
				<?php	  } 	?>
			</CENTER>
		
    </FORM>
	</div>
 </body>
</html>