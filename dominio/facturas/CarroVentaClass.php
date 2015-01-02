<?php
include_once("../../dominio/facturas/FacturaLineaClass.php");
class CarroVenta{
	var $listalineasf; // var?? //pasa a ser un array de objetos lineas
  //--------------------------------------------------------------------- constructor	
	public function _construct($listalineasf){
	$this->listalineasf=$listalineasf;}
  //------------------------------------------------------------------------- retorna	
	public function get_listalineasf(){	return $this->listalineasf;} //ojo conjunto de objetos
  //------------------------------------------------------------------------------	
	public function set_listalineasf($listalineasf){$this->listalineasf=$listalineasf;}//ojo conjunto de objetos
  //--------------------------------------------------------------------------- carga	 
  	public function agregarf($FacturaLinea){   //-------------agrega linea de factura
	    $idmer=$FacturaLinea->get_idmer();          //carga el codmer del objeto linea
		$posicion=$this->buscarlineaf($idmer);      //busca si el codigo esta dentro del carrito	
		if($posicion==-1){                          //si codmer no esta en una linea
			$cant=count($this->listalineasf);
			$this->listalineasf[$cant]=$FacturaLinea;  //carga en listalineas la nueva linea FacturaLinea
		}else{
			session_start();
			$_SESSION["ses_error"]="LA MERCADERIA SELECCIONADA YA SE INGRESO";
		}
	}
 	public function eliminarf($idmer){     //------------------------------------
		$posicion=$this->buscarlineaf($idmer);   
		$this->listalineasf[$posicion]->set_idlinea(0);
	}   
 	public function buscarlineaf($idmer){  //------------------------------------
		$pos=-1;
		for($i=0; $i < count($this->listalineasf); $i ++){   
			if($this->listalineasf[$i]->get_idmer()==$idmer){ 
				$pos=$i;
			}
		}
		return $pos;	
	} 
  	public function guardarCarritof(){  //----------------------------------------
		$link=Conecta();
		$cant=count($this->listalineasf);	//$cant=1;
		for($i=0;$i<$cant;$i++){
			$idlinea= $this->listalineasf[$i]->get_idlinea();
			//echo $i;
			if($idlinea!=0){
				$idfactura= $this->listalineasf[$i]->get_idfac();
				$idmer    = $this->listalineasf[$i]->get_idmer();
				$cantidad = $this->listalineasf[$i]->get_cantidad();
				$unidad   = $this->listalineasf[$i]->get_unidad();
				$articulo = $this->listalineasf[$i]->get_articulo();
				$unitario = $this->listalineasf[$i]->get_unitario(); 
				$descuento= $this->listalineasf[$i]->get_descuento(); 
				$iva      = $this->listalineasf[$i]->get_iva(); 
				$nulo="N";
				$sql2="INSERT INTO facturalinea (id_faclinea , id_fac, cod_mer, cant_lin , uni_mer, des_mer,uni_lin, des_lin,iva_lin, nul_lin )
								          VALUES($idlinea,$idfactura,$idmer,$cantidad,'$unidad' ,'$articulo',$unitario,$descuento,$iva,'$nulo')";
				$res2=ejecutarConsulta($sql2,$link);  //guardado de lineas
				
			}	
		}
		Desconecta($link);
	}   
 	public function cantidadLineasf(){   //--------------------------------------
		$cant=0;
		for($i=0; $i<count($this->$listalineasf);$i++){
			$cant++	;
		}
		return $cant;
	}   
 	public function Devidlineaf($i){  $idlinea=$this->listalineasf[$i]->get_idlinea();    return $idlinea;}
	public function Devidfacf($i){    $idfac=$this->listalineasf[$i]->get_idfac();        return $idfac;}
	public function Devidmerf($i){    $idmer=$this->listalineasf[$i]->get_idmer();        return $idmer;}
	public function Devcantidadf($i){ $cantidad=$this->listalineasf[$i]->get_cantidad();  return $cantidad;}
	public function Devunidadf($i){   $unidad=$this->listalineasf[$i]->get_unidad();      return $unidad;}
	public function Devarticulof($i){ $articulo=$this->listalineasf[$i]->get_articulo();  return $articulo;}
	public function Devunitariof($i){ $unitario=$this->listalineasf[$i]->get_unitario();  return $unitario;}
	public function Devdescuentof($i){$descuento=$this->listalineasf[$i]->get_descuento();return $descuento;}
	public function Devivaf($i){      $iva=$this->listalineasf[$i]->get_iva();            return $iva;}
	public function Devnulaf($i){     $iva=$this->listalineasf[$i]->get_nula();           return $iva;}  
} //cierro la clase 

if (!isset($_SESSION['ses_carroventa'])){     //si no esta creada la sesion la creo
	//session_register('ses_carroventa');
	$_SESSION['ses_carroventa']=new CarroVenta();
	$_SESSION['ses_error']="YA PUEDE AGREGAR ARTICULOS AL PEDIDO";
}
?>