<?php
include("../../dominio/Persistencia.php");
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
				
		if(form.txtdes.value.length <6 ){ //controla que el nombre no este vacío.
      		 alert("Tiene que escribir la mercaderia sin espacios al inicio y ser un nombre valido"); 
			 form.txtdes.focus();
			 return; 
    	} 
				
		if(form.txtuni.value.length<1 ){ 
      		 alert("Ingrese la unidad"); 
			 form.txtuni.value="";
      	 	 form.txtuni.focus();
			 return; 
		}
			
		 
				
		if(form.txtcat.value==""){ 
      		 alert("Debe elegir una categoria"); 
			 form.txtcat.value="";
      	 	 form.txtcat.focus();
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
	$sql="SELECT * FROM insumo WHERE id_insumo=".$id;
	$res=mysql_query($sql,$link);       //realizo la consulta
	if (mysql_num_rows($res)!=0){      //encontro registro?
		$row=mysql_fetch_array($res);  //cargo resultado en $row.
	}
	FreeResp($res);    // en Persistencia.php
	Desconecta($link); // en Persistencia.php
	if($modo==2){ 
	   $titulo=" MODIFICAR INSUMO";
	   $boton="MODIFICAR";
	}elseif($modo==3){
	   $titulo="ELIMINAR INSUMO"; 
	   $boton="ELIMINAR";
	}elseif($modo==4){
		$titulo="VER INSUMO"; 
	    $boton="SALIR";
	}	  
 }else{
	 $titulo="ALTA DE INSUMO";
	 $boton="INGRESAR";
 } 
?>
<h2><center><?php echo $titulo; ?><img src='../../iconos/box_48.png' border="0"></center></h2>
<form name="form2" action="../../dominio/insumos/InsumoMant.php" method="POST" >
 <center>
 <TABLE border="0" width=40% CELLSPACING=1  CELLPADDING=1 style="font-size:12px">
    <tr>
		<td>Descripción :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtdes" VALUE="" SIZE="40" MAXLENGTH="40"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtdes" VALUE="<?PHP echo $row['des_insumo'];?>" SIZE="40" MAXLENGTH="40"/>
			<?php } ?>	
		*</td>
    </tr>
	<tr>
		<td>Detalle :</td>
		<td><?php if($modo==1){ ?>
					<INPUT TYPE="text" NAME="txtdet" VALUE="" SIZE="40" MAXLENGTH="40"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtdet" VALUE="<?PHP echo $row['det_insumo'];?>" SIZE="40" MAXLENGTH="40"/>
			<?php } ?>
		*</td>
    </tr>
	<tr>													
	   <td>Categoria :</td>
	   <TD>
         <?php
	     $sql="select * FROM rubro WHERE est_rubro='HABILITADO' ORDER BY des_rubro ASC";
	     $link=Conecta();
	     $resultado=mysql_query($sql);
	   	   echo "<select name='txtcat'>";
		     if(modo==1){ 
			   echo "<option value=''>"."sin seleccionar.."."</option>";
			 }else{
			   echo "<option value=".$row['cat_insumo'].">".$row['cat_insumo']."</option>";
	             while ($row1=mysql_fetch_array($resultado)){ 
				     echo "<option value=".$row1['des_rubro'].">".$row1['des_rubro']."</option>";
			     }
			 } 	  
		   echo "</select>";
		  Desconecta($link);		  
		  ?>
      </td>	
	</tr>
	<tr>	 														
		<td>Unidad :</td>
		<td><?php if($modo==1){?>
					<INPUT TYPE="text" NAME="txtuni" VALUE="" SIZE="12" MAXLENGTH="12" />
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="txtuni" VALUE="<?PHP echo $row['uni_insumo'];?>" SIZE="12" MAXLENGTH="12" />
		    <?php } ?>
		*</td>
    </tr>
	<tr>
		<td>Iva :</td>
		<td><?php if($modo==1){?>
					<INPUT TYPE="text" NAME="numiva"  VALUE="" SIZE="2" MAXLENGTH="2" 
	 									onkeypress="return permite(event,'num')"/>
			<?php }else{ ?>
					<INPUT TYPE="text" NAME="numiva"  VALUE="<?PHP echo $row['iva_insumo'];?>" SIZE="2" MAXLENGTH="2" 
	 									onkeypress="return permite(event,'num')"/>
			<?php } ?>							
		*</td> 												
   </tr>
   <tr>													
	 <td>Stock :</td>
	 <td><?php if($modo==1){?>
					<input type="text" name="numstock" value="" size="8" maxlength="8">
		<?php }else{ ?>
					<input type="text" name="numstock" value="<?PHP echo $row['stock_insumo'];?>" size="8" maxlength="8">
		<?php } ?>*	
	 </td>
   </tr>
   <tr>													
		<td>Fecha :</td>
		<td><?php if($modo==1){?>
					<input type="text" name="fecstock" value="" size="10" maxlength="10"/>
			<?php }else{ ?>
					<input type="text" name="fecstock" value="<?PHP echo $row['fecha_insumo'];?>" size="10" maxlength="10"/>
			<?php } ?>*		
	        formato: AAAA/mm/dd 
	    </td>
   </tr>
 </TABLE>
 </center>
         <input type="hidden" NAME="modo"   VALUE="<?php echo $modo ;?>">
 <?php
 	     if($modo!=1){ // MODI o DELETE un usuario?>
		  	 <input type="hidden" name="id" value="<?PHP echo $id ;?>" >
 <?php   } ?>
 		 <center><INPUT TYPE="button" VALUE=<?php echo $boton ?> onClick="Validar(this.form)">
 <?php   if($modo==1){ ?>
		     <input type="reset" value="LIMPIAR" />
 <?php	 } ?>	 
		 </center>
 </FORM>
  </div>
 </body>
</html>