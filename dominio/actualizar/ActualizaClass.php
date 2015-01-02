<?php class Actualiza{	private $idup;      private $fechaup;	private	$codmer;	private	$numcli;
                    	private $catmer;    private $usuario;    private $porcentup;  private $uniup;
						private $catup;
	
	public function __construct($idup,$fechaup,$codmer,$numcli,$catmer,$usuario,$porcentup,$uniup,$catup){
		$this->idup=$idup;
		$this->fechaup=$fechaup;
		$this->codmer=$codmer;
		$this->numcli=$numcli;
		$this->catmer=$catmer;
		$this->usuario=$usuario;
		$this->porcentup=$porcentup;
		$this->uniup=$uniup;
		$this->catup=$catup;
	}
		
	public function setidup($idup)          {$this->idup   = $idup;   }  
	public function setfechaup($fechaup)    {$this->fechaup= $fechaup;}
	public function setcodmer ($codmer)     {$this->codmer = $codmer; }
	public function setnumcli($numcli)      {$this->numcli = $numcli; }
	public function setcatmer($catmer)      {$this->catmer = $catmer; }
	public function setusuario($usuario)    {$this->usuario= $usuario;}
	public function setporcentup($porcentup){$this->porcentup=$porcentup;}
	public function setuniup($uniup)        {$this->uniup = $uniup;   }
	public function setcatup($catup)        {$this->catup = $catup;   }
				
	public function getidup()     {return $this->idup;     }
	public function getfechaup()  {return $this->fechaup;  } 
	public function getcodmer()   {return $this->codmer;   }
	public function getnumcli()   {return $this->numcli;   }
	public function getcatmer()   {return $this->catmer;   }
	public function getusuario()  {return $this->usuario;  }
	public function getporcentup(){return $this->porcentup;}
	public function getuniup()    {return $this->uniup;    }
	public function getcatup()    {return $this->catup;    }
				
	public function ActualizaAdd(){
		$this->setidup(siguienteID('contadores','id_update'));
		$this->setfechaup(date("Y/m/d"));
		$link=Conecta();
		$sql="INSERT INTO actualiza (id_update, fecha_update, cod_mer, num_cli,
                               		 cat_mer, nom_user, porcent_update, uni_update ,cat_update)
						    values('".$this->getidup()."','".$this->getfechaup()."','".$this->getcodmer()."',
							       '".$this->getnumcli()."','".$this->getcatmer()."','".$this->getusuario()."',
								   '".$this->getporcentup()."','".$this->getuniup()."','".$this->getcatup()."' )";
		$res=ejecutarConsulta($sql,$link);
	
		Desconecta($link);
	}
	public function ActualizaMod(){
		$link=Conecta();
		
		    $sql="UPDATE actualiza SET  id_update ='".$this->getidup()."',
									 fecha_update ='".$this->getfechaup()."',
									      cod_mer ='".$this->getcodmer()."',
							   	          num_cli ='".$this->getnumcli()."',
									      cat_mer ='".$this->getcatmer()."',
									      nom_user='".$this->getusuario()."',
								    porcent_update='".$this->getporcentup()."',
									    uni_update='".$this->getuniup()."',
									    cat_update='".$this->getcatup()."'
											WHERE id_update = '".$this->getidup()."'";
		$res=ejecutarConsulta($sql,$link);
		//FreeResp($res);
		Desconecta($link);
	}
	public function ActualizaDel(){
		$link=Conecta();
		$sql="DELETE FROM actualiza WHERE id_update =".$this->getidup()."";
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	public function ActualizaYou(){
		$link=Conecta();
		$sql="SELECT * FROM actualiza WHERE num_cli=".$this->getnumcli()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>