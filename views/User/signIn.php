<?php
/*
*  CONKRETEMOS SAS
*  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
*  author:  ing Jaime Diaz G.
*  2016  COMPANY   float-right
*/
?>
<!--[ VENTANA FLOTANTE ]************************************-->
<div class="cls-floating-window cls-confFloating-window">
    <div class="cls-header-panel-fltWindow">
        <h2>ventana - Login -</h2>
        <span id="id-span-close-fltWindow" class="glyphicon glyphicon-remove-circle" title="Cerrar ventana flotante"></span>
    </div>
  <div class="cls-scrollingWindow">
      <div id="cls-header-botonera">
        <!--        <button class="btn btn-info center-block verticalSpace2x-top" id="id-btn-closeLogin">
            cerrar ventana login  
            <span class="space2xLeft glyphicon glyphicon-remove-circle"></span>
        </button>-->
        <!--mensajes de actions-->
        <span></span>
    </div>
    
    <!--TABS -------------[ SESSION ]------------------------------------------->
    <div class="tab" data-tab="login">
        <div id="id-tittle-form" class="border-top-title-fltWindow cls-tittle-form">
            <span class="cls-span-tittle-panelTab">Inicio de sesion</span>
        </div>
        <!--SEPARADORES VERTICALES Y HORIZONTALES ]---------->
        <div class="cls-div-hv-bar">
           <hr class="cls-hr-floating-window"> 
           <div class="cls-div-hv-inner">
               <hr class="cls-hr-vertical">
           </div>
        </div>                           
        <!--<hr class="cls-hr-vertical">-->
        <form name="frm-signIn-sesion" method="post" id="id-form-session" class="paddingLeftAndRight">
            <div class="verticalSpace1x-bottom input-group">
                <span class="input-group-addon">@</span>
                <input class="form-control" id="id-txt-userName"  type="text" name="txt-userName" placeholder="Nombre de usuario">
            </div>
            <div class="verticalSpace2x-bottom input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-eye-close"></span></span>
                <input class="form-control" id="id-txt-password" type="text" name="txt-password" placeholder="Contraseña" >
            </div>            
            <!--BOTON PARA INICIO DE SESION ------------------------------------>            
            <input class="cls-btn-submitSess" id="id-btn-submitSess" type="submit" name="btn-entrar" value="Entrar">                
            <!--        <div class="loader"></div>-->    
        </form>
        <!--BOTONES DE NAVEGACION ENTRE PANELES ******* -->
        <div id="id-small-text" class="cls-small-text paddingLeftAndRight">
            <span data-tab="register" id="id-span-registrar" class="cls-span-registrar" >¿No te has registrado?</span>
            <span id="id-span-registrar" class="cls-span-registrar" data-tab="FPassword">¿Olvidaste la contraseña?</span>       
        </div>               
    </div>
    
    <!--PANEL REGISTRAR USUARIOS ]---------------------------------------------->
    <div class="tab hideElement" data-tab="register">   
        <!--TITULO DEL PANEL REGISTRAR-->
        <div id="id-tittle-form-reg" class="border-top-title-fltWindow cls-tittle-form">
            <span class="cls-span-tittle-panelTab">Registro de usuario</span>
        </div>
        <!--SEPARADORES VERTICALES Y HORIZONTALES ]---------->
        <div class="cls-div-hv-bar">
           <hr class="cls-hr-floating-window"> 
           <div class="cls-div-hv-inner">
               <hr class="cls-hr-vertical">
           </div>
        </div> 
        <form name="frm-signUp-sesion"  id="id-form-register" autocomplete="off" class="paddingLeftAndRight">
            <!--NOMBRES COMPLETOS-->
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-pencil"></span>
                <input class="form-control" id="id-txt-nombres-nw"  type="text" name="txt-names-nw" placeholder="Nombres completos" >
            </div>
            <!--USERNAME-->
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-user"></span>
                    <input class="form-control" id="id-txt-userName-nw"  type="text" name="txt-userName-nw" placeholder="Nombre de usuario" >            
            </div>
            <!--PASSWORD-->
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-eye-close"></span>
                    <input class="form-control" id="id-txt-password" type="text" name="txt-password-nw" placeholder="Contraseña nueva" >
            </div>
            <!--RE-PASSWORD-->
            <div class="input-group">
                <span class="input-group-addon glyphicon glyphicon-eye-close"></span>
                    <input class="form-control" id="id-txt-Rpassword" type="text" name="txt-Rpassword-nw" placeholder="repita la contraseña" >
            </div>
            <!--CORREO ELECTRONICO-->
            <div class="verticalSpace2x-bottom input-group">
                <span class="input-group-addon">@</span>
                    <input class="form-control" id="id-txt-email-nw"  type="text" name="txt-email-nw" placeholder="Correo electronico" >
            </div>
            <!--boton  ------------[ REGISTRAR USUARIO ]----------------->
            <input class="cls-btn-submitSess" id="id-btn-submitRegister" type="submit" name="btn-register" value="Registrar">                
            <!--        <div class="loader"></div>-->
        </form>
        <!--NAVEGACION ENTRE PANELES ] ---------------------->
        <div id="id-small-text-register" class="cls-small-text paddingLeftAndRight">
            <span id="id-span-cancelar" class="cls-span-registrar" data-tab="login">Cancelar</span>
            <span id="id-span-recover-reg" class="cls-span-registrar" data-tab="FPassword">Recuperar password</span>
        </div>         
    </div>
    
    <!--panel -------------[ RECUPERACION DE PASSWORD A TRAVÉS DE CORREO ]------>
    <div class="tab hideElement" data-tab="FPassword">
        <div id="id-tittle-form-rec" class="border-top-title-fltWindow cls-tittle-form">
            <span class="cls-span-tittle-panelTab">Recuperacion de password</span>
        </div>
        <!--SEPARADORES VERTICALES Y HORIZONTALES ]---------->
        <div class="cls-div-hv-bar">
           <hr class="cls-hr-floating-window"> 
           <div class="cls-div-hv-inner">
               <hr class="cls-hr-vertical">
           </div>
        </div>
        <form name="frm-recover-sesion" method="post" id="id-form-recover" class="paddingLeftAndRight">
            <input id="id-txt-email-rec"  type="text" name="txt-email-rec" placeholder="Correo electronico" >
            <input class="cls-btn-submitSess" id="id-btn-submitRecover" type="submit" name="btn-entrar-recover" value="Recuperar password">                
        </form>
        <!--BOTONES DE NAVEGACION DE ACCIONES-->
        <div class="cls-small-text paddingLeftAndRight">
            <span id="id-span-recuperar" class="cls-span-registrar" data-tab="login">Cancelar</span>                 
        </div>         
    </div>
  </div> 
</div>
<!--scripts necesarios *****-->
<script type="text/javascript"></script>





