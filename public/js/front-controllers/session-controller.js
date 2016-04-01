/* 
 * Copyright (C) 2016 Jaime Diaz <jaimeivan0017@gmail.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
/**
 * 
 * @returns {undefined}
 */
$(function ()
{    
    //VARIABLES GLOBALES *************
    var bandGlobalValidation = false; //<== unicamente valida PASS Y RE-PASS
    var bandColsAjax = false;
    var errorMessage = "";
    
    // INSTANCIACION *****************
    objScopeApp = new ScopeApplication(retornarURL());
    console.log("URL PRECONFIGURADA: " + objScopeApp.getPathScopeApplication());
    
    //clase que gestiona las peticiones AJAX
    objRequests = new CLS_ajaxRequest();//LISTENER PARA DETECTAR EVENTOS EN TIEMPO REAL <KEYDOWN, KEYUP> ]--------------
  
});

$('#id-window-userOptions li').click(function ()
{
    var option = $(this).data("option");
    //alert("click en los options");
    switch (option)
    {
        case "opt-logout":
            
                alertify.confirm("¿Realmente desea cerrar la sesion activa?", function (e) {
                    if (e) {
    //                        alertify.success("You've clicked OK");
                            showMessage('Se serrara la sesion activa...', MENSAJE_INFORMACION);
                            setTimeout(function(){
                                //window.location.href= rootPathApp + "/Index/destroySessionApp";
                                objRequests.destroyFullSession(
                                    objScopeApp.getPathScopeApplication());
                            }, 2000);

                    } else {
                            alertify.error("Se cancelo el cierre de la sesion activa");
                    }
            });
                                    
        break;
    }
});
// EVENTOS EN LOS DISTINTOS FORMULARIOS DE PRE::CARGA::SESSION
$("div.cls-floating-window form input").on("blur keyup keydown", function (event)
{
    console.log("ENTRANDO AL LISTENER ROOT");
    //obteniendo el padre del formulario [ EL PRIMERO ]
    var currentForm = $(this).parent()[0];
    var formName = currentForm.name;
    //Nombre del evento actual *****************************
    var eventName = event.type;
    console.log("EVENTO: " + eventName);
    // PRINT - TEST
    console.log("nombre del formulario actual: " + formName);

    switch (formName)
    {
        case "frm-signIn-sesion":

        break;
        //----------------[ CASO :: REGISTRAR USER ]----------------------------
        case "frm-signUp-sesion":
            //validando el type Event *******************
            if (eventName == "blur")
            {
                console.log("LISTENER USER AND MAIL");
                //  VALIDANDO EL USERNAME :: DB ****************************
                var userNameComponent = currentForm.querySelector("[name=txt-userName-nw]");
                var usernameValue = userNameComponent.value;
                
                //*********** VALIDANDO USERNAME ] ---------------
                if ( usernameValue != '' && usernameValue != null)
                {
                    //usernameValue = "a";
                    //validando mediante ajax
                    objRequests.validateUniqueColumn(userNameComponent, usernameValue, "User", "validarExistenciaUsername", 
                        objScopeApp.getPathScopeApplication(), "username");                    
                }

                
                //EMAIL INPUT
                var inputEmail = currentForm.querySelector("[name=txt-email-nw]");
                //valueInput::
                var valueInputParam = inputEmail.value;
                //progamacion defensiva para cuando sea la primer vez: ]--------
                if (valueInputParam != '' && valueInputParam != null)
                {
                    //valueInputParam = "a";
                    //instanciar AJAX::REQUEST, PASAR PARAMETROS URL, VALOR EMAIL, JQUERYOBJ (INPUT)
    //                objRequests.validarEmailAJAXRequest(valueInputParam, inputEmail, 
    //                    objScopeApp.getPathScopeApplication());
                    objRequests.validateUniqueColumn(inputEmail, valueInputParam, "User", "validarExistenciaEmail", 
                        objScopeApp.getPathScopeApplication(), "email");                    
                }

            }        
            //-----[ PASSWORD AND RE-PASSWORD ] ****************************
            console.log("LISTENER PASS Y RE PASSWORD");
            //PASSWORD INPUTS
            var pass = currentForm.querySelector("[name=txt-password-nw]");
            var Rpass = currentForm.querySelector("[name=txt-Rpassword-nw]");

            if (pass.value != '' && Rpass.value != '')
            {
                //validando si son identicas::
                if (pass.value == Rpass.value)
                {
                    $(pass).removeClass("inputWrong").addClass("inputCorrect");
                    $(Rpass).removeClass("inputWrong").addClass("inputCorrect");
                    bandGlobalValidation = true;
                    
                } else {
                    $(pass).removeClass("inputCorrect").addClass("inputWrong");
                    $(Rpass).removeClass("inputCorrect").addClass("inputWrong");
                    errorMessage = "Los passwords no coinciden";
                    bandGlobalValidation = false;
                }
            }
            console.log("keyup property: " + pass + " <= " + Rpass);
                            
        break;
        
        //---------------------[ RECUPERACION DEL CORREO ]----------------------
        case "frm-recover-sesion":

        break;
    }
});

//-------------[ NAVEGACION ENTRE ELEMENTOS DE SESSION ]------------------------
$('div.cls-small-text span').click(function(event)
{

    var thisComponent = $(this);
    var tabSession = thisComponent.data("tab");
    console.log("mostrar: " + tabSession);
    
    var tabElem = thisComponent.parent().parent().data("tab");
    console.log("ocultar: " + tabElem);
    
//    $("div.cls-floating-window .tab[data-tab='" + tabElem + "']").css("display", "none");
//    $("div.cls-floating-window .tab[data-tab='" + tabSession + "']").css("display", "block");
    $("div.cls-floating-window .tab[data-tab='" + tabElem + "']").hide("fast");
    $("div.cls-floating-window .tab[data-tab='" + tabSession + "']").show("slow");
});

//LISTENER PARA SABER EN QUE FORMULARIO SE HIZO CLICK ]-------------------------
$("div.cls-floating-window form").submit(function(event)
{
    event.preventDefault();
    
    var dataJson = {};
    var ready = false;
    //alert("click");
    var currentForm = $(this)[0];
    var inputs = currentForm.querySelectorAll("input");    
    //OBTENIENDO EL NOMBRE DEL FORMULARIO:
    var formName = currentForm.name;
    //*****************************
    //     [  EJECUCION DEL TRIGGER  ]
    $(inputs).each( function () 
    {
        //funcion a ejecutatar
        //$(this).trigger("blur"); 
        /*
         * al ejecutarse secuencialmente el ultimo siempre retornara false
         */
        //por cada recorrido si hay algun campo en rojo ::
        if ($(this).hasClass("inputWrong"))
        {
            bandGlobalValidation = false ; bandColsAjax = false;
        }
    });
    
    switch (formName)
    {
        //-------------[ INCIAR SESION ]----------------------------------------
        case "frm-signIn-sesion":
           console.log("lógica de login") ;
           //ready = true;
           dataJson = processDataForm(currentForm);
           
           //PROCESAR LOS DATOS A ENVIAR POR POST ]-----------------------------
           var dataSessionResponse = processDataPOSTRegister( dataJson , 'initSession');
           console.log(dataSessionResponse);
           

           //REALIZAR PETICION AJAX AL CONTROLADOR PHP
           objRequests.iniciarSessionAJAXRequest(currentForm, dataSessionResponse
                   , objScopeApp.getPathScopeApplication());
        break;
        //-------------[ REGISTRAR ]--------------------------------------------
        case "frm-signUp-sesion":
            console.log("lógica de register") ;
            
            //validar si todo esta OK ? ******
            if ( bandGlobalValidation && bandColsAjax )
            {
                ready = true;
                dataJson = processDataForm(currentForm);
                //procesar nuevamente los datos a enviar con los indices originales:
                var dataResponse = processDataPOSTRegister( dataJson , 'register');
               
                //una vez obtenidos los indices, eliminar los sobrantes
                //var unqDataResponse = deleteColsInArrayObject({0:"names",1: "rpassword"}, dataResponse);
                delete dataResponse.names;
                delete dataResponse.rpassword;
                //var res = deleteColsInArrayObjectSingle({0: "names", 1: "rpassword"}, dataResponse);
                //-------[ EXPERIMENTAL TMP ]---------
                dataResponse["fechaCreacion"] = 'dataVoid';
                //-------[ END EXPERIMENTAL ]---------                                 
                console.log(dataResponse);
                //realizar la peticion AJAX
                var actionRes = objRequests.registrarUsuarioAJAXRequest(dataResponse, 
                    objScopeApp.getPathScopeApplication());
                    
                console.log(actionRes);
            } 
            else 
            {
                alert (errorMessage);
            }
            //********************************
            
        break;
        //------------[ RECUPERACION PASSWORD ]---------------------------------
        case "frm-recover-sesion":
            console.log("lógica de recover") ;
            ready = true;
        break;    
    }
    
    if (ready) 
    {
        
    }
    //objeto JSON void
//    var data = {};
    
//    $(inputs).each(function () {
//        console.log($(this).context.type);
//        
//        // siempre y cuando NO sea un boton el input a evaluar
//        if ( $(this).context.type != "submit" ){
//            var attr = $(this).context.name;
//            data[attr] = $(this).context.value;
//        }
//        
//        //datos del formulario:
//        console.log(data);
//    });
});
//*****************************[ PROCCESS DATA - CONVERTER ] *******************
function deleteColsInArrayObjectSingle ( arrayIn, arrayResponse)
{
    var arr = arrayIn;
    
    $.each( arr, function (index, content)
    {
        delete arrayResponse.content;
    });
    return arrayResponse;
}
function deleteColsInArrayObject ( arrayIn, arrayFull ){
    
    var array = arrayIn;
    var size = Object.keys(array).length;
    var cont = 0;
    
    $.each(array, function (indexI, contentI)
    {
        console.log ("indice: " + indexI + " ,contenidoI:  " + contentI);
        $.each(arrayFull, function (indexJ, contentJ)
        {
               if ( contentI == indexJ )
               {
                   var tmp = contentI;
                   console.log("elementos iguales, eliminar!: " + indexJ);
                    delete arrayFull.tmp;
                   
               }
        });                
    });
    return arrayFull ;
}
function processDataPOSTRegister ( dataJsonInput, typeAction )
{
    var contador = 0;
    var dataJsonRes = {};
    var newIndex = {};
    
    if (typeAction == 'register')
    {
        newIndex = {0: "names", 1: "username", 2: "password", 3: "rpassword", 4: "email"};
    }
    else if (typeAction == 'initSession')
    {
        newIndex = {0: "username", 1: "password"};
    }
      
    console.log(Object.keys(newIndex).length);
    $.each( dataJsonInput, function (index, content)
    {
        console.log("indice: " + index + " , contenido: " + content);
        var indexTmp = '';
        
        indexTmp = index.replace(index, newIndex[contador]);
        console.log(indexTmp);
        
        dataJsonRes[indexTmp] = content;
        contador ++;
    });
    
    return dataJsonRes;
}
//******************************************************************************
function processDataForm ( form )
{
    var inputs = form.querySelectorAll("input");
    var data = {};
    // recorriendo los inputs *****************
    $(inputs).each(function () 
    {
        //console.log($(this).context.type);
        var input = $(this);
        // siempre y cuando NO sea un boton el input a evaluar
        if ( input.context.type != "submit" ){
            var attr = input.context.name;
            data[attr] = input.context.value;
        }        
        //datos del formulario:
//        console.log(data);
    });
    return data;
}
//--------------------------- [ CLASES PROTOTIPADAS ]---------------------------
//function ScopeApplication(urlApplication){
//    
//    if (urlApplication != ''){
//        this.urlMain = urlApplication;
//    }
//}
//// METODO QUE OBTIENE LA URL A PROCESAR EN EL SERVIDOR A TRAVES DE AJAX
//ScopeApplication.prototype.getPathScopeApplication = function(){
//    return this.urlMain;
//}
////******************************************************************************

//CLASE REQUEST:: ]-------------
function CLS_ajaxRequest (){
    
}
//METODO GENERICO QUE REALIZA VARIAS PETICIONES **************************
CLS_ajaxRequest.prototype.validateUniqueColumn = 
        function (inputComponent, valueInput, controller, method, rootPath, nameColumn)
{
    var path = rootPath;
    var controlador = controller;
    var metodo = method;
    var inputC = inputComponent;
    var valueInput = valueInput;
    var colName = nameColumn;
    // PROMISE *****************
    var promiseRequest = $.ajax(
    {
        method: 'GET',
        dataType: 'json',
        url: path + controlador + "/" + metodo + "/" + valueInput,        
        success: function (response)
        {
            var res = response.success;
            //VALIDANDO **************
            if (res == true)
            {
                //EXISTE! NO DEBE DEJAR REGISTRAR
                $(inputC).removeClass("inputCorrect").addClass("inputWrong");
                errorMessage = "el campo " + colName + " ya se encuentra registrado";
                bandColsAjax = false;
            } 
            else
            {
                //NO EXISTE! DEBE DEJAR REGISTRAR
                $(inputC).removeClass("inputWrong").addClass("inputCorrect");                
                bandColsAjax = true;
            }
        },
        error: function ()
        {
            
        }
    });
}
CLS_ajaxRequest.prototype.iniciarSessionAJAXRequest =
        function (currentForm, dataPostSession, pathApplication)
{
    var path = pathApplication;
    var data = dataPostSession;
    var form = currentForm;
    
    var userNameComponent = form.querySelector("[name=txt-userName]");
    var passwordComponent = form.querySelector("[name=txt-password]");    
    
    var promiseSessionAJAX = $.ajax(
    {
        url: path + 'User/iniciarSessionUsuario',
        type: 'POST',
        dataType: 'json',
        data: data,
        
        success: function (response)
        {
            var res = response;            
            console.log(res);
            
           // si el username es erroneo
           if (res.username == false)
           {
               $(userNameComponent).removeClass("inputCorrect").addClass("inputWrong");
               errorMessage = "El username es incorrecto!";
               bandGlobalValidation = false;
           }
           //si el password es erroneo
           if (res.password == false)
           {
               $(passwordComponent).removeClass("inputCorrect").addClass("inputWrong");
               errorMessage = "el password es incorrecto!";
               bandGlobalValidation = false;
           }
           //-------------[ VALIDANDO SESSION EXITOSA ]-------------------------
           if ((res.password == true) && (res.username == true))
           {
               bandGlobalValidation = true;
               //preguntar si estan con el estilo incorrecto::
               if ($(userNameComponent).hasClass("inputWrong")){
                   $(userNameComponent).removeClass("inputWrong").addClass("inputCorrect");
               }
               if ($(passwordComponent).hasClass("inputWrong")){
                   $(passwordComponent).removeClass("inputWrong").addClass("inputCorrect");
               }
               alertify.alert("datos correctos! se iniciará la sesion");    
               //recargar page**********
                setTimeout(function()
                {
                    location.reload();
                },2000);
               
           }
        },
        error: function (response)
        {
            
        }
    });
    
}
//Metodo que realiza el registro del usuario via AJAX **************************
CLS_ajaxRequest.prototype.registrarUsuarioAJAXRequest =
        function (dataPost, pathApplication){
    //variables globales de metodo
    var dataPostArr = dataPost;
    var path = pathApplication;
    var actionResponse = false;
    
    var promiseRegisterAJAX = $.ajax(
    {
        url: path + "User/registrarNuevoUsuario/",
        data: dataPostArr,
        type: 'POST',
        dataType: 'json',
        //respuesta
        /*
         * sino se define dataType: 'json' la respuesta se captaria asi:
         * (res)
         * JSON.parse(r)
         * if (r.error){...}
         */
        success: function (response)
        {
            //error, getID, msg  <= vars response
            var res = response.error;
            if (res == 0)
            {
                console.log('Response: ' + response.msg);
                actionResponse = true;
                //redireccionamiento
                alertify.alert("Registro exitoso! Iniciara sesion...");
                setTimeout(function ()
                {
                    //recarga de la pagina
                    location.reload();
                },2000);                
            } 
            else 
            {
                console.log('Response: ' + response.msg);
            }
        },
        error: function ()
        {
            
        }
    });
     //RETORNANDO ACCION DE RESPUESTA POST:: AJAX
     return actionResponse;
}
//Metodo para validar la existencia de correo electronico
CLS_ajaxRequest.prototype.validarEmailAJAXRequest = 
        function (mailValue, mailComponent, pathApplication) {
//    event.preventDefault();
    var path = pathApplication;
    var email = mailValue;
    var inputMail = mailComponent;
    
    var emailValAJAXPromise = $.ajax({
        method: 'GET',
        dataType: 'json',
        url: path + 'User/validarExistenciaEmail/' + email,
        
        //response from server :: User_controller / method
        success: function (respuesta)
        {    
            var res = respuesta.success;
            //VALIDACION
            if (respuesta.success == true){
                console.log("existe");
                $(inputMail).removeClass("inputWrong").addClass("inputCorrect");
            }else {
                console.log("NO existe");
                $(inputMail).removeClass("inputCorrect").addClass("inputWrong");
            }
        },
        error: function (){
            
        }
    }).always (function (){

    });
}
//DESTRUIR LA SESSION ]---------------------------------------------------------
CLS_ajaxRequest.prototype.destroyFullSession = function (pathApplication)
{
    var path = pathApplication;
    
    var promiseAJAXDestroy = $.ajax(
    {
        url: path + 'User/destruirSessionGlobal/',
        type: 'GET',
        
        success: function(response){
            var res = response;
            console.log(res);
            location.reload();
        }
    });
}
