 <?php
class Movimient{
	private $codmov;	private	$fecmov;	private	$tipmov;	private	$nummov;
	private	$numrut;	private $valmov;	private	$monmov;	private $iva;
	private $rubro;
	
	public function __construct($codmov, $fecmov, $tipmov, $nummov,	$numrut, $valmov, $monmov, $iva, $rubro){
		$this->codmov=$codmov;
		$this->fecmov=$fecmov;   
		$this->tipmov=$tipmov;
		$this->nummov=$nummov;
		$this->numrut=$numrut;			
		$this->valmov=$valmov;
		$this->monmov=$monmov;	
		$this->iva=$iva;
		$this->rubro=$rubro;
	}
		
	public function setcodmov($codmov)	{ $this->codmov = $codmov;  }  
	public function setfecmov($fecmov)  { $this->fecmov = $fecmov;  }
	public function settipmov($tipmov)  { $this->tipmov = $tipmov;  }
	public function setnummov($nummov)  { $this->nummov = $nummov;  }
	public function setnumrut($numrut)  { $this->numrut = $numrut;  }
	public function setvalmov($valmov)  { $this->valmov = $valmov;  }
	public function setmonmov($monmov)  { $this->monmov = $monmov;  }
	public function setiva($iva)        { $this->iva    = $iva;     }
	public function setrubro($rubro)    { $this->rubro  = $rubro;   }
	
			
	public function getcodmov()  { return $this->codmov; }
	public function getfecmov()  { return $this->fecmov; } 
	public function gettipmov()  { return $this->tipmov; }
	public function getnummov()  { return $this->nummov; }
	public function getnumrut()  { return $this->numrut; }
	public function getvalmov()  { return $this->valmov; }
	public function getmonmov()  { return $this->monmov; }
	public function getiva()     { return $this->iva;    }
	public function getrubro()   { return $this->rubro;  }
			
	public function MovimientoExiste(){
		$link=Conecta();
		$sql="select cod_mov from movimiento where cod_mov='".$this->getcodmov()."";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	
	public function MovimientoAdd(){
		$this->setcodmov(siguienteID('contadores','id_mov'));
		$link=Conecta();
		$sql="insert into movimiento(cod_mov ,fec_mov ,tip_mov ,num_mov ,rut_pro ,val_mov ,mon_mov ,val_iva , rub_mov )
						values('".$this->getcodmov()."',
						       '".$this->getfecmov()."',
							   '".$this->gettipmov()."',
							   '".$this->getnummov()."',
							   '".$this->getnumrut()."',
							   '".$this->getvalmov()."',
							   '".$this->getmonmov()."',
							   '".$this->getiva()."',
							   '".$this->getrubro()."')";
								   
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function MovimientoMod(){
		$link=Conecta();
		$sql="update movimiento set cod_mov='".$this->getcodmov()."',
							  		fec_mov='".$this->getfecmov()."',
							   		tip_mov='".$this->gettipmov()."',
							   		num_mov='".$this->getnummov()."',
							   		rut_pro='".$this->getnumrut()."',
							   		val_mov='".$this->getvalmov()."',
							   		mon_mov='".$this->getmonmov()."',
									val_iva='".$this->getiva()."',
									rub_mov='".$this->getrubro()."'
							        	WHERE cod_mov =".$this->getcodmov()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function MovimientoDel(){
		$link=Conecta();
		$sql="delete from movimiento where cod_mov = ".$this->getcodmov();
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	
	public function LosMovimientos(){
		$link=Conecta();
		$sql="select cod_mov, fec_mov, tip_mov, num_mov, rut_pro, val_mov, mon_mov , val_iva , rub_mov 
					from movimiento where num_rut= ".$this->getnumrut();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>