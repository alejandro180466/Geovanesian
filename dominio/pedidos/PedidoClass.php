<?php
class Pedido{
	private $idpedido;	private	$numcli;	private	$fecpedido;	    private $fecentrega;
	private $estado;	private $memo;	    private	$fecfactura;	private $tippedido;
		
	public function __construct($idpedido ,$numcli ,$fecpedido ,$fecentrega ,$estado ,$memo ,$fecfactura, $tippedido ){
		$this->idpedido=$idpedido;			$this->numcli=$numcli;		$this->fecpedido=$fecpedido;
		$this->fecentrega=$fecentrega;		$this->estado=$estado;		$this->memo=$memo;
		$this->fecfactura=$fecfactura;		$this->tippedido=$tippedido;
	}
		
	public function setidpedido($idpedido)	  { $this->idpedido= $idpedido;    }  
	public function setnumcli($numcli)        { $this->numcli = $numcli;       }
	public function setfecpedido($fecpedido)  { $this->fecpedido = $fecpedido; }
	public function setfecentrega($fecentrega){ $this->fecentrega= $fecentrega;}
	public function setestado($estado)        { $this->estado = $estado;       }
	public function setmemo($memo)            { $this->memo = $memo;           }
	public function setfecfactura($fecfactura){ $this->fecfactura=$fecfactura; }
	public function settippedido($tippedido)  { $this->tippedido=$tippedido;   }
			
	public function getidpedido()   { return $this->idpedido;  }
	public function getnumcli()     { return $this->numcli;    } 
	public function getfecpedido()  { return $this->fecpedido; }
	public function getfecentrega() { return $this->fecentrega;}
	public function getestado()     { return $this->estado;    }
	public function getmemo()       { return $this->memo;      }
	public function getfecfactura() { return $this->fecfactura;}
	public function gettippedido()  { return $this->tippedido; }

	public function PedidoAdd(){
		$this->setidpedido(siguienteID('contadores','id_pedido'));
		$link=Conecta();
		$sql="insert into pedido (id_pedido , num_cli, fec_pedido , ent_pedido , est_pedido , mem_pedido , fec_factura ,                                  tip_pedido)
						values('".$this->getidpedido()."',
							   '".$this->getnumcli()."',
							   '".$this->getfecpedido()."',
							   '".$this->getfecentrega()."',
							   '".$this->getestado()."',
							   '".$this->getmemo()."',
							   '".$this->getfecfactura()."',
							   '".$this->gettippedido()."')";
							   
		$res=ejecutarConsulta($sql,$link);
		//FreeResp($res);
		Desconecta($link); 
	}
	public function PedidoMod(){
		$link=Conecta();
		$sql="UPDATE pedido SET id_pedido=".$this->getidpedido().",
							  	est_pedido='".$this->getestado()."',
								ent_pedido='".$this->getfecentrega()."',
								tip_pedido='".$this->gettippedido()."',
								mem_pedido='".$this->getmemo()."'
									WHERE id_pedido=".$this->getidpedido()."";
		$res=ejecutarConsulta($sql,$link);
		FreeResp($res);
		//echo $sql;
		Desconecta($link);
	}
	public function PedidoEst($estado){   //cambia el estado del pedido PENDIENTE , PREPARADO , FACTURADO , ENTREGADO
		$link=Conecta();
		$this->setestado($estado);
		$sql="UPDATE pedido SET id_pedido=".$this->getidpedido().",
								est_pedido='".$this->getestado()."',
								fec_factura='".$this->getfecfactura()."'
									WHERE id_pedido=".$this->getidpedido()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);		
		//echo $sql;
	}
	public function PedidoPen($estado){
		$link=Conecta();
		$this->setestado($estado);
		$sql="SELECT num_cli , est_pedido FROM pedido WHERE num_cli="."'".$this->getnumcli()."'"."AND est_pedido="."'".$this->getestado()."'";
		//echo $sql;
		
		$res=mysql_query($sql,$link);
		//echo $res;
		$cantlin=mysql_num_rows($res);
		Desconecta($link);
		return $cantlin;
	
	}
	public function PedidoDel(){
		$link=Conecta();
		$idpedido=$this->getidpedido();
		$sql="delete from pedido where id_pedido=$idpedido";
		$res=ejecutarConsulta($sql,$link);
		//FreeResp($res);
		Desconecta($link);
	}
	public function TodosPedidos(){
		$link=Conecta();
		$sql="select id_pedido , num_cli, fec_pedido , ent_pedido ,est_pedido, mem_pedido ,fec_factura, tip_pedido  
					from pedido where 1=1";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
		return $res;
	}
}
?>