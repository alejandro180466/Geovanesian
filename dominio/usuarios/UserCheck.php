<?php include("../../dominio/Persistencia.php");
session_register("ses_perfil");
	if ($_POST){
		if($_POST["on_of"]=="on"){
			$nom=$_POST["txtnombre"];	     // tomo datos por POST
			$pwd=$_POST["txtpassword"];
			$conn=Conecta(); //Conecta y selecciona base ver en Persistencia.php
			$sql="SELECT perfil_user,cod_user,nom_user,pass_user,email_user,fono_user FROM user WHERE nom_user='$nom' AND pass_user='$pwd'";
			$res=mysql_query($sql,$conn);
			Desconecta($conn);    //en Persistencia.php
			if (mysql_num_rows($res)!=0){
				$row=mysql_fetch_array($res);
				$perfil=array();
				$perfil[0]=$row['perfil_user'];    // colocar perfil del usuario(ADIMINISTRADOR,PROMOTOR,CLIENTE)
				$perfil[1]=$row['cod_user'];       // colocar identificador del usuario
				$perfil[2]=$row['nom_user'];       // colocar el nombre del usuario
				$perfil[3]=$row['pass_user'];      // colocar la password
				$perfil[4]=$row['email_user'];     // colocar el mail
				$perfil[5]=$row['fono_user'];      // colocar el telefono
				$_SESSION["ses_perfil"]=$perfil;   //cargo el array en la variable de sesion
				
				respaldar();
			}else{
				$_SESSION["ses_error"]="NOMBRE DE USUARIO O CLAVE INCORRECTA";
			}
			header("location:../../index.php");
			exit();
			
		}else{
			session_unregister("ses_perfil");  // si el formulario manda off cierra sesion
			session_destroy();
			if( $_SERVER['HTTP_REFERER']=="http://www.bondulce.com/pentisol/index.php"){
				header("location:/../../pentisol/index.php");
			}else{
				header("location:../../index.php");
			}	
			exit();
		}	
	}else{  
		if($_GET){
			session_unregister("ses_perfil");  // si el formulario manda off cierra sesion
			session_destroy();
		
		}else{
			session_unregister("ses_perfil");  // si el formulario manda off cierra sesion
			session_destroy(); 
		} 
	}
	header("location:../../index.php");
	exit();
?>