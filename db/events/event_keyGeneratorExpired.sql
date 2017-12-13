/*
*  CONKRETEMOS SAS
*  Licencia de cabeceras para el proyecto CONKRETEMOS SAS
*  author:  ing Jaime Diaz G.
*  2016  COMPANY
*/




/**
 * Author:  Jaime Diaz <jaimeivan0017@gmail.com>
 * Created: 16/04/2016
 */

delimiter $$

DROP EVENT IF EXISTS event_update_keys_expired$$
    CREATE EVENT event_update_keys_expired ON schedule every 1 Minute
    starts '2016-04-16 12:20:00' ENABLE
    DO
    BEGIN

     call updateStateKeyGenerator();
    
    END;$$    
DELIMITER;    