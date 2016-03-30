<?php

/*
*  CONKRETEMOS SAS
*  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
*  author:  ing Jaime Diaz G.
*  2016  COMPANY
*/
    include PATH_VIEWS_MODULES ."header.php";
?>
<!--CUERPO PRINCIPAL DE LA PAGINA ---------------------------------------------->
<body>
    <!--<h1>PAGINA TEMPORAL INDEX :: VIEW</h1>-->
    <!--LIBRERIAS JQUERY UI-->    
    <?php if(isset($this->debug) && ($this->debug)): ?>
        <div id="id-debug">Offset Top: 0 px</div>
    <?php endif; ?>
    
    <header id="id-header-main">
        <div id="id-logo"></div>
        <nav></nav>
        <!--USERNAME COMPONENT-------------------------------------> 
        <div id="id-login" class="float-right">
            <?php  if (SessionApp::existVarNameSession("username")) 
                   {
                      echo SessionApp::getValueSession("username");
                   } else {
                      echo "Login";
                   }
            ?>
        </div>        
    </header>

    <!--mensajes de actions-->
    <div id="id-band-container">
        <div class = "band-status-action" id="success">
            <span class="icon-info"></span>
                <p></p>
             <span class="icon-cross"></span>
        </div>

        <div class = "band-status-action" id="error">
            <span class="icon-info"></span>
                <p></p>
             <span class="icon-cross"></span>
        </div>    
    </div>
    <!-------------------------------------------------------------------------->        

     <script type="text/javascript">      
      //retorna la URL global para la configuracion del ambiente
      function retornarURL (){
          var global = "<?php print(URL_SINGLE_APPLICATION);  ?>";
          return global;
      }
    </script>
    <!--FRAGMENTO DE PARAMETRIZACION ESTATICA JS ------------------------------->
        
    
    
    <!--INCRUSTACION DE FRAGMENTO :: INICIO DE SESION :: signIn-------------- -->   
    <?php 
        if ( SessionApp::existVarNameSession("username"))
        {
            $this->userControllerObj->userOptions();
        } else {
            $this->userControllerObj->signIn(); 
        }
    ?>
    
          
    <!--IMAGENES PARALLAX---------------------------------------------------- -->
    <div id="id-container-wrapper">
        <div class="parallax-window" data-image-src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/img1.jpg" 
             data-parallax="scroll"></div>
        
        <div class="cls-separador-titulo">
            Welcome to <?php print($this->title);  ?>
        </div>
        <!--SEPARADOR HORIZONTAL ------------------------------------------------>
        <div class="cls-separador">
            <div class="cls-contenido">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
            </div>
        </div>
        <!----------------------------------------------------------------------->
        
        <div class="parallax-window" data-image-src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/img2.jpg" 
             data-parallax="scroll"></div>
        
        <!--SEPARADOR HORIZONTAL ------------------------------------------------>
        <div class="cls-separador">
            <!--IMAGEN LIKED--> 
            <div id="id-liked">
                <img src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/liked1.png" alt="">
            </div>
            
            <div class="cls-contenido">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
            </div>
        </div>
        <!----------------------------------------------------------------------->        
        
       <div class="cls-separador">
            <div class="cls-contenido">
                <div class="cls-title-product"></div>
                
                <div class="cls-img-product">
                    <img src="<?php  print(URL_SINGLE_APPLICATION);?>public/assets/images/producto1.jpg" alt="Producto recomendado">                        
                </div>
                
                <div class="cls-img-product">
                    <img src="<?php  print(URL_SINGLE_APPLICATION);?>public/assets/images/producto1.jpg" alt="Producto recomendado">                        
                </div>

                <div class="cls-img-product">
                    <img src="<?php  print(URL_SINGLE_APPLICATION);?>public/assets/images/producto1.jpg" alt="Producto recomendado">                        
                </div>                
            </div>
       </div>
        
        <div class="parallax-window" data-image-src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/img3.png" 
             data-parallax="scroll"></div>

        <!--SEPARADOR HORIZONTAL ------------------------------------------------>
        <div class="cls-separador">
            <div class="cls-contenido">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
            </div>
        </div>
        <!----------------------------------------------------------------------->        
        
        <div class="parallax-window" data-image-src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/img4.jpg" 
             data-parallax="scroll"></div>  
        
        <!--SEPARADOR HORIZONTAL ------------------------------------------------>
        <div class="cls-separador">
            <div class="cls-contenido">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                proident, sunt in culpa qui officia deserunt mollit anim id est laborum. 
            </div>
        </div>
        <!----------------------------------------------------------------------->        
    </div>
         <!--SCRIPTS DE INCLUSION-->          
         <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/front-controllers/index-controller.js"></script>
         <!--CARGANDO SCRIPTS NECESARIOS--> 
         <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/front-controllers/session-controller.js" type="text/javascript"></script>
         
        <!--LIBRERIAS JQUERY UI-->
        <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/lib/jquery-ui.js"></script>
        <!--LIBRERIAS ALERTIFY-->
        <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/lib/alertify.js"></script>         
</body>
</html>