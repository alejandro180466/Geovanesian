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
$total_registros = mysql_num_rows($result);
 //-------------------------------------------------------  
    if($total_registros>0){	
  		$pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6, array('left'=>4));
		$pdf->ezText($criterio,9,array('left'=>6));
			 
 		$titles = array('pes'=>'PESO',			// tittulos de la tabla
						'uni'=>'UNIDAD',
						'des'=>'DESCRIPCION',
		 				'cat'=>'CATEGORIA');							
				   
		$options = array('xPos'=>'center',
		                 'width'=>550,
						 'shaded'=>1,
						 'cols'=>array( 'pes'=>array('justification'=>'center'),
										'uni'=>array('justification'=>'left'),
										'des'=>array('justification'=>'left'),
										'cat'=>array('justification'=>'center')));
 		$totalkg=$totalingredientes=$ingrediente=$contador=0;
			
  		while($row=mysql_fetch_array($result)){
			if($contador==0 || $ingrediente!=$row["id_insumo"] ){
			$totalingredientes++;
			$totalkg=$totalkg+$row["cant_partida"];
			$data[] =array(	'pes'=>$row["cant_partida"],'uni'=>$row["uni_insumo"],'des'=>$row["des_insumo"],'cat'=>$row["cat_insumo"]);
			}	
			$contador++;
			$ingrediente=$row["id_insumo"]; 
		} 
		   
		$pdf->ezTable($data,$titles,'FORMULA DEL PRODUCTO',$options);
		$pdf->ezText($totalkg." kg de carga inicial ",14,array('left'=> -12));
		$pdf->ezText(" ");
		$pdf->ezText($totalingredientes."  ingredientes ",14,array('left'=> -12));
		$pdf->ezText();
		
		$pdf->ezStream();
    }else{
	   echo("NO HAY MERCADERIAS REGISTRADOS CON ESTE CRITERIO");
    }
Desconecta($link);
?>
   