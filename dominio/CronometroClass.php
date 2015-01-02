<?php class getmicrotime
{ 
    var $iniciar; 
	function micro(){ 
		$micro_time = microtime(); 
		$micro_time = explode(" ",$micro_time); 
		$micro_time = $micro_time[1] + $micro_time[0]; 
		return $micro_time; 
	} 
    /** @Constructor of class - Initializes class 
    * @Usage -> include("CronometroClass.php"); 
    * $tiempo = new getmicrotime; 
    * echo $tiempo->vertiempo();          */ 
	function getmicrotime(){ 
		$this->iniciar = $this->micro(); 
		return true; 
	} 
	function vertiempo(){ 
		$total_time = ($this->micro() - $this->iniciar); 
		$total_time = "Consulta generada en ".substr($total_time,0,4)." Seg."; 
		return $total_time; 
	} 
} 
?> 