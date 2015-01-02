// JavaScript Document
function sinespacioblanco(cadena){
	k=" ";
	for (j=0;j<cadena.length;j++){
		if (k.indexOf(cadena.charAt(j)) != -1){
			return true;
		}
	}
	return false;
}
//-------------------------------------
function sinespacioinicial(cadena){
	k=" ";
	if (k.indexOf(cadena.charAt(0)) != -1){
		return true;
	}
	return false;
	
}
//-------------------------------------
function permite(elEvento, permitidos) {
    // Variables que definen los caracteres permitidos
    var numeros = "0123456789";
	var numerosd = "0123456789.";
    var caracteres = "aáíóúébcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    var numeros_caracteres = numeros + caracteres;
	var fechas = "0123456789-";
    var teclas_especiales = [8, 37, 39, 46];
    // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
  
    // Seleccionar los caracteres a partir del parámetro de la función
    switch(permitidos) {
     case 'num':
      permitidos = numeros;
      break;
	 case 'car':
      permitidos = caracteres;
      break;
     case 'num_car':
      permitidos = numeros_caracteres;
      break;
	 case 'fec':
	  permitidos = fechas;
	  break;	
    }
 
     // Obtener la tecla pulsada 
     var evento = elEvento || window.event;
     var codigoCaracter = evento.charCode || evento.keyCode;
     var caracter = String.fromCharCode(codigoCaracter);
 
    // Comprobar si la tecla pulsada es alguna de las teclas especiales
    // (teclas de borrado y flechas horizontales)
    var tecla_especial = false;
    for(var i in teclas_especiales) {
    if(codigoCaracter == teclas_especiales[i]) {
      tecla_especial = true;
      break;
    }
  }
  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
  // o si es una tecla especial
  return permitidos.indexOf(caracter) != -1 || tecla_especial;
}
//--------------------------------------
function permiteconespacios(elEvento, permitidos) {
    // Variables que definen los caracteres permitidos
    var numeros = "0123456789";
    var caracteres = " abcdefghijklmnñopqrstuvwxyzáíóúéABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    var numeros_caracteres = numeros + caracteres;
    var teclas_especiales = [37, 39, 46];
    // 8 = BackSpace, 46 = Supr, 37 = flecha izquierda, 39 = flecha derecha
  
    // Seleccionar los caracteres a partir del parámetro de la función
    switch(permitidos) {
     case 'num':
      permitidos = numeros;
      break;
     case 'car':
      permitidos = caracteres;
      break;
     case 'num_car':
      permitidos = numeros_caracteres;
      break;
    }
 
     // Obtener la tecla pulsada 
     var evento = elEvento || window.event;
     var codigoCaracter = evento.charCode || evento.keyCode;
     var caracter = String.fromCharCode(codigoCaracter);
 
    // Comprobar si la tecla pulsada es alguna de las teclas especiales
    // (teclas de borrado y flechas horizontales)
    var tecla_especial = false;
    for(var i in teclas_especiales) {
    	if(codigoCaracter == teclas_especiales[i]) {
      		tecla_especial = true;
      		break;
    	}
  	}
  // Comprobar si la tecla pulsada se encuentra en los caracteres permitidos
  // o si es una tecla especial
  return permitidos.indexOf(caracter) != -1 || tecla_especial;
}
//----------------------------------------
function esnumeroentero(cadena){
		k="0123456789";
		for (j=0;j<cadena.length;j++){
			if (k.indexOf(cadena.charAt(j)) == -1){
				return false;
			}
		}
	return true;
}
//---------------------------------------
function esfechavalida(cadena){
		k="0123456789-";
		for (j=0;j<cadena.length;j++){
			if (k.indexOf(cadena.charAt(j)) == -1){
				return false;
			}
		}
	return true;
}
//----------------------------------------
function validomail(email){
		var ret=true;
				var chars= new String("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-.@");
		var mail= new String(email);
		
		if (email==""){
			eMail.focus();
			alert("El campo mail es un campo oblligatorio")
			return false;
		}		
		
		var i;
		for (i=0; i<mail.length; i++){
			if ( chars.indexOf( mail.charAt(i) )==-1 ){  // La letra del mail no está en chars ?
				ret=false;
			}
		}
		
		if ( chars.indexOf(mail.charAt(0))>61 ){  // 1 letra es un simbolo ?
			ret=false;
		}
		var arroba=mail.indexOf("@")
		if (arroba==-1){  // Sin @ ? (se que no está en 1er posicion)
			ret=false;
		}
			
		var cuenta= mail.substring(0,arroba);
		var restoMail= new String( mail.substring(arroba+1,mail.length) );
			
		arroba= restoMail.indexOf("@")
		if (arroba!=-1){  // Tiene @ ?
			ret=false;
		}
		punto= restoMail.indexOf(".");
		if (punto==-1 || punto==0){  // Sin . o . pegado al @ ?
			ret=false;
		}
		var servidor= restoMail.substring(0,punto);
		var dominio= new String( restoMail.substring(punto+1,restoMail.length) );
			
		if (dominio.length<2){  // Dominio con menos de 2 letras ?
			ret=false;
		}
		if (dominio.charAt(0)=="." || dominio.charAt(dominio.length)=="."){  // 1er y ultima letra del dominio = . ?
			ret=false;
		}
		if(!ret){
			alert("El formato de mail no es valido");
		}
		return ret;
	}
//-----------------------------------	
function confirma(){
  ret=false; 	 
  if (confirm("¿Estas seguro de enviar este formulario?")){
     ret=true;         
  }
  return ret;
}
//-----------------------------------
function IsNumeric(value) {
    var log=value.length;
    var sw="S";
    for (x=0; x<log; x++) {
		v1=value.substr(x,1);v2 = parseInt(v1);
        if (isNaN(v2)) {
			sw= "N";
		}//check if numeric value
    }
    if (sw=="S") {
		return true;
	}else {
		return false;
	}
}

//llamar a esta funcion solo si la fecha no es vacia
function Validafecha(fecha){
	var ret=true;
	var posible=fecha;
	// controlar largo de la cadena sea igual a 10
	var recibo= new String(posible);
	//recibo = posible;
	if(recibo.length!=10){
		alert('LA FECHA NO TIENE DIEZ CARACTERES DE LARGO :');
		ret=false;
		return ret;
	}
	//controlo que los caracteres sean validos
	var tipo='fec';
	var caracteresok = esfechavalida(posible); 	
	if (caracteresok!=true){
		 alert('DEBE INGRESAR SOLO NUMEROS Y GUIONES -');
		 ret=false;
		 return ret;
	}
    //controlar 3 secuencias numericas entre barras
	var cifras = recibo.split("-");
	var numerocifras=cifras.length;
	if(numerocifras!=3){
		 alert('DEBE INGRESAR TRES CIFRAS, SEPARADAS POR GUIONES  ANIO - MES - DIA ');
		 ret=false;
		 return ret;
	}
	var anio= cifras[0];	var mes = cifras[1];	var dia = cifras[2];
	var hoy=new Date();
	
	var aniohoy = hoy.getFullYear();
	var aniohoy = aniohoy.toString();
	
	var meshoy  = hoy.getMonth()+1;
	if(meshoy<10){
		var meshoy  = "0"+meshoy.toString();
	}else{
		var meshoy  = meshoy.toString();
	}
	
	var diahoy  = hoy.getDate();
	if(diahoy<10){
		var diahoy  = "0"+diahoy.toString();
	}else{
		var diahoy = diahoy.toString();
	}
	var hoyes = +aniohoy+"-"+meshoy+"-"+diahoy;
	
	//controla el año
	if (anio.length!=4){
		 alert('EL AÑO DEBE SER DE 4 NUMEROS');
	}else{
		var numanio=cifras[0];
		if((numanio<1901) || (numanio>hoy.getFullYear())){
			 alert("EL AÑO DEBE SER MAYOR A 1901 Y MENOR O IGUAL AL ACTUAL");
			 ret=false;
		}
    }
	//controlar el mes
	if (mes.length!=2){
		 alert('EL MES DEBE SER DE 2 DIGITOS');
	}else{
		var nummes=cifras[1];
		if((nummes<1) || (nummes>12)){
			 alert('EL MES DEBE ESTAR ENTRE 1 A 12');
			 ret=false;
		}
	}
	//controlar el dia
	if (dia.length!=2){
		 alert('EL DIA DEBE SER DE 2 DIGITOS');
		 ret=false;
	}else{
		var numdia=cifras[2];
		if((numdia<1) || (numdia>31)){
			 alert('EL DIA DEBE ESTAR ENTRE 1 Y 31');
			 ret=false;
		}
	}
	//controlar que la fecha sea futura
	if(recibo>hoyes){
		alert('LA FECHA DE BUSQUEDA NO DEBE SER A FUTURO');
		ret=false;
	}	
	    	  
  return ret;
}