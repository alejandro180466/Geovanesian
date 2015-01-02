<?php 
if(!isset($_SESSION)){ 
    session_start(); 
}
//session_register('ses_sqll');
$codmer=$_POST['id'];       //razon social
$sqll="SELECT m.cod_mer, m.des_mer, m.peso_mer ,
  				 l.cod_mer , l.id_pedido , l.cant_pedido ,
				 	 p.id_pedido , p.num_cli , p.fec_pedido , p.est_pedido ,
					   c.num_cli , c.raz_cli
					     FROM mercaderia m , pedido p , cliente c , pedidolinea l 
					 		WHERE l.cod_mer = $codmer
								  AND m.cod_mer = l.cod_mer 
								  AND l.id_pedido = p.id_pedido
								  AND p.num_cli = c.num_cli  ";

$criterio="Criterio: todos los pedidos del producto ".$codmer. " ";								  
  
$sqll.=" ORDER BY p.fec_pedido ASC";
$criterio.= "ordenado por fecha de pedido";
$_SESSSION['ses_criterio']=$criterio ;	
$_SESSION['ses_sqll']=$sqll;
header('location:../../dominio/mercaderias/SeekPag2.php');
?>