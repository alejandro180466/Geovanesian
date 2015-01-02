<?php
include("../../dominio/Persistencia.php");
include("../../dominio/producciones/ProduccionClass.php");
include("../../dominio/formulates/FormulateClass.php");
include("../../dominio/stocks/StockClass.php");
if(!isset($_SESSION)){     session_start(); }
$perfiles=$_SESSION["ses_perfil"];  //carga los valor de perfil que vienen de xlogin.php, ses_perfiles es el nombre de la sesion
$perfil=$perfiles[0]; // perfil
$codusr=$perfiles[1]; // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
$modo=$_POST['modo'];
$_SESSION['ses_error']="";
if($modo=="1" || $modo=="2" || $modo=="4"){
    $numprod=$_POST['numprod'];
    $fecprod=$_POST['fecprod']; 
    $canprod=$_POST['canprod'];
    $lotprod=0; 
    $codmer=$_POST['nummer'];
    $escala=0;
}else{
	$numprod=$_POST['id'];
	$fecprod = $canprod = $lotprod = $codmer = $escala	= "";
}   
 $prod=new Producido($numprod, $fecprod, $canprod, $lotprod ,$codmer,$escala);
                 
   if($modo=="1"){  //ALTA
        $prod->ProduccionAdd();
		//buscar en partidas los ultimos registros de la formula del producto(clase Formulate)
		$ingrediente=new Formulate("",$codmer,"","","");
		$res=$ingrediente->TusFormulates(); //carga los registros de codmer ordenados fecha decend.
		$ingred=$contador=0;
		while($row=mysql_fetch_array($res)){
			if($contador==0 || $ingred!=$row["id_insumo"] ){
				$cantidad=$row["cant_partida"]*$escala*$lotprod;
				$id_produccion=$prod->getnumprod();
				//ir registrando en stock los consumos de cada materia prima(clase Stock)
				$stock=new Stock("",$row["id_insumo"],$cantidad,$fecprod,"C",$id_produccion);
				$stock->StockAdd();
			}	
			$contador++;
			$ingred=$row["id_insumo"]; 
		}//echo $fecprod;
			//echo "contador:".$contador;
		$_SESSION['ses_error']="LA ENTRADA ANTERIOR SE INGRESO CORRECTAMENTE";
		header("location:../../interface/producciones/ProduccionForm.php?modo=1&id=0&rechazo=0");
   }
   if($modo=="2"){ //MODI
		$prod->ProduccionMod();	

		//buscar en partidas los ultimos registros de la formula del producto(clase Formulate)
		$ingrediente=new Formulate("",$codmer,$fecprod,"","");
		$res=$ingrediente->TusFormulates(); //carga los registros de codmer ordenados fecha decend.
		$ingred=$contador=0;
		while($row=mysql_fetch_array($res)){
			if($contador==0 || $ingred!=$row["id_insumo"] ){
			    $cantpartida=$row["cant_partida"]; 
				$cantidad=$cantpartida*$escala*$lotprod;
				$id_produccion=$prod->getnumprod();
				
				//ir registrando en stock los consumos de cada materia prima(clase Stock)
				$stock=new Stock("",$row["id_insumo"],$cantidad,$fecprod,"C",$id_produccion);
				$stock->StockMod2();
			}
			$contador++;
			$ingred=$row["id_insumo"]; 
		} 
      	echo "<script>history.go(-2);</script>";        exit();		
   }
   if($modo=="3"){  //BAJA
		$prod->ProduccionDel();
        $stock=new Stock("","","","","",$numprod);
		$stock->StockDel();
		header("location:".$_SERVER['HTTP_REFERER']);
   }
   if($modo=="4"){   //VISTA
		$prod->setnumprod($numprod);
		$labuscada = $prod->LasProducciones();
		echo "<script>history.go(-2);</script>";        exit();	
   }
?>
