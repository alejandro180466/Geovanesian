<html>
  <script>
	function cambiaraction(opcion){
		switch(opcion){
			case 1 :
				document.forms["formUserIndex"].modo.value=1;           //alta
				document.forms["formUserIndex"].action="UserForm.php";
				break;
			case 2 :	
				document.forms["formUserIndex"].opcion.value=2;        //modificaciones
				document.forms["formUserIndex"].action="UserList.php"; 
				break;
			case 3 :
				document.forms["formUserIndex"].opcion.value=3;        //baja
				document.forms["formUserIndex"].action="UserList.php";
				break;
			case 4 :
				document.forms["formUserIndex"].opcion.value=4;        //listado 
				document.forms["formUserIndex"].action="UserList.php";
				break;
			case 5 :	
				document.forms["formUserIndex"].opcion.value=5;        //busqueda
				document.forms["formUserIndex"].action="UserBuscar.php";
				break;
		}
	    document.forms["formUserIndex"].submit();
	}
  </script>
 <body>
  <?php include("../../estilos/Estilo_page.php"); ?>
  <H1><CENTER>MANTENIMIENTO DE USUARIOS<img src='../../iconos/Users.png' border="0"/></CENTER></H1>
  
  <?php
 // session_start();                    // en todo lugar que se necesite
  $perfiles=$_SESSION["ses_perfil"];
  $perfil=$perfiles[0];              // cargo el perfil del usuario 
  ?>
 <form name="formUserIndex"  method="POST">
 			<input type="hidden" name="opcion" value=1 >
			<input type="hidden" name="modo" value=1 >
  <table align="center"><tr align="center">
   <?php if($perfil!="C"){ ?>
   	     	<td><input type='image' src='../../iconos/Addp.png' border=0  title="INGRESO DE NUEVOS USUARIOS" 
					onClick="cambiaraction(1);"/></td>
		
   <?php } ?>
   <?php
   if ($perfil=="A" || $perfil=="P" ){?>
           	 <td><input type='image' src='../../iconos/Editp.png' border=0 title="MODIFICAR FICHA DE USUARIOS REGISTRADOS"
			 		 onClick="cambiaraction(2);"/></td>
		  
      <?php if ($perfil=="A"){?>
       	     <td><input type='image' src='../../iconos/Deletep.png' border=0  title="ELIMNAR USUARIOS EXISTENTES" 
			 		onClick="cambiaraction(3);"/></td>
		  
	  <?php }
   }?>
   </tr>
  </table>
 </form>
</body>
</html>