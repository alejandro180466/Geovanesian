<?php
include("../../dominio/Persistencia.php");
include("../../estilos/Estilo_page.php");
$perfiles=$_SESSION["ses_perfil"];
$perfil=$perfiles[0]; // perfil: administrador,promotor,cliente
?>
<html>
 <head>
  <script type="text/javascript" src="../../dominio/funciones.js"></script>
  <script languaje="javascript"> 
    function ValidarForm(form,modo){    //Validación del formulario 
		form.modo.value=modo;
		form.submit();
		return false;
	}
	</script>			
 </head>
<body>
 <DIV id="formulario">
<?php
if($_POST){
 $modo=$_POST['modo'];  
 $id=$_POST['id'];
}else{
 $modo=$_GET['modo'];
 $id=$_GET['id'];
}
if ($modo==5){ //elije el cliente y fecha del pedido
	$ssql="select num_cli, raz_cli , dir_cli , tel_cli from cliente where 1=1 order by raz_cli asc";
	$link=Conecta();
	$boton="INGRESAR";
	$titulo="INGRESO DEL PEDIDO";
}elseif($modo==2){
    $boton="MODIFICAR";
	$titulo="MODIFICAR PEDIDO";
	$sql="SELECT c.num_cli, c.raz_cli,
					 p.id_pedido , p.num_cli , p.est_pedido , p.mem_pedido , p.ent_pedido
						FROM cliente c , pedido p
							WHERE c.num_cli = p.num_cli
							  AND p.id_pedido =$id";
	$link=Conecta();
	$pedi=ejecutarConsulta($sql,$link);
	$row=mysql_fetch_array($pedi);
	Desconecta($link);
}	?>
<br></br>
<CENTER><font style="font-size:24px;"><?php echo $titulo;?></font></CENTER>
<?php
if (isset($_SESSION['ses_carro'])){     //si no esta creada la sesion la creo
		$_SESSION['ses_error']="PARA INGRESAR UN PEDIDO FINALICE EL QUE ESTA EN EL CARRITO ";
		echo $_SESSION['ses_error']; ?>
		<a href="../../interface/carrito/VerCarrito.php" title="Fimalizar el pedido">
		<img src='../../iconos/empty-shopping-cart.png' border="0"/>TERMINAR PEDIDO</a>
		<?php
		 
}else{ ?>	
    <form name="form1" action="../../dominio/pedidos/PedidoMant.php" method="POST">
    <TABLE  width="50%" CELLSPACING="1"  CELLPADDING="1"  align="center">
      <tr>
        <td>Razón social:</td>
		<td>
		  <?php	if($modo==5){ 		  
		  	  	 echo "<select name='numcli'>";
			 		   echo "<option value='' selected='selected'>sin seleccionar</option>";
			           $resultado=mysql_query($ssql); 
						while ($fila=mysql_fetch_row($resultado)){ 
							echo "<option value='$fila[0]'>$fila[1]";	
						} 
						echo "</select>";
						Desconecta($link);
				}else{ ?>
					<input type="text" value="<?php echo $row['raz_cli'];?>" size="40" maxlength="40"/>
		  <?php	} ?>	 
	    </td>
      </tr>
      <tr>
        <td>Estado: </td>
	    <td><?php if($modo==5){ ?>
					<select name="txtestado"  size="1">
						<option value=""         >seleccionar</option> 
						<option value="PENDIENTE">PENDIENTE  </option>
						<option value="PREPARADO">PREPARADO  </option>
						<option value="FACTURADO">FACTURADO  </option>
						<option value="ENTREGADO">ENTREGADO  </option>
					</select>
		
		    <?php }else{ ?>
					<select name="txtestado"  size="1">
						<option value="<?PHP echo $row['est_pedido'];?>"><?PHP echo $row['est_pedido'];?></option> 
						<option value="PENDIENTE">PENDIENTE</option>
						<option value="PREPARADO">PREPARADO</option>
						<option value="FACTURADO">FACTURADO</option>
						<option value="ENTREGADO">ENTREGADO</option>
					</select>
			<?php	} ?>
		</td>
      </tr>
      <tr>
        <td> 	  
			Fecha entrega:
		</td>
        <td>		
			<?php if($modo==5){ ?>
					<input type="text" name="fecentrega" value="" size="10" maxlength="10" />
			<?php }else{ ?>
					<input type="text" name="fecentrega" value="<?PHP echo $row['ent_pedido'];?>" size="10" maxlength="10" />
			<?php	} ?>		
		</td>
	  </tr>
	  <tr>
        <td>Comentario:</td>
	    <td><?php if($modo==5){ ?>
						<textarea rows="2" cols="31" maxlength="60" NAME="txtmemo"  
							onkeypress="return permiteconespacios(event,'num_car')">
						</textarea>
		
			<?php }else{ ?>
						<textarea rows="2" cols="31" maxlength="60" NAME="txtmemo"  
							onkeypress="return permiteconespacios(event,'num_car')">
								<?PHP echo $row['mem_pedido'];?>
						</textarea>
			<?php	} ?>
		</td> 
      </tr>
    </TABLE>
	      <input type="hidden" name="id"   value="<?php echo $id ;?>" />
          <input type="hidden" name="modo" value="<?php echo $modo ; ?>" />
 		  <center>
		   <INPUT TYPE="button" VALUE="<?php echo $boton;?>" onClick="ValidarForm(this.form,<?php echo $modo;?>)"/>
			<?php if($modo==5 ){ ?>
						<input type="reset" value="LIMPIAR" />
			<?php  } ?>		   
		  </center>
    </FORM>
<?php
}	?>
  </div>
 </body>
</html>