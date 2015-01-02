<?php
include_once("../../dominio/carrito/LineaClass.php");
class Carrito{
 var $listalineas; // var?? //pasa a ser un array de objetos lineas
	
	public function _construct($listalineas){
		$this->listalineas=$listalineas;
	}
//------------------------------------------------------------------------------	
	public function get_listalineas(){       //retorna
	  	return $this->listalineas;           //ojo es un conjunto de objetos
	}
//------------------------------------------------------------------------------	
	public function set_listalineas($listalineas){  //carga
		$this->listalineas=$listalineas;            //ojo es un conjunto de objetos
	} 
//-------------------------------------------------------------------------------	
	public function agregar($linea){
		$codmer=$linea->get_codmer();             //carga el codavs del objeto linea
		$posicion=$this->buscarAvisoXid($codmer); //busca si el codigo esta dentro del carrito	
		if($posicion==-1){                        //si el aviso no esta en una linea
			$cant=count($this->listalineas);     
			$this->listalineas[$cant]=$linea;     //carga en listalineas la nueva linea
		}else{
			session_start();
			$_SESSION["ses_error"]="LA MERCADERIA SELECCIONADA YA SE INGRESO";
		}
	}
//-----------------------------------------------------------------------	
	public function eliminar($codmer){
		$posicion=$this->buscarAvisoXid($codmer);   
		$this->listalineas[$posicion]->set_idlinea(0);
		$this->listalineas[$posicion]->set_codmer(0);
	}
//-----------------------------------------------------------------------	
	public function buscarAvisoXid($codmer){
		$pos=-1;
		for($i=0; $i < count($this->listalineas); $i ++){   
			if($this->listalineas[$i]->get_codmer()==$codmer){ 
				$pos=$i;
			}
		}
		return $pos;	
	}
//-----------------------------------------------------------------------	
	public function imprimeCarrito(){  //de momento no lo uso mas
		$cant=$this->cantidadLineas();
		if($cant>0){
			//$string="<CENTER><table align='center' width='20%' border='1' bgcolor='#FFFFFF'>
				//				<tr><td>codigo</td><td>Articulo</td><td>Cantidad</td></tr>";
			$string= array();
			$string[0]=array('codigo','articulo','cantidad');	
			for($i=0 ; $i < $cant ; $i++){ 
				$codmer=$this->listalineas[$i]->get_codmer(); 
				$articulo=$this->listalineas[$i]->get_articulo();
				$cantidad=$this->listalineas[$i]->get_cantidad(); 
				
				//$string=$string."<tr><td>".$codmer."</td><td>".$articulo."</td><td>".$cantidad."</td></tr>";
				$string[$i-1]=array($codmer,$articulo,$cantidad);
			}	
			//$string=$string."</table>"."Cantidad de articulos : ".$cant."</CENTER>";
		}else{
			//$string="No hay productos en el carrito";
		}
		return $string;	
	}
//------------------------------------------------------------------------	
	public function guardarCarrito(){
		$link=Conecta();			
		$cant=count($this->listalineas);
		for($i=0;$i<$cant;$i++){
			$idlinea=$this->listalineas[$i]->get_idlinea();
			if($idlinea!=0){
				$idpedido=$this->listalineas[$i]->get_idpedido();
			    $articulo=$this->listalineas[$i]->get_articulo();
				$codmer  =$this->listalineas[$i]->get_codmer();
				$cantidad=$this->listalineas[$i]->get_cantidad();  
							
				$sql2="insert into pedidolinea (id_pedido , id_pedidolinea, cod_mer , cant_pedido)
								          values('$idpedido','$idlinea','$codmer','$cantidad')";
				$res2=ejecutarConsulta($sql2,$link);  //guardado de lineas
			}	
		}
		Desconecta($link);
	}
//-------------------------------------------------------------------------
	public function cantidadLineas(){
		$cant=0;
		for($i=0; $i < count($this->listalineas);$i ++){
			$cant++	;
		}
		return $cant;
	}
//-------------------------------------------------------------------------	
	public function Devidlinea($i){			
		$idlinea=$this->listalineas[$i]->get_idlinea(); 
		return $idlinea;	
	}
	public function Devidpedido($i){			
		$idpedido=$this->listalineas[$i]->get_idpedido(); 
		return $idpedido;	
	}
	public function Devcodmer($i){
		$codmer=$this->listalineas[$i]->get_codmer(); 
		return $codmer;
	}	
	public function Devarticulo($i){	
		$articulo=$this->listalineas[$i]->get_articulo();
		return $articulo;		
	}			
	public function Devcantidad($i){			
		$cantidad=$this->listalineas[$i]->get_cantidad(); 
		return $cantidad;	
	}
} //cierro la clase
session_start();
if (!isset($_SESSION['ses_carro'])){     //si no esta creada la sesion la creo
	//session_register('ses_carro');
	$_SESSION['ses_carro']=new Carrito();
	$_SESSION['ses_error']="YA PUEDE AGREGAR ARTICULOS";
}
?>