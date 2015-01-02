<?php
if(!isset($_SESSION)){ 
    session_start(); 
}
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
	<link rel="shortcut icon"  href="../../iconos/favicon.ico"/> <!-- Coloca un mini icono -->
     <title>interno</title> 
     <script languaje="javascript" >
  	   function Salir(form){
		form.on_of.value="off";
		form.submit();
	   }
    </script>			
  </head>
<body> 
   <div id="menuizquierdo">
   		<img  border="0" src="../../imagenes/image2063.jpg" title="SITIO OPERATIVA INTERNA" />
	 <ul id="navmenu">
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
		    <li><input type="button" value="INGRESO" style="font-size:9px;width:60px;height:18px"  
							title="LOGIN" onClick="ValidarIng(this.form)"/>
			</li>
        </form>
<?php }else{ ?>		 
		<form name="formIng" action="../../dominio/usuarios/UserCheck.php" method="POST"/>
		  <input type="hidden" name="on_of" size="2" value="off"/>
		   <!--li><b><?php //echo $estado;?></b></li-->
		   <li><b>NOMBRE:</b><?php echo $nombre; ?></li>
		   <li><input type="button" value="SALIDA" style="font-size:9px;width:60px;height:18px" onClick="Salir(this.form)"/></li> 
		 </form>
<?php } ?>
<!-------------------------  MENU DEL USUARIO -------------------------------------------------->  
        <li><a href="../../" title="Mantenimiento de Usuarios">INICIO</a></li>
<?php 	if($perfil=="A"){ ?>		
		    <li><a href="../../interface/usuarios/UserIndex.php" >USUARIOS</a></li>
<?php   } 
        if($perfil=="A" || $perfil=="P" ){ ?>	  
			<li>
<?php			if($perfil=="A"){ ?>			
					<a href="../../interface/proveedores/ProvIndex.php" >
<?php			}
				if($perfil=="P"){ ?>
					<a href="../../interface/proveedores/ProvSeek.php" title="Proveedores">
<?php			}  ?>	
					PROVEDORES
				</a>
			</li>
			<li>
<?php			if($perfil=="A"){ ?>
				    <a href="../../interface/movimientos/MovimientoIndex.php" title="Compras y Pagos">
<?php			}
				if($perfil=="P"){ ?>
					<a href="../../interface/movimientos/MovimientoSeek.php" title="Compras y Pagos">
<?php			}  ?>
				COMPRAS
				</a>
			</li>
<?php	if($perfil=="A"){ ?>					
			<li><a href="../../interface/insumos/InsumoIndex.php" title="Insumos varios">INSUMOS</a></li>
<?php	}  ?>					
			<li>
<?php               if($perfil=="A"){ ?>			
						<a href="../../interface/clientes/ClienteIndex.php" title="Clientes de la empresa">
<?php				}
					if($perfil=="P"){ ?>
						<a href="../../interface/clientes/ClienteSeek.php" title="Clientes de la empresa">
<?php				}  ?>					
						CLIENTES
					</a>
			</li>
<?php	if($perfil=="A"){ ?>					
			<li><a href="../../interface/precios/PrecioIndex.php">PRECIOS</a></li>
<?php	}  ?>	
<?php	if($perfil=="A"|| $perfil=="P" ){ ?>	
		    <li><a href="../../interface/documentos/DocumentoIndex.php" title="Nuestros DOCUMENTOS">DOCUMENTOS</a></li>
<?php   } 			
        if($perfil!=""){ ?>
			<li>
<?php				if($perfil=="A" || $perfil=="C"){ ?>			
						<a href="../../interface/pedidos/PedidoIndex.php" title="Pedidos recibidos">
<?php				}
					if($perfil=="P"){ ?>
						<a href="../../interface/pedidos/PedidoSeek.php" title="Pedidos recibidos">
<?php				} ?>					
					  PEDIDOS
					</a>
		    </li>
<?php   }   ?>			
		    <li>
			<?php   if($perfil=="A"){ ?>			
						<a href="../../interface/mercaderias/MercaderiaIndex.php" >
<?php				}
					if($perfil=="P" || $perfil=="C"){ ?>
						<a href="../../interface/mercaderias/MercaderiaSeek.php" >
<?php				}	?>	
					  MERCADERIAS
					</a>
		    </li>
<?php	if($perfil=="A"){ ?>				
			<li><a href="../../interface/formulates/FormulateIndex.php" >FORMULAS</a></li>
<?php	} ?>			
			<li>
<?php	        if($perfil=="A" || $perfil=="C"){ ?>			
						<a href="../../interface/producciones/ProduccionIndex.php" title="Producción">
<?php			}
				if($perfil=="P"){ ?>
					<a href="../../interface/producciones/ProduccionSeek.php" title="Producción">
<?php			}	?>				
				PRODUCCION</a></li>
			    
<?php	if($perfil=="A"|| $perfil=="C" ){ ?>			
			<li><a href="../../interface/entradas/EntradaIndex.php" title="Entrada de insumos">ENTRADAS</a></li>
<?php   } 
        if($perfil=="A" ){ ?>
			<li><a href="../../interface/foros/ForoList.php" title="Foro interno">FOROS</a></li>
<?php		} 
	    if($perfil=="A" || $perfil=="P"){ ?>
			<li><a href="../../interface/ventas/VentaIndex.php" title="ventas realizadas">VENTAS</a></li>
<?php	}
        if (isset($_SESSION['ses_carro'])){     //si existe no lo muestro ?>
				<li><a href="../../interface/carrito/CarritoIndex.php" title="carrito de compras">CARRITO</a></li>
<?php   } ?>
    </ul> 
<?php	
    } ?>			
  </div>
</div>		
  </body>
</html>