<?php
include("../../estilos/Estilo_page.php");
include("../../dominio/foros/ForoverClass.php");
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
    function ValForm2(form){    //Validación del formulario 
		if(form.txtopinion.value.length<=10){ 
      		 alert("Tiene que escribir un comentario"); 
			 form.txtopinion.value="";
      	 	 form.txtopinion.focus();
			 return; 
    	} 
		form.submit();
		return false;
	}
  </script>			
 </head>
<body>
<?php
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$op=$_POST['modo']; // 1 Nuevo , 2 modificar  , 3 eliminar
$idforo=$_POST['idforo'];
$idpart=$_POST['idpart'];  //si es in ingreso viene cero , al gaurdar asigna numero
$tema=$_POST['tema'];
if ($op==1){
    $coduser=$codusr;
	$fecpart=date( "Y/n/j" );
	$timepart=date("H:i");
	$codforo=$idforo;
	$opinforo=" ";
}
$Comento=new ForoVer($idpart,$coduser,$fecpart,$timepart,$codforo,$opinforo);

 if($op==1){ //ingresar
   	$titulo="INGRESAR OPINION";	$boton="INGRESAR";
 }
 if($op==3){ //eliminar
     $Comento=$Comento->PartForoCargar($idforo,$idpart);
	$titulo="ELIMINAR OPINION";	$boton="ELIMINAR";
 }
?>	
  <H1><CENTER><?php echo $titulo; ?><img src='../../iconos/Foro.png' border="0"></CENTER></H1>
  <H2><CENTER>TEMA :<?php echo $tema; ?></CENTER></H2>
  <form name="formForo2" action="../../dominio/foros/ForoverMant.php" method="POST">
       <input type="hidden" NAME="op" ID="op" value="<?php echo $op;?>" >
 
 <TABLE  align="center" border="0" width=68% CELLSPACING=1  CELLPADDING=1 bgcolor="#FF9900"> 
 						   <INPUT TYPE="hidden" NAME="numpart" ID="numpart" VALUE="<?PHP echo $Comento->getidpart();?>">
						   <INPUT TYPE="hidden" NAME="numuser" id="numuser" VALUE="<?PHP echo $Comento->getcoduser();?>">
  		<TD></TD><TD >
							<INPUT TYPE="hidden" NAME="txtfecha" ID="txtfecha" VALUE="<?PHP echo $Comento->getfecpart();?>"
  												 SIZE="10" MAXLENGTH="10"></TD>
        <TD></TD><TD >
							<INPUT TYPE="hidden" name="txthora" ID="txthora" VALUE="<?PHP echo $Comento->gettimepart(); ?>"
  												 size="8" MAXLENGTH="8"></TD></TR>
                            <INPUT TYPE="hidden" NAME="numforo" ID="numforo" VALUE="<?PHP echo $Comento->getcodforo();?>">
 </TABLE>
 <TABLE align="center" border="0" width=68% CELLSPACING=1  CELLPADDING=1 bgcolor="#FFFFFF">
 	<TR><TD>OPINION:</TD><TD><textarea rows=3 cols=79 NAME="txtopinion" ID="txtopinion"><?php echo $Comento->getopinforo();?></textarea>
	</TD></TR>
	</TD></TR>
 </TABLE>
   
  <center><INPUT TYPE="button" VALUE="<?php echo $boton; ?>" onClick="ValForm2(this.form)"></center>
 </FORM>

 </body>
</html>
