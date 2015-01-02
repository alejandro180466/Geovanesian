<?php
include("../Persistencia.php");
class Usuario{
	private $codigo;
	private $nombre;
	private $apellido;
	private $direc;
	private $fono;
	private $email;
	private $city;
	private $fnac;
	private $pass;
	private $perfil;
	
	public function __construct($codigo,$nombre,$apellido,$direc,$fono,$email,$city,$fnac,$pass,$perfil){
		$this->codigo=$codigo;		$this->nombre=$nombre;   
		$this->apellido=$apellido;	$this->direc=$direc;
		$this->fono=$fono;			$this->email=$email;
		$this->city=$city;			$this->fnac=$fnac;
		$this->pass=$pass;			$this->perfil=$perfil;
	}
		
	public function setcodigo($codigo)	  { $this->codigo = $codigo;  }  
	public function setnombre($nombre)    { $this->nombre = $nombre;  }
	public function setapellido($apellido){ $this->apellido = $apellido;}
	public function setdirec($direc)      { $this->direc = $direc;    }
	public function setfono($fono)        { $this->fono = $fono;      }
	public function setemail($email)      { $this->email = $email;    }
	public function setcity($city)        { $this->city = $city;      }
	public function setfnac($fnac)        { $this->fnac = $fnac;      }
	public function setpass($pass)        { $this->pass = $pass;      }
	public function setperfil($perfil)    { $this->perfil = $perfil;  }
	
	public function getcodigo()  { return $this->codigo;}
	public function getnombre()  { return $this->nombre;}
	public function getapellido(){ return $this->apellido;}
	public function getdirec()   { return $this->direc;}
	public function getfono()    { return $this->fono;}
	public function getemail()   { return $this->email;}
	public function getcity()    { return $this->city;}
	public function getfnac()    { return $this->fnac;}
	public function getpass()    { return $this->pass;}
	public function getperfil()  { return $this->perfil;}
	
	public function existeUsuario($codigo){
		$link=Conecta();
		$sql="select cod_user from user where cod_user='".$codigo."'";
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
	public function UserAdd(){
		$link=Conecta();
		$sql="insert into user (nom_user, apellido_user, direc_user, fono_user, email_user, city_user, fnac_user, pass_user, perfil_user)
							values('".$this->getnombre()."','".$this->getapellido()."','".$this->getdirec()."','".$this->getfono().
							  "','".$this->getemail()."','".$this->getcity()."','".$this->getfnac()."','".$this->getpass()."','".
							  $this->getperfil()."')";
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	public function UserMod(){
		$link=Conecta();
		$sql="update user set  nom_user= '".$this->getnombre()."',
							   apellido_user='".$this->getapellido()."',
							   direc_user= '".$this->getdirec()."',
							   fono_user='".$this->getfono()."',
							   email_user='".$this->getemail()."',
							   city_user='".$this->getcity()."',
							   fnac_user='".$this->getfnac()."',
							   pass_user='".$this->getpass()."',
							   perfil_user='".$this->getperfil()."'
									WHERE cod_user =".$this->getcodigo()."";
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
	public function UserDel(){
		$link=Conecta();
		$sql="delete from user where cod_user = ".$this->getcodigo();
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		Desconecta($link);
	}
}
?>