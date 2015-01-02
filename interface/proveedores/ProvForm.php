<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
//session_start();
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
		if(razlargo <3 ){ //controla que el nombre no este vacío.
      		 alert("Tiene que escribir la razón social sin espacios al inicio y ser un nombre valido"); 
			 form.txtraz.focus();
			 return; 
    	} 
		
		var rut=form.numrut.value;          //validacion del RUT
		var rutlargo=form.numrut.value.length;
		var isnum=esnumeroentero(rut);
		
		if((rutlargo!=12 || isnum==false) &&(modo==1)){
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
		
		if(form.txtmail.value!=""){		
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
	$sql="select num_pro ,raz_pro , nom_pro , bank_pro , rut_pro, dir_pro, dep_pro , cat_insumo , tel_pro , fax_pro , cel_pro , con_pro , mail_pro 
			from proveedor  where num_pro=".$id;
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	FreeResp($res);    // en Persistencia.php
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	 ?><H2><CENTER>MODIFICAR DATOS DEL PROVEEDOR<img src='../../iconos/userp.png' border="0"></CENTER></H2><?php
	   $boton="MODIFICAR";
	}elseif($modo==3){
	  ?><H2><CENTER>ELIMINAR PROVEEDOR<img src='../../iconos/userp.png' border="0"></CENTER></h2><?php 
	    $boton="ELIMINAR";
	}elseif($modo==4){
		?><H2><CENTER>FICHA PROVEEDOR<img src='../../iconos/userp.png' border="0"></CENTER></h2><?php 
	    $boton="SALIR";
	}	  
 }else{?>
    <H2>
	  <CENTER>ALTA DE PROVEEDOR<img src='../../iconos/userp.png' border="0"></CENTER>
	</H2>
	<?php
    $boton="INGRESAR";
 } 
?>
<form name="form1" action="../../dominio/proveedores/ProvMant.php" method="POST">
<center>
 <TABLE width=50% CELLSPACING=1  CELLPADDING=1 style="font-size:12px">
   <tr>
		<td>Razón social :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtraz" VALUE="" SIZE="30" MAXLENGTH="40"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtraz" VALUE="<?PHP echo $row['raz_pro'];?>" SIZE="30" MAXLENGTH="40"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php } ?>							
		*</td>
   </tr>
   <tr>
		<td>Nombre comercial :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtcom" VALUE="" SIZE="30" MAXLENGTH="40" 
						onkeypress="return permiteconespacios(event,'car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtcom" VALUE="<?PHP echo $row['nom_pro'];?>" SIZE="30" MAXLENGTH="40" 
						onkeypress="return permiteconespacios(event,'car')"/>
			<?php } ?>
		</td>
   </tr>
	<tr>	 														
		<td>RUT</td>
		<td><?php if($modo==1){ ?>
						<INPUT TYPE="text" NAME="numrut" VALUE="" SIZE="12" MAXLENGTH="12"
	 									onkeypress="return permite(event,'num')"/>*
			<?php }else{ ?>
				<INPUT TYPE="text" NAME="numrut" VALUE="<?PHP echo $row['rut_pro'];?>" SIZE="12" MAXLENGTH="12"
	 									onkeypress="return permite(event,'num')"/>*
			<?php } ?>							
		</td>
	</tr>
    <tr>
		<td>Direccion :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtdir"  VALUE="" SIZE="30" MAXLENGTH="35" 
	 										onkeypress="return permiteconespacios(event,'num_car')"/>*
		 <?php }else{ ?>	
					<INPUT TYPE="text" NAME="txtdir"  VALUE="<?PHP echo $row['dir_pro'];?>" SIZE="30" MAXLENGTH="35" 
	 										onkeypress="return permiteconespacios(event,'num_car')"/>*
		<?php } ?>									
		</td> 												
    </tr>
   <tr>													
		<td>Departamento :</td>
		<td><?php if($modo==1){ ?>
					<select name="txtcity" VALUE="" size="1" >
						<option value=""              >seleccionar</option>
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
			<?php }else{ ?>
	 
					<select name="txtcity" VALUE="<?PHP echo $row['dep_pro'];?>" size="1" >
						<option value="<?PHP echo $row['dep_pro'];?>"><?PHP echo $row['dep_pro'];?></option>
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
			<?php } ?>
		*</td>
   </tr>
   <tr>
     <td>Rubro :</td>
	 <td>
       <?php
	   $sql2="select * FROM rubro WHERE est_rubro='HABILITADO' ORDER BY des_rubro asc";
	   $link=Conecta();
	   $resultado=mysql_query($sql2);
	   if($modo==1){
		 	echo "<select name='txtrub'>";
				echo "<option value=''>"."elegir..."."</option>";
		            while ($row2=mysql_fetch_array($resultado)){ 
					    echo "<option value=".$row2['des_rubro'].">".$row2['des_rubro']."</option>";
				    } 
				    echo "</select>";
				    
	   }else{
			echo "<select name='txtrub'>";
				echo "<option value='".$row['cat_insumo']."' selected='selected'>".$row['cat_insumo']."</option>";
				   while ($row2=mysql_fetch_array($resultado)){ 
					    echo "<option value=".$row2['des_rubro'].">".$row2['des_rubro']."</option>";
				    } 
				    echo "</select>";
				    
		}
		Desconecta($link);		  
		?>*
      </td>
   </tr>
    <tr>
		<td>Teléfono :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text"  NAME="numfono"  VALUE=""  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>*
			<?php }else{ ?>
					<INPUT TYPE="text"  NAME="numfono"  VALUE="<?PHP echo $row['tel_pro'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>*
			<?php } ?>									
		</td>
    </tr>
    <tr> 	 
		<td>Fax :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text"  NAME="numfax"  VALUE=""  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>									
					<INPUT TYPE="text"  NAME="numfax"  VALUE="<?PHP echo $row['fax_pro'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>								
			<?php } ?>									
		</td>
    </tr>
    <tr>
        <td>Móvil :</td>
        <td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="numcel" VALUE="" SIZE="9" MAXLENGTH="9"
												onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="numcel" VALUE="<?PHP echo $row['cel_pro'];?>" SIZE="9" MAXLENGTH="9"
												onkeypress="return permite(event,'num')"/>
			<?php } ?>									
		</td>
    </tr>
    <tr>
		<td>Nombre contacto :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtcon" VALUE="" SIZE="25" MAXLENGTH="25"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtcon" VALUE="<?PHP echo $row['con_pro'];?>" SIZE="25" MAXLENGTH="25"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php } ?>
		</td>
    </tr>
   <tr>	 
		<td>Mail :</td>
		<td><?php if($modo==1){ ?>
	 					<INPUT TYPE="text"  NAME="txtmail" VALUE="" SIZE="35" MAXLENGTH="35">
			<?php }else{ ?>	
						<INPUT TYPE="text"  NAME="txtmail" VALUE="<?PHP echo $row['mail_pro'];?>" SIZE="35" MAXLENGTH="35">
			<?php } ?>	
		</td>
   </tr>
   <tr>	 
		<td>Cuenta Bancaria :</td>
		<td><?php if($modo==1){ ?>
	 					<INPUT TYPE="text"  NAME="txtbank" VALUE="" SIZE="35" MAXLENGTH="35">
			<?php }else{ ?>	
						<INPUT TYPE="text"  NAME="txtbank" VALUE="<?PHP echo $row['bank_pro'];?>" SIZE="35" MAXLENGTH="35">
			<?php } ?>	
		</td>
   </tr>
 </TABLE>
 </center>
         <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ?>">
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numpro" value="<?PHP echo $row['num_pro'];?>" >
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE=<?php echo $boton ?> onClick="ValidarForm(this.form)">
 <?php   if($modo==1){ ?>
		     <input type="reset" value="LIMPIAR" />
 <?php	 } ?>	 
		</center>
 </FORM>
  </div>
 </body>
</html>