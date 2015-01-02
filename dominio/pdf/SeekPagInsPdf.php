<?php  
include("../../dominio/Persistencia.php");
include("../../dominio/stocks/StockClass.php");
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
			 
 		$titles = array('des'=>'DESCRIPCION',     //ittulos de la tabla
						'cat'=>'CATEGORIA',
						'uni'=>'UNIDAD',
		 				'sto'=>'STOCK',
						'fec'=>'FECHA RESET');		
				   
		$options = array('xPos'=>'center',
		                 'width'=>550,
						 'shaded'=>1,
						 'cols'=>array( 'des'=>array('justification'=>'center'),
										'cat'=>array('justification'=>'center'),
										'uni'=>array('justification'=>'center'),
										'sto'=>array('justification'=>'right'),
										'fec'=>array('justification'=>'center')));
 		$contador=0;			
  		while($row=mysql_fetch_array($result)){
			$contador++;
			$endeposito=0;
			$id=$row['id_insumo'];
			$stockini=$row['stock_insumo'];
			$fechaini=$row['fecha_insumo'];
			$stock=new Stock("",$id,"","","","");
			$endeposito=$stockini+$stock->Consumido($fechaini);
	    						
			$data[] =array(	'des'=>$row["des_insumo"],
							'cat'=>$row["cat_insumo"],
							'uni'=>$row["uni_insumo"],
							'sto'=>$endeposito,
							'fec'=>$row["fecha_insumo"]);
		} 
		$pdf->ezTable($data,$titles,'STOCK DE INSUMOS',$options);
		$pdf->ezText("Total de insumos de la categoria : ".$contador." ",14,array('left'=> -12));
		$pdf->ezText("");
		$pdf->ezText("",14,array('left'=> -12));
		$pdf->ezText();
		$pdf->ezStream();
    }else{
	   echo("NO HAY INSUMOS REGISTRADOS REGISTRADOS CON ESTE CRITERIO");
    }
Desconecta($link);
?>