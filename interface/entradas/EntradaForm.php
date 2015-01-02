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
				
		if(form.txtins.value=="" ){ 
      		 alert("ELEGIR UN INSUMO"); 
			 form.txtins.focus();
			 return; 
    	} 
		if (form.numuni.value<=0){        
			alert("INGRESAR LA CANTIDAD DEL INSUMO");
			form.numuni.focus();
			return;
		} 
		var recibido=form.txtfecha.value;
		if (Validafecha(recibido)==false){;
			form.txtfecha.value="";
			form.txtfecha.focus();
			return;
		}
				
		if(form.txttip.value==" "){ 
      		 alert("ELEGIR TIPO"); 
			 form.txttip.focus();
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
}else{
 $modo=$_GET['modo'];
}  
if($modo==2 ||$modo==3 || $modo==4){           
 	$id=$_POST['id'];
	$link=Conecta();   //en Persistencia.php
	$sql="select * FROM stock s, insumo i  WHERE s.id_insumo = i.id_insumo and s.id_stock=".$id;
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	   $titulo=" MODIFICAR ENTRADA";
	   $boton="MODIFICAR";
	}elseif($modo==3){
	   $titulo="ELIMINAR ENTRADA"; 
	   $boton="ELIMINAR";
	}elseif($modo==4){
		$titulo="VER ENTRADA"; 
	    $boton="SALIR";
	}	  
 }else{
	 $titulo="ALTA DE ENTRADA";
	 $boton="INGRESAR";
 } 
?>
<h2><center><?php echo $titulo; ?><img src='../../iconos/box_48.png' border="0"></center></h2>
<form name="form2" action="../../dominio/entradas/EntradaMant.php" method="POST" >
 <center>
 <TABLE  width="40%" CELLSPACING="2"  CELLPADDING="2" style="font-size:12px">
    <tr><td>Insumo :</td>
		<td><?php if($modo==1){ 
					echo "<select name='txtins'>";
						echo "<option value='' selected='selected'>sin seleccionar</option>";
								$link=Conecta();
								$sql_insumo="SELECT * FROM insumo WHERE 1=1 ORDER BY des_insumo ASC";
								$res_insumo=mysql_query($sql_insumo);
								Desconecta($link);
						while ($fila=mysql_fetch_row($res_insumo)){ 
							echo "<option value='$fila[0]'>$fila[1]";
						} 
					echo "</select>";
					?>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtins" VALUE="<?PHP echo $row['des_insumo'];?>" SIZE="45" MAXLENGTH="45"/>
			<?php } ?>*	
		</td>
    </tr>
	<tr><td>Cantidad :</td>
		<td><?php if($modo==1){?>
					<INPUT TYPE="text" NAME="numuni" VALUE=" " SIZE="8" MAXLENGTH="8" />
	  		<?php }else{ ?>
					<INPUT TYPE="text" NAME="numuni" VALUE="<?PHP echo $row['cant_stock'];?>" SIZE="12" MAXLENGTH="12" />
	  		<?php } ?> *
		</td>
	</tr>
	<tr><td>Fecha :</td>
		<td><?php if($modo==1){?>
					<INPUT TYPE="text"  NAME="txtfecha"  VALUE=""  SIZE="10" MAXLENGTH="10"/>
			<?php }else{ ?>
					<INPUT TYPE="text"  NAME="txtfecha"  VALUE="<?php echo $row['fec_stock'];?>"  SIZE="10" MAXLENGTH="10"/>
			<?php } ?>*				
		</td>
	</tr>
  	<tr><td>Tipo :</td>
		<td><?php if($modo==1){?>
					<select name="txttip" VALUE=" " size="1" >
						<option value="sin seleccionar">seleccionar</option>
						<option value="I"              >INGRESO</option>
						<option value="C"              >CONSUMO</option>
						<option value="E"              >EGRESO</option>
					</select>
			<?php }else{ ?>
					<select name="txttip" VALUE="<?php echo $row['tip_stock'];?>" size="1" >
						<option value="<?php echo $row['tip_stock'];?>"><?php echo $row['tip_stock'];?></option>
						<option value="I" >INGRESO</option>
						<option value="C" >CONSUMO</option>
						<option value="E" >EGRESO</option>
						
					</select>
			<?php } ?>*
		</td>
	</tr>
 </TABLE>  
 </center>
         <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ; ?>"/>
 <?php
 	     if($modo!=1){  ?>
		  	<input type="hidden" name="numstock" value="<?php echo $row['id_stock'];?>" />
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE="<?php echo $boton ;?>" onClick="Validar(this.form)";/>
 <?php   if($modo==1){ ?>
		    <input type="reset" value="LIMPIAR" />
 <?php	 } ?>	 
		</center>  
 </FORM>
  </div>
 </body>
</html>