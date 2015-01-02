<?php 
include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
session_start();
$sqll=$_SESSION['ses_sqll'];
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
$result=mysql_query($sqll,$link);
$total_registros=mysql_num_rows($result);
Desconecta($link);
//-------------------------------------------------------  
if($total_registros>0){	
  	$pdf= new Cezpdf('a4');
	$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
	$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
	$pdf->selectFont('font/courier.afm');
	$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
	$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
	$pdf->ezText($criterio,10,array('left'=>6));		 
 	$titles = array('fec'=>'FECHA','ped'=>'PEDIDO','cli'=>'CLIENTE','art'=>'ARTICULO','can'=>'CANTIDAD');
	$options = array('xPos'=>'center','width'=>520,'shaded'=>1 );			  	// opciones para la tabla	
 	$total=0;
  	while($row=mysql_fetch_array($result)){
		$id=$row['cod_mer'];	
		$data[] = array('fec'=>$row['fec_pedido'],
	    			    'ped'=>$row['id_pedido'],
			    	    'cli'=>$row['raz_cli'],
					    'art'=>$row['des_mer'],
			    	    'can'=>$row['cant_pedido'],
				       );
		$total=$total+$row['cant_pedido'];
		$kguni=$row['peso_mer'];
	} 
	$grantotal=$total*$kguni;
	$pdf->ezTable($data,$titles,'LISTADO DE PEDIDOS POR ARTICULO',$options);
	$pdf->ezText(" ");
	$pdf->ezText("TOTAL DE UNIDADES PEDIDAS : ".$total."",12,array('left'=>4));
	$pdf->ezText(" ");
	$pdf->ezText("TOTAL DE KG PEDIDOS : ".$grantotal."",12,array('left'=>4));
	$pdf->ezStream();
  }else{
	   echo("NO HAY PEDIDOS REGISTRADOS CON ESTE CRITERIO");
  } 
?>