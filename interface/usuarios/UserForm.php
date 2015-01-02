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
		
		var nombre = form.txtnombre.value;
		var nombrelargo = form.txtnombre.value.length;
		var blanconombre = sinespacioblanco(nombre);
		if(nombrelargo <3 || blanconombre == true){ //controla que el nombre no este vacío.
      		 alert("Tiene que escribir su nombre"); 
			 form.txtnombre.value="";
      	 	 form.txtnombre.focus();
			 return; 
    	} 
		if (form.txtcity.value==0){
			alert("DEBE SELECCIONAR UN DEPARTAMENTO");
			form.txtcity.focus();
			return;
		} 
				
		var fono=form.numfono.value;          //validacion del telefono
		var fonolargo=form.numfono.value.length;
		var isnum=esnumeroentero(fono);
		if(fonolargo<8 || fonolargo>9 || isnum==false){ 
      		 alert("El teléfono debe contener solo numeros (8 a 9 digitos)"); 
			 form.numfono.value="";
      	 	 form.numfono.focus();
			 return; 
		}
		var valid=validomail(form.txtemail.value);
		if(form.txtemail.value.length<6 ||valid==false){     //controla que el mail sea válido
		     alert("Ingrese un mail válido"); 
			 form.txtemail.value="";
      	 	 form.txtemail.focus();
			 return; 
    	}		
		var blancopass = sinespacioblanco(form.txtpass1.value);
		if(form.txtpass1.value.length<=5 || blancopass==true){ //controla que la contraseña tenga 6 digitos.
      		 alert("contraseña de 6 a 8 digitos sin espacios en blanco"); 
			 form.txtpass1.value="";
      	 	 form.txtpass1.focus();
			 return; 
    	} 
		if(form.txtpass1.value!=form.txtpass2.value){  // controlo que la repetición de la contraseña sea identica
			alert("La repetición de la contraseña no coincide");
			form.txtpass2.value="";
			form.txtpass2.focus();
			return;
		}
	   	if(form.txtnombre.value==form.txtpass1.value){   // controlo que la contraseña no sea igual al nombre
	    	alert("La contraseña no puede ser igual al nombre de usuario");
        	form.txtpass1.value="";
			form.txtpass1.focus();
			return;
	   	}
		// solicito la confirmacion del envio de la informacion del formulario
		var enviar=confirm('Se enviarán los datos del formulario');
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
 if ($modo==2 ||$modo==3){           
 	$id=$_POST["id"];
	$link=Conecta();   //en Persistencia.php
	$sql="select cod_user ,nom_user , apellido_user, direc_user, fono_user , email_user , city_user , fnac_user , pass_user , perfil_user  from user
			where cod_user=".$id;
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	FreeResp($res);    // en Persistencia.php
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	 ?><H2><CENTER>MODIFICAR DATOS DEL USARIO<img src='../../iconos/userb.png' border="0"></CENTER></H2><?php
	   $boton="MODIFICAR";
	}else{
	  ?><H2><CENTER>ELIMINAR USUARIO<img src='../../iconos/userb.png' border="0"></CENTER></h2><?php 
	    $boton="ELIMINAR";
	}	  
 }else{
	 ?><H2><CENTER>ALTA DE USUARIO<img src='../../iconos/userb.png' border="0"><font size="2">(*)campos obligatiros</font></CENTER></H2><?php
	   $boton="INGRESAR";
 } 
?>
<form name="form1" action="../../dominio/usuarios/UserMant.php" method="POST">
<center>
 <TABLE border="4" width=60% CELLSPACING=2  CELLPADDING=2 style="font-size:12px">
  <TR>
    <TD>Nombre :</td>
    <td><INPUT TYPE="text" NAME="txtnombre"   VALUE="<?PHP echo $row['nom_user'];?>" SIZE="20" MAXLENGTH="30"
  													onkeypress="return permite(event,'car')"/>*
	</TD>
  </TR> 	
  <tr>
    <TD>Apellido : </TD>
	<TD><INPUT TYPE="text" NAME="txtapellido" VALUE="<?PHP echo $row['apellido_user'];?>" SIZE="20" MAXLENGTH="30"
	  												onkeypress="return permite(event,'car')"/>
	</TD>
  </TR>
  <TR>
    <TD>Direccion : </TD>
	<TD><INPUT TYPE="text" NAME="txtdirec"  VALUE="<?PHP echo $row['direc_user'];?>" SIZE="35" MAXLENGTH="35"
  													onkeypress="return permite(event,'num_car')"/>
	</TD>
  </TR>
  <tr>	
     <TD>Departamento :</TD>
	 <TD><select name="txtcity"  VALUE="<?PHP echo $row['city_user'];?>"     size="1" >
  					     <option value="<?PHP echo $row['city_user'];?>"><?PHP echo $row['city_user'];?></option>
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
          </select>*
		</TD>
  </TR>
  <TR>
    <TD>Teléfono : </TD>
	<TD><INPUT TYPE="text"    NAME="numfono"  VALUE="<?PHP echo $row['fono_user'];?>"  SIZE="9" MAXLENGTH="9">*
	</TD>
  </TR>
  <tr>	
      <TD>Mail :     </TD><TD><INPUT TYPE="text"    NAME="txtemail" VALUE="<?PHP echo $row['email_user'];?>" SIZE="35" MAXLENGTH="35">*</TD></TR>
  
  <TR><TD>Nacido el :</TD><TD><INPUT TYPE="text"    NAME="txtfnac"  VALUE="<?PHP echo $row['fnac_user'];?>"  SIZE="10" MAXLENGTH="10"></TD>
  <?php if($perfil!="" && $perfil!="C"){ ?>  
      <TD>Perfil :   </TD><TD><select name="txtperfil"  VALUE="" SIZE="1">
	  												  <option value="C">CLIENTE      </option>
  											<?php if($perfil=="A"){?>
  												      <option value="P">PROMOTOR     </option>
													  <option value="A">ADMINISTRADOR</option>
											<?php }?>
						       </select>*</TD></TR>
<?php }else{ ?>
		   	<input type="hidden" name="txtperfil" value="C" >
<?php } ?>		
						   
<TR><TD>Contraseña        </TD><TD><INPUT TYPE="password" NAME="txtpass1" VALUE="<?PHP echo $row['pass_user'];?>" SIZE="8" MAXLENGTH="8"
														onkeypress="return permite(event, 'num_car')"/>*(6-8caract.)</TD>
    <TD>Repetir contraseña</TD><TD><INPUT TYPE="password" NAME="txtpass2" VALUE="<?PHP echo $row['pass_user'];?>" SIZE="8" MAXLENGTH="8"
														onkeypress="return permite(event, 'num_car')"/>*</TD></TR>
  </TABLE>
 </center>
             <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ?>">
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numcodigo" value="<?PHP echo $row['cod_user'];?>" >
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE=<?php echo $boton ?> onClick="ValidarForm(this.form)">
 <?php   if($modo==1){ ?>
		     <input type="reset" value="LIMPIAR" />
 <?php	 } ?>	 
		 </center>
	
 </FORM>

 </body>
</html>
