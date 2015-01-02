<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){  	header("location:../../index.php");		exit();}	?>
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
	$id="";
} 
if ($modo==1){                //elije el cliente y fecha del pedido
	$boton="INGRESAR";
	$titulo="INGRESA ALERTA";
}elseif($modo==2){
    $boton="MODIFICAR";
	$titulo="MODIFICAR ALERTA";
	$sql="SELECT *	FROM alertas WHERE alertas_id = $id";
	$link=Conecta();
	$pedi=ejecutarConsulta($sql,$link);
	$row=mysql_fetch_array($pedi);
	Desconecta($link);
}	?>
<DIV id="formulario">
 <CENTER><font style="font-size:24px;"><?php echo $titulo; ?></font></CENTER>
  <form name="form1" action="../../dominio/alertas/AlertaMant.php" method="POST">
    <TABLE  CELLSPACING="1"  CELLPADDING="1"  >
		<tr><td>Concepto :</td>
			<td>
			  <?php 
				if($modo==1){ ?>
					<input type="text" name="txtconcepto" id="txtconcepto" value="" size="30" maxlength="30"/>	
				<?php  	 
				}else{ ?>
				  <input type="text" name="txtconcepto" id="txtconcepto" value="<?php echo $row['concepto'];?>" size="30" maxlength="30"/>
				  <input type="hidden" name="id" id="id" value="<?php echo $row['alertas_id']; ?>" />
				  <?php	
				} ?>	 
			</td>
		</tr>
	    <tr><td>Detalle : </td>
			<td><?php if($modo==1){ ?>
						 <input type="text" name="txtdet" id="txtdet" size="40" maxlength="40" />
				<?php }else{ ?>
						 <input type="text" name="txtdet" id="txtdet" value="<?PHP echo $row['detalle'];?>"
							size="40" maxlength="40" />
				<?php } ?>
			</td>
		</tr>
	<?php if($modo!=1){ ?>  
		<tr><td>Ingresado : </td>
			<td><input type="text" name="fechoy" id="fechoy" size="10" maxlength="10" 
						value="<?PHP echo $row['hoy'];?>" />formato : 2011/12/01
			</td>
		</tr>
	<?php } ?> 
		<tr><td>Vence : </td>
			<td><?php if($modo==1){ ?>
					 <input type="text" name="fecvence" id="fecvence" size="10" maxlength="10" />
			<?php }else{ ?>
					 <input type="text" name="fecvence" id="fecvence" size="10" maxlength="10" 
									value="<?PHP echo $row['vence'];?>" />
			<?php } ?>	formato : 2011/12/01
			</td>
		</tr>
		<tr><td>Previo : </td>
			<td><?php if($modo==1){ ?>
		              <input type="text" name="numprevio" id="numprevio" size="3" maxlength="3" />
			 <?php }else{ ?> 
		              <input type="text" name="numprevio" id="numprevio" value="<?PHP echo $row['previo'];?>" size="3" maxlength="3" />
			  <?php } ?> días
			</td>
		</tr>
		<tr><td>Estado : </td>
			<td><?php if($modo==1){ ?>
						<select name="txtestado" size="1" >
							<option value="" selected="selected">sin seleccionar</option>
  							<option value="P"  >PENDIENTE</option>
							<option value="C"  >CANCELADO</option>
							<option value="E"  >EJECUTADO</option>
						</select>
			<?php }else{ ?> 
		              <input type="text" name="txtestado" id="txtestado" value="<?PHP echo $row['estado'];?>" size="1" maxlength="1" />
			<?php } ?>
			</TD>	  
			<td style="font-size:12px" >elegir del listado</td>				  
		</tr>
		<tr><td>Comentario:</td>
			<td><?php if($modo==1){ ?>
					<textarea rows="2" cols="31" maxlength="60" NAME="txtmemo"  
						onkeypress="return permiteconespacios(event,'num_car')">
					</textarea>
			<?php }else{ ?> 
					<textarea rows="2" cols="31" maxlength="60" NAME="txtmemo"  
						onkeypress="return permiteconespacios(event,'num_car')">
						<?PHP echo $row['memo'];?>
					</textarea>
			<?php } ?>
			</td> 
		</tr>
    </TABLE>
	<input type="hidden" name="id"   value="<?php echo $id ;?>" />
    <input type="hidden" name="modo" value="<?php echo $modo ; ?>" />
 	<INPUT TYPE="button" VALUE="<?php echo $boton;?>" onClick="ValidarForm(this.form,<?php echo $modo;?>)"/>
   </FORM>
  </div>
 </body>
</html>