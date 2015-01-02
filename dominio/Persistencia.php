<?php
function Conecta(){
	if (!($link=mysql_connect("localhost","root",""))){  //a servidor,usuario,password("localhost","root","")
								                                                     //"localhost","bondulce_ale","ale180466"
		$_SESSION["ses_error"]="Error conectando a la base de datos";
		exit();
	}
	if (!mysql_select_db("geovanesian",$link)){        //a base de datos("bondulce_pentisol",$link)conjunto de tablas)
		$_SESSION["ses_error"]="Error seleccionando la base de datos";
		exit();
	}
	return $link;
 }
 // funciones relacionadas a las consultas y desconexion
 function ejecutarConsulta($sql,$con){
	return mysql_query($sql,$con);
 }
 function FreeResp($result){
  	mysql_free_result($result);
 } 
 function Desconecta($link){
	mysql_close($link);
 }
 function siguienteID($tabla,$campo){ //permite asignar nuevo id a la tabla
		$conn = Conecta();
		$id=0;
		$sql="select $campo id from ". $tabla;
		$rs = mysql_query($sql,$conn);
		$fila = mysql_fetch_array($rs);	
		$id=$fila["id"];
		$id++;
		Desconecta($conn);
		updateId($campo,$tabla);
		
		return $id;
 }
 function  actualID($tabla,$campo){ //retorna el valor del id en el contador
 		$conn = Conecta();
		$id=0;
		$sql="select $campo id from ". $tabla;
		$rs = mysql_query($sql,$conn);
		$fila = mysql_fetch_array($rs);	
		$id=$fila["id"];
		Desconecta($conn);
		return $id;
 }
 function cambiarID($tabla,$campo,$nuevo){ //permite asignar nuevo id a la tabla
		$conn = Conecta();
	    $sql  = "UPDATE $tabla SET $campo =". $nuevo;
		$rs   = mysql_query($sql,$conn);
		Desconecta($conn);
 }		
 function updateId($campo,$tabla){  //actualiza el id en tabla contadores
		$sql="update $tabla set $campo = $campo + 1";
		$conn = Conecta(); 
		$rs = mysql_query($sql,$conn);
		Desconecta($conn);
 }

  function convertirFormatoFecha2($fecha){
	if($fecha!=""){
		$anio=substr ($fecha,0,4);
		$mes=substr ($fecha,5,2);
		$dia=substr($fecha,8,2);
		$fechaFormat= $anio."-".$mes."-".$dia;
	}else{
 	    $fechaFormat="";
	}	
	
	return $fechaFormat;
 }
 function convertirFormatoFecha($fecha){
 	$anio=substr ($fecha,0,4);
	$mes=substr ($fecha,5,2);
	$dia=substr($fecha,8,2);
	$fechaFormat= $dia."-".$mes."-".$anio;
	return $fechaFormat;
 }
  
 function convertirFormatoHora($fecha){ //convierte de formato AAAA/mm/dd  A   dd-mm-AAAA
 	$hora=substr($fecha,11,2);
	$min= substr($fecha,14,2);
	$seg= substr($fecha,17,2);
	$horaFormat=$hora.":".$min.":".$seg;
  	return $horaFormat;
 }
 function suma_fechas($fecha,$ndias){  //recibe formato AAAA/mm/dd convierte a dd-mm-AAAA y le suma $ndias
      $fecha=convertirFormatoFecha($fecha); 
            
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
        list($dia,$mes,$año)=split("/", $fecha);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
        list($dia,$mes,$año) = explode("-",$fecha);
        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);
            
    return ($nuevafecha);  //devuelve nueva fecha
 }
 function redondea_2decimal($valor){
	return round($valor*100)/100;
 }
 function redondea_sindecimal($valor){
	return round($valor,0);
 }
 function respaldar(){
	$sql="mysqldump --opt -u root -p  bondulce_pentisol > /backups/archivodebackup.txt";
	$conn = Conecta();
	$rs = mysql_query($sql,$conn);
	Desconecta($conn);
 }
?>