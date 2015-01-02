<?php
include("../../interface/documentos/DocumentoIndex.php");
include("../../dominio/Persistencia.php");
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
  		header("location:../../index.php");
		exit();
}	
//------------ BUSCA ULTIMO id de factura 
$numactual=actualID("contadores","id_numfac");
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form){    //Validación del formulario 
		modo=form.modo.value;
		alert $$modo;
		form.submit();
		return false;
	}
	</script>			
 </head>
<body>
<H3><center><?php echo "SETEAR NUMERO DE DOCUMENTO"?><img src='../../iconos/Inbox_128.png' border="0"/></center></h3>
<br></br>	
   <form name="form8" action="../../dominio/facturas/FacturaMant.php" method="POST">
     <TABLE  width=30% CELLSPACING=1  CELLPADDING=1  align="center">
      <tr>
        <td>ULTIMO NUMERO :  </td><td><?php echo $numactual; ?></td>
	  </tr>
	  <tr>	
	    <td>NUMERO CORRECTO :</td><td><input type="text"  size="7"maxlength="6" name="numfac" id="numfac"   
			   	                                   	onkeypress="return permite(event,'num')"/> 
		</td> 
      </tr>
     </TABLE>
	      <input type="hidden" name="modo" id="modo" value=6 />
 		  <center>
		  <INPUT TYPE="submit" VALUE="MODIFICAR"/>
		  </center>
    </FORM>
 </body>
</html>