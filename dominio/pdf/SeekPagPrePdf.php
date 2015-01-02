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
if($perfil=="" || $codusr==""){  	header("location:../../index.php");	exit();}	
  $link=Conecta();                                  // en Persistencia.php 
  $resultados=ejecutarConsulta($sql,$link);
  Desconecta($link);
  $total_registros=mysql_num_rows($resultados);
  //-------------------------------------------------------  
  if($total_registros>0){	
        $pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(1,1,2,1); //top,bottom,left,right
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
		$pdf->ezText($criterio,10,array('left'=>4));
						 
 		$titles = array('id'=>'ID','fec'=>'FECHA','raz'=>'EMPRESA','pro'=>'PRODUCTO','mon'=>'MONEDA','pre'=>'PRECIO');
		$options=array('xPos'=>'center',     
	               'width'=>570,                 //ancho de la tabla 586
				   'shaded'=>1,                  // intercala lineas blncas y negras 
				   'showLines'=>1,               // mostrar u ocultar lineas
				   'rowGap'=>1,
				   'fontSize'=>8,
				   'showHeadings'=>1,            //mostrar u ocultar titulos de columnas
				   'cols'=>array('id'=>array('justification'=>'center'),
								 'fec'=>array('justification'=>'center'),
								 'raz'=>array('left'=>60),
								 'pro'=>array('justification'=>'left'),
								 'mon'=>array('center'=>10),
								 'pre'=>array('justification'=>'right'))); 		  
								 
		while($row=mysql_fetch_array($resultados)){
			//CONTENIDO DE CADA LINEA			
		    $data[]=array('id'=>$row["id_pre"],   
						  'fec'=>$row["fec_pre"],
						  'raz'=>$row["raz_cli"],
			    		  'pro'=>$row["des_mer"],
						  'mon'=>$row["moneda_pre"],
						  'pre'=>number_format($row["val_pre"],2)	
						 );
		} 
		$pdf->ezTable($data,$titles,'LISTADO DE PRECIOS ESPECIALES',$options);
		$pdf->ezText(" ");
		$pdf->ezStream();
   }else{
	   echo("NO HAY COBRANZAS REGISTRADAS CON ESTE CRITERIO");
   } ?>
