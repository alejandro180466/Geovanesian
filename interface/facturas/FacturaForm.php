<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/facturas/FacturaClass.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
}	?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form,modo){    //Validación del formulario 
		form.modo.value=modo;
		
	/*	$importe=form.numsub.value;
		if(importe!=""){
		
		
		}else{
			alert('DEBE INGRESAR EL IMPORTE');
			form.numsub.value="";
			form.numsub.focus();
			return;
		}
		fecha = form.fecfac.value;
		
		if (Validafecha(fecha)==false){;
			form.fecfac.value="";
			form.fecfac.focus();
			return;
		}  */
		form.submit();
		return false;
	}
	</script>			
 </head>
<body>
<DIV id="formulario">
<?php
if($_POST){
 $modo=$_POST['modo'];  
 $id=$_POST['id'];
}else{
 $modo=$_GET['modo'];
 $id=$_GET['id'];
}
//elije el cliente 
$ssql="SELECT num_cli, raz_cli , dir_cli , tel_cli FROM cliente where 1=1 ORDER BY  raz_cli ASC";
$link=Conecta();
$boton="INGRESAR";
$titulo="INGRESO MANUAL DE LA FACTURA"; ?>

<H3><center><?php echo $titulo; ?></center></h3>
</br>	
   <form name="form1" action="../../dominio/facturas/FacturaMant.php" method="POST">
    <TABLE  width=40% CELLSPACING=1  CELLPADDING=1  align="center">
      <tr><td>Razón social :</td>
		<td><?php echo "<select name='numcli'>";
			 		   echo "<option value='' selected='selected'>sin seleccionar</option>";
			           $resultado=mysql_query($ssql); 
						while ($fila=mysql_fetch_row($resultado)){ 
							 
								echo "<option value='$fila[0]'>$fila[1]";	
							 
						} 
						echo "</select>";
						Desconecta($link); ?>	 
	    </td>
     </tr>
     <tr><td>Tipo documento </td><td><select name="txttipdoc" value="" size="1" >
  				<option value=""><?PHP echo "ELEGIR DOCUMENTO";?></option>
				<option value="FACTURA CONTADO"   >FACTURA CONTADO   </option>
  				<option value="FACTURA CREDITO"   >FACTURA CREDITO   </option>
				<option value="DEVOLUCION CONTADO">DEVOLUCION CONTADO</option>
				<option value="NOTA DE CREDITO"   >NOTA DE CREDITO   </option>
				<option value="NOTA DE DEVOLUCION">NOTA DE DEVOLUCION</option>
				<option value="NOTA REMITO"       >NOTA REMITO       </option>
				<option value="SALDO INICIAL"     >SALDO INICIAL     </option>
			</select>*</td>
	  </TR>
	  <tr><td>FECHA DE EMISION :</td><td><input type="text" name="fecfac" id="fecfac" size="10" maxlength="10" />formato: aaaa-MM-dd</td>
	  </tr>
	  <tr><td>SERIE DEL DOCUMENTO :</td>
	       <td><input type="text"  size="2"maxlength="1" name="numser" id="numser"   
			   	                                   	onkeypress="return permite(event,'car')"/></td> 
      </tr>
	  <tr><td>NUMERO DOCUMENTO :</td><td><input type="text"  size="7"maxlength="6" name="numfac" id="numfac"   
			   	                                   	onkeypress="return permite(event,'num')"/></td> 
      </tr>
	  <tr><td>IMPORTE SUBTOTAL : $</td><td><input type="text"  size="10"maxlength="10" name="numsub" id="numsub"   
		   	                                    	onkeypress="return permite(event,'num')"/></td> 
												
      </tr><tr><td>IMPORTE IVA : $</td><td><input type="text"  size="10"maxlength="10" name="numiva" id="numiva"   
			   	                                   	onkeypress="return permite(event,'num')"/> </td> 
      </tr>
	</TABLE>
	      <input type="hidden" name="id"   value="<?php echo $id ;?>" />
          <input type="hidden" name="modo" value="5" />
 		  <center>
		   <INPUT TYPE="button" VALUE="<?php echo $boton;?>" onClick="ValidarForm(this.form,5)"/>
		  </center>
    </FORM>
	<div>
 </body>
</html>