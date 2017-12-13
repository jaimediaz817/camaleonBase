CREATE DEFINER=`root`@`localhost` PROCEDURE `updateIdKeyGen`(
#PARAMETROS DE ENTRADA
IN idKeyGenerator INTEGER(11),
IN newState INTEGER(1),
OUT returnRes INTEGER(1)
)
BEGIN

	UPDATE key_generator set codeState = newState
    WHERE id = idKeyGenerator;
	SET returnRes = 1;

END