<?php	class Sucursal{	private $idsuc;		private $numcli;	private	$razcli;
						private	$dircli;	private	$depcli;	private $telcli;
						private	$contcli;	private	$entrega;
		
	public function __construct($idsuc,$numcli,$razcli,$dircli,$depcli,$telcli,$contcli,$entrega){
		$this->idsuc=$idsuc;		$this->numcli=$numcli;		$this->razcli=$razcli;   
		$this->dircli=$dircli;		$this->depcli=$depcli;		$this->telcli=$telcli;
		$this->contcli=$contcli;	$this->entrega=$entrega;
	}
	
	public function setidsuc($idsuc)	  { $this->idsuc  = $idsuc;   } 
	public function setnumcli($numcli)	  { $this->numcli = $numcli;  }  
	public function setrazcli($razcli)    { $this->razcli = $razcli;  }
	public function setdircli($dircli)    { $this->dircli = $dircli;  }
	public function setdepcli($depcli)    { $this->depcli = $depcli;  }
	public function settelcli($telcli)    { $this->telcli = $telcli;  }
	public function setcontcli($contcli)  { $this->contcli= $contcli; }
	public function setentrega($entrega)  { $this->entrega= $entrega; }
	
	public function getidsuc()   { return $this->idsuc;  }
	public function getnumcli()  { return $this->numcli; }
	public function getrazcli()  { return $this->razcli; } 
	public function getdircli()  { return $this->dircli; }
	public function getdepcli()  { return $this->depcli; }
	public function gettelcli()  { return $this->telcli; }
	public function getcontcli() { return $this->contcli;}
	public function getentrega() { return $this->entrega;}
			
	public function SucursalAdd(){
		$link=Conecta();
		$sql="INSERT INTO sucursal (num_cli, nom_suc, dir_suc, dep_suc, tel_suc , cont_suc, ent_suc )	
						values('".$this->getnumcli()."','".$this->getrazcli()."','".$this->getdircli()."',
							   '".$this->getdepcli()."','".$this->gettelcli()."','".$this->getcontcli()."',
							   '".$this->getentrega()."'
							   )";
							   
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function SucursalMod(){
		$link=Conecta();
		$sql="UPDATE sucursal SET sucursal_id = '".$this->getidsuc()."',
								  num_cli ='".$this->getnumcli()."',
							  	  nom_suc ='".$this->getrazcli()."',
							   	  dir_suc ='".$this->getdircli()."',
							   	  dep_suc ='".$this->getdepcli()."',
							   	  tel_suc ='".$this->gettelcli()."',
								 cont_suc ='".$this->getcontcli()."',
							   	  ent_cli ='".$this->getentrega()."',
							   	  suc_cli ='".$this->getsucursal()."'
								   		WHERE num_cli = ".$this->getnumcli()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function SucursalDel(){
		$link=Conecta();
		$sql="DELETE FROM sucursal WHERE sucursal_id = ".$this->getidsuc();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function SusSucursales(){
		$link=Conecta();
		$sql="SELECT * FROM sucursal WHERE num_cli = ".$this->getnumcli() ;
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>