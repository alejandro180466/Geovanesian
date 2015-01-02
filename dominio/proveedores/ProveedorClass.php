<?php
class Proveedor{
	private $numpro;	private	$razpro;	private $nompro; 	private $rutpro;	private	$dirpro;
	private	$deppro;	private $rubro;     private $telpro;	private	$faxpro;	private	$celpro;
	private $conpro;	private $bankpro;	private	$mailpro;
	
	public function __construct($numpro,$razpro,$nompro,$rutpro,$dirpro,$deppro,$rubro,$telpro,$faxpro,$celpro,$conpro,$bankpro,$mailpro){
		$this->numpro=$numpro;
		$this->razpro=$razpro;
		$this->nompro=$nompro;   
		$this->rutpro=$rutpro;
		$this->dirpro=$dirpro;
		$this->deppro=$deppro;
		$this->rubro=$rubro;			
		$this->telpro=$telpro;
		$this->faxpro=$faxpro;			
		$this->celpro=$celpro;
		$this->conpro=$conpro;
		$this->bankpro=$bankpro;
		$this->mailpro=$mailpro;
	}
		
	public function setnumpro($numpro)	  { $this->numpro = $numpro;  }  
	public function setrazpro($razpro)    { $this->razpro = $razpro;  }
	public function setnompro($nompro)    { $this->nompro = $nompro;  }
	public function setrutpro($rutpro)    { $this->rutpro = $rutpro;  }
	public function setdirpro($dirpro)    { $this->dirpro = $dirpro;  }
	public function setdeppro($deppro)    { $this->deppro = $deppro;  }
	public function setrubro($rubro)      { $this->rubro  = $rubro;   }
	public function settelpro($telpro)    { $this->telpro = $telpro;  }
	public function setfaxpro($faxpro)    { $this->faxpro = $faxpro;  }
	public function setcelpro($celpro)    { $this->celpro = $celpro;  }
	public function setconpro($conpro)    { $this->conpro = $conpro;  }
	public function setbankpro($bankpro)  { $this->bankpro = $bankpro;}
	public function setmailpro($mailpro)  { $this->mailpro= $mailpro; }
		
	public function getnumpro()  { return $this->numpro; }
	public function getrazpro()  { return $this->razpro; } 
	public function getnompro()  { return $this->nompro; }
	public function getrutpro()  { return $this->rutpro; }
	public function getdirpro()  { return $this->dirpro; }
	public function getdeppro()  { return $this->deppro; }
	public function getrubro()   { return $this->rubro;  }
	public function gettelpro()  { return $this->telpro; }
	public function getfaxpro()  { return $this->faxpro; }
	public function getcelpro()  { return $this->celpro; }
	public function getconpro()  { return $this->conpro; }
	public function getbankpro() { return $this->bankpro; }
	public function getmailpro() { return $this->mailpro;}
		
	public function ProveedorExiste($rut){
		$link=Conecta();
		$sql="select rut_pro from proveedor where rut_pro='".$rut."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	public function ProveedorAdd(){
		$this->setnumpro(siguienteID('contadores','num_pro'));
		if($this->getrutpro()=="X"){
			$this->setrutpro($this->getnumpro());
		}
		$link=Conecta();
		$sql="insert into proveedor (num_pro, raz_pro, nom_pro , rut_pro, dir_pro, dep_pro, cat_insumo ,tel_pro, fax_pro, cel_pro,
										con_pro , bank_pro, mail_pro)
						values('".$this->getnumpro()."','".$this->getrazpro()."','".$this->getnompro()."',
						       '".$this->getrutpro()."','".$this->getdirpro()."','".$this->getdeppro()."',
							   '".$this->getrubro()."','".$this->gettelpro()."','".$this->getfaxpro()."',
							   '".$this->getcelpro()."','".$this->getconpro()."','".$this->getbankpro()."',
							   '".$this->getmailpro()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function ProveedorMod(){
		$link=Conecta();
		$sql="update proveedor set  num_pro= '".$this->getnumpro()."',
							  		raz_pro='".$this->getrazpro()."',
									nom_pro='".$this->getnompro()."',
							   		rut_pro= '".$this->getrutpro()."',
							   		dir_pro='".$this->getdirpro()."',
							   		dep_pro='".$this->getdeppro()."',
									cat_insumo='".$this->getrubro()."',
							   		tel_pro='".$this->gettelpro()."',
							   		fax_pro='".$this->getfaxpro()."',
							   		cel_pro='".$this->getcelpro()."',
									con_pro='".$this->getconpro()."',
									bank_pro='".$this->getbankpro()."',
							   		mail_pro='".$this->getmailpro()."'
										WHERE num_pro =".$this->getnumpro()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function ProveedorDel(){
		$link=Conecta();
		$sql="delete from proveedor where num_pro = ".$this->getnumpro();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusProveedores(){
		$link=Conecta();
		$sql="select num_pro, raz_pro, nom_pro ,rut_pro, dir_pro, dep_pro, cat_insumo ,tel_pro, fax_pro,
						cel_pro, con_pro, bank_pro ,mail_pro from proveedor where 1=1";
		$res=ejecutarConsulta($sql,$link);
		return $res;
	}
}	
?>