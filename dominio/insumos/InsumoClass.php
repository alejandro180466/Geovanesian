<?php
class Insumo{
	 private $idinsumo;
	 private $desinsumo;
	 private $detinsumo;
	 private $catinsumo;
	 private $uniinsumo;
	 private $stockinsumo;
	 private $fecstock;
	 private $ivainsumo;
	
	public function __construct($idinsumo,$desinsumo,$detinsumo,$catinsumo,$uniinsumo,$stockinsumo,$fecstock,$ivainsumo){
	
	 $this->idinsumo = $idinsumo;
	 $this->desinsumo = $desinsumo;
	 $this->detinsumo  = $detinsumo;
	 $this->catinsumo  = $catinsumo;
	 $this->uniinsumo  = $uniinsumo;
	 $this->stockinsumo = $stockinsumo;
	 $this->fecstock   = $fecstock;
	 $this->ivainsumo  = $ivainsumo;
	}
		
	public function setidinsumo($idinsumo)	    {  $this->idinsumo=$idinsumo;    }  
	public function setdesinsumo($desinsumo)    {  $this->desinsumo=$desinsumo;  }
	public function setdetinsumo($detinsumo)    {  $this->detinsumo=$detinsumo;  }
	public function setcatinsumo($catinsumo)    {  $this->catinsumo= $catinsumo; }
	public function setuniinsumo($uniinsumo)    {  $this->uniinsumo=$uniinsumo;  }
	public function setstockinsumo($stockinsumo){  $this->stockinsumo=$stockinsumo;}
	public function setfecstock($fecstock)      {  $this->fecstock=$fecstock;    }
	public function setivainsumo($ivainsumo)    {  $this->ivainsumo=$ivainsumo;  }
			
	public function getidinsumo()    { return  $this->idinsumo;  }
	public function getdesinsumo()   { return  $this->desinsumo; } 
	public function getdetinsumo()   { return  $this->detinsumo; }
	public function getcatinsumo()   { return  $this->catinsumo; }
	public function getuniinsumo()   { return  $this->uniinsumo; }
	public function getstockinsumo() { return  $this->stockinsumo;}
	public function getfecstock()    { return  $this->fecstock;  }
	public function getivainsumo()   { return  $this->ivainsumo; }
	
	public function InsumoExiste($cod){
		$link=Conecta();
		$sql="select id_insumo from insumo where id_insumo='".$cod."'";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	public function InsumoAdd(){
		$this->setidinsumo(siguienteID('contadores','id_insumo'));
		$link=Conecta();
		$sql="insert into insumo (id_insumo, des_insumo , det_insumo , cat_insumo , uni_insumo , stock_insumo , fecha_insumo , iva_insumo )
						values('".$this->getidinsumo()."',
							   '".$this->getdesinsumo()."',
							   '".$this->getdetinsumo()."',
							   '".$this->getcatinsumo()."',
							   '".$this->getuniinsumo()."',
							   '".$this->getstockinsumo()."',
							   '".$this->getfecstock()."',
							   '".$this->getivainsumo()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function InsumoMod(){
		$link=Conecta();
		$sql="update insumo set  id_insumo = '".$this->getidinsumo()."',
							  	 des_insumo = '".$this->getdesinsumo()."',
							   	 det_insumo = '".$this->getdetinsumo()."',
							   	 cat_insumo = '".$this->getcatinsumo()."',
							   	 uni_insumo = '".$this->getuniinsumo()."',
							   	 stock_insumo ='".$this->getstockinsumo()."',
								 fecha_insumo ='".$this->getfecstock()."',
								  iva_insumo ='".$this->getivainsumo()."'
							   	  		WHERE id_insumo =".$this->getidinsumo()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		
	}
	public function InsumoDel(){
		$link=Conecta();
		$sql="delete from insumo where id_insumo = ".$this->getidinsumo();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function TusInsumos(){
		$link=Conecta();
		$sql="select id_insumo, des_insumo, det_insumo, cat_insumo, uni_insumo, stock_insumo , fecha_insumo , iva_insumo
					from insumo where 1=1";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>