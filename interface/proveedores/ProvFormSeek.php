<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
session_start();
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
      		 alert("El rut debe contener solo numeros (12 digitos)"); 
			 form.numrut.value="";
      	 	 form.numrut.focus();
			 return; 
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
		if(faxlargo!=8 || isnum==false){ 
      		 alert("El fax debe contener solo numeros (8 digitos)"); 
			 form.numfax.value="";
      	 	 form.numfax.focus();
			 return; 
		}
		
		var cel=form.numcel.value;          //validacion del celular
		var cellargo=form.numcel.value.length;
		var isnum=esnumeroentero(cel);
		
		if(cellargo!=9 || isnum==false){ 
      		 alert("El celular debe contener solo numeros ( 9 digitos)"); 
			 form.numcel.value="";
      	 	 form.numcel.focus();
			 return; 
		}
		
				
		var valid=validomail(form.txtmail.value);
		if(valid==false){     //controla que el mail sea válido
		     alert("Ingrese un mail válido"); 
			 form.txtmail.focus();
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
 if ($modo==2 ||$modo==3 || $modo==4){           
 	$id=$_POST['id'];
	$link=Conecta();   //en Persistencia.php
	$sql="select num_pro ,raz_pro , rut_pro, dir_pro, dep_pro , tel_pro , fax_pro , cel_pro , mail_pro from proveedor
			where num_pro=".$id;
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	FreeResp($res);    // en Persistencia.php
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	 ?><H2><CENTER>MODIFICAR DATOS DEL PROVEEDOR<img src='../../iconos/userb.png' border="0"></CENTER></H2><?php
	   $boton="MODIFICAR";
	}elseif($modo==3){
	  ?><H2><CENTER>ELIMINAR PROVEEDOR<img src='../../iconos/userb.png' border="0"></CENTER></h2><?php 
	    $boton="ELIMINAR";
	}elseif($modo==4){
		?><H2><CENTER>FICHA PROVEEDOR<img src='../../iconos/userb.png' border="0"></CENTER></h2><?php 
	    $boton="SALIR";
	}	  
 }else{
	 ?><H2><CENTER>ALTA DE PROVEEDOR<img src='../../iconos/userb.png' border="0"><font size="2">(*)campos obligatiros</font></CENTER></H2><?php
	   $boton="INGRESAR";
 } 
?>
<form name="form1" action="../../dominio/proveedores/ProvMant.php" method="POST">
<center>
 <TABLE border="2" width=60% CELLSPACING=1  CELLPADDING=1 style="font-size:12px">
   <tr>
     <td>Razón social :</td>
	 <td><INPUT TYPE="text" NAME="txtraz" VALUE="<?PHP echo $row['raz_pro'];?>" SIZE="30" MAXLENGTH="30"
      									onkeypress="return permiteconespacios(event,'car')"/>*</td>
    </tr>
	<tr>	 														
	 </td>
     <td>RUT</td>
	 <td><INPUT TYPE="text" NAME="numrut" VALUE="<?PHP echo $row['rut_pro'];?>" SIZE="12" MAXLENGTH="12"
	  												onkeypress="return permite(event,'num')"/>*</td>
   </tr>
   <tr>
     <td>Direccion :</td>
	 <td><INPUT TYPE="text" NAME="txtdir"  VALUE="<?PHP echo $row['dir_pro'];?>" SIZE="35" MAXLENGTH="35" 
	 										onkeypress="return permiteconespacios(event,'num_car')"/>*</td> 												
   </tr>
   <tr>													
	 <td>Departamento :</td>
	 <td><select name="txtcity" VALUE="<?PHP echo $row['dep_pro'];?>" size="1" >
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
        </select>*</td>
   </tr>
   <tr>
     <td>Teléfono :</td>
	 <td><INPUT TYPE="text"  NAME="numfono"  VALUE="<?PHP echo $row['tel_pro'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>*</td>
   </tr>
   <tr> 	 
	 <td>Fax :</td>
	 <td><INPUT TYPE="text"  NAME="numfax"  VALUE="<?PHP echo $row['fax_pro'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>*</td>
   </tr>
   <tr>
     <td>Móvil :</td>
     <td><INPUT TYPE="text" NAME="numcel" VALUE="<?PHP echo $row['cel_pro'];?>" SIZE="9" MAXLENGTH="9"
												onkeypress="return permite(event,'num')"/>*</td>
   </tr>
   <tr>	 
   	 <td>Mail :</td>
	 <td><INPUT TYPE="text"  NAME="txtmail" VALUE="<?PHP echo $row['mail_pro'];?>" SIZE="35" MAXLENGTH="35">*</td>
   </tr>
 </TABLE>
 </center>
         <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ?>">
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numpro" value="<?PHP echo $row['num_pro'];?>" >
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE=<?php echo $boton ?> onClick="ValidarForm(this.form)"></center>
 </FORM>

 </body>
</html>