<?php Class Paginar{
		private $regXpagina;
		private $totRegistros;
}
  $link=Conecta();                                  // en Persistencia.php 
  $registros =12;
  if(isset($_GET['pagina'])){
	$pagina=$_GET['pagina'];
	$inicio=($pagina - 1)*$registros;
  }else{
  	$inicio=0;     $pagina=1;
  }
  echo $pagina;
  $result=mysql_query($sql,$link);
  $total_registros=mysql_num_rows($result);
  $sql.=" LIMIT $inicio , $registros";
  $resultados=ejecutarConsulta($sql,$link);	
  $total_paginas = ceil($total_registros / $registros); 	
  //-------------------------------------------------------  
  Desconecta($link);
	if($total_registros){
		echo "<center>";
		$desde = $pagina;
		$hasta = $pagina+$indicepag;
		
		if(($pagina-$indicepag)<0){
			$desde =1;
		}else{
			$desde = $pagina-$indicepag;
		}
		
		if($pagina > $indicepag){
			echo "<a href='SeekPag.php?pagina=".($desde)."'>< Anterior</a> ";
		}
		if($hasta>$total_paginas){
			$hasta=$total_paginas;
		}
		for ($i=$desde; $i<=$hasta; $i++){ 
			if ($pagina == $i){
				echo "<b>".$pagina."</b> "; 
			} else {
				echo "<a href='SeekPag.php?pagina=$i'>$i</a> "; 
			}	
		}
		if(($i + 1)<=$total_paginas){
			echo " <a href='SeekPag.php?pagina=".($i)."'>Siguiente ></a>";
		}
		echo "</center>";
	}
?>