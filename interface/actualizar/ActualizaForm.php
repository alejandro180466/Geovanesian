<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
//session_start();
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form,modo){    //Validación del formulario 
		form.modo.value=modo;
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
if ($modo==1){ //ingresar precio nuevo
	$sqlcli="select * FROM cliente WHERE 1=1 ORDER BY raz_cli ASC";
	$sqlmer="select * FROM mercaderia WHERE 1=1 ORDER BY des_mer ASC";
	$sqlmon="SELECT * FROM moneda WHERE 1=1 ORDER BY moneda_nombre ASC";
	$boton="INGRESAR";
	$titulo="INGRESO DE ACTUALIZACION DE PRECIO";
	
}elseif($modo==2){ //modificar
    $boton="MODIFICAR";
	$titulo="MODIFICAR LA ACTUALIZACION DE PRECIOS";
    $sql="SELECT c.num_cli, c.raz_cli, 
					a.id_update, a.fecha_update, a.cod_mer, a.num_cli, a.cat_mer, a.nom_user,
						a.porcent_update,a.uni_update, a.cat_update, a.moneda_update,  
							m.cod_mer , m.des_mer, m.cat_mer
								FROM cliente c , actualiza a , mercaderia m
									WHERE c.num_cli = a.num_cli
										AND a.cod_mer = m.cod_mer
											AND a.id_update =". $id;
	$pedi=ejecutarConsulta($sql,$link);
    $row=mysql_fetch_array($pedi);						  
}							  
?>
<DIV id="formulario">
	<CENTER><H2><?php echo $titulo;?></H2></CENTER>
	<form name="form1" action="../../dominio/actualizar/ActualizaMant.php" method="POST">
	 <TABLE CELLSPACING="1"  CELLPADDING="1"  >
   
	    <tr>													
	   <td>Criterio :</td>
	   <td><select name="opcionup" VALUE="<?PHP echo $row['cat_update'];?>" size="1" >
						 <option value='' selected='selected'>sin seleccionar</option>
  						 <option value="L">ACTUALIZA LISTA</option>
  						 <option value="E">ACTUALIZA PRECIOS ESPECIALES</option>
		  </select>
		</td>
      </tr>
	  <tr>
        <td>Razón social :</td>
		<td>
		  <?php echo "<select name='numcli'>";
			 if($modo==1){
			     echo "<option value='' selected='selected'>sin seleccionar</option>";
			 	 $resultadocli=mysql_query($sqlcli); 
				 while ($fila=mysql_fetch_row($resultadocli)){ 
					if ($fila[0]==$fila['raz_cli']){
						echo "<option selected value='$fila[0]'>$fila[1]";	
					}else{ 
						echo "<option value='$fila[0]'>$fila[1]";	
					} 
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
		 ?>	 
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
				 	//if ($fila[0]==$row['des_mer']){
						//echo "<option selected value='$fila[0]'>$fila[1]";	
					//}else{ 
					    echo "<option value='$fila[0]'>$fila[1]";	
					//} 
				}
				echo "</select>";
		   	    Desconecta($link);
			}else{ ?>
			 	<input type="text" value="<?php echo $row['des_mer']; ?>" size=45 disabled="disabled"/>
				<input type="hidden" name="nummer" id="nummer" value="<?php echo $row['cod_mer'];?>" />			
			 <?php 	
			}
			
			 ?>
		 </td>
	 </tr>
	<?php
	if($modo!=1){ ?>
	 <tr> 	 
  		<td>Fecha actualizacion:</td>
		<td>
		 	<input type="text" name="fechaup" id="fechaup" size="10" maxlength="10" 
			               value="<?PHP echo $row['fecha_update'];?>"  />
		    formato: aaaa/mm/dd</td>
	  </tr>
	  <?php 			   
	}  
	//if($modo!=1){ ?>
	  <tr> 	 
  	    <td>Porcentaje :</td>
		<td>
			<!--input type="text" name="porciento" id="`porciento" value="<?PHP //echo $row['porcent_update'];?>" size="6" maxlength="6" /-->
			<input type="text" name="porciento" id="`porciento"  size="6" maxlength="6" />
		</td>
	  </tr>
	  <?php
	//  } ?>
	  <tr> 	 
  	    <td>Precio unitario:</td>
		<td>
			<!--input type="text" name="porunitario" id="`porunitario" value="<?PHP echo $row['uni_update'];?>" size="10" maxlength="10" /-->
			<input type="text" name="porunitario" id="`porunitario"  size="10" maxlength="10" />
		</td>
	  </tr>
	  
	</TABLE>
	      <input type="hidden" name="id"   value="<?php echo $id ;?>" />
          <input type="hidden" name="modo" value="<?php echo $modo ; ?>" />
 		  <center>
		   <INPUT TYPE="button" VALUE="<?php echo $boton;?>" onClick="ValidarForm(this.form,<?php echo $modo;?>)"/>
		  </center>
    </FORM>
 </div>	
 </body>
</html>