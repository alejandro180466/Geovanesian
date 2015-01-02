<?php Class Paginador{	private $total_paginas;		private $num_paginas;    private $ruta;   private $actual_pagina;
    public function __construct($total_paginas,$num_paginas,$ruta,$actual_pagina){
		$this->total_paginas=$total_paginas;		$this->num_paginas=$num_paginas;
		$this->ruta=$ruta;							$this->actual_pagina=$actual_pagina;
	}
	public function settotal_paginas($total_paginas){ $this->total_paginas = $total_paginas;}
	public function setnum_paginas($num_paginas)    { $this->num_paginas   = $num_paginas;  }
	public function setruta($ruta)                  { $this->ruta          = $ruta;         }
	public function setactual_pagina($actual_pagina){ $this->actual_pagina = $actual_pagina;}
		
	public function gettotal_paginas(){ return $this->total_paginas; }
	public function getnum_paginas()  { return $this->num_paginas;   } 
	public function getruta()         { return $this->ruta;          }
	public function getactual_pagina(){ return $this->actual_pagina; }
	
	function Armado(){		
		$indicepag=$this->getnum_paginas();    // numeros de paginas a mostrar
		$desde = 1;		$pagina=0;	$armar = "";
		$total_paginas=$this->gettotal_paginas();
		$ruteo=$this->getruta();
		$hasta = $this->getactual_pagina()+$indicepag;
		if($total_paginas>0){
			if(($this->getactual_pagina()- $indicepag)<0){
				$desde =1;
			}else{
				$desde = $this->getactual_pagina()-$indicepag;
			}
			if($this->getactual_pagina()>($indicepag)){
				$armar="<a href='".$ruteo."?pagina="."1"."'> Primera </a>";
			}
			if($this->getactual_pagina() > $indicepag){$armar=$armar."<a href='".$ruteo."?pagina=".$desde."'> Ant </a> ";	}
			if($hasta>$total_paginas){$hasta=$total_paginas;}
			for ($i=$desde; $i<=$hasta; $i++){
				if($i==$this->getactual_pagina()){
					$armar=$armar."<b><a href='".$ruteo."?pagina=$i'> $i </a></b>";	
				} else {
					$armar=$armar."<a href='".$ruteo."?pagina=$i'> $i </a>";
				}	
			}
			if(($i + 1)<=$total_paginas){$armar=$armar." <a href='".$ruteo."?pagina=".($i)."'> Sig </a>";	}
			if($this->getactual_pagina()<($total_paginas-$indicepag)){
				$armar=$armar."<a href='".$ruteo."?pagina=".$total_paginas."'> Ultima </a>";
			}	
		}	
        return $armar; 
    }
}
?>