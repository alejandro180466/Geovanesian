<?php include("../../dominio/Persistencia.php");
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
  $result=mysql_query($sql,$link);
  Desconecta($link);
  $total_registros=mysql_num_rows($result);
  //-------------------------------------------------------  
if($total_registros>0){	
    $pdf= new Cezpdf('a4');
	$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
	$pdf->selectFont('font/courier.afm');
	$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
	$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
	$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
	$pdf->ezText($criterio,10,array('left'=>4));
	$titles = array('id'=>'ID','fec'=>'FECHA','num'=>'NºDOC','raz'=>'RAZON SOCIAL','imp'=>'IMPORTE','nul'=>'ESTADO');
	$options = array('xPos'=>'center','width'=>500,'shaded'=>0,'fontSize'=>9 ,
					 'cols'=>array('id'=>array('justification'=>'center'),
 					              'fec'=>array('justification'=>'center'),
								  'num'=>array('justification'=>'center'),
								  'imp'=>array('justification'=>'right'),
								  'nul'=>array('justification'=>'center')));
	$total=0;				 
	while($row=mysql_fetch_array($result)){
		$id=$row['id_recibo'];
		$estado=$row['nul_recibo'];
		if($estado=="N"){
			$estado="ok";
			$total=$total+$row['tot_recibo'];
			$importe=number_format($row['tot_recibo'],2);
		}else{
			$estado="anulado";		$importe="----------";
		}
		//CONTENIDO DE CADA LINEA			
	    $data[]=array('id'=>$row["id_recibo"],'fec'=>$row["fec_recibo"],'num'=>$row["num_recibo"],
		    		  'raz'=>$row["raz_cli"],'imp'=>$importe,'nul'=>$estado	);
	} 
	$pdf->ezTable($data,$titles,'DETALLE DE LOS RECIBOS EMITIDOS - COBRANZAS',$options);
	$pdf->ezText(" ");
	$pdf->ezText("PESOS - Total cobranza en $ ".number_format($total,2)."",10,array('left'=>4));
	$pdf->ezText(" ");
	$pdf->ezStream();
  }else{
	echo("NO HAY COBRANZAS REGISTRADAS CON ESTE CRITERIO");
} ?>
