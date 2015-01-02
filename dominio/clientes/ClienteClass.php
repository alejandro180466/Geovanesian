<?php
class Cliente{
	private $numcli;	private	$razcli;	private	$rutcli;	private	$dircli;	private	$depcli;
	private $telcli;	private $telcli2;   private	$faxcli;	private	$celcli;	private	$mailcli;
	private	$contcli;	private	$entrega;	private	$pago;      private $comenta;   private $fpagcli; 
	private $plazo;		private $sucursal;
	
	public function __construct($numcli,$razcli,$rutcli,$dircli,$depcli,$telcli,$telcli2,$faxcli,$celcli,
								$mailcli,$contcli,$entrega,$pago,$comenta,$fpagcli,$plazo,$sucursal){
		$this->numcli=$numcli;		$this->razcli=$razcli;   
		$this->rutcli=$rutcli;		$this->dircli=$dircli;
		$this->depcli=$depcli;		$this->telcli=$telcli;
		$this->telcli2=$telcli2;	$this->faxcli=$faxcli;			
		$this->celcli=$celcli;		$this->mailcli=$mailcli;
		$this->contcli=$contcli;	$this->entrega=$entrega;
		$this->pago=$pago;			$this->comenta=$comenta;
		$this->fpagcli=$fpagcli;	$this->plazo=$plazo;
		$this->sucursal=$sucursal;
	}
		
	public function setnumcli($numcli)	  { $this->numcli = $numcli;  }  
	public function setrazcli($razcli)    { $this->razcli = $razcli;  }
	public function setrutcli($rutcli)    { $this->rutcli = $rutcli;  }
	public function setdircli($dircli)    { $this->dircli = $dircli;  }
	public function setdepcli($depcli)    { $this->depcli = $depcli;  }
	public function settelcli($telcli)    { $this->telcli = $telcli;  }
	public function settelcli2($telcli2)  { $this->telcli2 = $telcli2;}
	public function setfaxcli($faxcli)    { $this->faxcli = $faxcli;  }
	public function setcelcli($celcli)    { $this->celcli = $celcli;  }
	public function setmailcli($mailcli)  { $this->mailcli= $mailcli; }
	public function setcontcli($contcli)  { $this->contcli= $contcli; }
	public function setentrega($entrega)  { $this->entrega= $entrega; }
	public function setpago($pago)        { $this->pago = $pago;      }
	public function setcomenta($comenta)  { $this->comenta= $comenta; }
	public function setfpagcli($fpagcli)  { $this->fpagcli= $fpagcli; }
	public function setplazo($plazo)      { $this->plazo  = $plazo;   }
	public function setsucursal($sucursal){ $this->sucursal=$sucursal;}
		
	public function getnumcli()  { return $this->numcli; }
	public function getrazcli()  { return $this->razcli; } 
	public function getrutcli()  { return $this->rutcli; }
	public function getdircli()  { return $this->dircli; }
	public function getdepcli()  { return $this->depcli; }
	public function gettelcli()  { return $this->telcli; }
	public function gettelcli2() { return $this->telcli2;}
	public function getfaxcli()  { return $this->faxcli; }
	public function getcelcli()  { return $this->celcli; }
	public function getmailcli() { return $this->mailcli;}
	public function getcontcli() { return $this->contcli;}
	public function getentrega() { return $this->entrega;}
	public function getpago()    { return $this->pago;   }
	public function getcomenta() { return $this->comenta;}
	public function getfpagcli() { return $this->fpagcli;}
	public function getplazo()   { return $this->plazo;  }
	public function getsucursal(){ return $this->sucursal;}
		
	public function ClienteExiste($rut){
		$link=Conecta();
		$sql="select rut_cli from cliente where rut_cli='".$rut."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	public function ClienteAdd(){
		$this->setnumcli(siguienteID('contadores','num_cli'));
		$link=Conecta();
		$sql="insert into cliente (num_cli, raz_cli, rut_cli, dir_cli, dep_cli, tel_cli , tel_cli2 , fax_cli, cel_cli, mail_cli,
								   cont_cli, ent_cli, pag_cli, com_cli, fpag_cli, plazo_cli, suc_cli )	
						values('".$this->getnumcli()."','".$this->getrazcli()."','".$this->getrutcli()."',
							   '".$this->getdircli()."','".$this->getdepcli()."','".$this->gettelcli()."',
							   '".$this->gettelcli2()."','".$this->getfaxcli()."','".$this->getcelcli()."',
							   '".$this->getmailcli()."','".$this->getcontcli()."','".$this->getentrega()."',
							   '".$this->getpago()."','".$this->getcomenta()."','".$this->getfpagcli()."',
							   '".$this->getplazo()."','".$this->getsucursal()."')";
							   
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function ClienteMod(){
		$link=Conecta();
		$sql="UPDATE cliente SET  num_cli= '".$this->getnumcli()."',
							  	  raz_cli='".$this->getrazcli()."',
							   	  rut_cli= '".$this->getrutcli()."',
							   	  dir_cli='".$this->getdircli()."',
							   	  dep_cli='".$this->getdepcli()."',
							   	  tel_cli='".$this->gettelcli()."',
								  tel_cli2='".$this->gettelcli2()."',
							   	  fax_cli='".$this->getfaxcli()."',
							   	  cel_cli='".$this->getcelcli()."',
							   	  mail_cli='".$this->getmailcli()."',
								  cont_cli='".$this->getcontcli()."',
							   	  ent_cli='".$this->getentrega()."',
							   	  pag_cli='".$this->getpago()."',
							   	  com_cli='".$this->getcomenta()."',
								  fpag_cli='".$this->getfpagcli()."',
								  plazo_cli='".$this->getplazo()."',
								  suc_cli='".$this->getsucursal()."'
								   		WHERE num_cli =".$this->getnumcli()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function ClienteDel(){
		$link=Conecta();
		$sql="DELETE FROM cliente WHERE num_cli = ".$this->getnumcli();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusClientes(){
		$link=Conecta();
		$sql="SELECT num_cli, raz_cli, rut_cli, dir_cli, dep_cli, tel_cli, tel_cli2, fax_cli, cel_cli, mail_cli ,
						cont_cli, ent_cli, pago_cli, com_cli, fpag_cli, plazo_cli, suc_cli
							FROM cliente WHERE 1=1";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>