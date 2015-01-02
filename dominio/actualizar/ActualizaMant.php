<?php
include("../../dominio/Persistencia.php");
include("../../dominio/actualizar/ActualizaClass.php");
include("../../dominio/precios/PrecioClass.php");
include("../../dominio/mercaderias/MercaderiaClass.php");
session_start();                    // en todo lugar que se necesite
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
   $idup=$_POST['id'];
   $fechaup=$_POST['fecha'];
   if($fechaup==""){$fechaup = date( "Y/n/j" );}
   $codmer=$_POST['nummer'];
   $numcli=$_POST['numcli'];
   $catmer="";//$_POST['txtcatmer'];
   $usuario=$perfiles[2];           //nombre
   $porcentup=$_POST['porciento'];
   $uniup=$_POST['porunitario'];
   $catup=$_POST['opcionup'];      //modalidad: Lista o especial
  
   $modo = $_POST['modo'];
   $Act=new Actualiza($idup,$fechaup,$codmer,$numcli,$catmer,$usuario,$porcentup,$uniup,$catup);
      
    if($modo=="1"){  //ALTA
    	//$Act->ActualizaAdd();  //registra la actualizacion
		//*******************************************************************************************
		if($catup=="L"){       //actualiza la lista 
			$Act->ActualizaAdd();  //registra la actualizacion
			$sql="SELECT * FROM mercaderia WHERE 1=1 ";
			if($codmer!=""){ $sql.=" AND (cod_mer ='$codmer')"; }
				
					
			$link=Conecta();		
		    $res=ejecutarConsulta($sql,$link);
			$total=mysql_num_rows($res);	
			Desconecta($link);
				
		    while($row=mysql_fetch_array($res)){
				  $codmer=$row['cod_mer'];
				  if($porcentup!=""){
				  	  $unitario=$row['precio_mer']+(($row['precio_mer']/100)*$porcentup);
				  }else{
				  	  $unitario=$uniup;	
				  } 
				  $mer=new Mercaderia($codmer,"","","","","","","","",$unitario);
			      $mer->MercaderiaActPrecio();	
				  
			}
//**********************************************************************************************		
		}else{                 //ingresa precios especiales   
			/*$sql="SELECT c.num_cli ,m.cod_mer , m.cat_mer 
							FROM cliente c , mercaderia m WHERE 1=1"; */
	 
			if($numcli!=""){
				if($codmer!=""){ $sql="SELECT * FROM precio WHERE (cod_mer=$codmer) AND (num_cli=$numcli) "; }
			}else{
				if($codmer!=""){
					$sql="SELECT * FROM precio WHERE cod_mer=$codmer";
				}else{
					$sql="SELECT * FROM precio WHERE 1=1 ";	
				}	
			}
			$link=Conecta();
			echo $sql;
		  	$resCli_Mer=ejecutarConsulta($sql,$link);
			Desconecta($link);
		    echo $total_registros_Cli_Mer=mysql_num_rows($resCli_Mer);
			while($row_Cli_Mer=mysql_fetch_array($resCli_Mer)){
				  $idpre=$row_Cli_Mer['id_pre'];
				  $unitario=($row_Cli_Mer['val_pre']/100)*(100+$porcentup);
				  $codmer=$row_Cli_Mer['cod_mer'];
				  $numcli=$row_Cli_Mer['num_cli'];
				  $fecha=$fechaup;
				  $moneda=$row_Cli_Mer['moneda_pre'];
				  $pre=new Precio($idpre,$unitario,$codmer,$numcli,$fecha,$moneda);
				  $pre->PrecioMod();
				  $Act=new Actualiza($idup,$fechaup,$codmer,$numcli,$catmer,$usuario,$porcentup,$uniup,$catup);
				  $Act->ActualizaAdd();  //registra la actualizacion
			}
		}	
	}
	if($modo=="2"){ //MODI
	    $Act->ActualizaMod();			
	}
	if($modo=="3"){ //BAJA
		$Act->ActualizaDel();			
  	}
header("location:../../interface/actualizar/ActualizaIndex.php");
?>