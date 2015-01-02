<?php
class ForoW{
	private $codforo;
	private $temforo;
	private $estforo;
	private $fecforo;
		
	public function __construct($codforo,$temforo,$estforo,$fecforo){
		$this->codforo=$codforo;	$this->temforo=$temforo;   
		$this->estforo=$estforo;	$this->fecforo=$fecforo;
	}
		
	public function setcodforo($codforo) { $this->codforo = $codforo; }  
	public function settemforo($temforo) { $this->temforo = $temforo; }
	public function setestforo($estforo) { $this->estforo = $estforo; }
	public function setfecforo($fecforo) { $this->fecforo = $fecforo; }
	
	public function getcodforo()  { return $this->codforo;}
	public function gettemforo()  { return $this->temforo;}
	public function getestforo()  { return $this->estforo;}
	public function getfecforo()  { return $this->fecforo;}
	
	public function existeForoW($temforo){
		$link=Conecta();
		$sql="select cod_foro, tem_foro, est_foro, fec_foro from foro where tem_foro='".$temforo."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		FreeResp($res);
		Desconecta($link);
		return $existe;
	}
	public function ForoAdd(){
		
		$this->setcodforo(siguienteID("contadores","id_foro"));
		$link=Conecta();
		$sql="insert into foro (cod_foro, tem_foro, est_foro, fec_foro)
							values('".$this->getcodforo()."','".$this->gettemforo()."',
							       '".$this->getestforo()."','".$this->getfecforo()."')";
							   
		$res=ejecutarConsulta($sql,$link);
		//FreeResp($res);
		Desconecta($link);
	}
	public function ForoMod(){
		$link=Conecta();
		$sql="update foro set cod_foro='".$this->getcodforo()."',
							  tem_foro='".$this->gettemforo()."',
							  est_foro='".$this->getestforo()."',
							  fec_foro='".$this->getfecforo()."'
							 	WHERE cod_foro=".$this->getcodforo()."";
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	public function ForoDel(){
		$link=Conecta();
		$sql="delete from foro where cod_foro = ".$this->getcodforo();
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	public function ForoCargar($codforo){
	    
		$link=Conecta();
		$sql="select cod_foro, tem_foro, est_foro, fec_foro from foro where cod_foro='".$codforo."'";  
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$row=mysql_fetch_array($res);
			$obj=new ForoW($row['cod_foro'],$row['tem_foro'],$row['est_foro'],$row['fec_foro']);
			$existe=$obj; //si existe deuvelve el objeto
		}
		FreeResp($res);
		Desconecta($link);
		return $existe;
	}
}
?>