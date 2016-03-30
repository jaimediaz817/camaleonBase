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


var banderaLiked = false;
    
$(function (){    
    //--------------[ BANDERAS DE ACCIONES ]------------------------------------
    // ESCONDIENDO POR DEFECTO LAS BANDERAS DE INFORMACION
    $('div.band-status-action#success').hide();
    $('div.band-status-action#error').hide();   
    
    objBandActions = new BandStatusComponent();
    //objBandActions.showBandMessage("testMessage", MENSAJE_INFORMACION);
    
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
    $('#id-login').click(function ()
    {
        $('.cls-floating-window').slideToggle();
          
//        alertify.alert("No ha ingresado los datos para iniciar sesion");
          //objBandActions.showBandMessage("test Messsage", MENSAJE_INFORMACION);
    });
});

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



