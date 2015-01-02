<?php	include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){
	header("location:../../index.php");  exit();
}
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form){             //Validación del formulario 
		var modo=form.modo.value;
		if(form.fecprod.value==""){ 
      		 alert("Ingresar fecha"); 
			 form.fecprod.focus();
			 return; 
		}else{
			var desde=form.fecprod.value;
			if (Validafecha(desde)==false){;
				form.fecprod.value="";
				form.fecprod.focus();
				return;
			}
		}
				
		if (form.canprod.value==0 ){      
			alert("DEBE INGRESAR UNIDADES PRODUCIDAS");
			form.canprod.value="";
			form.canprod.focus();
			return;
		}else{
			var can=form.canprod.value;
			if(IsNumeric(can)== false){
				alert("LA CANTIDAD DE UNIDADES DEBE SER NUMERICA");
				form.canprod.value="";
				form.canprod.focus();
				return;
			}
		}
		if(form.txtrechazo.value==1){
				form.canprod.value=form.canprod.value*(-1);
		}
	
		if(form.nummer.value==""){ 
      		 alert("SELECCIONAR PRODUCTO"); 
			 form.nummer.focus();
			 return; 
		}
		if (modo!=4){
		   ret=confirma();
		}else{
		   ret=true;	
		}   
		if(ret==true){
		   form.submit();
		}else{
		   return;	
		}   
	}
	</script>			
 </head>
<body>
<DIV id="formulario">
<?php
$id=""; $rechazo=0;
if($_POST){
 $modo=$_POST['modo'];  //MODO=1 INGRESA   MODO=2 modifica  y  MODO=3 elimina
 $id=$_POST['id'];
 
}else{
 $modo=$_GET['modo'];
 $id=$_GET['id'];
 $rechazo=$_GET['rechazo'];
}  
 if ($modo==2 ||$modo==3 || $modo==4){           
 	$link=Conecta();   //en Persistencia.php
	$sql="select p.num_prod, p.fec_prod, p.can_prod, p.lot_prod ,p.cod_mer, p.lot_esca,
					m.cod_mer, m.des_mer, m.uni_mer 
						 from mercaderia m , produccion p 
			              where p.num_prod ='$id' and (p.cod_mer = m.cod_mer)";
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	 ?><H2>MODIFICAR ENTRADA</H2><?php
	   $boton="MODIFICAR";
	}elseif($modo==3){
	  ?><H2>ELIMINAR ENTRADA</h2><?php 
	    $boton="ELIMINAR";
	}elseif($modo==4){
		?><H2>FICHA ENTRADA</h2><?php 
	    $boton="SALIR";
	}
 }else{
	 $ssql="select m.cod_mer ,m.des_mer from mercaderia m where 1=1 order by m.des_mer asc";
	 $link=Conecta();
	 if($rechazo==0){ 
	 	 $titulo="INGRESAR ENTRADA";	
	   		
	 }else{
	 	$titulo="RECHAZO DE ENTRADA";
	 } ?>
	 <H2><?php echo $titulo;?></H2><?php
	 $boton="INGRESAR";	
 } ?>
<form name="form1" action="../../dominio/producciones/ProduccionMant.php" method="POST">
 <center>
 <TABLE  width="40%" CELLSPACING="1"  CELLPADDING=1"  style="font-size:12px">
    <tr><td>Fecha:</td>
	    <td><?php	if($modo==1){ ?>
						<input type="text" name="fecprod" value="" size="10" maxlength="10">
			<?php   }else{  ?>
						<input type="text" name="fecprod" value="<?PHP echo $row['fec_prod'];?>" size="10" maxlength="10">
			<?php   } ?>			
		*</td>
	  <td>formato: aaaa-mm-dd</td>
	  </tr>
	<tr><td>Unidades:</td>
	    <td><?php if($modo==1){ ?>
					<input type="text" name="canprod"  value="" size="4" maxlength="4"
												onkeypress="return permite(event,'num')"/>
	        <?php }else{ ?>
					<input type="text" name="canprod"  value="<?PHP echo $row['can_prod'];?>" size="4" maxlength="4"
	              								onkeypress="return permite(event,'num')"/>
			<?php } ?>
		*</td>
	  <td>formato: valor numérico</td>
	</tr>
	<tr>	 														
	 <td>articulo:</td>
	 <td>
     <?php  if($modo==1){ ?>
			 <?php	echo "<select name='nummer'>";
			 			echo "<option value='' selected='selected'>sin seleccionar</option>";
			           $resultado=mysql_query($ssql); 
						while ($fila=mysql_fetch_row($resultado)){ 
							echo "<option  value='$fila[0]'>$fila[1]";	
						} 
						echo "</select>";
						Desconecta($link); ?>	 
  	  <?php	}else{ ?>
				<input type="text" name="desmer"  value="<?php echo $row['des_mer'];?>" 
						size="40" maxlength="45" disabled="disabled"/>
				<input type="hidden" name="nummer" value="<?php echo $row['cod_mer'];?>" />	
	  <?php } ?>
	  *
	 </td>
	 <td>seleccionar de la lista</td>		
   </tr>		 
 </TABLE>
 </center>
         <input type="hidden" name="txtrechazo" value="<?php echo $rechazo;?>" />	
         <input type="hidden" name="modo" value="<?php echo $modo; ?>">
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numprod" value="<?PHP echo $row['num_prod'];?>" >
 <?php   }else{ ?>
 			 <input type="hidden" name="numprod" value="0" />
<?php    }  ?>	
 		 <center>
		 <input type="button" value=<?php echo $boton ?> onClick="ValidarForm(this.form)">
 <?php   if($modo==1){ ?>
		     <input type="reset" value="LIMPIAR" >
 <?php	 } ?> 
		</center>	
		<center><?php echo $_SESSION['ses_error']?></center>	
  </FORM>
  </div>
 </body>
</html>