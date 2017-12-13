CREATE trigger tgr_Insert_usuariosBitacora AFTER insert
ON usuario
for each row
 insert INTO bitacora_usuarios (usuario_mysql, fecha_movimiento, accion_sistema, id_usuario)
 values (USER(), NOW(), 'INSERT', NEW.id);