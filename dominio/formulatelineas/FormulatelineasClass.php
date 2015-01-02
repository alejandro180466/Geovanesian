<?php
class Formulatelinea{
	private	$flinea;	private $numfor;	private	$numins;	private	$cantfor;	     
	
	public function __construct($flinea,$numfor,$numins,$cantfor){
		$this->flinea  = $flinea;
		$this->numfor  = $numfor;
		$this->numins  = $numins;
		$this->cantfor = $cantfor;
	}
	public function setflinea($flinea)    { $this->flinea = $flinea;     }	
	public function setnumfor($numfor)	  { $this->numfor = $numfor;     }  
	public function setnumins($numins)    { $this->numins = $numins;     }
	public function setcantfor($cantfor)  { $this->cantfor = $cantfor;   }
	
	public function getflinea()   { return $this->flinea; }
	public function getnumfor()   { return $this->numfor;   }
	public function getnumins()   { return $this->numins;   }
	public function getcantfor()  { return $this->cantfor;  }
	
	public function FormulatelineasExiste($cod){
		$link=Conecta();
		$sql="select cod_mer from lineformulate where cod_mer='".$cod."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	public function FormulatelineasAdd(){
		$link=Conecta();
		$sql="insert into lineformulate (id_formulate, id_insumo,cant_lineformulate)
						values('".$this->getnumfor()."','".$this->getnumins()."','".$this->getcantfor()."'";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function FormulatelineasMod(){
		$link=Conecta();
		$sql="update lineformulate set  id_lineformulate = '".$this->getflinea()."', 
										id_formulate = '".$this->getnumfor()."',
		                                id_insumo = '".$this->getnumins()."',
							   	  	    cant_lineformulate = '".$this->getcantfor()."
							   	       	    WHERE cod_mer =".$this->getnummer()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function FormulatelineasDel(){
		$link=Conecta();
		$sql="update lineformulate set del_mer =0  where cod_mer =".$this->getnummer()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusFormulatelineas(){
		$link=Conecta();
		$sql="select * from lineformulate where id_mer=".$this->getnummer()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>