<?php	class Alerta{	private $id;	    private	$concepto;	private $detalle;   private $hoy; 
						private $vence;		private	$previo;	private $estado;	private	$memo;
	
	public function __construct($id,$concepto,$detalle,$hoy,$vence,$previo,$estado,$memo){
		$this->id = $id;                 //id 
		$this->concepto = $concepto;    //concepto
		$this->detalle = $detalle;     //detalle
		$this->hoy = $hoy;            //hoy
		$this->vence = $vence;       //vence
		$this->previo = $previo;    //precio			
		$this->estado = $estado;   //estado
		$this->memo = $memo;      //memo
	}
		
	public function setid($id)            { $this->id = $id;            }  
	public function setconcepto($concepto){ $this->concepto = $concepto;}
	public function setdetalle($detalle)  { $this->detalle = $detalle;  }
	public function sethoy($hoy)          { $this->hoy = $hoy;          }
	public function setvence($vence)      { $this->vence = $vence;      }
	public function setprevio($previo)    { $this->previo = $previo;    }
	public function setestado($estado)    { $this->estado = $estado;    }
	public function setmemo($memo)        { $this->memo = $memo;        }
			
	public function getid()      { return $this->id;       }
	public function getconcepto(){ return $this->concepto; }
	public function getdetalle() { return $this->detalle;  }
	public function gethoy()     { return $this->hoy;      }
	public function getvence()   { return $this->vence;    }
	public function getprevio()  { return $this->previo;   }
	public function getestado()  { return $this->estado;   }
	public function getmemo()    { return $this->memo;     }
	
	public function AlertaAdd(){
	    $link=Conecta();
		$sql="INSERT INTO alertas ( concepto, detalle, hoy, vence, previo, estado, memo)
					    VALUES('".$this->getconcepto()."','".$this->getdetalle()."','".$this->gethoy()."',
						       '".$this->getvence()."','".$this->getprevio()."','".$this->getestado()."',
							   '".$this->getmemo()."')";
				   
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function AlertaMod(){
	    $link=Conecta();
		$sql="UPDATE alertas SET   concepto = '".$this->getconcepto()."',
						            detalle = '".$this->getdetalle()."',
							            hoy = '".$this->gethoy()."',
						              vence = '".$this->getvence()."',
									 previo = '".$this->getprevio()."',
						             estado = '".$this->getestado()."',
							           memo = '".$this->getmemo()."'
									        WHERE alertas_id =".$this->getid()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function AlertaDel(){
		$link=Conecta();
		$sql="DELETE FROM alertas WHERE alertas_id = ".$this->getid();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function Alertar(){
		$vence =strtotime($this->getvence());  //vencimiento
		$previo=$this->getprevio()*24*60*60;   // previo 
		$hoy=time();
		$plazo=$vence-$hoy;
		
		if($plazo<=$previo){
			if($plazo >($previo*0.85)){	$color="verde";		}	
			if($plazo<=($previo*0.85)){	$color="amarillo";	}	
			if($plazo<=($previo*0.65)){	$color="naranja";   }
			if($plazo<=($previo*0.45)){	$color="rojo";		}
		}else{
			$color="blanco";
		}
		return $color;	
	}
}?>