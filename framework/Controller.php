<?php

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
 * Description of Controller
 *
 * @author Jaime Diaz <jaimeivan0017@gmail.com>
 */
class Controller {
    //put your code here
    function __construct() {
        
        //**********************************************************************
        //                    [ BUSINESS - LOGIC - LYER ]
        User_business::iniciarSession();
        //**********************************************************************
        $this->view = new View();
    }
    
    //****[ VALIDACION DE LLAVES ] **************
    function validateKeys ($keys, $where )
    {
        foreach ( $keys as $key)
        {
            //ResourceBundleV2::writeDATABASELOG("005_nwcols", "campo: ".$key ." content: ". $where[$key]);
            if (empty($where[$key]) or !isset( $where[$key]))
            {
                exit ("No se encuentra el campo: " . $key . "!");
            }
        }
        return true;
    }
    //------------------------------------------
}