<?php
include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
session_start();
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
  	header("location:../../index.php");		exit();
}	
$link=Conecta();                                  // en Persistencia.php 
$resultados=ejecutarConsulta($sql,$link);
$total_registros=mysql_num_rows($resultados);
//-------------------------------------------------------  
if($total_registros>0){	
    $pdf= new Cezpdf('a4');
	$i=$pdf->ezStartPageNumbers(300,32,14,'','',1);
	$pdf->ezSetCmMargins(1,2,2,1); //top,bottom,left,right
	$pdf->selectFont('font/courier.afm');
	$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
	$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
	$pdf->ezText($criterio,10,array('left'=>4));
	$titles = array('ide'=>'ID','fec'=>'FECHA','raz'=>'RAZON SOCIAL','num'=>'NºDOC','pes'=>'PESOS','dol'=>'DOLARES' );
	$options = array('xPos'=>'center','width'=>560,'shaded'=>1,'fontSize'=>10,
					 'cols'=>array('ide'=>array('justification'=>'center'),
									'fec'=>array('justification'=>'center'),
									'raz'=>array('left'=>60),
									'num'=>array('justification'=>'left'),
									'pes'=>array('justification'=>'right'),
									'dol'=>array('justification'=>'right')));
	$totalP = $totalD = 0;							   
	while($row=mysql_fetch_array($resultados)){
		//EVALUAR TIPO DE DOCUMENTO PARA ELEGIR UBICACION DEL VALOR
		$haberP = $haberD = 0;
		if($row['mon_mov']=="Peso"){ // -----------------------  peso
			$haberP=$row["val_mov"];	$totalP=$totalP+$haberP;	$hP=number_format($haberP,2); $hD=" ";
		}
		if($row['mon_mov']=="Dolar"){ // ----------------------- dolar
			$haberD=$row["val_mov"];	$totalD=$totalD+$haberD;	$hD=number_format($haberD,2); $hP=" ";
		}
		//CONTENIDO DE CADA LINEA			
		$data[]=array('ide'=>$row["cod_mov"],   'fec'=>$row["fec_mov"],   'raz'=>$row["raz_pro"],
						  'tip'=>$row["tip_mov"],   'num'=>$row["num_mov"],   'pes'=>$hP,   'dol'=>$hD); 
	} 
	$pdf->ezTable($data,$titles,'PAGOS DE COMPRAS A CREDITO',$options);
	$pdf->ezText(" ");  
	$pdf->ezText("PESOS  total pagado en $ ".number_format($totalP,2),12,array('left'=>0));
	$pdf->ezText(" ");
	$pdf->ezText("DOLAR  total pagado en U$"."S ".number_format($totalD,2),12,array('left'=>0));
	$pdf->ezStream();  
}else{
   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
}
?>