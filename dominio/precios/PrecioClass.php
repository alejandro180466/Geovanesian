<?php class Precio{	private $idpre;      private $valpre;	private	$codmer;	private	$numcli;	private $fecpre;
								private $monedapre;
	
	public function __construct($idpre,$valpre,$codmer,$numcli,$fecpre,$monedapre){
		$this->idpre=$idpre;
		$this->valpre=$valpre;
		$this->codmer=$codmer;
		$this->numcli=$numcli;
		$this->fecpre=$fecpre;
		$this->monedapre=$monedapre;
	}
		
	public function setidpre($idpre)   { $this->idpre  = $idpre; }  
	public function setvalpre($valpre) { $this->valpre = $valpre; }
	public function setcodmer($codmer) { $this->codmer = $codmer; }
	public function setnumcli($numcli) { $this->numcli = $numcli; }
	public function setfecpre($fecpre) { $this->fecpre = $fecpre; }
	public function setmonedapre($monedapre) { $this->monedapre = $monedapre; }
	
	public function getidpre()  { return $this->idpre;  }
	public function getvalpre() { return $this->valpre; } 
	public function getcodmer() { return $this->codmer; }
	public function getnumcli() { return $this->numcli; }
	public function getfecpre() { return $this->fecpre; }
	public function getmonedapre() { return $this->monedapre; }

	public function PrecioExiste($idcli,$idmer){
		$link=Conecta();
		$sql="select cod_mer, num_cli, moneda_pre from precio where num_cli=$idcli. AND cod_mer=$idmer";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
	return $existe;
	}
		
	public function PrecioAdd(){
		$this->setidpre(siguienteID('contadores','id_pre'));
		$this->setfecpre(date("Y/m/d"));
		$link=Conecta();
		$sql="INSERT INTO precio (id_pre, val_pre, cod_mer, num_cli, fec_pre, moneda_pre)
						    values('".$this->getidpre()."','".$this->getvalpre()."','".$this->getcodmer()."',
							       '".$this->getnumcli()."','".$this->getfecpre()."','".$this->getmonedapre()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function PrecioMod(){
		$link=Conecta();
		
		$sql="UPDATE precio SET  id_pre ='".$this->getidpre()."',
							  	val_pre ='".$this->getvalpre()."',
							   	cod_mer ='".$this->getcodmer()."',
								fec_pre ='".$this->getfecpre()."',
								moneda_pre ='".$this->getmonedapre()."',
							   	num_cli ='".$this->getnumcli()."' WHERE id_pre = '".$this->getidpre()."'";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function PrecioDel(){
		$link=Conecta();
		$sql="DELETE FROM precio WHERE id_pre =".$this->getidpre()."";
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	public function TusPrecios(){
		$link=Conecta();
		$sql="SELECT * FROM precios WHERE num_cli=".$this->getnumcli()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>