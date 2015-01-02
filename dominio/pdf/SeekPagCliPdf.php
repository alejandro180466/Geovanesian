<?php  include("../../dominio/Persistencia.php");
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
 
  $link=Conecta();                               
  $resultados=ejecutarConsulta($sql,$link);
  $total_registros=mysql_num_rows($resultados);
  //-------------------------------------------------------  
  if($total_registros>0){	
        $pdf= new Cezpdf('a4','landscape');
		$i=$pdf->ezStartPageNumbers(440,33,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezSetCmMargins(2,2,2,2); //top,bottom,left,right
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
		$pdf->ezText($criterio,10,array('left'=>4));
						 
 		$titles = array('raz'=>'RAZON SOCIAL','dir'=>'DIRECCION','tel'=>'fono','cel'=>'movil','fax'=>'fax',
						'con'=>'CONTACTO','ent'=>'ENTREGA',
						'lu'=>'L',
						'ma'=>'M',
						'mi'=>'M',
						'ju'=>'J',
						'vi'=>'V',
						'sa'=>'S',
						'etc'=>'COMENTARIO'
					   );
		$options=array('xPos'=>'center',     
	               	   'width'=>760,                 //ancho de la tabla 586
				       'shaded'=>1,                  // intercala lineas blncas y negras 
				       'showLines'=>1,               // mostrar u ocultar lineas
				       'rowGap'=>1,
				       'fontSize'=>8,
				       'showHeadings'=>1,            //mostrar u ocultar titulos de columnas
				       'cols'=>array('raz'=>array('justification'=>'left'),
								     'dir'=>array('justification'=>'left'),
								     'tel'=>array('justification'=>'center'),
									 'cel'=>array('justification'=>'center'),
								     'fax'=>array('justification'=>'center'),
				                     'con'=>array('justification'=>'left'),
								     'ent'=>array('justification'=>'left'), 		  
								     'etc'=>array('justification'=>'left')
								    )
					   );
		while($row=mysql_fetch_array($resultados)){
			//CONTENIDO DE CADA LINEA			
		    $data[]=array('raz'=>$row['raz_cli'],
			    		  'dir'=>$row['dir_cli'],
				          'tel'=>$row['tel_cli'],
						  'cel'=>$row['cel_cli'],
						  'fax'=>$row['fax_cli'],
						  'con'=>$row['cont_cli'],
						  'ent'=>$row['ent_cli'],
						  'lu'=>'','ma'=>'','mi'=>'','ju'=>'','vi'=>'','sa'=>'',
						  'etc'=>''
						 );
		} 
		$pdf->ezTable($data,$titles,'LISTADO DE CARTERA DE CLIENTES',$options);
		$pdf->ezText(" ");
		$pdf->ezStream();
   }else{
	   echo("NO HAY CLIENTES CON ESTE CRITERIO");
   } ?>
