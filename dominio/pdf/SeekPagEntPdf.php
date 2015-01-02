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
if($perfil=="" || $codusr==""){ header("location:../../index.php");	exit();}
$link=Conecta();                  // en Persistencia.php 
$result=mysql_query($sql,$link);
$total_registros=mysql_num_rows($result);
 //-------------------------------------------------------  
    if($total_registros>0){	
  		$pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6, array('left'=>4));
		$pdf->ezText($criterio,9,array('left'=>6));
			 
 		$titles = array('fec'=>'FECHA',			// titulos de la tabla
						'des'=>'DESCRIPCION',
						'can'=>'CANTIDAD',
		 				'uni'=>'UNIDAD',
						'cat'=>'CATEGORIA',
						'tip'=>'TIPO',);							
				   
		$options = array('xPos'=>'center',
		                 'width'=>550,
						 'shaded'=>1,
						 'cols'=>array( 'fec'=>array('justification'=>'center'),
										'des'=>array('justification'=>'left'),
										'can'=>array('justification'=>'left'),
										'uni'=>array('justification'=>'left'),
										'cat'=>array('justification'=>'left'),
										'tip'=>array('justification'=>'center')));
 					
  		while($row=mysql_fetch_array($result)){
			$tipo=$row["tip_stock"];
			if($tipo=="E"){
				$mostrar="EGRESO";
			}elseif($tipo=="I"){
				$mostrar="INGRESO";
			}else{
				$mostrar="CONSUMO";
			}
			$data[] =array(	'fec'=>$row["fec_stock"],
							'des'=>$row["des_insumo"],
							'can'=>$row["cant_stock"],
							'uni'=>$row["uni_insumo"],
							'cat'=>$row["cat_insumo"],
							'tip'=>$mostrar);
		} 
		$pdf->ezTable($data,$titles,'ENTRADAS Y CONSUMOS DE INSUMOS',$options);
		$pdf->ezText("  ",14,array('left'=> -12));
		$pdf->ezText(" ");
		$pdf->ezText(" ",14,array('left'=> -12));
		$pdf->ezText();
		$pdf->ezStream();
    }else{
	   echo("NO HAY ENTRADAS NI CONSUMOS DE INSUMOS REGISTRADOS CON ESTE CRITERIO");
    }
Desconecta($link);
?>
   