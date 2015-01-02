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
  		header("location:../../index.php");
		exit();
}	
  $link=Conecta();                                  // en Persistencia.php 
  $registros =2000;
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  $totallotes = $totalunidades = $totalkg=0;
  while($row=mysql_fetch_array($result)){
  		$totallotes = $totallotes + $row['lot_prod'];
		$totalunidades = $totalunidades + $row['can_prod'];
		$kglinea = $row['can_prod']* $row['peso_mer'];
		$totalkg = $totalkg + $kglinea;	
  } 
  $resultados=ejecutarConsulta($sql,$link);	
  Desconecta($link); 
  //-------------------------------------------------------  
  if($total_registros>0){
  		$pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6, array('left'=>4));
		
		$pdf->ezText($criterio,9,array('left'=>6));
			 
 		$titles = array('fec'=>'FECHA',         // tittulos de la tabla
		 	 			'cat'=>'CATEGORIA',
						'lot'=>'LOTES',
						'esc'=>'ESCALA',
		 				'art'=>'ARTICULO',
						'env'=>'ENVASE',
		 				'uni'=>'UNIDADES',
						'kgs'=>'KG'
					  );
	

		$options=array('xPos'=>'center',     
	               'width'=>500,                 //ancho de la tabla 586
				   'shaded'=>1,                  // intercala lineas blncas y negras 
				   'showLines'=>1,               // mostrar u ocultar lineas
				   'rowGap'=>1,
				   'fontSize'=>8,
				   'showHeadings'=>1,            //mostrar u ocultar titulos de columnas
				   'cols'=>array('fec'=>array('justification'=>'center'),
								 'cat'=>array('justification'=>'center'),
								 'lot'=>array('justification'=>'center'),
								 'esc'=>array('justification'=>'center'),
								 'art'=>array('center'=>60),
				                 'env'=>array('justification'=>'center'),
								 'uni'=>array('justification'=>'right'), 		  
								 'kgs'=>array('justification'=>'right')));
 	
		while($row=mysql_fetch_array($resultados)){
				$id=$row['num_prod'];
				$kg=$row['can_prod']*$row['peso_mer'];
		    	$data[] = array( 'fec'=>$row["fec_prod"],
			      		         'cat'=>$row["cat_mer"],
							     'lot'=>$row["lot_prod"],
								 'esc'=>$row["lot_esca"],
				        	     'art'=>$row["des_mer"],
							     'env'=>$row["uni_mer"],
					    	     'uni'=>number_format($row["can_prod"],0),
				    		     'kgs'=>number_format($kg,2)
						       );
		}
		$pdf->ezTable($data,$titles,'DETALLE DE LAS PRODUCCIONES',$options);
		$pdf->ezText(" ");
		$pdf->ezText("Total lotes: ".number_format($totallotes,2)." Totales unidades: ".number_format($totalunidades,2)." Total kg: ".number_format($totalkg,2)."",10,
		             array('left'=>4));
		$pdf->ezText(" ");
		$pdf->ezText("PROMEDIO unidedes/lotes: ".number_format($totalunidades/$totallotes,2)."",10,array('left'=>4));
		$pdf->ezText(" ");
		$pdf->ezText("PROMEDIO kg/lotes: ".number_format($totalkg/$totallotes,2)."",10,array('left'=>4));
		$pdf->ezStream();
		
   }else{
	   echo("NO HAY MOVIMIENTOS REGISTRADOS CON ESTE CRITERIO");
   }
?>