<?php
include("../../dominio/Persistencia.php");
include("class.ezpdf.php");
session_start();
$numcli=$_POST['numcli'];

$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
$nombre=$perfiles[2];              //nombre

if($perfil=="" || $codusr==""){
  		header("location:../../index.php");		exit();
}
$sql="SELECT l.id_pedido, l.id_pedidolinea, l.cod_mer, l.cant_pedido,
					c.num_cli, c.raz_cli,
						 p.id_pedido, p.num_cli, p.fec_pedido,
						 	m.cod_mer, m.des_mer, m.peso_mer		 
								FROM pedidolinea l , mercaderia m , pedido p , cliente c
									WHERE c.num_cli = $numcli
									  AND c.num_cli = p.num_cli
									  AND p.id_pedido = l.id_pedido
									  AND l.cod_mer = m.cod_mer";
  $link=Conecta();                                  // en Persistencia.php 
  $resultados=ejecutarConsulta($sql,$link);
  Desconecta($link);
  $total_registros=mysql_num_rows($resultados);
  //-------------------------------------------------------  
  if($total_registros>0){	
  		$pdf= new Cezpdf('a4');
		$i=$pdf->ezStartPageNumbers(300,30,14,'','',1);
		$pdf->selectFont('font/courier.afm');
		$pdf->ezImage('../../imagenes/image2063.jpg',0,80,'none','left');
		$pdf->ezText("FECHA DE IMPRESION: ".date("d/m/Y")." HORA:".date("H:i:s")." IMPRESO POR:".$nombre."",6,array('left'=>4));
				 
 		$titles = array('num'=>'PEDIDO','fec'=>'FECHA','raz'=>'CLIENTE','art'=>'ARTICULO','can'=>'CANTIDAD');
		$options = array('xPos'=>'center','width'=>510,'shaded'=>1 );			  	// opciones para la tabla	
		$kgtot=0;				 
 		while($row=mysql_fetch_array($resultados)){
				$id=$row["id_pedido"];
				$kg =$row["peso_mer"];
				$kglin=$kg*$row["cant_pedido"];
				$data[]=array('num'=>$row["id_pedido"],
					   		  'fec'=>$row["fec_pedido"],
							  'raz'=>$row["raz_cli"],
			    			  'art'=>$row["des_mer"],
				        	  'can'=>$row["cant_pedido"]);
							  
               $kgtot=$kgtot+$kglin ;
		}
		$pdf->ezTable($data,$titles,'TODOS LOS ARTICULOS PEDIDOS POR EL CLIENTE' ,$options);
		$pdf->ezText(" ");
		$pdf->ezText("Total en kg: ".$kgtot."",10,array('left'=>4));
		$pdf->ezStream();
   }else{
	   echo("NO HAY PEDIDOS REGISTRADOS CON ESTE CRITERIO");
   }
?>