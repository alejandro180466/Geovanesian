<?php
include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
session_start();
$sql=$_SESSION['ses_sql'];
$sql2=$_SESSION['ses_sql2'];
$criterio=$_SESSION['ses_criterio'];

$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){ header("location:../../index.php");	exit();}	
	$link=Conecta();                                  // en Persistencia.php 
	$result=mysql_query($sql,$link);
	$total_registros=mysql_num_rows($result);
	$res2=mysql_query($sql2,$link);
	$total_sucursales=mysql_num_rows($res2);
   //-------------------------------------------------------  
   if($total_registros>0){	
        $pdf = new Cezpdf('a4');
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
		$pdf->ezText($criterio,10,array('left'=>4));		 
 		$titles = array('fec'=>'FECHA','fac'=>'NºDOC','tip'=>'TIPO DOCUMENTO',
						'mer'=>'MERCADERRIA','uni'=>'UNIDAD','imp'=>'IMPORTE','ver'=>'VER'); 
		$contador=$total=0;
		$city=$_SESSION['ses_city'];
		//---------------------------------------------------------------------		
		while($row=mysql_fetch_array($result)){ 
			if($row['sucursal_id']!=0 || $row['dep_cli']==$city){
				$retorno=false;
				$sucursal = $row['sucursal_id'];
				if($sucursal==19 || $sucursal==22){    // Hasta aca funciona
					$retorno=true;
				}
				if( $row['dep_cli']==$city  || $retorno==true){	
					$id=$row['id_fac'];
					$fname=$row['num_fac'];
					$nulfac=$row['nul_fac'];
					$tipdoc=$row['tip_fac'];
					$existepdf=is_file('../facturaspdf/'.$fname.'.pdf');
					if ($existepdf){
						$ruta="http://www.bondulce.com/pentisol/dominio/facturas/facturaspdf/".$fname.".pdf";
					}else{
						$ruta = "NO DISPONIBLE";
					} 	
					$options=array('xPos'=>'center',     
							   'width'=>540,                 //ancho de la tabla 586
							   'shaded'=>0,                  // intercala lineas blncas y negras 
							   'showLines'=>1,               // mostrar u ocultar lineas
							   'rowGap'=>1,
							   'fontSize'=>7,
							   'showHeadings'=>1,            //mostrar u ocultar titulos de columnas
							   'cols'=>array('fec'=>array('justification'=>'center'),
											 'fac'=>array('justification'=>'center'),
											 'tip'=>array('left'=>48),
											 'mer'=>array('center'=>60),
											 'uni'=>array('justification'=>'center'),
											 'imp'=>array('justification'=>'right'),
											 'ver'=>array('name'=>'VER','justification'=>'center','link'=>$ruta))); 
																 //CONTROLO QUE NO SEA ENVASE  
					if($tipdoc=="FACTURA CREDITO" || $tipdoc=="FACTURA CONTADO"){               //CONTROLA TIPO DE DOCUMENTO
						$montolinea=$row['cant_lin']*$row['uni_lin'];
						if($row['des_lin']>0){
							$descuento=($montolinea/100)*$row['des_lin'];
							$montolinea=$montolinea-$descuento;
						}	 
						$total=$total+$montolinea;
					}elseif($tipdoc=="DEVOLUCION CONTADO" || $tipdoc=="NOTA DE CREDITO"){
						$montolinea=$row['cant_lin']*($row['uni_lin'])*(-1);
						if($row['des_lin']>0){
							$descuento=($montolinea/100)*$row['des_lin'];
							$montolinea=$montolinea-$descuento;
						}	 			
						$total=$total-$montolinea;
					}
					$fecha=$row['fec_fac'];
					$numdoc=$row['ser_fac'].$row['num_fac'];
					$descrip=$row['des_mer'];
					$cantidad=$row['cant_lin'];
					$monto=number_format($montolinea,2);
					$data[]=array('fec'=>$fecha,'fac'=>$numdoc,'tip'=>$tipdoc,'mer'=>$descrip,'uni'=>$cantidad,
								  'imp'=>$monto,'ver'=>$ruta);
				}				  
			}				  
		} 
		$apagar=$total*0.02;  //importe a pagar 
		$pdf->ezTable($data,$titles,'LISTADO DE LINEAS DE FACTURAS PARA PAGO DE TASA BROMATOLOGICA',$options);
		$pdf->ezText(" ");
		$pdf->ezText("PESOS  Total VENDIDO : $ ". number_format($total,2)." Tasa a pagar : $ ".number_format($apagar,2)."",10,array('left'=>4));
		$pdf->ezStream();
	}else{
	   echo("NO HAY FACTURACION REGISTRADAS CON ESTE CRITERIO");
    }
?>