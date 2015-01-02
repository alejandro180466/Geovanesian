<?php
session_start(); 
$perfiles=$_SESSION["ses_perfil"]; //carga los valores de perfilvienen de xlogin.php, ses_perfiles nombre sesion
$perfil=$perfiles[0];              // perfil
$codusr=$perfiles[1];              // carga en variable el identificador del usuario COD_USER
if($perfil=="" || $codusr==""){	header("location:../../index.php"); exit();}

  $Vdes=$_POST['txtdes'];
  $sql="select m.cod_mer, m.des_mer, m.uni_mer, m.cat_mer, m.peso_mer,
					p.cod_mer, p.fec_partida  , p.id_insumo, p.cant_partida, p.id_partida,
						i.id_insumo, i.des_insumo, i.cat_insumo, i.uni_insumo
							from mercaderia m , partida p, insumo i
								where m.cod_mer=$Vdes
									AND p.cod_mer = m.cod_mer
									AND p.id_insumo = i.id_insumo ";
  $criterio="Criterio : ";							
  $criterio.=" Producto :".$Vdes." "; 
  
  $sql.="order by p.cod_mer + p.id_insumo + p.fec_partida DESC"  ;                                //" order by p.cant_pa rtida DESC";;
  
  $_SESSION['ses_criterio']=$criterio;
  $_SESSION['ses_sql']=$sql;
   header('location:../../dominio/formulates/SeekPag.php');     
?>