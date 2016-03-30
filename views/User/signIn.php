<?php
/*
*  CONKRETEMOS SAS
*  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
*  author:  ing Jaime Diaz G.
*  2016  COMPANY
*/
?>
<div class="cls-floating-window float-right">
    
    <!--TABS SESSION-->
    <div class="tab" data-tab="login">
        <div id="id-tittle-form" class="cls-tittle-form">Inicio de sesion</div>
        <form name="frm-signIn-sesion" method="post" id="id-form-session">
            <input id="id-txt-userName"  type="text" name="txt-userName" placeholder="Nombre de usuario" >
            <input id="id-txt-password" type="text" name="txt-password" placeholder="Contraseña" >
            <input class="cls-btn-submitSess" id="id-btn-submitSess" type="submit" name="btn-entrar" value="Entrar">                
    <!--        <div class="loader"></div>-->    
        </form>
        <div id="id-small-text" class="cls-small-text">
            <span data-tab="register" id="id-span-registrar" class="cls-span-registrar" >¿No te has registrado?</span>
            <span id="id-span-registrar" class="cls-span-registrar" data-tab="FPassword">¿Olvidaste la contraseña?</span>       
        </div>               
    </div>

    <div class="tab hideElement" data-tab="register">
        
        <div id="id-tittle-form-reg" class="cls-tittle-form">Registro de usuario</div>
        <form name="frm-signUp-sesion"  id="id-form-register" autocomplete="off">
            <input id="id-txt-nombres-nw"  type="text" name="txt-names-nw" placeholder="Nombres completos" >
            <input id="id-txt-userName-nw"  type="text" name="txt-userName-nw" placeholder="Nombre de usuario" >            
            <input id="id-txt-password" type="text" name="txt-password-nw" placeholder="Contraseña nueva" >
            <input id="id-txt-Rpassword" type="text" name="txt-Rpassword-nw" placeholder="repita la contraseña" >
            <input id="id-txt-email-nw"  type="text" name="txt-email-nw" placeholder="Correo electronico" >
            <input class="cls-btn-submitSess" id="id-btn-submitRegister" type="submit" name="btn-register" value="Registrar">                
    <!--        <div class="loader"></div>-->
        </form>

        <div id="id-small-text-register" class="cls-small-text">
            <span id="id-span-cancelar" class="cls-span-registrar" data-tab="login">Cancelar</span>
            <span id="id-span-recover-reg" class="cls-span-registrar" data-tab="FPassword">Recuperar password</span>
        </div> 
        
    </div>

    <div class="tab hideElement" data-tab="FPassword">
        <div id="id-tittle-form-rec" class="cls-tittle-form">Recuperacion de password</div>
        <form name="frm-recover-sesion" method="post" id="id-form-recover">
            <input id="id-txt-email-rec"  type="text" name="txt-email-rec" placeholder="Correo electronico" >
            <input class="cls-btn-submitSess" id="id-btn-submitRecover" type="submit" name="btn-entrar-recover" value="Recuperar password">                
        </form>
        <!--BOTONES DE NAVEGACION DE ACCIONES-->
        <div class="cls-small-text">
            <span id="id-span-recuperar" class="cls-span-registrar" data-tab="login">Cancelar</span>                 
        </div>         
    </div>
   
</div>
<script type="text/javascript"></script>





