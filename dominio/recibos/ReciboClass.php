<?php
class Recibo{
	private $idrec;	    private	$numrec;	private $fecrec;    private $numcli;
	private	$totrec;	private $memorec;	private	$nulrec;
	
	public function __construct($idrec,$numrec,$fecrec,$numcli,$totrec,$memorec,$nulrec){
		$this->idrec=$idrec;     //id de recibo
		$this->numrec=$numrec;   //numero de recibo
		$this->fecrec=$fecrec;   //fecha de recibo
		$this->numcli=$numcli;   //id del cliente
		$this->totrec=$totrec;   //total de recibo			
		$this->memorec=$memorec; //memo
		$this->nulrec=$nulrec;   //documento anulado
	}
		
	public function setidrec ($idrec)   { $this->idrec  = $idrec;  }  
	public function setnumrec($numrec)  { $this->numrec = $numrec; }
	public function setfecrec($fecrec)  { $this->facrec = $fecrec; }
	public function setnumcli($numcli)  { $this->numcli = $numcli; }
	public function setnulrec($nulrec)  { $this->nulrec = $nulrec; }
	public function settotfac($totrec)  { $this->totrec = $totrec; }
	public function setmemorec($memorec){ $this->memorec= $memorec;}
			
	public function getidrec () { return $this->idrec;  }
	public function getnumrec() { return $this->numrec; }
	public function getfecrec() { return $this->fecrec; }
	public function getnumcli() { return $this->numcli; }
	public function getnulrec() { return $this->nulrec; }
	public function gettotrec() { return $this->totrec; }
	public function getmemorec(){ return $this->memorec;}
	
	public function ReciboExiste($id){
		$link=Conecta();
		$sql="SELECT num_recibo FROM recibo WHERE num_recibo='".$id."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	
	public function ReciboAdd(){
	    $this->setidrec(siguienteID('contadores','id_recibo'));
		$link=Conecta();
		$sql="INSERT INTO recibo (id_recibo, num_recibo, fec_recibo, num_cli, tot_recibo,  mem_recibo, nul_recibo)
					    VALUES('".$this->getidrec()."','".$this->getnumrec()."','".$this->getfecrec()."',
						       '".$this->getnumcli()."','".$this->gettotrec()."','".$this->getmemorec()."',
							   '".$this->getnulrec()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function ReciboMod(){
	    $link=Conecta();
		$sql="UPDATE recibo SET id_recibo='".$this->getidrec()."',
							   num_recibo='".$this->getnumrec()."',
							   fec_recibo='".$this->getfecrec()."',
							      num_cli='".$this->getnumcli()."',
							   tot_recibo='".$this->gettotrec()."',
							   mem_recibo='".$this->getmemorec()."',
							   nul_recibo='".$this->getnulrec()."'
									WHERE id_recibo =".$this->getidrec()."";
		
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function ReciboNul(){
	    $link=Conecta();
		$sql="UPDATE recibo SET  nul_recibo='S' WHERE id_recibo =".$this->getidrec()."";
		
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function ReciboDel(){
		$link=Conecta();
		$sql="DELETE FROM recibo WHERE id_recibo = ".$this->getidrec();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusRecibos(){
		$link=Conecta();
		$sql="SELECT id_recibo, num_recibo, fec_recibo, num_cli, tot_recibo, mem_recibo, nul_recibo
					    FROM recibo WHERE 1=1";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>