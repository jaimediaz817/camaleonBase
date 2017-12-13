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
$('div#pre-load-web').addClass("loaderMainPage");
//VARIABLES GLOBALES *************
var bandGlobalValidation = false; //<== unicamente valida PASS Y RE-PASS
var bandColsAjax = false;
var errorMessage = "";
var con = 0;
var heightBody;



function ajustarFloatingWindow(altoVentana)
{
    var alto = altoVentana;    
    var ventanaFloat ;
    
    if ($('div.cls-floating-window').length > 0){
        console.log("es visible FLOAT");
        ventanaFloat = $('div.cls-scrollingWindow');
    }else{
        console.log("no esta visible el FLOAT");
    }
    
    if (alto < 390){
        ventanaFloat.css({"height": "70vh"});
        console.log("menor a 390");
    }else{
        ventanaFloat.css({"height": "auto"});
        console.log("> a 390");
    }
}



$(function ()
{    
    
    // INSTANCIACION *****************
    objScopeApp = new ScopeApplication(retornarURL());
    console.log("URL PRECONFIGURADA: " + objScopeApp.getPathScopeApplication());
    
    //clase que gestiona las peticiones AJAX
    objRequests = new CLS_ajaxRequest();//LISTENER PARA DETECTAR EVENTOS EN TIEMPO REAL <KEYDOWN, KEYUP> ]--------------
  
    objDataGridComponent = new CLASS_DatagridComponent();
    //-----------------------[ TABLE :: PAGINATION ]----------------------------      
    //eliminamos el scroll de la pagina
    $("body").css({"overflow-y":"hidden"});
    //guardamos en una variable el alto del que tiene tu browser que no es lo mismo que del DOM
    //var alto=$(window).height();
    //agregamos en el body un div que sera que ocupe toda la pantalla y se muestra encima de todo
    //$("body").append('<div id="pre-load-web"></div>'); 
    //le damos el alto 
    
    /*
     *     width: 100%;
    /* height: 100% !important; */
    /* margin-top: 0; */
    /* background: grey; 
    background: rgba(1,1,1,0.5) url("http://localhost:8081/conkretemos-SAS-sistemaComercial-BETA/public/assets/images/loaders/default.svg") no-repeat center;
    position: absolute;
     */
    //$('div#id-band-container').append('<div class = "band-status-action" id="success"><span class="icon-info"></span><p></p><span class="icon-cross"></span></div><div class = "band-status-action" id="error"><span class="icon-info"></span><p></p><span class="icon-cross"></span></div></div>');
    
    

   $("div#pre-load-web").append('<img src="'+ objScopeApp.getPathScopeApplication() +'public/assets/images/loaders/default.svg">');
   //esta sera la capa que esta dento de la capa que muestra un gif 
   //$("#imagen-load").css({"margin-top":(alto/2)-30+"px"}); 
   heightBody = $('body').height();
   ajustarFloatingWindow(heightBody);
   console.log("desde la carga de jquery:: alto : " + heightBody);
   
   
   
   
   //BOTON FLOTANTE ]-----------------------------------------------------------
    $("ul.dropdown-menu").mouseover(function(){
//            console.log("SOBRE EL FOCO");
    });

    $("ul.dropdown-menu").mouseout(function(){
            //alert("El ratón ya no está sobre el texto");
//            console.log("YA NO ESTA EL FOCO");
//            if ($('div.open').length > 0){
//                console.log("estan desplegadas las opciones");
//                //$('div#id-floatButtonLeft').removeClass("open");
//            }
//        var leftFloat = $('div#id-floatButtonLeft').css("left");
//        console.log("izquierda: " + leftFloat);
//        if (leftFloat < 0){
//            console.log("el left es MENOR 0");
//        }else{
//            console.log("el left es MAYOR 0");
//        }
            
    });   
    
    $('ul.dropdown-menu').mouseleave(function(){
        console.log("MOUSE FUERA DEL FOCO");
        var leftFloat = $('div#id-floatButtonLeft').css("left");
        console.log("izquierda: " + leftFloat);
        
        $('ul.dropdown-menu').css({"-moz-transition":"left 600ms linear 0s"});
        $('ul.dropdown-menu').css({"-webkit-transition":"left 600ms linear 0s"});
        $('ul.dropdown-menu').css({"-o-transition":"left 600ms linear 0s"});
        $('ul.dropdown-menu').css({"transition":"left 600ms linear 0s"});
        //REMOVER LA CLASE OPEN
        $('div#id-floatButtonLeft').removeClass("open");
//        $('div#id-floatButtonLeft').fadeOut("slow", function(){
//            $(this).removeClass("open");
//        });
    });

   
});

$(window).load(function() 
{
    //alert("carga total");
    $('div#pre-load-web').fadeOut(4500);
    
    //permitimos scroll 
    $("body").css({"overflow-y":"auto"});    
   
});





//CUANDO CAMBIE EL ALTO DE LA VENANA::
$(window).resize(function(){
   
   heightBody = $('body').height();
   console.log(heightBody);
   ajustarFloatingWindow(heightBody);
    
});





$('button#btn-cargarUsuarios').on('click', function(event)
{
    //alert("click load usersr");
    event.preventDefault();
    //objRequests.getAllUsersPaginator(objScopeApp.getPathScopeApplication());
    //printTestMethod
    objDataGridComponent.getRenderDataGridComponent(
            objScopeApp.getPathScopeApplication(), '@', '1', '5', 'id', 'asc');
    //alert(");");
    
    

});





//------------------[ ORDENAMIENTOS ]-------------------------------------------
    //objBandActions.showBandMessage("mensaje cargadp", MENSAJE_INFORMACION);










//--------------------[  EXPERIMENTAL ::  COMBO BOX ]---------------------------

$('select#id-municipios').change( function (){
    var obj = $('select#id-municipios');
    alert("selecciono: " + obj.val() + $('select#id-municipios option:selected').html());
    objRequests.getAllUsers(objScopeApp.getPathScopeApplication());
    //alert("seleccion");
});

//-------------------[ END :: EXPERIMENTAL ]------------------------------------




$('#id-window-userOptions li').click(function () //********* E V E N T *********
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
}); //************** E N D   E V E N T  C L I K ********************************

/* EVENTOS EN LOS DISTINTOS FORMULARIOS DE PRE::CARGA::SESSION ]
*/
//***************************** E V E N T **************************************
$("div.cls-floating-window form input").on("blur keyup keydown", function (event)
{
    console.log("ENTRANDO AL LISTENER ROOT");
    //obteniendo el padre del formulario [ EL PRIMERO ]
    var currentForm = $(this).parent().parent()[0];
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
        if ($(this).val == ""){
            errorMessage = "no puede omitir los campos obligatorios, ingrese la informacion";
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
                //
                //-------[ INSERT COLS TMP ]------------------------------------
                //TODO: CAMPOS A ADICIONAR EN EL REGISTRO
                dataResponse["fechaCreacion"] = new Date();
                dataResponse["horaCreacion"] = new Date();
                dataResponse["estadoRegistro"] = false;
                dataResponse["keyGenerator"] = 'dataVoid';
                dataResponse["nivelAcceso"] = parseInt(1);
                dataResponse["idKeyGenerator"] = parseInt(1);
                //-------[ END ADD COLS ]---------------------------------------      
                console.log(dataResponse);
                //realizar la peticion AJAX
                var actionRes = objRequests.registrarUsuarioAJAXRequest(dataResponse, 
                    objScopeApp.getPathScopeApplication());
                    
                console.log(actionRes);
            } 
            else 
            {
                var usernameTxt = $('input#id-txt-userName-nw').text();
                if (usernameTxt == ""){
                    errorMessage = "username vacio";
                }
                alertify.alert(errorMessage); 
                //alert (errorMessage);
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
            var objErrResponse = "";
            
           // si el username es erroneo
           if (res.username == false)
           {
               $(userNameComponent).removeClass("inputCorrect").addClass("inputWrong");
               errorMessage = "El username es incorrecto!";
               bandGlobalValidation = false;
               objErrResponse = "username";
           }
           //si el password es erroneo
           if (res.password == false)
           {
               $(passwordComponent).removeClass("inputCorrect").addClass("inputWrong");
               errorMessage = "el password es incorrecto!";
               bandGlobalValidation = false;
               if (res.username == false){
                   objErrResponse = "username, password";
               }else{
                   objErrResponse = "password";
               }
           }
           
           //configurando las alertas
           
           //-------------[ VALIDANDO SESSION EXITOSA ]-------------------------
           if ((res.password == true) && (res.username == true))
           {
               //validando el estado del registro::
               if (res.estadoRegistro == 1)
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
               else {
                    //preguntar si estan con el estilo incorrecto::
                    if ($(userNameComponent).hasClass("inputWrong")){
                        $(userNameComponent).removeClass("inputWrong").addClass("inputCorrect");
                    }
                    if ($(passwordComponent).hasClass("inputWrong")){
                        $(passwordComponent).removeClass("inputWrong").addClass("inputCorrect");
                    }   
                    alertify.alert("datos correctos! PERO no esta activada su cuenta, verifique en su correo o contacte al administrador del sistema comercial.");
               }
                              
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
                alertify.alert("Registro exitoso! debe revisar su correo para activar la cuenta..");
                setTimeout(function ()
                {
                    //recarga de la pagina
                    location.reload();
                },4000);                
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


//------------------------[  EXPERIMENTAL :: AJAX REQUEST ]---------------------
CLS_ajaxRequest.prototype.getAllUsers = function (pathApplication)
{
    var path = pathApplication;
    
    var promiseAJAXRequest = $.ajax(
    {
        url: path + "User/getUsersFromDB/",
        type: 'POST',
        dataType: 'json',
        data: {varRequest: "jaime"},
        
        success: function(respuesta)
        {
            var res = respuesta;
            
            //preparando el combo::
            $('select#id-ciudades').html('');
            
            for (var i = 0; i < res.length; i++)
            {
                console.log("recorrido: " + i);
                //ingresarlos en el combo:
                $('select#id-ciudades').append('<option value ="' + res[i].id + '">' + res[i].username + '</option>');
            }
        }        
    });
}

CLS_ajaxRequest.prototype.getAllUsersPaginator = function (pathApplication)
{
    var path = pathApplication;
    
    var promiseAJAXRequest = $.ajax(
    {
        url: path + "User/getUsersFromDB/",
        type: 'POST',
        dataType: 'json',
        data: {varRequest: "jaime"},
        
        success: function(respuesta)
        {
            var res = respuesta;            
            var tablaUsuarios = $('table#id-tablaUsuarios');
            tablaUsuarios.html('');
            //preparando el combo::            
            listadoUsuarios(res, tablaUsuarios);
        }        
    });
}
// FUNCTION ]-------------------------------------------------------------------
listadoUsuarios = function (dataArr, tableComponent)
{
    var table = tableComponent;
    $.each( dataArr, function (key, value)
    {
        var rowTable = "<tr> <td>"+ value.id +"</td> <td>"+ value.username +"</td>"                  
                      +"</tr>";        
        
        tableComponent.append(rowTable);
    })    
}


//******************************************************************************
function CLASS_DatagridComponent ()
{
    var global = "componente Data Grid";
}
CLASS_DatagridComponent.prototype.getRenderDataGridComponent = 
        function(pathApp, criterio, pagina, regXpagina, columnNameOrder, orderType)
{
    var path = pathApp;
    //ARMANDO LA DATA::
    var divLoader = $('div#id-loader');
    
    var dataSend = '&_criterio='+criterio+'&_pagina='+pagina+'&_regxpagina='+
        regXpagina+'&_columnNameOrder='+columnNameOrder+'&_orderType='+orderType;
    
    var promiseRequestRenderCtrll = $.ajax(
    {
        url: path + "DataComponents/renderDataGridComponent/",
        type: 'POST',
        dataType: 'html',
        data: dataSend,//{varRequest: "jaime"},
        
        beforeSend: function()
        {
            divLoader.html('<img src="'+ path +'public/assets/images/loaders/loaderBlue.gif">');
        },
        success: function(respuesta)
        {
            divLoader.html('');
            var res = respuesta;            
            //alert(res);
            var divTable = $('div#id-datagridContainer');
            divTable.html('');
            divTable.html(res);

            //captura el evento click de la tabla renderizada
            eventTable();

        }         
    });
}

CLASS_DatagridComponent.prototype.printTestMethod = function (path)
{
    var pathApp = path;
    alert("path : " + pathApp);    
}

//--------------------[ ACCIONES ]----------------------------------------------
//editObject                               // function(path, param1, param2)
CLASS_DatagridComponent.prototype.editObject = function(path, arrJson)
{
    event.preventDefault();
    var pathApp = path;
    //var username = param1;
    //var email = param2;
    
    var obj = arrJson;
    
    alert ("path: " + pathApp + ", username: "+ obj.username);
}

CLASS_DatagridComponent.prototype.checkObjectElement = function(param1, param2)
{
    alert(" data: "+param1 + ", data2: "+param2);
}
//------------------[ CAPTURA EL EVENTO POST CARGA ]----------------------------
function eventTable(){

    $('th').on("click", function(){
        
        //---------------------- LOGICA FUNCIONANDO -----------------
        var dataVal = "";
        var currentPage = "";
        var regXpage = 0;
        
        
        dataVal = $(this).data('column');
        
        if (dataVal != null)
        {
            //FLUJO NORMAL DE EVENTOS
            console.log("valor null");
            //$(this).data("data-column");
            console.log(dataVal);

            currentPage = $("ul.pagination.pull-left").find("li.active a").text();
            //currentPage = parseInt(currentPage);        
            console.log(currentPage);

            regXpage = $('select.selectpicker').find('option:selected').text();
            //regXpage = parseInt(regXpage);
            console.log(regXpage);

            con++;
            console.log("valor de con: "+ con);

            if (con%2){
                console.log("mostrar DESC");
                console.log($(this));
                $(this).find('span').removeClass('icon-move-up');
                $(this).find('span').addClass('icon-move-down');

                objDataGridComponent.getRenderDataGridComponent(
                        objScopeApp.getPathScopeApplication(), '@', currentPage, regXpage, dataVal, 'DESC');            

            }else{
                console.log("mostrar ASC");
                $(this).find('span').addClass('icon-move-up');
                $(this).find('span').removeClass('icon-move-down');

                objDataGridComponent.getRenderDataGridComponent(
                        objScopeApp.getPathScopeApplication(), '@', currentPage, regXpage, dataVal, 'ASC'); 
            }              
        }
        else
        {
            console.log("valor nulo");
        }
        
                     
    });

    
}