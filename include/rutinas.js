function check_radiobtn_valor(valor,name_radiobtn)
{
	radiobtns=document.getElementsByName(""+name_radiobtn+"");
	for ( var i = 0; i < radiobtns.length; i++ )
	{
		if(radiobtns[i].value.toUpperCase()==valor.toUpperCase())
		{
			radiobtns[i].checked=true;
		}
	}	
}
//Esta funcion recibe como parametros el valor y el nombre 
//del select, posicionando el option en el valor indicado
function seleccionar(valor,id_select) {
   var combo = document.getElementById(""+id_select+"");
   var cantidad = combo.length;
   for (i = 0; i < cantidad; i++) {
      if (combo[i].value == valor) {
         combo[i].selected = true;
      }   
   }
}
function validaRut(text)
{
	/*EXPRESIONES REGULARES*/
	var reg_rut=/[0-9]{7,8}\-[k|K|0-9]/
	
	if(!reg_rut.test(text)) { 
		return false    //no submit
    }
	//function valida_rut(crut,dv)
	/*Separamos el rut del digito verificador*/
	array_rut=text.split("-");
	//var rut=crut;
	var rut=array_rut[0];
	var largo=rut.length;
	var i=0;
	//var dv=dv;
	var dv=array_rut[1];
	var mult=2;
	var suma=0;
	largo--;
	while(largo>=0)
    {
	    suma=suma+(rut.charAt(largo)*mult);
		if(mult>6)
			mult=2;
		else
			mult++;
		largo--;
    }
	var resto = suma%11;
	var digito = 11-resto
	if(digito==10)
		digito="K" ;
	else
		if(digito==11)
			digito=0;

	if(digito!=dv.toUpperCase())
		return false;
	else
		return true;
//	return true
}
function validaEmail(text)
{
	var reg_email=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/

	if(!reg_email.test(text)) { 
       return false    //no submit
    }
	return true
}

function validaPasswordIntouch(text)
{
	var reg_pass=/[a-zA-Z0-9_\-\.]+/
	
	if(reg_pass.test(text)) { 
       return true    //no submit
    }
	reg_pass=/^\d{1,2}\/\d{1,2}\/\d{2,4}$/ /*Password del tipo fecha ejemplo 22/01/2007*/
	if(reg_pass.test(text)) { 
       return true    //no submit
    }
	return false
}
function validaAlphanumericos(text)
{
	var reg_val=/[a-zA-Z0-9_\-\.\s]+/
	
	if(reg_val.test(text)) { 
       return true    //no submit
    }
	return false
}

function validaNumericos(text)
{
	//var reg_val=/[0-9_\-\.\s]+/
	//var reg_val=^[0-9]{2,3}-? ?[0-9]{6,7}$
	var reg_val=/^([0-9])*$/
	
	if(reg_val.test(text)) { 
       return true    //no submit
    }
	return false
}

 function compare_dates(fecha, fecha2)  //compara si fecha es mayor que fecha2
   {  
     var xMonth=fecha.substring(3, 5);  
     var xDay=fecha.substring(0, 2);  
     var xYear=fecha.substring(6,10);  
     var yMonth=fecha2.substring(3, 5);  
     var yDay=fecha2.substring(0, 2);  
     var yYear=fecha2.substring(6,10);  
     if (xYear> yYear)  
     {  
         return(true)  
     }  
     else  
     {  
       if (xYear == yYear)  
       {   
         if (xMonth> yMonth)  
         {  
             return(true)  
         }  
         else  
         {   
           if (xMonth == yMonth)  
           {  
             if (xDay> yDay)  
               return(true);  
             else  
               return(false);  
           }  
           else  
             return(false);  
         }  
       }  
       else  
         return(false);  
     }  
}  
function validaFecha(text)
{
	//var reg_val=/^\d{1,2}\-\d{1,2}\-\d{2,4}$/
	var reg_val=/^\d{2}\-\d{2}\-\d{4}$/
	if(reg_val.test(text))
	{ 
		/*var fecha = new Array(); 
		fecha=text.split('-');
		if(reValidaFecha(fecha[0],fecha[1],fecha[2])==1)
			return false;
		else*/
			return true;
    }
	else
	{
		return false;	
	}
	
}

function reValidaFecha(dia,mes,anio) 
{ 
	var elMes = parseFloat(mes); 
	if(anio<2007)
		return 1;
	if(elMes>12) 
		return 1; 
	// MES FEBRERO 
	if(elMes == 2){ 
		if(esBisiesto(anio)){ 
			if(parseInt(dia) > 29){ 
				return 1; 
			} 
		else 
			return 0; 
	} 
	else
	{ 
		if(parseInt(dia) > 28){ 
			return 1; 
		} 
		else 
		return 0; 
		} 
	} 
	//RESTO DE MESES 
	if(elMes== 4 || elMes==6 || elMes==9 || elMes==11){ 
		if(parseInt(dia) > 30){ 
			return 1; 
		} 
	} 
	return 0; 
} 
//***************************************************************************************** 
// esBisiesto(anio) 
// 
// Determina si el año pasado com parámetro es o no bisiesto 
//***************************************************************************************** 
function esBisiesto(anio) 
{ 
	var BISIESTO; 
	if(parseInt(anio)%4==0){ 
		if(parseInt(anio)%100==0){ 
			if(parseInt(anio)%400==0){ 
				BISIESTO=true; 
			} 
			else{ 
				BISIESTO=false; 
			} 
		} 
		else{ 
			BISIESTO=true; 
		} 
	} 
	else 
	BISIESTO=false; 
	
	return BISIESTO; 
} 

/*FUNCION TRIM PARA JSCRIPT*/
function trim(str)
{
  return( (""+str).replace(/^\s*([\s\S]*\S+)\s*$|^\s*$/,'$1') );
} 

function formatNumber(num,prefix){
	num_split=(num.toString()).split(".");
	
	decimal="";
	if(!isNaN(parseInt(num_split[1])))
	{
		num=num_split[0].toString();
		decimal=","+num_split[1].toString();
	}
	else
		num=num.toString();
	i=num.length;
	numero=""
	while(i>0)
	{
		if(i==num.length)
			numero=num.substring(i-3, i);
		else
			numero=num.substring(i-3, i)+"."+numero;
		i=i-3;
	}
	return prefix+" "+numero+decimal;
}

var cuenta=0;
function checkea_form()
{
	document.getElementById("txtRut").value=trim(document.getElementById("txtRut").value);
	document.getElementById("txtDv").value=trim(document.getElementById("txtDv").value);
	if(trim(document.getElementById("txtRut").value)=="" || trim(document.getElementById("txtDv").value)=="")
	{
		alert("Debe ingresar el RUT ó DV");
		document.getElementById("txtRut").value=trim(document.getElementById("txtRut").value);
		document.getElementById("txtDv").value=trim(document.getElementById("txtDv").value);
		document.getElementById("txtRut").focus();
		return;
	}
	
	document.getElementById("txtRut").value=trim(document.getElementById("txtRut").value);
	document.getElementById("txtDv").value=trim(document.getElementById("txtDv").value);
	if(!validaRut(document.getElementById("txtRut").value+'-'+document.getElementById("txtDv").value))
	{
		alert("El RUT ingresado no es válido");
		document.getElementById("txtRut").focus();
		return;
	}

	document.getElementById("txtNombre").value=trim(document.getElementById("txtNombre").value);
	if(trim(document.getElementById("txtNombre").value)=="")
	{
		alert("Debe ingresar el Nombre");
		document.getElementById("txtNombre").value=trim(document.getElementById("txtNombre").value);
		document.getElementById("txtNombre").focus();
		return;
	}

	document.getElementById("txtPaterno").value=trim(document.getElementById("txtPaterno").value);
	if(trim(document.getElementById("txtPaterno").value)=="")
	{
		alert("Debe ingresar el Apellido Paterno");
		document.getElementById("txtPaterno").value=trim(document.getElementById("txtPaterno").value);
		document.getElementById("txtPaterno").focus();
		return;
	}

	document.getElementById("txtFecNac").value=trim(document.getElementById("txtFecNac").value);
	if(!validaFecha(document.getElementById("txtFecNac").value))
	{
		alert("La fecha de nacimiento ingresada no es válida");
		document.getElementById("txtFecNac").focus();
		return;
	}

	document.getElementById("txtEmail").value=trim(document.getElementById("txtEmail").value);
	if(!validaEmail(document.getElementById("txtEmail").value))
	{
		alert("El email ingresado no es válido");
		document.getElementById("txtEmail").focus();
		return;
	}

	document.getElementById("txtTelefono").value=trim(document.getElementById("txtTelefono").value);
	if(!validaNumericos(document.getElementById("txtTelefono").value))
	{
		alert("El teléfono ingresado no es válido");
		document.getElementById("txtTelefono").focus();
		return;
	}

	document.getElementById("txtCelular").value=trim(document.getElementById("txtCelular").value);
	if(!validaNumericos(document.getElementById("txtCelular").value))
	{
		alert("El teléfono ingresado no es válido");
		document.getElementById("txtCelular").focus();
		return;
	}

	document.getElementById("txtFecInsc").value=trim(document.getElementById("txtFecInsc").value);
	if(!validaFecha(document.getElementById("txtFecInsc").value))
	{
		alert("La fecha de inscripción ingresada no es válida");
		document.getElementById("txtFecInsc").focus();
		return;
	}

	
	/*Evito el reenvio del formulario*/
	if (cuenta == 0)
		cuenta++;
	else
	{
		/*alert("Formulario ya enviado");
		return;*/
	}
	if(confirm("¿Desea enviar los datos para agregar esta nueva carga?"))
	{
		document.getElementById("form1").submit();
	}
}

function checkea_form_update()
{
	document.getElementById("txtNombre").value=trim(document.getElementById("txtNombre").value);
	if(trim(document.getElementById("txtNombre").value)=="")
	{
		alert("Debe ingresar el Nombre");
		document.getElementById("txtNombre").value=trim(document.getElementById("txtNombre").value);
		document.getElementById("txtNombre").focus();
		return;
	}

	document.getElementById("txtPaterno").value=trim(document.getElementById("txtPaterno").value);
	if(trim(document.getElementById("txtPaterno").value)=="")
	{
		alert("Debe ingresar el Apellido Paterno");
		document.getElementById("txtPaterno").value=trim(document.getElementById("txtPaterno").value);
		document.getElementById("txtPaterno").focus();
		return;
	}

	document.getElementById("txtFecNac").value=trim(document.getElementById("txtFecNac").value);
	if(!validaFecha(document.getElementById("txtFecNac").value))
	{
		alert("La fecha ingresada no es válida");
		document.getElementById("txtFecNac").focus();
		return;
	}

	document.getElementById("txtEmail").value=trim(document.getElementById("txtEmail").value);
	if(!validaEmail(document.getElementById("txtEmail").value))
	{
		alert("El email ingresado no es válido");
		document.getElementById("txtEmail").focus();
		return;
	}

	document.getElementById("txtTelefono").value=trim(document.getElementById("txtTelefono").value);
	if(!validaNumericos(document.getElementById("txtTelefono").value))
	{
		alert("El teléfono ingresado no es válido");
		document.getElementById("txtTelefono").focus();
		return;
	}

	document.getElementById("txtCelular").value=trim(document.getElementById("txtCelular").value);
	if(!validaNumericos(document.getElementById("txtCelular").value))
	{
		alert("El teléfono ingresado no es válido");
		document.getElementById("txtCelular").focus();
		return;
	}

	document.getElementById("txtFecInsc").value=trim(document.getElementById("txtFecInsc").value);
	if(!validaFecha(document.getElementById("txtFecInsc").value))
	{
		alert("La fecha ingresada no es válida");
		document.getElementById("txtFecInsc").focus();
		return;
	}

	
	/*Evito el reenvio del formulario*/
	if (cuenta == 0)
		cuenta++;
	else
	{
		/*alert("Formulario ya enviado");
		return;*/
	}
	if(confirm("¿Desea enviar los datos para modificar esta carga?"))
	{
		document.getElementById("form1").submit();
	}
}