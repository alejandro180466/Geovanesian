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
  		header("location:../../index.php");		exit();
}
  $link=Conecta();                                  // en Persistencia.php 
  $resultados=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($resultados);
  Desconecta($link);
  //-------------------------------------------------------  
  if($total_registros>0){	
  		$pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->ezSetCmMargins(2,2,3,2); //top,bottom,left,right
		$pdf->selectFont('font/courier.afm');
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
		$pdf->ezText($criterio,8,array('left'=>4));
		
 		$titles = array('num'=>'Nº',         // tittulos de la tabla
		 	 			'fec'=>'FECHA',
						'raz'=>'RAZON SOCIAL',
		 				'tel'=>'TELEFONO',
						'est'=>'ESTADO',
		 				'par'=>'PARA EL'
					   );
		$options = array('xPos'=>'center',
		                 'width'=>510,
						 'shaded'=>1 );			  	// opciones para la tabla	
 		while($row=mysql_fetch_array($resultados)){
				$id=$row["id_pedido"];
				$mensaje=$row['mem_pedido'];
				$data[]=array('num'=>$row["id_pedido"],
					   		  'fec'=>$row["fec_pedido"],
			    			  'raz'=>$row["raz_cli"],
				        	  'tel'=>$row["tel_cli"],
					    	  'est'=>$row["est_pedido"],
							  'par'=>$row["ent_pedido"]
					          );

		}
		$pdf->ezTable($data,$titles,'LISTADO DE LOS PEDIDOS',$options);
		$pdf->ezText(" ");
		$pdf->ezText("Total pedidos: ".$total_registros."",10,array('left'=>4));
		$pdf->ezStream();
   }else{
	   echo("NO HAY PEDIDOS REGISTRADOS CON ESTE CRITERIO");
   }
?>
