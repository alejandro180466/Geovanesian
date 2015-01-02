<?php
class Producido{
	private $numprod;	private	$fecprod;	private	$canprod;  private $lotprod;	private	$codmer;	private $escala;
	
	public function __construct($numprod, $fecprod, $canprod, $lotprod, $codmer, $escala){
		$this->numprod=$numprod;
		$this->fecprod=$fecprod;   
		$this->canprod=$canprod;
		$this->lotprod=$lotprod;
		$this->codmer =$codmer;
		$this->escala =$escala;
	}
		
	public function setnumprod($numprod)  { $this->numprod = $numprod; }  
	public function setfecprod($fecprod)  { $this->fecprod = $fecprod; }
	public function setcanprod($canprod)  { $this->canprod = $canprod; }
	public function setlotprod($lotprod)  { $this->lotprod = $lotprod; }
	public function setcodmer ($codmer)   { $this->codmer  = $codmer;  }
	public function setescala ($escala)   { $this->escala  = $escala;  }
				
	public function getnumprod()  { return $this->numprod; }
	public function getfecprod()  { return $this->fecprod; } 
	public function getcanprod()  { return $this->canprod; }
	public function getlotprod()  { return $this->lotprod; }
	public function getcodmer()   { return $this->codmer;  }
	public function getescala()   { return $this->escala;  }
			
	public function ProduccionExiste(){
		$link=Conecta();
		$sql="select num_prod from produccion where num_prod='".$this->getnumprod()."";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		//FreeResp($res);
		Desconecta($link);
		return $existe;
	}
	
	public function ProduccionAdd(){
		
		$this->setnumprod(siguienteID('contadores','num_prod'));
		$link=Conecta();
		$sql="insert into produccion( num_prod , fec_prod , can_prod , lot_prod , cod_mer ,lot_esca)
						values('".$this->getnumprod()."',
						       '".$this->getfecprod()."',
							   '".$this->getcanprod()."',
							   '".$this->getlotprod()."',
							   '".$this->getcodmer()."',
							   '".$this->getescala()."')";
								   
		$res=ejecutarConsulta($sql,$link);
		//FreeResp($res);
		Desconecta($link);
	}
	
	public function ProduccionMod(){
		$link=Conecta();
		$sql="update produccion set num_prod='".$this->getnumprod()."',
							  		fec_prod='".$this->getfecprod()."',
							   		can_prod='".$this->getcanprod()."',
									lot_prod='".$this->getlotprod()."',
									lot_esca='".$this->getescala()."',
							   		cod_mer='".$this->getcodmer()."'
							   			WHERE num_prod =".$this->getnumprod()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function ProduccionDel(){
		$link=Conecta();
		$sql="delete from produccion where num_prod = ".$this->getnumprod();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function LasProducciones(){
		$link=Conecta();
		$sql="select num_prod, fec_prod, can_prod, lot_prod, cod_mer, lot_esca
		 			from produccion where num_prod= ".$this->getnumprod();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>