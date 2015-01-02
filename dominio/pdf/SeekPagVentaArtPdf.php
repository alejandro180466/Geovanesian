<?php include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
session_start();
$sql=$_SESSION['ses_sql'];
$criterio=$_SESSION['ses_criterio'];
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){	header("location:../../index.php");	exit();}
$link=Conecta();  // en Persistencia.php 
$result=mysql_query($sql,$link);
$total_registros = mysql_num_rows($result);
if($total_registros>0){	
	$pdf = new Cezpdf('a4');
	$pdf->selectFont('font/courier.afm');
	$pdf->ezSetCmMargins(2,2,2,1); //top,bottom,left,right
	$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
	$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
	$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
	$pdf->ezText(" ");
	$pdf->ezText($criterio,10,array('left'=>4));
	$pdf->ezText(" ");
	$titles = array('fec'=>'FECHA', 'tip'=>'TIPO DOCUMENTO','fac'=>'NºDOC',
					'mer'=>'ARTICULO','env'=>'ENVASE','uni'=>'UNIDADES','link'=>'LINK');
						
	$options=array('xPos'=>'center',     
                   'width'=>560,                 //ancho de la tabla 586
		           'shaded'=>0,                  // intercala lineas blncas y negras 
			       'showLines'=>1,               // mostrar u ocultar lineas
			       'rowGap'=>1,
				   'fontSize'=>7,
			       'showHeadings'=>1,            //mostrar u ocultar titulos de columnas
			       'cols'=>array('fec'=>array('justification'=>'center'),
							     'tip'=>array('justification'=>'left'),
							     'fac'=>array('center'=>48),
							     'mer'=>array('justification'=>'left'),
							     'env'=>array('justification'=>'left'),
								 'uni'=>array('justification'=>'right'),
								 'link'=>array('justification'=>'center'),
							  ));
	$totalunidades = $totalkg = 0;
  	while($row=mysql_fetch_array($result)){
		$id=$row['id_fac'];	$nulfac=$row['nul_fac'];	$tipdoc=$row['tip_fac'];
		if($tipdoc=="FACTURA CREDITO" || $tipdoc=="FACTURA CONTADO"){ //CONTROLA TIPO DE DOCUMENTO
			//$kglinea = $row['cant_lin']* $row['peso_mer'];
			$canlinea = $row['cant_lin'] * 1;
			//$totalkg = $totalkg + $kglinea;	
			$totalunidades = $totalunidades + $row['cant_lin'];
		}elseif($tipdoc=="DEVOLUCION CONTADO" || $tipdoc=="NOTA DE CREDITO"){
			//$kglinea = $row['cant_lin']* $row['peso_mer']*(-1);
			$canlinea = $row['cant_lin'] * (-1);
			//$totalkg = $totalkg + $kglinea;	
			$totalunidades = $totalunidades - $row['cant_lin'];
		}
		// genera vinculo con el pdf de la factura
		$fname=$row['num_fac'];
		$nulfac=$row['nul_fac'];
		$existepdf=is_file('../../../copiaspdf/facturaspdf/'.$fname.'.pdf');
		if ($existepdf){
			$ruta="../../../copiaspdf/facturaspdf/".$fname.".pdf";
			$link="<a href=".$ruta.">ver</a>";
		}else{
			$ruta ="";		$link="SIN PDF";
		} 	//---------------------------------- imprime la linea
		$kg=number_format($kglinea,2);	
		$cant=number_format($canlinea,2);
		$data[]=array('fec'=>$row['fec_fac'],'tip'=>$row['tip_fac'],'fac'=>$row['num_fac'],
					  'mer'=>$row['des_mer'],'env'=>$row['uni_mer'],
					  'link'=>' ' );  //$link 
	} 
	$pdf->ezTable($data,$titles,'LISTADO DE LINEAS DE FACTURAS POR MERCADERIA',$options);
	$pdf->ezText(" ");
	$pdf->ezText("PESOS  Total unidades : ". number_format($totalunidades,0).
	             " en " .$total_registros." documentos ",10,array('left'=>4));
	$pdf->ezStream();
}
?> 