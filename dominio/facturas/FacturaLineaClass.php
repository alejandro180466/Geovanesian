<?php
class FacturaLinea{private $idlinea;	private $idfac;	    private $idmer;	    private $cantidad;	private $unidad;
	private $articulo;  private $unitario;	private $descuento;	private $iva;	    private $nula;
		
	public function __construct( $idlinea,$idfac,$idmer,$cantidad,$unidad,
								 $articulo,$unitario,$descuento,$iva,$nula){
		$this->idlinea=$idlinea;    //id de facturalinea
		$this->idfac=$idfac;        //id de factura
		$this->idmer=$idmer;        //id de mercaderia
		$this->cantidad=$cantidad;  //cantidad de unidades
		$this->unidad=$unidad;      //unidad envase
		$this->articulo=$articulo;  //descripcion del articulo
		$this->unitario=$unitario;  //precio unitario de la unidad
		$this->descuento=$descuento;//desceunto por unidad
		$this->iva=$iva;            //iva de la linea (%)
		$this->nula=$nula;          //linea anulada o no
	}
	//public function __destruct(){	}
//------------------------------------- RETORNAN CONTENIDO	
	public function get_idlinea()  {return $this->idlinea;	}
	public function get_idfac()    {return $this->idfac;	}
	public function get_idmer()    {return $this->idmer;	}
	public function get_cantidad() {return $this->cantidad;	}
	public function get_unidad()   {return $this->unidad;	}
	
	public function get_articulo() {return $this->articulo;	}
	public function get_unitario() {return $this->unitario;	}
	public function get_descuento(){return $this->descuento;}
	public function get_iva()      {return $this->iva;	    }
	public function get_nula()     {return $this->nula;     }
//-------------------------------------- ASIGNAN CONTENIDO	
	public function set_idlinea($idlinea)    {$this->idlinea=$idlinea;   }
	public function set_idfac($idfac)        {$this->idfac=$idfac;       }
	public function set_idmer($idmer)        {$this->idmer=$idmer;	     }
	public function set_cantidad($cantidad)  {$this->cantidad=$cantidad; }
	public function set_unidad($unidad)      {$this->unidad=$unidad;     }
	
	public function set_articulo($articulo)  {$this->articulo=$articulo; }
	public function set_unitario($unitario)  {$this->unitario=$unitario; }
	public function set_descuento($descuento){$this->dscuento=$descuento;}
	public function set_iva($iva)            {$this->iva=$iva;	         }
	public function set_nula($nula)          {$this->nula=$nula;	     }
 //------------------------------------- LISTA LOS DATOS DE LA LINEA
	public function listarDatos(){
	    $color='white'; 
		if($this->get_unitario==0){
			$color='yellow';
		}
		$res="<tr bgcolor='#FFFFFF' align='center'>
		           <td>".$this->get_idmer()."</td>
		           <td>".$this->get_cantidad()."</td>
				   <td align='left'>".$this->get_unidad()."</td>
				   <td align='left'>".$this->get_articulo()."</td>
				   <td align='rigth'style='background-color:'.$color ;>".$this->get_unitario()."</td>
				   <td align='rigth'>".$this->get_descuento()."</td>
				   <td align='rigth'>".$this->get_cantidad()*$this->get_unitario()."</td>
				   <td align='rigth'>".$this->get_iva()."</td>
				   <td>"."<input type='image' src='../../iconos/delete_16.png' border='0'
												title='eliminar esta linea' 
												onclick='cargarInfo(this.form,".$this->get_idmer.",3)';>"."</td>
				</tr>";
		return $res;	 
	}
	public function FacturaLineaExiste(){
		$link=Conecta();
		$sql="SELECT id_fac, cod_mer FROM facturalinea WHERE id_fac=".$this->get_idfac()." AND cod_mer=".$this->get_idmer()."";
		$res=ejecutarConsulta($sql,$link);
		if($res==null){
			$existe=0;
		}else{
			if(mysql_num_rows($res)==0){
				$existe=0; //si no existe
			}else{
				$existe=1; //si existe			
			}
		}	
		Desconecta($link);
		return $existe;
	}
	public function FacturaLineaAdd(){
		$this->set_idlinea(siguienteID('contadores','id_faclinea'));
		$link=Conecta();
		$sql="INSERT INTO facturalinea (id_faclinea, id_fac, cod_mer, cant_lin, uni_mer,
								   		des_mer, uni_lin, des_lin, iva_lin, nul_lin)	
						VALUES('".$this->get_idlinea()."',
								'".$this->get_idfac()."',
								'".$this->get_idmer()."',
								'".$this->get_cantidad()."',
								'".$this->get_unidad()."',
								'".$this->get_articulo()."',
								'".$this->get_unitario()."',
								'".$this->get_descuento()."',
								'".$this->get_iva()."',
								'".$this->get_nula()."')";
								
		$res=ejecutarConsulta($sql,$link);
		Desconecta($link);
	}
}
?>