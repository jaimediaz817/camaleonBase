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
    
    <header id="id-header-main" class="navbar navbar-default" >
        
        <nav id="id-navbarMain" role="navigation">            
            <div class="container-fluid">                
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#id-containerItems">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="#" class="navbar-brand">Conkretemos S.A.S</a>
                </div>                
                
                <div id="id-containerItems" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="#"><span class="space2xRight glyphicon glyphicon-home"></span>Inicio</a></li>
                        <li><a href="#"><span class="space2xRight glyphicon glyphicon-cog"></span>Configuracion</a></li>
                        <!--lista desplegable--> 
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Desplegar <b class="caret"></b></a>
                            <!--sub-items-->
                            <ul class="dropdown-menu">
                                <li><a href="#">Sub-Item1</a></li>
                                <li><a href="#">Sub-Item2</a></li>
                                <li><a href="#">Sub-Item3</a></li>
                            </ul>
                            <!--final sub-items-->
                        </li>                        
                    </ul>
                    
                    <ul class="nav navbar-right">
                        <li>
                            <!--USERNAME COMPONENT-------------------------------------> 
                            <div id="id-login" class="float-right">
                                <span class="space2xRight glyphicon glyphicon-log-in"></span>
                                <?php  if (SessionApp::existVarNameSession("username")) 
                                       {
                                          echo " ";
                                          echo SessionApp::getValueSession("username");
                                       } else {
                                          echo " Login";
                                       }
                                ?>
                            </div>  -->                          
                        </li>
                    </ul>
                </div>
               
            </div>            
        </nav>      
    </header>
 
        
        
 <!--BOTON FLOTANTE ------------------------------------------------------------->        
<!-- <div id="id-floatButtonLeft" class="borderExample">
     <span>Menu</span>
 </div>-->


    <div class="cls-sidebar">
        <h2>Menu administrativo <span id="id-closeSidebar"class="pull-right glyphicon glyphicon-remove-circle" title="cerrar menú lateral"></span></h2>
        <ul>
            <li><a href="#">Administrar Clientes</a></li>
            <li><a href="#">Administrar insumos</a></li>
            <li><a href="#">Ver obras civiles</a></li>
            <li><a href="#">configuracion</a></li>
            
            <div id="id-glyp-leftDirection" title="Desplazar menu lateral"><span class="glyphicon glyphicon-chevron-left"></span></div>
        </ul>
    </div>

    <!-- BOTON FLOTANTE DEL LADO IZQUIERDO -->
    <div class="btn-group" id="id-floatButtonLeft">
        <button id="id-btn-directCloseSb" type="button" class="btn btn-info" title="click en la flecha abajo para desplegar las opciones"><span class="glyphicon glyphicon-menu-hamburger"></span></button>
       <button id="id-pointerBtnFloat" type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
             <span class="caret"></span>
       </button>
       <ul class="dropdown-menu" role="menu">
           <li id="id-subItem-show"><a href="#">Mostrar Menu</a></li>
           <li id="id-subItem-hide"><a href="#">Ocultar boton</a></li>
       </ul>
    </div> 
        
        
        
        
        
        
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
      //RETORNA EL NIVEL DE ACCESO UNA VEZ SE INICIE SESSION
      var nivelAccesoUserApp = -1;
      var experimental = -1;
      <?php
        if (SessionApp::existVarNameSession("nivelAccesoUsr"))
        {
      ?>
          nivelAccesoUserApp = <?php print(SessionApp::getValueSession("nivelAccesoUsr"));?>;
          experimental = <?php print($this->varTestAccess); ?>;
      <?php    
        }      
        else
        {
      ?>
          nivelAccesoUserApp = 0; //USUARIO SIN AUTENTICAR
          experimental = -5;
      <?php
        } 
      ?>

      //funcion para retornar el nivel de acceso
      function retornarNivelAccesoUsuario()
      {
          return nivelAccesoUserApp;
      }
      function retornarValorFromController()
      {
          return experimental;
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
    
    <!--LOADER CSS-->
    <div id="pre-load-web"></div>          
    <!--IMAGENES PARALLAX---------------------------------------------------- -->
    <div id="id-container-wrapper" class="container">

    
   
        <!---------------------[ COMBO :: EXPERIMENTAL ]------------------------>
        <form  name="frm-comboBox">
<!--            <select name="ciudades" id="id-ciudades">
                
            </select>
            
            <select name="municipios" id="id-municipios">
                <option value="0">Seleccione una opcion</option>
                <option value="01">Armenia</option>
                <option value="01">Calarca</option>
                <option value="01">Circasia</option>
                <option value="01">Montenegro</option>
                <option value="01">Tebaida</option>
            </select>-->
            
            <button id="btn-cargarUsuarios" class="btn btn-info"  title="mostrar usuarios">DataGridComponent, ing. JD</button>
            <!--<a href="javascript:;" onclick="objDataGridComponent.printTestMethod(retornarURL())"><span>CLICK TEST</span></a>-->            
            <br>
            
            <!--EXPERIMENTO CON EL COMPONENTE DATAGRID-->
            <div id="id-loader-container">
                <div id="id-loader"></div>
            </div>
            

<!--            <div id="pagination"></div>-->
        </form>                                         
        
        <!--contenidos ------------------------------------------------------ -->                        
        
        <section class="main row" id="id-sectionMainContainer">

            <article class="col-xs-12 col-sm-8 col-md-9">
                
                <div id="id-datagridContainer" class="table-responsive">

                </div>                
                
                <article class="verticalSpace2x-top colorDefault col-md-12">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                </article>
                <article class="verticalSpace2x-top colorDefault col-md-12">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                </article>
                <article class="verticalSpace2x-top colorDefault col-md-12">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                </article>                
                <p>
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
                                        
                </p>
            </article>            
            <!--CONTENIDO PUBLICITARIO -------------------------------------- -->
            <aside class="col-xs-12 col-sm-4 col-md-3">
                
                <div class="verticalSpace2x-top panel panel-default">
                   <div class="panel-heading">
                      <h2 class="panel-title"><strong>Noticias concretera</strong></h2>
                   </div>
                   <div class="panel-body">
                      Contenido del panel
                   </div>
                </div> 

                <div class="panel panel-default">
                   <div class="panel-heading">
                      <h2 class="panel-title"><strong>Google maps</strong></h2>
                   </div>
                   <div class="panel-body">
                      Contenido del panel
                   </div>
                </div>                 
                
                <p class="text-justify">
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
                    
                </p>
                             
                
            </aside>
        </section>
        
        <!--COLUMNAS O CUADROS UBICADOS VERTICALMENTE-->
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <p>
                    <h3>Columna 1</h3>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                  
                </p>
                <p class="colorGrey">
                    <h3>Columna 1 - 2</h3>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo                  
                </p>                
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <p>
                    <h3>Columna 2</h3>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                  
                </p>
            </div>
            
            <div class="clearfix visible-sm-block"></div>
            
            <div class="col-xs-12 col-sm-6 col-md-3 col-md-offset-3">
                <p>
                    <h3>Columna 3</h3>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                   
                </p>
            </div>
<!--            <div class="col-xs-12 col-sm-6 col-md-3">
                <p>
                    <h3>Columna 4</h3>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,                   
                </p>
            </div>            -->
        </div>
        
        
        <div class="parallax-window" data-image-src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/img1.jpg" 
             data-parallax="scroll"></div>
        
        <div class="cls-separador-titulo">
            Welcome to <?php print($this->title);  ?>
        </div>
        <!--SEPARADOR HORIZONTAL ---------------------------------------------- -->
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
        <!-- ------------------------------------------------------------------- -->
        
        <div class="parallax-window" data-image-src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/img2.jpg" 
             data-parallax="scroll"></div>
        
        <!-- SEPARADOR HORIZONTAL ---------------------------------------------- -->
        <div class="cls-separador">
            IMAGEN LIKED 
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
        <!-- -------------------------------------------------------------------        -->
        
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

        <!--SEPARADOR HORIZONTAL ---------------------------------------------- -->
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
        <!-- -------------------------------------------------------------------        -->
        
        <div class="parallax-window" data-image-src="<?php print(URL_SINGLE_APPLICATION); ?>public/assets/images/img4.jpg" 
             data-parallax="scroll"></div>  
        
        <!-- SEPARADOR HORIZONTAL ---------------------------------------------- -->
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
   <!--FINAL DEL DIV CONTAINER-->
    </div> 
         <!--SCRIPTS DE INCLUSION-->          
         <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/front-controllers/index-controller.js"></script>
         <!--CARGANDO SCRIPTS NECESARIOS--> 
         <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/front-controllers/session-controller.js" type="text/javascript"></script>
         
        <!--BOOTSTRAP JS-->
        <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/lib/bootstrap.js"></script>
        
        <!--LIBRERIAS JQUERY UI-->
        <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/lib/jquery-ui.js"></script>
        <!--LIBRERIAS ALERTIFY-->
        <script src="<?php print(URL_SINGLE_APPLICATION); ?>public/js/lib/alertify.js"></script>         
</body>
</html>