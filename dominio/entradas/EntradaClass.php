<?php
class Entrada{
	private $id; private $ins; private $cant; private $fecha; private $tipo;	private $prov;
		
	public function __construct($id,$ins,$cant,$fecha,$tipo,$prov){
		$this->id=$id;
		$this->ins=$ins;
		$this->cant=$cant;
		$this->fecha=$fecha;
		$this->tipo=$tipo;
		$this->prov=$prov;
	}
		
	public function setid($id)	    { $this->id = $id;      }  
	public function setins($ins)    { $this->ins = $ins;    }
	public function setcant($cant)  { $this->cant = $cant;  }
	public function setfecha($fecha){ $this->fecha = $fecha;}
	public function settipo($tipo)  { $this->tipo = $tipo;  }
	public function setprov($prov)  { $this->prov = $prov;  }
			
	public function getid()    { return $this->id;    }
	public function getins()   { return $this->ins;   } 
	public function getcant()  { return $this->cant;  }
	public function getfecha() { return $this->fecha; }
	public function gettipo()  { return $this->tipo;  }
	public function getprov()  { return $this->prov;  }
		
	public function EntradaAdd(){
		$link=Conecta();
		$sql="INSERT INTO stock (id_insumo,cant_stock,fec_stock,tip_stock,num_pro)
						VALUES('".$this->getins()."','".$this->getcant()."',
							   '".$this->getfecha()."','".$this->gettipo()."','".$this->getprov()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function EntradaMod(){
		$link=Conecta();
		$sql="update stock set  id_insumo = '".$this->getins()."',
							  	cant_stock= '".$this->getcant()."',
							   	fec_stock = '".$this->getfecha()."',
							   	tip_stock = '".$this->gettipo()."',
							   	num_pro   = '".$this->getprov()."',
							   		WHERE id_stock =".$this->getid()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}

	public function EntradaDel(){
		$link=Conecta();
		$sql="delete from stock  where id_stock =".$this->getid()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
}
?>