<?php
class Stock{
	private $idstock;	private	$idinsumo;	private	$cantidad;  private $fecha;	private	$tipo;	private $idprod;
	
	public function __construct($idstock,	$idinsumo,	$cantidad, $fecha,	$tipo, $idprod){
		$this->idstock=$idstock;
		$this->idinsumo=$idinsumo;   
		$this->cantidad=$cantidad;
		$this->fecha=$fecha;
		$this->tipo=$tipo;
		$this->idprod =$idprod;
	}
		
	public function setidstock($idstock)  { $this->idstock = $idstock; }  
	public function setidinsumo($idinsumo){ $this->idinsumo= $idinsumo;}
	public function setcantidad($cantidad){ $this->cantidad= $cantidad;}
	public function setfecha($fecha)      { $this->fecha   = $fecha;}
	public function settipo($tipo)        { $this->tipo    = $tipo;    }
	public function setidprod($idprod)    { $this->idprod  = $idprod;  }
					
	public function getidstock()   { return $this->idstock;  }
	public function getidinsumo()  { return $this->idinsumo; } 
	public function getcantidad()  { return $this->cantidad; }
	public function getfecha()     { return $this->fecha;    }
	public function gettipo() 	   { return $this->tipo;     }
	public function getidprod()    { return $this->idprod;   }
				
	public function StockExiste(){
		$link=Conecta();
		$sql="select num_prod from stock where num_prod='".$this->getidprod()."";
		$res=ejecutarConsulta($sql,$link);
		if(mysql_num_rows($res)==0){
			$existe=0; //si no existe
		}else{
			$existe=1; //si existe			
		}
		Desconecta($link);
		return $existe;
	}
	
	public function StockAdd(){
		$link=Conecta();
		$sql="insert into stock( id_stock, id_insumo,cant_stock,fec_stock,tip_stock,num_prod)
						values('".$this->getidstock()."',
						       '".$this->getidinsumo()."',
							   '".$this->getcantidad()."',
							   '".$this->getfecha()."',
							   '".$this->gettipo()."',
							   '".$this->getidprod()."')";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function StockMod(){
		$link=Conecta();
		$sql="update stock set id_stock='".$this->getidstock()."',
							  id_insumo='".$this->getidinsumo()."',
							 cant_stock='".$this->getcantidad()."',
							  fec_stock='".$this->getfecha()."',
						      tip_stock='".$this->gettipo()."',
							   num_prod='".$this->getidprod()."'
							   			WHERE id_stock =".$this->getidstock()."";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	public function StockMod2(){
		$link=Conecta();
		$sql="update stock set id_insumo='".$this->getidinsumo()."',
							 cant_stock='".$this->getcantidad()."',
							  fec_stock='".$this->getfecha()."',
						      tip_stock='".$this->gettipo()."',
							   num_prod='".$this->getidprod()."' 
							   	WHERE num_prod = ".$this->getidprod()." AND id_insumo = ".$this->getidinsumo()." ";
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function StockDel(){
		$link=Conecta();
		$sql="delete from stock where num_prod = ".$this->getidprod();
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
	
	public function Consumido($fechaini){
		$link=Conecta();
		$sql="select *	from stock where id_insumo = ".$this->getidinsumo(). " ORDER BY tip_stock DESC , fec_stock ASC" ;
		$res=ejecutarConsulta($sql,$link);
		$stock=0;
		while($row=mysql_fetch_array($res)){
		    if($row['fec_stock']>$fechaini){
				if($row['tip_stock']=="I"){
					$stock=$stock+$row['cant_stock'];
				}elseif($row['tip_stock']=="E"){
					$stock=$stock-$row['cant_stock'];
				
				}elseif($row['tip_stock']=="C"){	
					$stock=$stock-$row['cant_stock'];
				}
			}	
		}
		Desconecta($link);
		return $stock;
	}

}
?>