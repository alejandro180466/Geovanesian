<?php include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function Validar(form){    //Validación del formulario 
		var modo=form.modo.value;
				
		if(form.nummer.value.length <1 ){ //controla que el nombre no este vacío.
      		 alert("Tiene que elegir la mercarderia"); 
			 form.nummer.focus();
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
}else{
 $modo=$_GET['modo'];
}  
if($modo==1 || $modo==2 ||$modo==3 || $modo==4){    
    if($modo==1){ 
		$id="";
	}else{       
 	  $id=$_POST['id'];
	}
	$link=Conecta();   //en Persistencia.php
	// buscar mercaderia
	$sql="select cod_mer ,des_mer from mercaderia ORDER BY des_mer	" ; 
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	// buscar insumo
	$sql2="select id_insumo ,des_insumo from insumo ORDER BY des_insumo	" ; 
	$res2=mysql_query($sql2,$link);       //realizo la consulta
	if (mysql_num_rows($res2)!=0){      //encontro registro?
		$row2=mysql_fetch_array($res2);  //cargo resultado en $row.
	}
	
	
	if($modo==2){ 
	   $titulo=" MODIFICAR FORMULA";
	   $boton="MODIFICAR";
	}elseif($modo==3){
	   $titulo="ELIMINAR FORMULA"; 
	   $boton="ELIMINAR";
	}elseif($modo==4){
		$titulo="VER FORMULA"; 
	    $boton="SALIR";
	}elseif($modo==1){
	 $titulo="ALTA DE FORMULA";
	 $boton="INGRESAR";
	} 
 } 
?>
<h2><center><?php echo $titulo; ?><img src='../../iconos/box_48.png' border="0"></center></h2>
<form name="form2" action="../../dominio/formulates/FormulateMant.php" method="POST" >
 <center>
 <TABLE  width="40%" CELLSPACING="1"  CELLPADDING="1" style="font-size:12px">
    <tr>
		<td>Producto :</td>
		<td>
     	<?php echo "<select name='nummer'>";
					echo "<option value='' selected='selected'>sin seleccionar</option>";
			          $resultado=mysql_query($sql); 
					  while ($fila=mysql_fetch_row($resultado)){ 
						  	echo "<option value='$fila[0]'>$fila[1]";
					  } 
					  echo "</select>";
		?>
		</td>	 
	   	<td style="font-size:12px">elegir de la lista</td>
	</tr>
	<tr>
		<td>Fecha inicial :</td>
		<td><?php if($modo==1){?>	
				<input type="text" name="fecini" value="" size="10" maxlength="10"/>
			<?php }else{ ?>
				<!--input type="text" name="fecstock" value="<?php //echo $row['fecha_mer'];?>" size="10" maxlength="10"/-->
			<?php } ?></td>
		<td style="font-size:12px">formato : aaaa-mm-dd </td>
	</tr>
	<tr>
		<td>Materia prima : :</td>
		<td>
     	<?php echo "<select name='numins'>";
					echo "<option value='' selected='selected'>sin seleccionar</option>";
			          $resultado2=mysql_query($sql2); 
					  while ($fila=mysql_fetch_row($resultado2)){ 
						  	echo "<option value='$fila[0]'>$fila[1]";
							
					  } 
					  echo "</select>";
					  Desconecta($link);
		?>
		</td>	 
	   	<td style="font-size:12px">elegir de la lista</td>
	</tr>
	<tr>
		<td>Cantidad :</td>
		<td><?php if($modo==1){?>	
				<input type="text" name="numcant" value="" size="10" maxlength="10"/>
			<?php }else{ ?>
				<!--input type="text" name="fecstock" value="<?php //echo $row['fecha_mer'];?>" size="10" maxlength="10"/-->
			<?php } ?></td>
		<td style="font-size:12px">formato : 123.32 </td>
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
     <center><?php echo $_SESSION["ses_error"]; ?></center>
 </body>
</html>