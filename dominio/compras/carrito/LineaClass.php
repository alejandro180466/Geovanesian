<?php
class Linea{
	private $idlinea;	private $idpedido;	private $articulo;	private $codmer;	private $cantidad;
	
	public function __construct($idlinea,$idpedido,$articulo,$codmer,$cantidad){
		$this->idlinea=$idlinea;		$this->idpedido=$idpedido;
		$this->articulo=$articulo;		$this->codmer=$codmer;		$this->cantidad=$cantidad;
	}
	public function __destruct(){	}
//-------------------------------------	
	public function get_idlinea() {	return $this->idlinea;	}
	public function get_idpedido(){	return $this->idpedido;	}
	public function get_articulo(){	return $this->articulo;	}
	public function get_codmer()  {	return $this->codmer;	}
	public function get_cantidad(){	return $this->cantidad;	}
//--------------------------------------	
	public function set_idlinea($idlinea)  {$this->idlinea=$idlinea;	}
	public function set_idpedido($idpedido){$this->idpedido=$idpedido;	}
	public function set_articulo($articulo){$this->articulo=$articulo;	}
	public function set_codmer($codmer)    {$this->codmer=$codmer;	    }
	public function set_cantidad($cantidad){$this->cantidad=$cantidad;	}
//---------------------------------------
	public function listarDatos(){
		$res="LINEA:" .$this->get_idlinea(). "PEDIDO:".$this->get_idpedido().
			 "DESCRIPCION:".$this->get_articulo(). "CODIGO:".$this->get_codmer().
			 "CANTIDAD:".$this->get_cantidad();
	}
}
?>