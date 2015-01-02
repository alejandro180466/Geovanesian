<?php	include_once("../../dominio/Persistencia.php");
include_once("../../dominio/facturas/FacturaClass.php");
include_once("../../dominio/facturas/FacturaLineaClass.php");
include_once("class.ezpdf.php");
session_start();
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfil vienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre
if($perfil=="" || $codusr==""){
	header("location:../../index.php");	exit();
}//------------ BUSCA DATOS DEL CLIENTE 
$idpedido=$_SESSION['ses_pedido'];
$sqlcliente="SELECT p.num_cli , p.id_pedido, p.fec_pedido, p.est_pedido, p.mem_pedido , p.tip_pedido,
			        c.num_cli, c.raz_cli, c.rut_cli, c.dir_cli, c.dep_cli, c.tel_cli, c.fpag_cli ,
					c.ent_cli, c.pag_cli, c.plazo_cli,c.suc_cli,
					f.id_pedido,f.id_fac ,f.ser_fac, f.num_fac, f.fec_fac, f.tip_fac, f.sub_fac, f.iva_fac,
					f.tot_fac, f.memo_fac	
			 	        FROM pedido p ,cliente c, factura f
					        WHERE p.num_cli = c.num_cli AND p.id_pedido = $idpedido AND p.id_pedido = f.id_pedido";
$link=Conecta();
$res=mysql_query($sqlcliente,$link); 
while($row=mysql_fetch_array($res)){
    //DATOS SACADOS DEL CLIENTE 
    $numcli=$row['num_cli'];		$razcli=$row['raz_cli'];		$rutcli=$row['rut_cli'];
	$pagcli=$row['pag_cli'];		$dircli=$row['dir_cli'];		$depcli=$row['dep_cli'];
	$telcli=$row['tel_cli'];    	$fpagcli=$row['fpag_cli'];		$plazo=$row['plazo_cli'];
	$sucursal=$row['suc_cli'];
	
	// DATOS SACADOS DEL PEDIDO
	$fecped=$row['fec_pedido'];		$estado=$row['est_pedido'];		$memo=$row['mem_pedido'];
	$idped=$row['id_pedido'];		$tipeado=$row['tip_pedido'];    $pagcli=$row['pag_cli'];
    $ent=$row['ent_cli'];
	
	//DATOS SACADOS DE FACTURA
	$fecfac=convertirFormatoFecha($row['fec_fac']);
	$serfac=$row['ser_fac'];	$numfac=$row['num_fac'];   $memon=$row['memo_fac'];
	$tipfac=$row['tip_fac'];    $subfac=$row['sub_fac'];   $ivafac=$row['iva_fac'];
	$totfac=$row['tot_fac'];    $plafac=$row['pla_fac'];   $idfac=$row['id_fac'];     $nulfac="N";
	
	// redondeo de cifras
	$redondeo=$totfac-$ivafac-$subfac;
	$subfac=number_format($subfac,2);
    $ivafac=number_format($ivafac,2);
    $totfac=number_format($totfac,2);
	$redondeo=number_format($redondeo,2);
	$vence= suma_fechas($row['fec_fac'],$row['plazo_cli']);
}
//----------------- SI TIENE SUCURSALES , BUSCA LAS MISMAS
$numsuc=$_SESSION['ses_sucursal'];
if($sucursal==1){
	$numsuc=$_SESSION['ses_sucursal'];
	$sqlsuc="SELECT * FROM sucursal WHERE sucursal_id=".$numsuc ;
	$ressuc=mysql_query($sqlsuc,$link);
	while($row=mysql_fetch_array($ressuc)){
		$dircli='Sucursal '.$row['nom_suc'].'-'.$row['dir_suc'];
		$depcli=$row['dep_suc'];	$telcli=$row['tel_suc'];
		$ent=$row['ent_suc'];
	}
}
Desconecta($link);
//------------ CALCULO DE VENCIMIENTOS VS TIPO DOCUMENTO
if($tipfac=="FACTURA CONTADO" || $tipfac=="DEVOLUCION CONTADO"){
	$vence=$fecfac;
}elseif($tipfac=="FACTURA DE CREDITO" || $tipfac=="NOTA DE CREDITO"){
	
}elseif($tipfac=="NOTA REMITO"){
	$subfac="--------";		$ivafac="--------";		$totfac="--------";
}	 
//------------ BUSCA LINEAS DE LA FACTURA INGRESADO ANTERIORMENTE
$sqllineas="SELECT l.cod_mer, l.cant_lin, l.id_faclinea, l.id_fac, l.uni_mer, l.des_mer , l.uni_lin,
					l.des_lin,l.iva_lin,l.nul_lin,f.id_fac, f.id_pedido
							FROM facturalinea l, factura f 
								WHERE  f.id_fac = '$idfac'  AND  f.id_fac = l.id_fac 
								    ORDER BY l.id_faclinea ASC";
$link=Conecta();
$reslinea=mysql_query($sqllineas,$link);
$cantlin=mysql_num_rows($reslinea);
Desconecta($link); 
//------------- COMIENZA ARMADO DE PDF	
$pdf = new Cezpdf('C5','landscape');
$pdf->selectFont('fonts/Times-Roman.afm');
$pdf->ezSetCmMargins(1,1,2,1); //top,bottom,left,right
$i=0;
while($i<4){
    $i++;
	$laslineas=array();	$contador=0;   $totallinea=0; $subtotal=0; $subiva=0;  $via=" 1-CLIENTE ";
	//------------ GENERA LA VISTA DE LOS DATOS DEL CLIENTE
	$pdf->addText(400,425,12,$tipfac);$pdf->addText(560,425,16,$serfac." ".$numfac);
	$pdf->ezText(" ");
	$pdf->addText(106,400,12,$rutcli); $pdf->addText(400,400,12,$fecfac); $pdf->addText(480,400,12,$vence);$pdf->addText(590,390,10,$numcli);
	$pdf->ezText(" ");
    $pdf->addText(106,365,12,$razcli);
	$pdf->addText(106,350,12,$dircli); 									  $pdf->addText(400,350,10,'forma de pago : '.$fpagcli);
	$pdf->addText(106,335,12,$depcli); $pdf->addText(310,335,8,$telcli);  $pdf->addText(400,335,10,'dia de pago : '.$pagcli);     
	$pdf->ezText(" ");
	$pdf->ezSetY(294);
	//--------------GENERA LA VISTA DE LAS LINEAS DE LAS FACTURAS
	if($cantlin>0){
		while($row2=mysql_fetch_array($reslinea)){     
			$idlinea = $row2['id_faclinea'];
			$idpedido= $row2['id_pedido']; 
			//datos desplegados en forma impresa en la factura
			$codmer  = $row2['cod_mer'];      //codigo de la mercaderia 
			$cantlin = $row2['cant_lin'];     //cantidad de unidades 
			$unidad  = $row2['uni_mer'];      //unidad de venta 
			$articulo= $row2['des_mer'];      //descripcion de la mercadera 
			if($tipfac=="NOTA REMITO" || $tipfac=="NOTA DE DEVOLUCION"){
				$unilin=""; $descuen=""; $totallinea=""; $ivalin=""; $bonunit="";
			}else{
				$unilin  = $row2['uni_lin'];         //precio unitario  
				$descuen = $row2['des_lin'];         //descuento %
				$bonunit = ($unilin/100)*$descuen;
				$bonunit =number_format($bonunit,2); //descuento en pesos x unidad
				$final = $unilin-($unilin/100*($descuen));
				$totallinea=$cantlin*$final;         //importe de la linea                 
				$ivalin  = $row2['iva_lin'];         //tasa de iva de la mercaderia
				$totallinea=number_format($totallinea,2);
			}
			// datos no desplegados propios de cada linea
			$nullin  = 'A';
			//datos desplegados para cacular totales de la factura
			$data[] = array('codi'=>$codmer,'cant'=>$cantlin,'unid'=>$unidad,'desc'=>$articulo,
							'unit'=>$unilin,'des' =>$descuen,'dun' =>$bonunit,'subt'=>$totallinea,
							'iva' =>$ivalin);
		}
		$flinea= new FacturaLinea($idlinea,$idfac,$codmer,$cantlin,$unidad,$articulo,$unilin,$descuen,$ivalin,$nullin);
		$contador++;
		$laslineas[$contador]=$flinea;
	}									
	$options=array('xPos'=>'center',     
					'width'=>600,                 //ancho de la tabla 586
					'shaded'=>0,                  // intercala lineas blncas y negras 
					'showLines'=>0,               // mostrar u ocultar lineas
					'rowGap'=>1,
					'showHeadings'=>0,            //mostrar u ocultar titulos de columnas
					'fontSize'=>9,                // tamaño de la letra en las lineas de la tabla
					'cols'=>array('codi'=>array('justification'=>'left','width'=>20),
								  'cant'=>array('justification'=>'right','right'=>12,'width'=>40),
								  'unid'=>array('justification'=>'left','left'=>0,'width'=>64),
								  'desc'=>array('justification'=>'left' ,'left'=>0,'width'=>205),
								  'unit'=>array('justification'=>'right','right'=>14,'width'=>50),
								  'des' =>array('justification'=>'right','right'=>18,'width'=>28),
								  'dun' =>array('justification'=>'right','right'=>12,'width'=>54),
								  'subt'=>array('justification'=>'right','right'=>12,'width'=>84),
								  'iva' =>array('justification'=>'right','right'=>12,'width'=>30)));    
	$pdf->ezTable($data,'','',$options);         //$data,$cols,$titles,$options 
	//---------------genera la vista de totales y comentarios al pie
	if($tipfac=="NOTA REMITO" || $tipfac=="NOTA DE DEVOLUCION"){
		$subfac="= = = = = =" ; $ivafac="= = = = = ="; $totfac="= = = = =";
	}
	$pdf->addText(40,105,8,"PESOS URUGUAYOS"); $pdf->addText(554,105,12," $ "); $pdf->addText(578,105,12,$subfac);  //$subtotal
											  $pdf->addText(554,90,12," $ "); $pdf->addText(584,90,12,$ivafac);
										      $pdf->addText(554,78,9,"  $ redondeo "); $pdf->addText(608,78,9,$redondeo);			
	$pdf->addText(40,45,10,"Pedido Nº ".$idpedido );  $pdf->addText(110,45,10," del ".$fecped);
	$pdf->addText(40,35,10,"Entregar : ".$ent);                        $pdf->addText(554,35,14,"<b> $ ".$totfac."</b>\n");
	$pdf->addText(40,25,10,"Memo : ".$memon);
	if($i==1){	
		$via="1- VIA CLIENTE"; 
	}elseif($i==2){
		$via="2- VIA CONTABILIDAD";
	}else{	
		$via="3- VIA ARCHIVO";
	}
	$pdf->addText(528,1,10,$via);
	if($i<3){
	$pdf->ezNewPage(); //crea una nueva pagina
	}   
}	
$pdf->ezStream();
//---------------------------guarda en la carpeta un archivo pdf con el numero de pedido.
$pdfcode=$pdf->ezOutput();     
$fp=fopen('../../copiaspdf/facturaspdf/'.$numfac.'.pdf','wb');      
fwrite($fp,$pdfcode);fclose($fp);
?>