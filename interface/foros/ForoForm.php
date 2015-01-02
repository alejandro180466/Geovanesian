<?php
include("../../estilos/Estilo_page.php");
include("../../dominio/Persistencia.php");
include("../../dominio/foros/ForoClass.php");
//session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");
	exit();
}	
?>
<html>
 <head>
  <script languaje="javascript" >
    function ValForm(form,op){    //Validación del formulario 
		
		if(form.txttema.value.length==0){ 
      		 alert("Tiene que escribir un tema"); 
			 form.txttema.value="";
      	 	 form.txttema.focus();
			 return; 
    	} 
		// solicito la confirmacion del envio de la informacion del formulario
		form.op.value=op;
		var enviar=confirm('Se enviarán los datos del formulario');
		if (enviar){
			form.submit();
			
		}	
		return false;	
	}
  </script>			
 </head>
<body>
<?php
$op=$_POST['modo'];
if ($op==1){
	$codforo=0;
	$temforo="";
	$estforo="ACTIVO";
	$fecforo= date( "Y/n/j" ); 
}else{
	$codforo=0;
	$temforo="";
	$estforo="";
	$fecforo=""; 

}
$Foros=new ForoW($codforo,$temforo,$estforo,$fecforo);

 if ($op==2||$op==3){ 
	$idforo=$_POST['id'];
	$Foros=$Foros->ForoCargar($idforo);
 }
 if($op==1){ //ingresar
   	$titulo="INGRESAR FORO";    $boton="INGRESAR";
 }
 if($op==2){ //modoficar
	$titulo="MODIFICAR FORO";	$boton="MODIFICAR";
 }
 if($op==3){ //eliminar
	$titulo="ELIMINAR FORO";	$boton="ELIMINAR";
}
?>	
  <H1><CENTER><?php echo $titulo; ?><img src='../../iconos/Foro.png' border="0"></CENTER></H1>
  <form name="formForo1" action="../../dominio/foros/ForoMant.php" method="POST">
       <input type="hidden" NAME="op" ID="op" >
 
 <TABLE  align="center" border="0" width=68% CELLSPACING=2  CELLPADDING=2 bgcolor="#FF9900">
                            <INPUT TYPE="hidden" NAME="numcodigo" id="numcodigo" VALUE="<?PHP echo $Foros->getcodforo();?>">
  	  
  <tr><TD>TEMA    :</TD><TD><INPUT TYPE="text" NAME="txttema" ID="txttema"VALUE="<?PHP echo $Foros->gettemforo();?>"
  												 SIZE="50" MAXLENGTH="50"></TD></TR>
  <TR><TD>ESTADO  :</TD><TD><select name="txtestado" ID="txtestado" VALUE="<?PHP echo $Foros->getestforo(); ?>" size="1" >
 								  <option value="<?PHP echo $Foros->getestforo(); ?>"><?PHP echo $Foros->getestforo();?></option>
  								  <option value="ACTIVO"   >ACTIVO  </option>
  								  <option value="INACTIVO" >INACTIVO</option>
							</select></TD>
  							
  <TD>FECHA INICIO:</TD><TD><INPUT TYPE="text" NAME="fecinicio" ID="fecinicio"VALUE="<?PHP echo $Foros->getfecforo();?>"
   												 SIZE="10" MAXLENGTH="10" ></TD></TR>
   													 
 </TABLE>
   
  <center><INPUT TYPE="button" VALUE="<?php echo $boton; ?>" onClick="ValForm(this.form,<?php echo $op ?>)"></center>
 </FORM>

 </body>
</html>
