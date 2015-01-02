<?php include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0];               // cargo el perfil del usuario 
$codusr=$perfiles[1];
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}
?>
<html>
  <body>
	<div id="menumov">
		<H2> MANTENIMIENTO DE FORMULAS</H2>
	    <?php 
			if($perfil!="C"){   ?>
				<a href=""><!--../../interface/formulates/FormulateForm.php?modo=1" title="Ingresar Fórmula"-->
									<img src='../../iconos/document_add_81.png' border="0"/>INGRESAR</a>
					
				<a href=""><!--"./FormulaSeek.php" title="Buscar Formula"-->
									<img src='../../iconos/search81.png' border="0"/>BUSCAR</a>
				<?php							
		    } ?>							
	</div>							
 </body>
</html>