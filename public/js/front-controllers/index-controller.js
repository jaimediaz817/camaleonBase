/*
 *  CONKRETEMOS SAS
 *  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
 *  author:  ing Jaime Diaz G.
 *  2016  COMPANY
 */

//DEFINICION DE TIPOS DE MENSAJES A CONFIGURAR
const MENSAJE_INFORMACION = "info";
const MENSAJE_ERROR = "err";

/*
 * EJEMPLOS DE ALERTIFY::
 *         alertify.confirm("¿Realmente desea cerrar la sesion activa?", function (e) {
                if (e) {
//                        alertify.success("You've clicked OK");
                        showMessage('Se serrara la sesion activa...', MENSAJE_INFORMACION);
                        setTimeout(function(){
                            window.location.href= rootPathApp + "/Index/destroySessionApp";
                        }, 2000);
                        
                } else {
                        alertify.error("Se cancelo el cierre de la sesion activa");
                }
        });
 */
//GLOBAL VARS
var banderaLiked = false;
var windowFloat_ancho = 0;
var bandSessionState = false;

//------------SIDEBAR ]---------------------------------------------------------
var contador = 0;
    
$(function (){    
    //--------------[ BANDERAS DE ACCIONES ]------------------------------------
  
    
    objBandActions = new BandStatusComponent();
        // ESCONDIENDO POR DEFECTO LAS BANDERAS DE INFORMACION
    $('div.band-status-action#success').hide();
    $('div.band-status-action#error').hide();
    
    //showMessage('debe ingresar el nombre de usuario y contraseña', MENSAJE_INFORMACION);
    //--------------------------------------------------------------------------
    $(window).on("scroll", function(){
//        alert("global" + global);
        var scrllTop = window.pageYOffset;
        //modificando el DOM
        $('#id-debug').html("Offset Top: " + scrllTop + " px");        
        //validacion de SCROLL-TOP
        if ( scrllTop > 940 && scrllTop < 1492){
            //alert("960");
            showLiked();
        }         
        if ( scrllTop < 960 || scrllTop > 1460){
            hideLiked();
            console.log("FUERA DE RANGO:");
        }
    });
    
    //-------------------[ COMPONENTS LISTENER ]--------------------------------
    //LISTENER PARA CERRAR LA VENTANA DE LOGIN
    $('button#id-btn-closeLogin').click(function (){
       $('.cls-floating-window').slideToggle();
    });
    
    //ICONO CERRAR - PANEL VENTANA FLOTANTE
    $('span#id-span-close-fltWindow').click(function(){
       $('.cls-floating-window').slideToggle(); 
    });
    
    //EVENTO CLICK :: LOGIN ::  ]-----------------------------------------------
    $('#id-login').click(function ()
    {
        var tipoVentanaAdmin = false;
        
        //determinar si la ventana flotante a motrar es admin o login
        var textoLog = $('div#id-login').text();
        textoLog = rtrim(ltrim(textoLog));
        console.log(textoLog);
        if (textoLog == "Login"){
            //ASIGNANDO ANCHO DE LA VENTANA LOGIN
            windowFloat_ancho = 280;//$('.cls-floating-window').width();
            console.log("Login true, nivel de acceso: " + retornarNivelAccesoUsuario() + ", valor experimental: " + retornarValorFromController());
        }else{
            //estado de session activa
            bandSessionState = true;
            //ASIGNANDO ANCHO DE LA VENTANA OPTIONS
            windowFloat_ancho = 198;
            //alguien ha iniciado session
            console.log("Login false, nivel de acceso: " + retornarNivelAccesoUsuario() + ", valor experimental: " + retornarValorFromController());
            
        }
        //DETERMINA EL ANCHO DEL BODY EN GENERAL
        var body_ancho = $(window).width();
        console.log("ancho del navegador: " + body_ancho);
        //$('.cls-floating-window').css('')
        
        var resto_bodyLogin = (((body_ancho - windowFloat_ancho) * 100)/body_ancho);
        console.log("left calculado: " + resto_bodyLogin);
        //toFixed = elimina decimales y recibe como parametro los que deberia dejar
        
        //CONFIGURANDO LA ALINEACION HACIA LA DERECHA ]-------------------------
        if (body_ancho > 1000){
            //validando el tipo de ventana a mostrar
            if (bandSessionState){
               resto_bodyLogin = (resto_bodyLogin.toFixed(2)+3);
            }else{
               console.log("NO esta logueado, el left sera: " + resto_bodyLogin);
               resto_bodyLogin = (resto_bodyLogin.toFixed(2)+5); 
            }            
        }
        if (body_ancho < 1000 && body_ancho > 700){
            resto_bodyLogin = (resto_bodyLogin.toFixed(2)-6);
        }
        if (body_ancho < 700 && body_ancho > 400){
            resto_bodyLogin = (resto_bodyLogin.toFixed(2)-5);
            //$('.cls-floating-window').css("width", "290px");
        }        
        if (body_ancho < 400){
            //validando el tipo de ventana a mostrar
            if (bandSessionState){
               resto_bodyLogin = (resto_bodyLogin.toFixed(2)-3);
            }else{
               resto_bodyLogin = (resto_bodyLogin.toFixed(2)); 
            }
            
           resto_bodyLogin = convertirNumeroNegativoApositivoOnlyPos(resto_bodyLogin);
           
            //$('.cls-floating-window').css("width", "250px");
        }        
        console.log("valor abs de left calculado: " + resto_bodyLogin);
        //resto_bodyLogin = (resto_bodyLogin.toFixed(2)-6);
        
        var porcentaje = resto_bodyLogin + '%';
        
        console.log(body_ancho);
        console.log(windowFloat_ancho);
        console.log(resto_bodyLogin);
             
        //$('.cls-floating-window').css("width", "290px");
        $('.cls-floating-window').css("left",  resto_bodyLogin + "%");
        //  MOSTRAR U OCULTAR LA VENTANA
        $('.cls-floating-window').slideToggle();
        
        if (body_ancho > 700){
           //saber si esta logueado
           if (bandSessionState){
               $('.cls-floating-window').css("width", "198px");
           }else{
               $('.cls-floating-window').css("width", "270px");
           }
            
        }
        if (body_ancho < 700 && body_ancho > 400){
            //resto_bodyLogin = (resto_bodyLogin.toFixed(2)-5);
            $('.cls-floating-window').css("width", "290px");
        }        
        if (body_ancho < 400){
           //resto_bodyLogin = (resto_bodyLogin.toFixed(2)-12); 
            $('.cls-floating-window').css("width", "264px");
        }           
//        alertify.alert("No ha ingresado los datos para iniciar sesion");
          //objBandActions.showBandMessage("test Messsage", MENSAJE_INFORMACION);
    });
});

//---------------------- BOTON FLOTANTE ----------------------------------------
$('li#id-subItem-hide').click(function()
{
    //$('div#id-floatButtonLeft').fadeOut(1000);
    $('div#id-floatButtonLeft').animate({"left": "-65px"},"slow");
});
//mostrar sidebar ]-------------------------------------------------------------

function showLeftAllElements(){
    //MOSTRAR SIDEBAR
    $('div.cls-sidebar').animate({"left": "1px"},"slow");
    //correr el button Group 252px
    //DESPLAZAR HEADER
    $('header#id-header-main').animate({"left": "253px"},"slow");
    //DESPLAZAR CONTENEDOR PRINCIPAL
    $('div#id-container-wrapper').animate({"left": "172px"},"slow"); 
}
function hideLeftAllElements(){
    //MOSTRAR SIDEBAR
    $('div.cls-sidebar').animate({"left": "-251px"},"slow");
    //DESPLAZAR HEADER
    $('header#id-header-main').animate({"left": "0px"},"slow");
    //DESPLAZAR CONTENEDOR PRINCIPAL
    $('div#id-container-wrapper').animate({"left": "0px"},"slow");    
}
//boton cerrar SIDEBAR ]-----------------
$('span#id-closeSidebar').click(function(){
    //MOSTRAR SIDEBAR
    hideLeftAllElements();
});
//CERRAR DIRECTAMENTE EL BOTON
$('button#id-btn-directCloseSb').click(function(){
    //MOSTRAR SIDEBAR
    showLeftAllElements(); 
    //alert("cierre directo");
});

$('li#id-subItem-show').click(function(){
    if ((contador%2) == 0)
    {
        //$('div#id-floatButtonLeft').animate({"left": "252px"},"slow");
        showLeftAllElements();        
    }
    else
    {
        //$('div#id-floatButtonLeft').animate({"left": "-2px"},"slow");
        hideLeftAllElements();
    }
    
    contador++;
});
//close SIDEBAR
$('div#id-glyp-leftDirection').click(function(){
    hideLeftAllElements();
});
//------------------------------------------------------------------------------

function showLiked () {
    
    if (!banderaLiked){
        console.log(banderaLiked);
        $('#id-liked').animate({
            marginLeft: "220px"
        },800, function(){
             banderaLiked = true; 
        });
        //change state              
    }
}

function hideLiked () {
    if (banderaLiked){
        console.log(banderaLiked);
        $('#id-liked').animate({
            marginLeft: "-150px"
        },800, function(){
             //change state
             banderaLiked = false;    
        });      
    }    
}

//---------------------[  CLASES  ]---------------------------------------------
function ScopeApplication(urlApplication){
    
    if (urlApplication != ''){
        this.urlMain = urlApplication;
    }
}
// METODO QUE OBTIENE LA URL A PROCESAR EN EL SERVIDOR A TRAVES DE AJAX
ScopeApplication.prototype.getPathScopeApplication = function(){
    return this.urlMain;
}
ScopeApplication.prototype.showLoader = function (){
    $('form#id-form-session').find('.loader').css('display','inline-block');
}
ScopeApplication.prototype.hideLoader = function (){
    $('form#id-form-session').find('.loader').remove();
}
//******************************************************************************


function BandStatusComponent ()
{
    //VARIABLES GLOBALES--------------------------------------
    this.MENSAJE_INFO = "info";
    this.MENSAJE_ERR = "err";    
}
BandStatusComponent.prototype.showBandMessage = function (message, tipoMensaje)
{
    //Mensaje a configurar
    var messageFull = "";
    
    if ( tipoMensaje == this.MENSAJE_INFO){
        
        messageFull = $("<span class='icon-info'></span><p id='tooltip'>"+ message +
                            "</p><span title='Cerrar banda de informacion' class='icon-cross'></span>");
                
        $('div.band-status-action#success').html("").fadeToggle(1500);
        $('div.band-status-action#success').html(messageFull);
//        $('div.band-status-action#success').fadeToggle();
        
        //ESCUCHANDO EL EVENTO CLICK CERRAR BANDERA INFO
        //BANDERA DE INFORMACION ---------------------------------------------------
        $('div.band-status-action#success').find('span.icon-cross').click(function (){
            $('div.band-status-action#success').fadeToggle();
        });        
    }else if (tipoMensaje == this.MENSAJE_ERR){
        
        messageFull = $("<span class='icon-warning'></span><p id='tooltip'>"+ message +
                            "</p><span title='Cerrar banda de error' class='icon-cross'></span>");
        
        $('div.band-status-action#error').html("").fadeToggle(1500);
        $('div.band-status-action#error').html(messageFull);
        
        //ESCUCHANDO EL EVENTO CLIK DE LA BANDERA DE ERROR
        $('div.band-status-action#error').find('span.icon-cross').click(function (){
             $('div.band-status-action#error').fadeToggle();
        }); 
//        $('div.band-status-action#error').fadeToggle();
    }   
}

//
//
//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message, tipoMensaje){
    
    //Mensaje a configurar
    var messageFull = "";
    
    if ( tipoMensaje == MENSAJE_INFORMACION){
        
        messageFull = $("<span class='icon-info'></span><p id='tooltip'>"+ message +
                            "</p><span title='Cerrar banda de informacion' class='icon-cross'></span>");
                
        $('div.band-status-action#success').html("").fadeToggle(1500);
        $('div.band-status-action#success').html(messageFull);
//        $('div.band-status-action#success').fadeToggle();
        
        //ESCUCHANDO EL EVENTO CLICK CERRAR BANDERA INFO
        //BANDERA DE INFORMACION ---------------------------------------------------
        $('div.band-status-action#success').find('span.icon-cross').click(function (){
            $('div.band-status-action#success').fadeToggle();
        });        
    }else if (tipoMensaje == MENSAJE_ERROR){
        
        messageFull = $("<span class='icon-warning'></span><p id='tooltip'>"+ message +
                            "</p><span title='Cerrar banda de error' class='icon-cross'></span>");
        
        $('div.band-status-action#error').html("").fadeToggle(1500);
        $('div.band-status-action#error').html(messageFull);
        
        //ESCUCHANDO EL EVENTO CLIK DE LA BANDERA DE ERROR
        $('div.band-status-action#error').find('span.icon-cross').click(function (){
             $('div.band-status-action#error').fadeToggle();
        }); 
//        $('div.band-status-action#error').fadeToggle();
    }
//    var messageFull = $("<span class='icon-info'></span><p id='tooltip'>"+ message +"</p><span title='Cerrar banda de informacion' class='icon-cross'></span>");
//    $(".band-status-action").html("").show();
//    $(".band-status-action").html(messageFull);
}

function fadeToggleInformation (){
    $('div.band-status-action#success').fadeToggle();
}
function fadeToggleError (){
    $('div.band-status-action#error').fadeToggle();
}

//------------------------[ UTILIDADES JS - FUNCIONES NATIVAS]------------------
function determinarValorAbsNumero(numero){
    if (numero < 0){
        return true;
    }else{
        return false;
    }
}

function convertirNumeroNegativoApositivoOnlyPos(numero){
    if (determinarValorAbsNumero(numero)){
        var numberPos = -(numero);
    }else{
        return numero;
    }
}
//TRATAMIENTO DE CADENAS
function ltrim(s) {
   return s.replace(/^\s+/, "");
}

function rtrim(s) {
   return s.replace(/\s+$/, "");
}
function trim(s) {
   return rtrim(ltrim(s));
}