<?php
if(!isset($_SESSION)){     session_start(); }
$perfiles=$_SESSION['ses_perfil']; // datos del usuario
$perfil=$perfiles[0]; //perfil
$nombre=$perfiles[2]; //nombre
?>
<html>
  <head>
    <link href="../../estilos/estilo.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="../../estilos/styles2.css" >
    <link rel="stylesheet" type="text/css" href="../../estilos/stylesmenu.css" >
    <link rel="stylesheet" type="text/css" href="../../estilos/stylesmenuV.css" >
	<!--link rel="shortcut icon"  href="../../iconos/favicon.ico"/--> <!-- Coloca un mini icono -->
     <title>titulo</title> 
     <script languaje="javascript" >
  	   function Salir(form){
		form.on_of.value="off";
		form.submit();
	   }
    </script>			
  </head>
<body> 
   <div id="menuizquierdo">
 	 <ul id="navmenu">
		<img  border="0" src="../../imagenes/image2063.jpg" title="SITIO OPERATIVA INTERNA" />
<!-------------------------  MENU DE LOGIN -------------------------------------------------->
<?php if ($perfil==""){ ?>  
  		<form name="formIng" action="../../dominio/usuarios/UserCheck.php" method="POST"/>
		    <li bgcolor="#FF8000" ><b><?php echo $estado;?></b></li>
		    <li><b>NOMBRE:</b>
		   	   	 <input type="text" name="txtnombre" id="txtnombre" value="<?php echo $nombre; ?>" size="9" maxlength="20" 	title="nombre de usuario" onkeypress="return permite(event,'car')"/>
			</li>
		    <li><b>PASS:</b>
				   <input type="password" name="txtpassword" id="txtassword" value="" size="9" maxlength="8"  title="Password"
							       onkeypress="return permite(event,'num_car')"/>
			</li>
				   <input type="hidden" name="on_of" size="2" value="on"/>
		    <li><input type="button" value="INGRESO" title="LOGIN" onClick="ValidarIng(this.form)"/></li>
        </form>
<?php }else{ ?>		 
		<form name="formIng" action="../../dominio/usuarios/UserCheck.php" method="POST"/>
		  <input type="hidden" name="on_of" size="2" value="off"/>
		   <!--li><b><?php //echo $estado;?></b></li-->
		   <li><b>NOMBRE:</b><?php echo $nombre; ?></li>
		   <li><input type="button" value="SALIDA" style="font-size:18px;width:158px;height:48"
					onClick="Salir(this.form)"/></li> 
		 </form>
<?php } ?>
<!-------------------------  MENU DEL USUARIO -------------------------------------------------->  
        <li><a href="../../" title="Mantenimiento de Usuarios">INICIO</a></li>
<!--  divs con enlasces a paginas utiles   -->
<?php
	if($perfil=="A" || $perfil=="P"){ ?>
	   <div>
 		<li><a href="">DE INTERES +</a>
			<ul>
			<!-- ORGANISMOS DEL ESTADO ------------------------------------------------------->
				<li><a href="">Organismos Estado +</a>
					<ul>
						<li><a rel="nofollow" target="_blank" href="http://www.aduanas.gub.uy">ADUANAS</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.bps.gub.uy">BPS</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.bse.com.uy/">BSE</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.dgi.gub.uy">DGI</a></li>
					</ul>
				</li>
				<!-- EMPRESAS PUBLICAS ------------------------------------------------------->
				<li><a href="">Empresas Públicas +</a>
					<ul>
						<li><a rel="nofollow" target="_blank" href="http://www.ancap.com.uy/">ANCAP</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.antel.com.uy/">ANTEL</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.ose.com.uy/">OSE</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.ute.com.uy/">UTE</a></li>
					</ul>
				</li>
				<!-- BANCOS ---------------------------------------------------------------------->
				<li><a href="">Bancos +</a>
					<ul>
						<li><a href="">Bancos oficiales +</a>
							<ul>
							  <li><a rel="nofollow" target="_blank" href="http://www.bcu.gub.uy/">Banco Central</a></li>
							  <li><a rel="nofollow" target="_blank" href="http://www.bhu.com.uy/">Banco Hipotecario</a></li>
							  <li><a rel="nofollow" target="_blank" href="http://www.brou.com.uy/">Banco República</a></li>
							</ul>
						</li>
						<li><a href="">Bancos privados +</a>
							<ul>
								<li><a rel="nofollow" target="_blank"href="http://www.bandes.com.uy/">Bandes</a></li>
								<li><a rel="nofollow" target="_blank" href="https://www.bbva.com.uy/">Bbva</a></li>
								<li><a rel="nofollow" target="_blank" href="https://www.citibank.com.uy/">Citi</a></li>
								<li><a rel="nofollow" target="_blank" href="http://www.nbc.com.uy/">Comercial</a></li>
								<li><a rel="nofollow" target="_blank" href="http://www.discbank.com.uy/">Discount</a></li>
								<li><a rel="nofollow" target="_blank"href="http://www.hsbc.com.uy/">Hsbc</a></li>
								<li><a rel="nofollow" target="_blank" href="https://www.itau.com.uy/">Itau</a></li>
								<li><a rel="nofollow" target="_blank" href="http://http://www.heritage.com.uy/web/BANQUE_HERITAGE_URUGUAY/">Heritage</a></li>
							</ul>
						</li>	
					</ul>
				</li>
				<!-- PRENSA LOCAL ------------------------------------------------------------------>
				<li><a href="">Prensa Local +</a>
					<ul>
						<li><a rel="nofollow" target="_blank" href="http://www.elpais.com.uy/">EL PAIS</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.ladiaria.com.uy/">LA DIARIA</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.lr21.com.uy/">LA REPUBLICA</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.elobservador.com.uy/">OBSERVADOR</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.unoticias.com.uy/">ULTIMAS NOTICIAS</a></li>
					</ul>
				</li>
				<!-- INTENDENCIAS ------------------------------------------------------------------>
				<li><a href="">INTENDENCIAS +</a>
					<ul>
						<li><a rel="nofollow" target="_blank" href="http://www.imcanelones.gub.uy/">CANELONES</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.colonia.gub.uy/">COLONIA</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.maldonado.gub.uy/">MALDONADO</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.montevideo.gub.uy/">MONTEVIDEO</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.rocha.gub.uy/">ROCHA</a></li>
						<li><a rel="nofollow" target="_blank" href="http://www.imsj.gub.uy/">SAN JOSE</a></li>
					</ul>
				</li>
				<!-- PRESIDENCIA ------------------------------------------------------------>
				<li><a rel="nofollow" target="_blank" href="HTTP://www.presidencia.gub.uy/">Presidencia</a></li>
				<!-- otros ------------------------------------------------------------------>
				<li><a href="">OTROS +</a>
					<ul>
						<li><a rel="nofollow" target="_blank" href='http://uca.mef.gub.uy/portal/web/guest/portada'>UCA</a></li>
						<li><a rel="nofollow" target="_blank" href='http://www.cgn.gub.uy/innovaportal/v/656/1/innova.front/proveedores_del_estado.html'>CGN-Proveedores</a></li>
						<li><a rel="nofollow" target="_blank" href='http://www.latu.org.uy/'>LATU</a></li>
						<li><a rel="nofollow" target="_blank" href='http://www.dinama.gub.uy/'>DINAMA</a></li>
						<li><a rel="nofollow" target="_blank" href='http://www.bomberos.gub.uy/'>BOMBEROS</a></li>
					</ul>	
				</li>
			</ul>
		</li>
<?php 
}  ?>			
<?php 	if($perfil=="A"){ ?>		
		    <!--li><a href="../../interface/usuarios/UserIndex.php" >USUARIOS</a>
        		  <ul>
<?php                if($perfil=="A"){ ?>			
						<li><a href="../../interface/usuarios/UserForm.php?opcion=1" 
									title="Ingresar usuarios al sistema">INGRESAR</a>
						</li>
<?php				 }
					 if($perfil=="P" || $perfil=="A" ){ ?>
						<li><a href="../../interface/usuarios/UserList.php?opcion=4" 
									title="Buscar usuarios">BUSCAR</a>
						</li>
<?php				 }  ?>					
				  </ul>
			</li -->
<?php   } 
       if($perfil=="A" || $perfil=="P" ){ //PROVEEDORES ?>	  
			<!--li><a href="">PROVEEDORES</a>
			    <ul>
<?php				if($perfil=="A"){ ?>			
						<li><a href="../../interface/proveedores/ProvForm.php?modo=1" >INGRESAR</a></li>
<?php				}
					if($perfil=="P"|| $perfil=="A" ){ ?>
						<li><a href="../../interface/proveedores/ProvSeek.php" >BUSCAR</a></li>
<?php				}  ?>	
				</ul>		
			</li>
			<li><a href="">COMPRAS</a>
			    <ul>
<?php				if($perfil=="A" ){    // compras          ?>
				       <li><a href="../../interface/movimientos/MovimientoForm.php?modo=1&id=0" title="Compras y Pagos">INGRESAR</a></li>
<?php				}
					if($perfil=="P"|| $perfil=="A" ){ ?>
					   <li><a href="../../interface/movimientos/MovimientoSeek.php" title="Compras y Pagos">BUSCAR</a></li>
<?php				}  ?>
				</ul>
			</li-->
			<li><a href="">CLIENTES</a>
			    <ul>
<?php               if($perfil=="A"){ ?>			
						<li><a href="../../interface/clientes/ClienteForm.php?modo=1" title="Clientes de la empresa">INGRESAR</a></li>
<?php				}
					if($perfil=="P" || $perfil=="A" ){ ?>
						<li><a href="../../interface/clientes/ClienteSeek.php" title="Clientes de la empresa">BUSCAR</a></li>
<?php				}  ?>					
				</ul>		
			</li>
					    <li><a href="">MERCADERIAS</a>
					<ul>
			<?php   if($perfil=="A"){ ?>			
						<li><a href="../../interface/mercaderias/MercaderiaForm.php?modo=1" title="Alta de nueva mercadería">INGRESAR</a></li>
<?php				}
					if($perfil=="P" || $perfil=="C" || $perfil=="A"){ ?>
						<li><a href="../../interface/mercaderias/MercaderiaSeek.php" >BUSCAR</a></li>
<?php				}	?>	
					</ul>  
		    </li>
			<li><a href="">ENTRADAS</a>
				<ul>
<?php	        if($perfil=="A" || $perfil=="C"){ ?>			
					<li><a href="../../interface/producciones/ProduccionForm.php?modo=1&rechazo=0&id=1" >INGRESAR</a></li>
					<li><a href="../../interface/producciones/ProduccionForm.php?modo=1&rechazo=1&id=1" >RECHAZAR</a></li>
<?php			}
				if($perfil=="P" || $perfil=="A"){ ?>
					<li><a href="../../interface/producciones/ProduccionSeek.php" >BUSCAR</a></li>
<?php			}	?>				
				</ul>
			</li>			
<?php	if($perfil=="A"){ ?>
			<li><a href="">PRECIOS</a>
				<ul style="navmenu">
					<li><a href="../../interface/precios/PrecioForm.php?modo=1&id=0" title="Precios de venta ">INGRESAR</a></li>
					<li><a href="../../interface/precios/PrecioSeek.php" title="Precios de venta">BUSCAR</a></li>
					<?php if($nombre=="alejandro"){ ?>
					<li><a href="interface/actualizar/ActualizaIndex.php" title="Actualizar Precios de venta">ACTUALIZAR</a></li>
					<?php } ?>
					
				</ul>
			</li>	
<?php	}  ?>
<?php   if($perfil!=""){ ?>
			<li><a href="">PEDIDOS</a>
			    <ul>
<?php				if($perfil=="A" || $perfil=="C"){ ?>			
						<li><a href="../../interface/pedidos/PedidoForm.php?modo=5&id=0" >INGRESAR</a></li>
<?php				}
					if($perfil=="P" || $perfil=="A"){ ?>
						<li><a href="../../interface/pedidos/PedidoSeek.php" >BUSCAR</a></li>
<?php				} ?>					
				</ul>	
		    </li>
<?php   }   ?>	
<?php	if($perfil=="A"|| $perfil=="P" ){ ?>	
		    <li><a href=""> DOCUMENTOS +</a>
				<ul>
					<?php	if($perfil=="A"){ ?>
								<li><a href="../../interface/recibos/ReciboIndex.php" title="RECIBOS de Luxus ltda." >RECIBOS	
									</a>
								</li>
					<?php	}
							if($perfil=="P"){ ?>		
								<li><a href="../../interface/recibos/ReciboSeek.php" title="RECIBOS de Luxus ltda." >RECIBOS	
									</a>
								</li>
					<?php   } ?>	    
					<?php	if($perfil=="A"){ ?>
								<li><a href="../../interface/facturas/FacturaIndex.php" title="FACTURAS de Luxus ltda.">FACTURAS
									</a>
								</li>
					<?php	}
							if($perfil=="P"){ ?>
								<li><a href="../../interface/facturas/FacturaSeek.php" title="FACTURAS de Luxus ltda.">FACTURAS
									</a>
								</li>
					<?php     	 					
							if($perfil=="P" || $perfil=="A"){ ?>
									<?php if($nombre=="alejandro"){ ?>			
								<LI><a href="../../interface/documentos/DocumentoSeek.php" title="ESTADOS DE CUENTA CLIENTES">
										ESTDO CTA
									</a>
								</LI>	
									<?php   } ?>
					<?php   } ?>			
					<?php	/*if($perfil=="A"){ ?>									
								<LI><a href="../../interface/alertas/AlertaIndex.php" title="ALERTAS DE VENCIMIENTOS VARIOS">
										ALERTAS</a>
								</LI>
					<?php	}*/ ?>
				</ul>
			</li>
<?php   }  ?>			
			



<?php   /*if($perfil=="A" ){ ?>
			<li><a href="../../interface/foros/ForoList.php" title="Foro interno">FOROS</a></li>
<?php	}  */ 
	    if($perfil=="A" || $perfil=="P"){ ?>
			<li><a href="">VENTAS</a>
				<ul>
					<li><a href="../../interface/ventas/VentaSeek_M.php" title="ventas realizadas">POR ARTICULO</a></li>
					<li><a href="../../interface/ventas/VentaSeek_C.php" title="ventas realizadas">POR CLIENTE</a></li>
				</ul>
			</li>	
<?php	}
///////////////////////////////////////////////////////////////////////////////////////////////////
        if (isset($_SESSION['ses_carro'])){     //si existe no lo muestro ?>
			<li><a href="../../interface/carrito/CarritoIndex.php" title="carrito de compras">CARRITO</a></li>
<?php   } ?>
    
      </div>
<?php	
    } ?>
   	</ul>
  </div>
 </body>
</html>