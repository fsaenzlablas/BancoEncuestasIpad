
--
-- Borrar en MySQL los datos para realizar pruebas
--

DELETE FROM  `banco_encuesta_enc_tmp` WHERE nro_consecutivo 
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );

DELETE FROM  `banco_mvto_encuesta_tmp` WHERE nro_consecutivo
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );



DELETE FROM  `banco_encuesta_enc_tmp` WHERE nro_consecutivo 
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );


DELETE FROM  `banco_mvto_encuesta_tmp` WHERE nro_consecutivo
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );


UPDATE banco_registro SET Encuesta='PE' WHERE nro_consecutivo 
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );

DELETE FROM  banco_encuesta_enc WHERE nro_consecutivo 
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );
		
DELETE FROM  banco_mvto_encuesta WHERE nro_consecutivo
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );
		
DELETE FROM banco_historia WHERE nro_consecutivo 
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );
		
DELETE FROM blobs WHERE  NomDocumento
IN ('0053627BD','0053629BD', '0053630BD', '0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );



DELETE FROM  `banco_encuesta_enc_tmp` WHERE nro_consecutivo 
IN ('0072293BD');


DELETE FROM  `banco_mvto_encuesta_tmp` WHERE nro_consecutivo
IN ('0072293BD' );


UPDATE banco_registro SET Encuesta='PE' WHERE nro_consecutivo 
IN ('0072293BD');

DELETE FROM  banco_encuesta_enc WHERE nro_consecutivo 
IN ('0072293BD');
		
DELETE FROM  banco_mvto_encuesta WHERE nro_consecutivo
IN ('0072293BD');
		
DELETE FROM banco_historia WHERE nro_consecutivo 
IN ('0072293BD');
		
DELETE FROM blobs WHERE  NomDocumento
IN ('0072293BD');


-- ---------------------


DELETE FROM  `banco_encuesta_enc_tmp` WHERE nro_consecutivo 
IN ('0072293BD');


DELETE FROM  `banco_mvto_encuesta_tmp` WHERE nro_consecutivo
IN ('0072293BD' );


UPDATE banco_registro SET Encuesta='PE' WHERE nro_consecutivo 
IN ('0072293BD');

DELETE FROM  banco_encuesta_enc WHERE nro_consecutivo 
IN ('0072293BD');
		
DELETE FROM  banco_mvto_encuesta WHERE nro_consecutivo
IN ('0072293BD');
		
DELETE FROM banco_historia WHERE nro_consecutivo 
IN ('0072293BD');
		
DELETE FROM blobs WHERE  NomDocumento
IN ('0072293BD');

---



DELETE FROM  `banco_encuesta_enc_tmp` WHERE nro_consecutivo
IN ('0072315BD');


DELETE FROM  `banco_mvto_encuesta_tmp` WHERE nro_consecutivo
IN ('0072315BD' );


UPDATE banco_registro SET Encuesta='PE' WHERE nro_consecutivo
IN ('0072315BD');

DELETE FROM  banco_encuesta_enc WHERE nro_consecutivo
IN ('0072315BD');

DELETE FROM  banco_mvto_encuesta WHERE nro_consecutivo
IN ('0072315BD');

DELETE FROM banco_historia WHERE nro_consecutivo
IN ('0072315BD');

DELETE FROM blobs WHERE  NomDocumento
IN ('0072315BD');

------


--
-- En 4D ver El Metodo a4
--

/*


If (True)
	
	Begin SQL
		
		
		UPDATE banco_registro SET Encuesta='PE' WHERE nro_consecutivo 
		IN ('0053627BD','0053628BD','0053629BD', '0053630BD', '0053630BD','0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );
		
		DELETE FROM  banco_encuesta_enc WHERE nro_consecutivo 
		IN ('0053627BD','0053628BD','0053629BD', '0053630BD', '0053630BD','0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );
		
		DELETE FROM  banco_mvto_encuesta WHERE nro_consecutivo
		IN ('0053627BD','0053628BD','0053629BD', '0053630BD', '0053630BD','0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );
		
		DELETE FROM banco_historia WHERE nro_consecutivo 
		IN ('0053627BD','0053628BD','0053629BD', '0053630BD', '0053630BD','0053631BD', '0053632BD', '0053633BD', '0053634BD', '0053636BD' );
		
		
	End SQL
	
	
	
	ALERT("Termine de borrar datos para pruebas de encuestas")
End if 

*/

-- Pruebas Junio 9



DELETE FROM  `banco_encuesta_enc_tmp` WHERE nro_consecutivo 
IN ('0060325BD','0060326BD', '0060327BD', '0060328BD', '0060329BD', '0060330BD', '0060331BD', '0060334BD' );


DELETE FROM  `banco_mvto_encuesta_tmp` WHERE nro_consecutivo
IN ('0060325BD','0060326BD', '0060327BD', '0060328BD', '0060329BD', '0060330BD', '0060331BD', '0060334BD' );


UPDATE banco_registro SET Encuesta='PE' WHERE nro_consecutivo 
IN ('0060325BD','0060326BD', '0060327BD', '0060328BD', '0060329BD', '0060330BD', '0060331BD', '0060334BD' );

DELETE FROM  banco_encuesta_enc WHERE nro_consecutivo 
IN ('0060325BD','0060326BD', '0060327BD', '0060328BD', '0060329BD', '0060330BD', '0060331BD', '0060334BD' );
		
DELETE FROM  banco_mvto_encuesta WHERE nro_consecutivo
IN ('0060325BD','0060326BD', '0060327BD', '0060328BD', '0060329BD', '0060330BD', '0060331BD', '0060334BD' );
		
DELETE FROM banco_historia WHERE nro_consecutivo 
IN ('0060325BD','0060326BD', '0060327BD', '0060328BD', '0060329BD', '0060330BD', '0060331BD', '0060334BD' );
		
DELETE FROM blobs WHERE  NomDocumento
IN ('0060325BD','0060326BD', '0060327BD', '0060328BD', '0060329BD', '0060330BD', '0060331BD', '0060334BD' );


