<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('../../funciones/idioma.php');	$I = new Idiomas();


//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["id"]))     { $id     = $_POST["id"];     } else { $id     = ''; }
if (isset($_POST["nombre"])) { $nombre = $_POST["nombre"]; } else { $nombre = ''; }
if (isset($_POST["txt_es"])) { $txt_es = $_POST["txt_es"]; } else { $txt_es = ''; }
if (isset($_POST["txt_en"])) { $txt_en = $_POST["txt_en"]; } else { $txt_en = ''; }

//---------------------------- VERIFICO QUE VENGAN TODOS LOS DATOS OK-----------------------------------------

if($id != '' && $nombre != '' && $txt_es != '' && $txt_en != '' ) { $opcion='ok';} else{$opcion ='faltan_datos'; }	

switch($opcion){
	case 'faltan_datos':
		$_SESSION['var_retorno_']= 'txt_upd_er';	$_SESSION['msj_retorno_']= 'Por favor revise los datos. Campos Vacios'; break;
	case 'ok': // INSERT NUEVO TEXTO
		$upd_es= $I->udp_campos_txt_es($id, $txt_es);
		$upd_en= $I->udp_campos_txt_en($id, $txt_en);
        if($upd_es && $upd_en){
            $_SESSION['var_retorno_']= 'txt_upd_ok';		$_SESSION['msj_retorno_']= 'El Texto se Actualizó Satisfactoriamente';           
        }else{
            $_SESSION['var_retorno_']= 'txt_upd_er';		$_SESSION['msj_retorno_']= 'Hubo un error en la Actualización';            
		}
	break;	
}
// retorno
?><script type="text/javascript"> window.location="../_admin_pagina_web_txt.php"; </script> 
