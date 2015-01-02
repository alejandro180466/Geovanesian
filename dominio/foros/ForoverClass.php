<?php
include("../../dominio/Persistencia.php");
class ForoVer{   //--------------------------ESTA CLASE CONTROLA LAS PARTICIPACIONES EN LOS FOROS
	private $idpart;
	private $coduser;
	private $fecpart;
	private $timepart;
	private $codforo;
	private $opinforo;
		
	public function __construct($idpart,$coduser,$fecpart,$timepart,$codforo,$opinforo){
		
		$this->idpart=$idpart;
		$this->coduser=$coduser;
		$this->fecpart=$fecpart;
		$this->timepart=$timepart;
		$this->codforo=$codforo;	   
		$this->opinforo=$opinforo;	
	}
	public function setidpart($idpart)     { $this->idpart   =$idpart;   }	
	public function setcoduser($coduser)   { $this->coduser  =$coduser;  }  
	public function setfecpart($fecpart)   { $this->fecpart  =$fecpart;  }
	public function settimepart($timepart) { $this->timepart =$timepart; }
	public function setcodforo($codforo)   { $this->codforo  =$codforo;  }
	public function setopinforo($opinforo) { $this->opinforo =$opinforo; }
	
	public function getidpart()   { return $this->idpart;   }
	public function getcoduser()  { return $this->coduser;  }
	public function getfecpart()  { return $this->fecpart;  }
	public function gettimepart() { return $this->timepart; }
	public function getcodforo()  { return $this->codforo;  }
	public function getopinforo() { return $this->opinforo; }
	
	public function existePartForo($codforo){
	    $link=Conecta();
		$sql="select id_part, cod_user, fec_part, cod_foro, opin_foro from parforo
					 where cod_foro like '.$codforo.' ";
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
	public function PartForoAdd(){
		
		$this->setidpart(siguienteID("contadores","id_partforo"));
		$link=Conecta();
		$sql="insert into parforo (id_part,cod_user, fec_part, time_part, cod_foro, opin_foro)
							values('".$this->getidpart()."','".$this->getcoduser()."',
							'".$this->getfecpart()."','".$this->gettimepart()."',
							'".$this->getcodforo()."','".$this->getopinforo()."')";
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	
	public function PartForoDel($op){
		$link=Conecta();
		if($op==1){
			$sql="delete from parforo where id_part=".$this->getidpart();
		}else{
			$sql="delete from parforo where cod_foro=".$this->getcodforo();
		}	
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	public function PartForoCargar($codforo,$idpart){
		$link=Conecta();
		$sql="select id_part, cod_user, fec_part, time_part, cod_foro, opin_foro from parforo
					 where cod_foro like '$codforo' and id_part like '$idpart' order by id_part";  
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$row=mysql_fetch_array($res);
			$obj=new ForoVer($row['id_part'],$row['cod_user'],$row['fec_part'],$row['time_part'],
								$row['cod_foro'],$row['opin_foro'] );
			$existe=$obj; //si existe devuelve el objeto
		}
		FreeResp($res);
		Desconecta($link);
		return $existe;
	}
}
?>