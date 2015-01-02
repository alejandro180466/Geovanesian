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
    function ValidarForm(form){    //Validación del formulario 
		var modo=form.modo.value;
		
		var raz = form.txtraz.value;
		var razlargo = form.txtraz.value.length;
		if(razlargo <6 ){ //controla que el nombre no este vacío.
      		 alert("Tiene que escribir la razón social sin espacios al inicio y ser un nombre valido"); 
			 form.txtraz.focus();
			 return; 
    	} 
		
		var rut=form.numrut.value;          //validacion del RUT
		var rutlargo=form.numrut.value.length;
		var isnum=esnumeroentero(rut);
		
		if(rutlargo!=12 || isnum==false){
		  if(rutlargo!=1){
		     alert("El rut debe contener solo numeros (12 digitos)"); 
			 form.numrut.value="";
      	 	 form.numrut.focus();
			 return;
		  }else{
		  	form.numrut.value="X";
		  }		  
		}
				
		if (form.txtcity.value==0){        //validar departamento
			alert("DEBE SELECCIONAR UN DEPARTAMENTO");
			form.txtcity.focus();
			return;
		} 
				
		var fono=form.numfono.value;          //validacion del telefono
		var fonolargo=form.numfono.value.length;
		var isnum=esnumeroentero(fono);
		if(fonolargo!=8 || isnum==false){ 
      		 alert("El teléfono debe contener solo numeros (8 digitos)"); 
			 form.numfono.value="";
      	 	 form.numfono.focus();
			 return; 
		}
		
				
		var fax=form.numfax.value;          //validacion del fax
		var faxlargo=form.numfax.value.length;
		var isnum=esnumeroentero(fax);
		if (fax!="" && fax!="0" ){
		 if(faxlargo!=8 || isnum==false){ 
      		 alert("El fax debe contener solo numeros (8 digitos)"); 
			 form.numfax.value="";
      	 	 form.numfax.focus();
			 return; 
		 }
		}
		
		var cel=form.numcel.value;          //validacion del celular
		var cellargo=form.numcel.value.length;
		var isnum=esnumeroentero(cel);
		if (cel!="" && cel!="0" ){
		 if(cellargo!=9 || isnum==false){ 
      		 alert("El celular debe contener solo numeros ( 9 digitos)"); 
			 form.numcel.value="";
      	 	 form.numcel.focus();
			 return; 
		 }
		}
				
		if(!form.txtmail.value){
		 var valid=validomail(form.txtmail.value);
		 if(valid==false){     //controla que el mail sea válido
		     alert("Ingrese un mail válido"); 
			 form.txtmail.focus();
			 return; 
    	 }
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
 if ($modo==2 ||$modo==3 || $modo==4){           
 	$id=$_POST['id'];
	$link=Conecta();   //en Persistencia.php
	$sql="SELECT num_cli ,raz_cli , rut_cli, dir_cli, dep_cli , tel_cli , tel_cli2 , fax_cli , cel_cli ,
					 mail_cli, cont_cli, ent_cli, fpag_cli ,pag_cli, com_cli, suc_cli, plazo_cli
						FROM cliente WHERE num_cli=".$id;
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	 ?><H2><CENTER>MODIFICAR DATOS DEL CLIENTE<img src='../../iconos/userp.png' border="0"></CENTER></H2><?php
	   $boton="MODIFICAR";
	}elseif($modo==3){
	  ?><H2><CENTER>ELIMINAR CLIENTE<img src='../../iconos/userp.png' border="0"></CENTER></h2><?php 
	    $boton="ELIMINAR";
	}elseif($modo==4){
		?><H2><CENTER>FICHA CLIENTE<img src='../../iconos/userp.png' border="0"></CENTER></h2><?php 
	    $boton="SALIR";
	}	  
 }else{
	 ?><H2><CENTER>ALTA DE CLIENTE<img src='../../iconos/userp.png' border="0"/></CENTER></H2><?php
	   $boton="INGRESAR";
 } 
?>
<form name="form1" action="../../dominio/clientes/ClienteMant.php" method="POST">
<center>
 <TABLE border="0" width="60%" CELLSPACING="1"  CELLPADDING="1"  style="font-size:12px">
   <tr>
		<td>Razón social :</td>
		<td><?php if($modo==1){ ?>
				<INPUT TYPE="text" NAME="txtraz" VALUE="" SIZE="30" MAXLENGTH="30"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php }else{ ?>
				<INPUT TYPE="text" NAME="txtraz" VALUE="<?PHP echo $row['raz_cli'];?>" SIZE="30" MAXLENGTH="30"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php } ?>							
		*</td>
   	 	<td>RUT :</td>
		<td><?php if($modo==1){ ?>
						<INPUT TYPE="text" NAME="numrut" VALUE="" SIZE="12" MAXLENGTH="12" 
				title="PARA INGRESAR CLIENTES SIN RUC DIGITE SOLO UN NUMERO"
				onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="numrut" VALUE="<?PHP echo $row['rut_cli'];?>" SIZE="12" MAXLENGTH="12" 
				title="PARA INGRESAR CLIENTES SIN RUC DIGITE SOLO UN NUMERO"
				onkeypress="return permite(event,'num')"/>
			<?php } ?>	
		*</td>
   </tr>
   <tr>
		<td>Dirección :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtdir"  VALUE="" SIZE="30" MAXLENGTH="35" 
	 										onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtdir"  VALUE="<?PHP echo $row['dir_cli'];?>" SIZE="30" MAXLENGTH="35" 
	 										onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php } ?>									
		*</td> 												
   													
		<td>Depto. :</td>
		<td><?php 	if($modo==1){ ?>
						<select name="txtcity" VALUE="" size="1"
							title="SELECCIONAR UN DEPARTAMENTO">
							<option value=""              >elegir...</option>
							<option value="ARTIGAS"       >ARTIGAS</option>
							<option value="CANELONES"     >CANELONES</option>
							<option value="CERRO LARGO"   >CERRO LARGO</option>
							<option value="COLONIA"       >COLONIA</option>
							<option value="DURAZNO"       >DURAZNO</option>
							<option value="FLORES"        >FLORES</option>
							<option value="FLORIDA"       >FLORIDA</option>
							<option value="LAVALLEJA"     >LAVALLEJA</option>
							<option value="MALDONADO"     >MALDONADO</option>
							<option value="MONTEVIDEO"    >MONTEVIDEO</option>
							<option value="PAYSANDU"      >PAYSANDU</option>
							<option value="RIO NEGRO"     >RIO NEGRO</option>
							<option value="RIVERA"        >RIVERA</option>
							<option value="ROCHA"         >ROCHA</option>
							<option value="SALTO"         >SALTO</option>
							<option value="SAN JOSE"      >SAN JOSE</option>
							<option value="SORIANO"       >SORIANO</option>
							<option value="TACUAREMBO"    >TACUAREMBO</option>
							<option value="TREINTA Y TRES">TREINTA Y TRES</option>
						</select>
			<?php   }else{ ?>
						<select name="txtcity" VALUE="<?PHP echo $row['dep_cli'];?>" size="1"
							title="SELECCIONAR UN DEPARTAMENTO">
							<option value="<?PHP echo $row['dep_cli'];?>"><?PHP echo $row['dep_cli'];?></option>
							<option value="ARTIGAS"       >ARTIGAS</option>
							<option value="CANELONES"     >CANELONES</option>
							<option value="CERRO LARGO"   >CERRO LARGO</option>
							<option value="COLONIA"       >COLONIA</option>
							<option value="DURAZNO"       >DURAZNO</option>
							<option value="FLORES"        >FLORES</option>
							<option value="FLORIDA"       >FLORIDA</option>
							<option value="LAVALLEJA"     >LAVALLEJA</option>
							<option value="MALDONADO"     >MALDONADO</option>
							<option value="MONTEVIDEO"    >MONTEVIDEO</option>
							<option value="PAYSANDU"      >PAYSANDU</option>
							<option value="RIO NEGRO"     >RIO NEGRO</option>
							<option value="RIVERA"        >RIVERA</option>
							<option value="ROCHA"         >ROCHA</option>
							<option value="SALTO"         >SALTO</option>
							<option value="SAN JOSE"      >SAN JOSE</option>
							<option value="SORIANO"       >SORIANO</option>
							<option value="TACUAREMBO"    >TACUAREMBO</option>
							<option value="TREINTA Y TRES">TREINTA Y TRES</option>
						</select>
			 <?php  } ?>
		*</td>
   </tr>
   <tr>
		<td>Teléfono1 :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text"  NAME="numfono"  VALUE=""  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text"  NAME="numfono"  VALUE="<?PHP echo $row['tel_cli'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php } ?>									
		*</td>
		<td>Teléfono2 :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text"  NAME="numfono2"  VALUE=""  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text"  NAME="numfono2"  VALUE="<?PHP echo $row['tel_cli2'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php } ?>									
		</td>
   </tr>
   <tr> 	 
		<td>Fax :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text"  NAME="numfax"  VALUE=""  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text"  NAME="numfax"  VALUE="<?PHP echo $row['fax_cli'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php }?>									
		</td>
		<td>Móvil :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="numcel" VALUE="" SIZE="12" MAXLENGTH="9"
												onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="numcel" VALUE="<?PHP echo $row['cel_cli'];?>" SIZE="12" MAXLENGTH="9"
												onkeypress="return permite(event,'num')"/>
			<?php }?>									
		</td>
    </tr>
    <tr>	 
		<td>Mail :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text"  NAME="txtmail" VALUE="" SIZE="30" MAXLENGTH="35" 
	 					title="SI EL CLIENTE NO TIENE MAIL INGRESE UN ESPACIO EN BLANCO"></td>
			<?php }else{ ?>
					<INPUT TYPE="text"  NAME="txtmail" VALUE="<?PHP echo $row['mail_cli'];?>" SIZE="30" MAXLENGTH="35" 
	 					title="SI EL CLIENTE NO TIENE MAIL INGRESE UN ESPACIO EN BLANCO">
			<?php } ?>			
		</td>
   
		<td>Contacto:</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtcont" VALUE="" SIZE="20" MAXLENGTH="25"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtcont" VALUE="<?PHP echo $row['cont_cli'];?>" SIZE="20" MAXLENGTH="25"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php } ?>									
		</td>
    </tr>
    <tr>	 
		<td>horario entrega :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtentrega" VALUE="" SIZE="30" MAXLENGTH="40"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtentrega" VALUE="<?PHP echo $row['ent_cli'];?>" SIZE="30" MAXLENGTH="40"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php } ?>									
		</td>
		<td>horario pago :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtpago" VALUE="" SIZE="20" MAXLENGTH="40"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtpago" VALUE="<?PHP echo $row['pag_cli'];?>" SIZE="20" MAXLENGTH="40"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }?>									
		</td>
    </tr>
    <tr>	 
   		<td>forma de pago :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtfpago" VALUE="" SIZE="30" MAXLENGTH="40"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtfpago" VALUE="<?PHP echo $row['fpag_cli'];?>" SIZE="30" MAXLENGTH="40"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }?>													
		</td>
		<td>plazo otorgado :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="numplazo" VALUE="" SIZE="3" MAXLENGTH="2"
												onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="numplazo" VALUE="<?PHP echo $row['plazo_cli'];?>" SIZE="3" MAXLENGTH="2"
												onkeypress="return permite(event,'num')"/>
			<?php } ?>										
		</td>										
	</tr>
	<tr>
		<td>Comentarios :</td>
		<td colspan="1">
			<?php if($modo==1){ ?>
					<textarea rows="2" cols="40" maxlength="120" NAME="txtcomenta"  
							onkeypress="return permiteconespacios(event,'num_car')">
							
					</textarea>
			
			<?php }else{ ?>
					<textarea rows="2" cols="59" maxlength="120" NAME="txtcomenta"  
							onkeypress="return permiteconespacios(event,'num_car')">
							<?PHP echo $row['com_cli'];?>
					</textarea>
			<?php } ?>		
		</td>
		<td>Tiene sucursales : </td>
		<td colspan="2">
			<?php if($modo==1){ ?>
						<INPUT TYPE="checkbox" NAME="sucursal" ID="sucursal" VALUE="1" />
			<?php }else{ ?>
						<INPUT TYPE="checkbox" NAME="sucursal" ID="sucursal" VALUE="<?php echo $row['suc_cli']; ?>" />
			<?php } ?>		
		</td>
		
   </tr>									
												
 </TABLE>
 </center>
         <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ?>">
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numcli" value="<?PHP echo $row['num_cli'];?>" >
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE=<?php echo $boton; ?> onClick="ValidarForm(this.form)">
 <?php    if($modo==1){ ?>
		     <input type="reset" value="LIMPIAR" /></center>
 <?php	  } 	?>
 </FORM>
  </div>
 </body>
</html>