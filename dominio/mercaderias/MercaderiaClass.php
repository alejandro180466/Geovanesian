<?php
class Mercaderia{
	private $nummer;	private	$desmer;	private	$unimer;	private	$catmer;
	private	$ivamer;	private $stockmer;	private $fecha;     private $minimo;
	private	$pesomer;	private $precio;
	
	public function __construct($nummer,$desmer,$unimer,$catmer,$ivamer,$stockmer,$fecha,$minimo,$pesomer,$precio){
		$this->nummer=$nummer;
		$this->desmer=$desmer;
		$this->unimer=$unimer;
		$this->catmer=$catmer;
		$this->ivamer=$ivamer;
		$this->stockmer=$stockmer;
		$this->fecha=$fecha;
		$this->minimo=$minimo;			
		$this->pesomer=$pesomer;
		$this->precio=$precio;
		
	}
		
	public function setnummer($nummer)	  { $this->nummer = $nummer;     }  
	public function setdesmer($desmer)    { $this->desmer = $desmer;     }
	public function setunimer($unimer)    { $this->unimer = $unimer;     }
	public function setcatmer($catmer)    { $this->catmer = $catmer;     }
	public function setivamer($ivamer)    { $this->ivamer = $ivamer;     }
	public function setstockmer($stockmer){ $this->stockmer = $stockmer; }
	public function setfecha($fecha)      { $this->fecha = $fecha;       } 
	public function setminimo($minimo)    { $this->minimo = $minimo;     }
	public function setpesomer($pesomer)  { $this->pesomer = $pesomer;   }
	public function setprecio($precio)    { $this->precio = $precio;     }
			
	public function getnummer()  { return $this->nummer;  }
	public function getdesmer()  { return $this->desmer;  } 
	public function getunimer()  { return $this->unimer;  }
	public function getcatmer()  { return $this->catmer;  }
	public function getivamer()  { return $this->ivamer;  }
	public function getstockmer(){ return $this->stockmer;}
	public function getfecha()   { return $this->fecha;   }
	public function getminimo()  { return $this->minimo;  } 
	public function getpesomer() { return $this->pesomer; }
	public function getprecio() { return $this->precio; }
	
	public function MercaderiaExiste($cod){
		$link=Conecta();
		$sql="select cod_mer from mercaderia where cod_mer='".$cod."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	public function MercaderiaAdd(){
		$this->setnummer(siguienteID('contadores','cod_mer'));
		$link=Conecta();
		$sql="insert into mercaderia (cod_mer, des_mer, uni_mer, cat_mer, iva_mer, stock_mer , fecha_mer , min_mer ,peso_mer,precio_mer)
						values('".$this->getnummer()."','".$this->getdesmer()."','".$this->getunimer()."',
							   '".$this->getcatmer()."','".$this->getivamer()."','".$this->getstockmer()."',
							   '".$this->getfecha()."','".$this->getminimo()."','".$this->getpesomer()."','".$this->getprecio()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function MercaderiaMod(){
		$link=Conecta();
		$sql="update mercaderia set  cod_mer = '".$this->getnummer()."',
							  		 des_mer = '".$this->getdesmer()."',
							   	  	 uni_mer = '".$this->getunimer()."',
							   	     cat_mer = '".$this->getcatmer()."',
							   	     iva_mer = '".$this->getivamer()."',
							   	     stock_mer='".$this->getstockmer()."',
									 fecha_mer='".$this->getfecha()."',
									 min_mer='".$this->getminimo()."',
							   	     peso_mer ='".$this->getpesomer()."',
									 precio_mer ='".$this->getprecio()."'
							   	  		WHERE cod_mer =".$this->getnummer()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function MercaderiaActPrecio(){
		$link=Conecta();
		$sql="UPDATE mercaderia SET  cod_mer='".$this->getnummer()."',
							  		 precio_mer='".$this->getprecio()."'
							   	  		WHERE cod_mer=".$this->getnummer()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function MercaderiaDel(){
		$link=Conecta();
		$sql="update mercaderia set del_mer =0  where cod_mer =".$this->getnummer()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusMercaderias(){
		$link=Conecta();
		$sql="select cod_mer, des_mer, uni_mer, cat_mer, iva_mer, stock_mer , fecha_mer , min_mer , peso_mer , precio_mer
					from mercaderia where 1=1";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>