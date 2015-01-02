<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
$numcli=$_SESSION['ses_numcli'];
$modo=$_SESSION['ses_modo'];
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form){    //Validación del formulario 
		var modo=form.modo.value;
			
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
		form.submit();
		return false;
	}
	</script>			
 </head>
<body>
<?php
if($_POST){
 $modo=$_POST['modo'];  //MODO=1 INGRESA   MODO=2 modifica  y  MODO=3 elimina
}elseif($_GET){
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
	 ?><H2><CENTER>MODIFICAR DATOS DE SUCURSAL<img src='../../iconos/userb.png' border="0"></CENTER></H2><?php
	   $boton="MODIFICAR";
	}elseif($modo==3){
	  ?><H2><CENTER>ELIMINAR SUCURSAL<img src='../../iconos/userb.png' border="0"></CENTER></h2><?php 
	    $boton="ELIMINAR";
	}elseif($modo==4){
		?><H2><CENTER>FICHA SUCURSAL<img src='../../iconos/userb.png' border="0"></CENTER></h2><?php 
	    $boton="SALIR";
	}	  
 }else{
	 ?><H2><CENTER>ALTA DE SUCURSAL<img src='../../iconos/userb.png' border="0"/>
	 			<font size="2">(*)campos obligatorios</font>
			</CENTER></H2><?php
	   $boton="INGRESAR";
 } 
?>
<form name="form1" action="../../dominio/sucursales/SucursalMant.php" method="POST">
<center>
 <TABLE border="0"  CELLSPACING="2"  CELLPADDING="2"  style="font-size:12px">
    <tr>
		<td>Nombre Sucursal :</td>
		<td><?php if($modo==1){ ?>
				<INPUT TYPE="text" NAME="txtnom" VALUE="" SIZE="30" MAXLENGTH="30"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php }else{ ?>
				<INPUT TYPE="text" NAME="txtnom" VALUE="<?PHP echo $row['nom_suc'];?>" SIZE="30" MAXLENGTH="30"
      									onkeypress="return permiteconespacios(event,'car')"/>
			<?php } ?>							
		*</td>
   	</tr>
    <tr>
		<td>Dirección :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtdir"  VALUE="" SIZE="30" MAXLENGTH="35" 
	 										onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtdir"  VALUE="<?PHP echo $row['dir_suc'];?>" SIZE="30" MAXLENGTH="35" 
	 										onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php } ?>									
		*</td> 												
   	</TR>
    <TR>	
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
						<select name="txtcity" VALUE="<?PHP echo $row['dep_suc'];?>" size="1"
							title="SELECCIONAR UN DEPARTAMENTO">
							<option value="<?PHP echo $row['dep_suc'];?>"><?PHP echo $row['dep_suc'];?></option>
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
					<INPUT TYPE="text"  NAME="numfono"  VALUE="<?PHP echo $row['tel_suc'];?>"  SIZE="8" MAXLENGTH="8"
	 											onkeypress="return permite(event,'num')"/>
			<?php } ?>									
		*</td>
    </tr>
    <tr>	 
		<td>Contacto:</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtcont" VALUE="" SIZE="20" MAXLENGTH="25"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtcont" VALUE="<?PHP echo $row['cont_suc'];?>" SIZE="20" MAXLENGTH="25"
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
					<INPUT TYPE="text" NAME="txtentrega" VALUE="<?PHP echo $row['ent_suc'];?>" SIZE="30" MAXLENGTH="40"
												onkeypress="return permiteconespacios(event,'num_car')"/>
			<?php } ?>									
		</td>
    </tr>
 </TABLE>
 </center>
         <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ?>"/>
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="numcli" value="<?PHP echo $row['num_cli'];?>" >
			 <input type="hidden" name="numsuc" value="<?PHP echo $row['sucursal_id'];?>" >
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE=<?php echo $boton; ?> onClick="ValidarForm(this.form)"></center>
 </FORM>
 </body>
</html>