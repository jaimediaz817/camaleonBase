alumno

SELECT ui.usin_nombre, u.usua_correo_electronico, ui.usin_movil, (sum(alhs.alhs_peldanos) + sum(alhs.alhs_dialogos) + sum(alhs.alhs_conversaciones)) /count(alhs.alhs_fecha_carga) promedio 

FROM pro8belt.usuario_informacion ui INNER JOIN pro8belt.usuarios u ON u.usua_id_PK=ui.usua_id_FK INNER JOIN pro8belt.usuario_informacion_perfiles uip ON (ui.usin_id_PK = uip.usin_id_FK AND uip.perf_id_FK = 93) ,pro8belt.alumno_paquete ap, alumno_historico_sala alhs WHERE ap.alum_id_FK= alhs.alum_id_FK and ap.alpa_activo = 1 AND uip.perf_id_FK = 93 AND ap.usin_id_FK=ui.usin_id_PK AND ap.alpa_fecha_fin >= '2016-06-28' AND u.usua_correo_electronico!='' group by alhs.alum_id_FK order by promedio desc limit 50

probadores

SELECT ui.usin_nombre, u.usua_correo_electronico, ui.usin_movil, (sum(alhs.alhs_peldanos) + sum(alhs.alhs_dialogos) + sum(alhs.alhs_conversaciones)) /count(alhs.alhs_fecha_carga) promedio FROM pro8belt.usuario_informacion ui INNER JOIN pro8belt.usuarios u ON u.usua_id_PK=ui.usua_id_FK INNER JOIN pro8belt.usuario_informacion_perfiles uip ON (ui.usin_id_PK = uip.usin_id_FK AND uip.perf_id_FK = 92) ,pro8belt.alumno_paquete ap, alumno_historico_sala alhs WHERE ap.alum_id_FK= alhs.alum_id_FK and ap.alpa_activo = 1 AND uip.perf_id_FK = 92 AND ap.usin_id_FK=ui.usin_id_PK AND ap.alpa_fecha_fin >= '2016-06-28' AND u.usua_correo_electronico!='' group by alhs.alum_id_FK order by promedio desc limit 50


=========================================================================================================================

SELECT u.usua_correo_electronico, ap.alpa_fecha_inicio, ap.alpa_fecha_fin, DATEDIFF(ap.alpa_fecha_fin,ap.alpa_fecha_inicio) as total_dias
FROM usuarios u INNER JOIN usuario_informacion ui 
on u.usua_id_PK = ui.usua_id_FK 
INNER JOIN usuario_informacion_perfiles uip
ON (ui.usin_id_PK = uip.usin_id_FK AND uip.perf_id_FK = 93),
alumno_paquete ap, alumno_historico_sala ahs 
WHERE ap.alum_id_FK = ahs.alum_id_FK AND ap.alpa_activo = 1 AND uip.perf_id_FK = 93 AND ap.usin_id_FK = ui.usin_id_PK 
group by ahs.alum_id_FK
limit 100

//

//

SELECT u.usua_correo_electronico, ap.alpa_fecha_inicio, ap.alpa_fecha_fin, DATEDIFF(ap.alpa_fecha_fin,ap.alpa_fecha_inicio) as total_dias_paqu, count(ahs.alhs_fecha_carga) as cantidad_registros_hist
, ahs.alhs_peldanos as peldanos_colgados_diario
FROM usuarios u 
INNER JOIN usuario_informacion ui 
ON u.usua_id_PK = ui.usua_id_FK 
INNER JOIN usuario_informacion_perfiles uip
ON (ui.usin_id_PK = uip.usin_id_FK AND uip.perf_id_FK = 93),
alumno_paquete ap, alumno_historico_sala ahs 
WHERE ap.alum_id_FK = ahs.alum_id_FK 
AND ap.alpa_activo = 1 
AND uip.perf_id_FK = 93 
AND ap.usin_id_FK = ui.usin_id_PK 
GROUP BY ahs.alum_id_FK
HAVING total_dias_paqu = 8


SELECT u.usua_correo_electronico, ap.alpa_fecha_inicio, ap.alpa_fecha_fin, DATEDIFF(ap.alpa_fecha_fin,ap.alpa_fecha_inicio) as total_dias_paqu, 
count(ahs.alhs_fecha_carga) as cantidad_registros_hist, ap.alpa_peldanos as cantidad_peldanos, ahs.alhs_peldanos as historico_cantidad_peldanos, ahs.alhs_dialogos as historico_cantidad_dialogos
FROM usuarios u INNER JOIN usuario_informacion ui 
on u.usua_id_PK = ui.usua_id_FK 
INNER JOIN usuario_informacion_perfiles uip
ON (ui.usin_id_PK = uip.usin_id_FK AND uip.perf_id_FK = 93),
alumno_paquete ap, alumno_historico_sala ahs, alumno_peldanos_prueba_nivel_2016 appnivel2016
WHERE ap.alum_id_FK = ahs.alum_id_FK AND ap.alpa_activo = 1 AND uip.perf_id_FK = 93 AND ap.usin_id_FK = ui.usin_id_PK 
AND appnivel2016.alum_id_FK = ap.alum_id_FK
GROUP BY ahs.alum_id_FK
HAVING total_dias_paqu = 8
