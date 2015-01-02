<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/facturas/FacturaLineaClass.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");		exit();
}	?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form,modo){    //Validación del formulario 
		
		if(form.numcli.value==""){ 
      		 alert("SELECCIONAR CLIENTE"); 
			 form.numcli.focus();
			 return; 
		}
		if(form.numrec.value=="" || form.numrec==0){ 
      		 alert("INGRESAR EL NUMERO DE RECIBO"); 
			 form.numrec.focus();
			 return; 
		}else{
			if(esnumeroentero(form.numrec.value)==false){
				alert("EL RECIBO ES SOLO NUMERICO");
				form.numrec.value="";
				form.numrec.focus();
				return;
			}	
		}
			
		var fecha = form.fecrec.value;
		if (Validafecha(fecha)==false){;
			form.fecrec.value="";
			form.fecrec.focus();
			return;
		}
		
		var importe = form.numtotal.value;
		if(importe!=""){
				
		}else{
			alert('DEBE INGRESAR EL IMPORTE');
			form.numtotal.value="";
			form.numtotal.focus();
			return;
		}
				
		form.modo.value=modo;
		form.submit();
		return false;
	}
	</script>			
 </head>
<body>
<?php
$id="";
if($_POST){
 $modo=$_POST['modo'];  
 $id=$_POST['id'];
}else{
 $modo=$_GET['modo'];
 $id=$_GET['id'];
}
if ($modo==1){ //elije el cliente y fecha del pedido
	$ssql="SELECT num_cli, raz_cli , dir_cli , tel_cli FROM cliente WHERE 1=1 ORDER BY raz_cli ASC";
	$link=Conecta();
	$boton="INGRESAR";
	$titulo="INGRESO DEL RECIBO";
}elseif($modo==2){
    $boton="MODIFICAR";
	$titulo="MODIFICAR RECIBO";
	$sql="SELECT c.num_cli, c.raz_cli,
					 r.id_recibo , r.num_cli , r.num_recibo , r.fec_recibo ,
					 r.tot_recibo, r.mem_recibo, r.nul_recibo
						FROM cliente c , recibo r
							WHERE c.num_cli = r.num_cli
							  AND r.id_recibo = ".$id;
	$link=Conecta();
	$pedi=ejecutarConsulta($sql,$link);
	$row=mysql_fetch_array($pedi);
	
}	?>
<BR></BR>
 <CENTER><font style="font-size:24px;"><?php echo $titulo; ?></font></CENTER>
   <form name="form1" action="../../dominio/recibos/ReciboMant.php" method="POST">
    <TABLE  width="40%" CELLSPACING="1"  CELLPADDING="1"  align="center" >
		<tr><td>Razón social :</td>
			<td>
			<?php
			if($modo==1){		  
		  	  	 echo "<select name='numcli'>";
			 		echo "<option value='' selected='selected'>sin seleccionar</option>";
			           $resultado=mysql_query($ssql); 
						while ($fila=mysql_fetch_row($resultado)){ 
							echo "<option value='$fila[0]'>$fila[1]";	
						} 
						echo "</select>";
						Desconecta($link);
			}else{ ?>
			  <input type="text" value="<?php echo $row['raz_cli'];?>" size="40" maxlength="40"/>
			  <input type="hidden" name="numcli" id="numcli" value="<?php echo $row['num_cli']; ?>" />
			  <?php	
			} ?>	 
			</td>
		</tr>
	    <tr><td>Nº recibo : </td>
			<td><?php if($modo==1){ ?>
		             <input type="text" name="numrec" id="numrec" size="6" maxlength="6" />
				<?php }else{ ?>
			         <input type="text" name="numrec" id="numrec" value="<?PHP echo $row['num_recibo'];?>" size="10" maxlength="10" />
				<?php } ?>
			</td>
		</tr>
		<tr><td>Fecha de cobro : </td>
			<td><?php if($modo==1){ ?>
					 <input type="text" name="fecrec" id="fecrec" size="10" maxlength="10" />
				<?php }else{ ?>
					 <input type="text" name="fecrec" value="<?PHP echo $row['fec_recibo'];?>" size="10" maxlength="10" />
				<?php } ?>	
			</td>
		</tr>
		<tr><td>Importe : </td>
			<td><?php if($modo==1){ ?>
		              <input type="text" name="numtotal" id="numtotal" size="11" maxlength="11" />
			 <?php }else{ ?> 
		              <input type="text" name="numtotal" value="<?PHP echo $row['tot_recibo'];?>" size="11" maxlength="11" />
			  <?php } ?>
			</td>
		</tr>
		<tr><td>Comentario:</td>
			<td><?php if($modo==1){ ?>
						<textarea rows="2" cols="31" maxlength="60" NAME="txtmemo"  
							onkeypress="return permiteconespacios(event,'num_car')">
						</textarea>
				<?php }else{ ?> 
						<textarea rows="2" cols="31" maxlength="60" NAME="txtmemo"  
							onkeypress="return permiteconespacios(event,'num_car')">
							<?PHP echo $row['mem_recibo'];?>
						</textarea>
				<?php } ?>
			</td> 
		</tr>
    </TABLE>
	      <input type="hidden" name="id"   value="<?php echo $id ;?>" />
          <input type="hidden" name="modo" value="<?php echo $modo ; ?>" />
 		  <center>
		   <INPUT TYPE="button" VALUE="<?php echo $boton;?>" onClick="ValidarForm(this.form,<?php echo $modo;?>)"/>
		  </center>
		  <center><?php echo $_SESSION['ses_error']?></center>
    </FORM>
 </body>
</html>