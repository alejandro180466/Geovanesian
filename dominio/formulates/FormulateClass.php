<?php
class Formulate{
	private $numfor;	private	$codmer;	private	$numins;	private	$cantfor;		private $fechafor;     
	
	public function __construct($numfor,$codmer,$numins,$cantfor,$fechafor){
		$this->numfor =$numfor;
		$this->codmer =$codmer;
		$this->numins =$numins;
		$this->cantfor=$cantfor;
		$this->fechafor=$fechafor;
	}
		
	public function setnumfor($numfor)	  { $this->numfor = $numfor;     }  
	public function setcodmer($codmer)    { $this->codmer = $codmer;     }
	public function setnumins($numins)    { $this->numins = $numins;     }
	public function setcantfor($cantfor)  { $this->cantfor = $cantfor;   }
	public function setfechafor($fechafor){ $this->fechafor = $fechafor; }
			
	public function getnumfor()   { return $this->numfor;   }
	public function getcodmer()   { return $this->codmer;   } 
	public function getnumins()   { return $this->numins;   }
	public function getcantfor()  { return $this->cantfor;  }
	public function getfechafor() { return $this->fechafor; }
	
	public function FormulateExiste($cod){
		$link=Conecta();
		$sql="select cod_mer from partida where cod_mer='".$cod."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	public function FormulateAdd(){
		$link=Conecta();
		$sql="insert into partida (cod_mer, id_insumo,cant_partida,fec_partida)
						values('".$this->getcodmer()."','".$this->getnumins()."','".$this->getcantfor()."',
							   '".$this->getfechafor()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function FormulateDel(){
		$link=Conecta();
		$sql="delete from partida where id_partida =".$this->getnumfor()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusFormulates(){
		$link=Conecta();
		$sql="SELECT * FROM partida WHERE cod_mer = ".$this->getcodmer().
										//" AND fec_partida <= ".$this->getfechafor().
										" ORDER BY cod_mer + id_insumo + fec_partida DESC";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>