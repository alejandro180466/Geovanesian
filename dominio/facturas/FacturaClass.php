<?php
class Factura{
	private $idfac;	    private $idped;     private	$serfac;	private	$numfac;	private $fecfac;
    private $numcli;	private	$tipfac;	private	$nulfac;	private $subfac;	private $ivafac;
    private	$totfac;	private	$plafac;	private $memo;		private $sucursal;
	
	public function __construct($idfac,$idped,$serfac,$numfac,$fecfac,$numcli,
	                            $tipfac,$nulfac,$subfac,$ivafac,$totfac,$plafac,$memo,$sucursal){
		$this->idfac=$idfac;   //id de factura
		$this->idped=$idped;   //id de pedido
		$this->serfac=$serfac; //letra de serie de la factura   
		$this->numfac=$numfac; //numero de factura
		$this->fecfac=$fecfac; //fecha de factura
		$this->numcli=$numcli; //id del cliente
		$this->tipfac=$tipfac; //tipo de documento
		$this->nulfac=$nulfac; //documento anulado			
		$this->subfac=$subfac; //subtotal de factura
		$this->ivafac=$ivafac; //iva de factura
		$this->totfac=$totfac; //total de factura			
		$this->plafac=$plafac; //plazo de pago
		$this->memo=$memo;     //memo
		$this->sucursal=$sucursal; //sucursal 
	}
		
	public function setidfac ($idfac)  { $this->idfac = $idfac;    }  
	public function setidped ($idped)  { $this->idped = $idped;    }
	public function setserfac($serfac) { $this->serfac = $serfac;  }
	public function setnumfac($numfac) { $this->numfac = $numfac;  }
	public function setfecfac($fecfac) { $this->facfac = $fecfac;  }
	public function setnumcli($numcli) { $this->numcli = $numcli;  }
	public function settipfac($tipfac) { $this->tipfac = $tipfac;  }
	public function setnulfac($nulfac) { $this->nulfac = $nulfac;  }
	public function setsubfac($subfac) { $this->subfac = $subfac;  }
	public function setivafac($ivafac) { $this->ivafac = $ivafac;  }
	public function settotfac($totfac) { $this->totfac = $totfac;  }
	public function setplafac($plafac) { $this->plafac = $plafac;  }
	public function setmemo ($memo)    { $this->memo   = $memo;    }
	public function setsucursal($sucursal){ $this->sucursal = $sucursal;}
			
	public function getidfac () { return $this->idfac;  }
	public function getidped () { return $this->idped;  }
	public function getserfac() { return $this->serfac; } 
	public function getnumfac() { return $this->numfac; }
	public function getfecfac() { return $this->fecfac; }
	public function getnumcli() { return $this->numcli; }
	public function gettipfac() { return $this->tipfac; }
	public function getnulfac() { return $this->nulfac; }
	public function getsubfac() { return $this->subfac; }
	public function getivafac() { return $this->ivafac; }
	public function gettotfac() { return $this->totfac; }
	public function getplafac() { return $this->plafac; }
	public function getmemo()   { return $this->memo;   }
	public function getsucursal()   { return $this->sucursal;   }
	
	public function FacturaExiste($id){
		$link=Conecta();
		$sql="SELECT num_fac FROM factura WHERE num_fac='".$id."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	
	public function FacturaAdd(){
		$link=Conecta();
		$sql="INSERT INTO factura (id_fac, id_pedido, ser_fac,
		                           num_fac, fec_fac, num_cli,
								   tip_fac, nul_fac, sub_fac,
								   iva_fac, tot_fac, pla_fac, memo_fac, sucursal_id)
					    VALUES('".$this->getidfac()."','".$this->getidped()."','".$this->getserfac()."',
							   '".$this->getnumfac()."','".$this->getfecfac()."','".$this->getnumcli()."',
							   '".$this->gettipfac()."','".$this->getnulfac()."','".$this->getsubfac()."',
							   '".$this->getivafac()."','".$this->gettotfac()."','".$this->getplafac()."',
							   '".$this->getmemo()."','".$this->getsucursal()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function FacturaNull(){
		$link=Conecta();
		$sql="UPDATE factura SET nul_fac ='S'	WHERE id_fac =".$this->getidfac()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function FacturaDel(){
		$link=Conecta();
		$sql="DELETE FROM factura WHERE id_fac = ".$this->getidfac();
		$res=ejecutarConsulta($sql,$link);
		$sql="DELETE FROM facturalinea WHERE id_fac = ".$this->getidfac();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusFacturas(){
		$link=Conecta();
		$sql="select *	from factura where 1=1";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>