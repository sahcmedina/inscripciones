<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('capacitaciones.php');	$Cap = new Capacitaciones();

function validar_fecha($fecha){ // en fecha viene a-m-d
	$valores = explode('-', $fecha);
	$anio= $valores[0];
	// verifico el dia
	if(substr($valores[2], 0, 1) == '0' ){
		$dia = substr($valores[2], 1, 1);
	}else{
		$dia = $valores[2];
	}
	// verifico el mes
	if(substr($valores[1], 0, 1) == '0' ){
		$mes = substr($valores[1], 1, 1);
	}else{
		$mes = $valores[1];
	}
	if(count($valores) == 3 && checkdate($mes, $dia, $anio)){
		return true;
    }
	return false;
}

// nombre y orden de los campos de la tabla capacitaciones
/*id, fk_categorias, nombre, descripcion, institucion, f_inicio, capacidad, cupo_ins, duracion, ins_auto, cant_enc, carga_hr, lugar, fk_departamento, 
estado, f_hs_creacion, usuario, f_inicio_ins, f_fin_ins, f_fin */

/* NOMBRE DE LOS ELEMENTOS DEL FRONT
categoria, nombre, usuario, institucion, descripcion, f_inicio, f_inicio_ins, f_fin_ins, capacidad, cupo_ins, duracion, cant_enc, ins_auto
carga_hr, lugar, departamento
*/

//------------------ RECIBO LOS DATOS ----------------------------
if (isset($_POST["usuario"]))      { $usuario       = $_POST["usuario"];      } else { $usuario       = ''; }

if (isset($_POST["id_curso"]))     { $id_curso      = $_POST["id_curso"];     } else { $id_curso      = ''; }
if (isset($_POST["categoria"]))    { $fk_categorias = $_POST["categoria"];    } else { $fk_categoria = ''; }
if (isset($_POST["add_categoria"])){ $nva_categoria = $_POST["add_categoria"];} else { $nva_categoria= ''; }

if (isset($_POST["form_mostrar"]))   { $form_mostrar = $_POST["form_mostrar"];      } else { $form_mostrar= ''; }
if (isset($_POST["dir_form_google"])){ $dir_form_google = $_POST["dir_form_google"];} else { $dir_form_google= ''; }

if (isset($_POST["nombre"]))       { $nombre        = $_POST["nombre"];       } else { $nombre       = ''; }
if (isset($_POST["institucion"]))  { $institucion   = $_POST["institucion"];  } else { $institucion  = ''; }

if (isset($_POST["f_inicio"]))     { $f_inicio      = $_POST["f_inicio"];     } else { $f_inicio     = ''; }
if (isset($_POST["f_inicio_ins"])) { $f_inicio_ins  = $_POST["f_inicio_ins"]; } else { $f_inicio_ins = ''; }
if (isset($_POST["f_fin_ins"]))    { $f_fin_ins     = $_POST["f_fin_ins"];    } else { $f_fin_ins    = ''; }

if (isset($_POST["capacidad"]))    { $capacidad     = $_POST["capacidad"];    } else { $capacidad    = ''; }
if (isset($_POST["cupo_ins"]))     { $cupo_ins      = $_POST["cupo_ins"];     } else { $cupo_ins     = ''; }
if (isset($_POST["duracion"]))     { $duracion      = $_POST["duracion"];     } else { $duracion     = ''; }
if (isset($_POST["cant_enc"]))     { $cant_enc      = $_POST["cant_enc"];     } else { $cant_enc     = ''; }
if (isset($_POST["carga_hr"]))     { $carga_hr      = $_POST["carga_hr"];     } else { $carga_hr     = ''; }
if (isset($_POST["ins_auto"]))     { $ins_auto      = $_POST["ins_auto"];     } else { $ins_auto     = ''; }

if (isset($_POST["lugar"]))        { $lugar        = $_POST["lugar"];         } else { $lugar        = ''; }
if (isset($_POST["departamento"])) { $departamento = $_POST["departamento"];  } else { $departamento = ''; }

// ---------------------------------recibo descripcion y duracion para mostrar en la web------------------------------
if (isset($_POST["modifica_si_no"])) { $modifica_si_no = $_POST["modifica_si_no"]; } else { $modifica_si_no = ''; }  // verifico si esta checked o no
if (isset($_POST["string"]))    { $string    = $_POST["string"];    } else { $string    = ''; }

if (isset($_POST["web_duracion"])) 	{ $web_duracion = $_POST["web_duracion"];  		} else { $web_duracion = ''; 	}
if (isset($_POST["web_obj"]))  		{ $web_obj  = $_POST["web_obj"];   				} else { $web_obj  = ''; 		}
if (isset($_POST["web_dictado_x"])) { $web_dictado_x  = $_POST["web_dictado_x"];   	} else { $web_dictado_x  = ''; 	}
if (isset($_POST["web_cursado"]))  	{ $web_cursado  = $_POST["web_cursado"];   		} else { $web_cursado  = ''; 	}
if (isset($_POST["web_destinat"]))  { $web_destinat  = $_POST["web_destinat"];   	} else { $web_destinat  = ''; 	}


// si está checked recibo la imagen y verifico que llegue algo.
if ($modifica_si_no == 'on') {
	$url = $_FILES['url']['name'];
	if ($url != ''){
		$nom_archivo = new SplFileInfo($url); // guardo el nombre del archivo original para luego obtener la extension del archivo
		$extension   = $nom_archivo->getExtension(); //guardo la extension del archivo
		$nom_imagen  = 'imagen_del_curso_nvo.'.$extension; // nuevo nombre de la imagen

		$directorio  = "../web_cursos/".$nom_imagen; // guardo el nombre de la carpeta adonde la voy a subir
		move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
		$dir = $directorio;
		
		$bin = file_get_contents($dir); // Load file contents into variable
		$b64 = base64_encode($bin);     // Encode contents to Base64
		unlink($directorio);
	}else{
		$opcion = 'falta_img';
	}
}else{
	$b64 = $string; // no quiero actualizar ninguna imagen
}

//------------------------------- recibos los requisitos -----------------------------------------------
if (isset($_POST["tema_1_titulo"])) { $t1_tit = $_POST["tema_1_titulo"]; } else { $t1_tit = '';	}
if (isset($_POST["tema_2_titulo"])) { $t2_tit = $_POST["tema_2_titulo"]; } else { $t2_tit = '';	}
if (isset($_POST["tema_3_titulo"])) { $t3_tit = $_POST["tema_3_titulo"]; } else { $t3_tit = '';	}
if (isset($_POST["tema_4_titulo"])) { $t4_tit = $_POST["tema_4_titulo"]; } else { $t4_tit = '';	}
if (isset($_POST["tema_5_titulo"])) { $t5_tit = $_POST["tema_5_titulo"]; } else { $t5_tit = '';	}

//---------------------------- VERIFICO QUE VENGAN TODOS LOS DATOS OK-----------------------------------------

$f_fin = '0000-00-00';
$falta = '';

// verifico si es una nueva categoria
if($fk_categorias == 'a'){
	if($nva_categoria != ''){
		$nva_cat      = $Cap->add_categoria_nueva($nva_categoria);
		$fk_categorias= $Cap->get_last_id_categoria();
	}else{
		$falta.='Falta Nueva Categoria';
	}
}

// add nueva categoria
// if($nueva_cat_ == 1){
// 	$nva_categoria = strtoupper($nva_categoria);  				// paso todo a mayusculas.
// 	$nva_cat       = $Cap->add_categoria_nueva($nva_categoria); // inserto la nueva categoria
// 	if($nva_cat){
// 		$fk_categorias=$Cap->get_last_id_categoria(); 			// traigo el id de la categoria anterniormente agregada.
// 	}
// }

// datos de cual formulario utilizar
if($form_mostrar == 'form_web'){$form_url= '';}
else{
	if($form_mostrar == 'form_google' and $dir_form_google == '' ){ $opcion ='falta_dir_google'; }
	else {$form_url= $dir_form_google;}
}

if($nombre == '')		$falta.= 'Falta Nombre al Curso, ';
if($institucion == '')	$falta.= 'Falta Institución, ';

if($f_inicio == '')   	$falta.= 'Fecha inicial, ';
if($f_inicio_ins == '') $falta.= 'Falta inicio inscripción, ';
if($f_fin_ins == '') 	$falta.= 'Falta fin inscripción,';

if($capacidad == '')   	$falta.= 'Falta Capacidad, ';
if($cupo_ins == '')   	$falta.= 'Falta Cupo, ';
if($duracion == '')   	$falta.= 'Falta Duración en horas, ';
if($cant_enc == '')   	$falta.= 'Falta Cantidad de encuentros, ';
if($carga_hr == '')   	$falta.= 'Falta Carga horaria, ';

if($lugar == '') 		$falta.= 'Falta Lugar,';
if($departamento == '') $falta.= 'Falta Departamento';

if($web_duracion=='' OR $web_obj=='' OR $web_dictado_x=='' OR $web_cursado=='' OR $web_destinat=='' )	$opcion ='faltan_datos_web' ;

$opcion= 'ok';
if($falta != '')		$opcion= 'faltan_datos'; // mensaje de faltante de datos

// verifico que las fechas sean reales y que no tengan el formato 0000-00-00
if($f_inicio     == '0000-00-00' OR !validar_fecha($f_inicio)     ) {$opcion= 'err_formato_fecha';}
if($f_inicio_ins == '0000-00-00' OR !validar_fecha($f_inicio_ins) ) {$opcion= 'err_formato_fecha';}
if($f_fin_ins    == '0000-00-00' OR !validar_fecha($f_fin_ins)    ) {$opcion= 'err_formato_fecha';}

if($f_inicio_ins > $f_fin_ins ) $opcion= 'error_fechas_i'; 	// detectar que las fechas de inicio de inscripcion sean correctas
if($f_fin_ins >= $f_inicio)     $opcion= 'error_fechas_ci'; // detectar que no se superpongan las fechas.

if($capacidad <= 0 OR $cupo_ins <= 0 OR $duracion <= 0 OR $cant_enc <= 0 OR $carga_hr <= 0) $opcion= 'revise los datos';

switch($opcion){

	case 'falta_img':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'Falta seleccionar una imagen para la capacitación'; 						break;
	case 'falta_dir_google':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'Por favor Ingrese la direccion del formulario Google'; 						break;
	case 'revise los datos':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'Por favor revise los datos. Faltantes: '.$falta;			 				break;
	case 'faltan_datos':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'Por favor revise los datos. Faltantes: '.$falta;			 				break;
	case 'err_formato_fecha':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'Por favor ingrese fechas reales ';			 								break;
	case 'error_fechas_c':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'La Fecha Inicio del Curso debe ser MENOR a la Fecha final'; 				break;
	case 'error_fechas_i':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'La Fecha Inicio de inscripción debe ser MENOR a la Fecha final'; 			break;	
	case 'error_fechas_ci':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'La Fecha Inicio del curso debe ser MAYOR a la Fecha final de inscripción'; 	break;		
	case 'faltan_datos_web':
		$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'Faltan datos para mostrar en la página web';			 					break;
	
	case 'ok':
		
			// calculo la fecha de finalizacion del curso en funcion a la duracion en dias y a la fecha de inicio del curso
			if($duracion == 1){
				$f_fin     = $f_inicio;
			}else{
				$duracion_ = $duracion - 1;
				$f_fin     = date("Y-m-d",strtotime($f_inicio."+ ".$duracion_." days")); ;
			}
	
			$f_hs_creacion= date("Y-m-d H:i:s");
			$estado       = 1;			
			$add_curso    = $Cap->add_curso($fk_categorias, $nombre, $institucion, $f_inicio, $capacidad, $cupo_ins, $duracion, $cant_enc, $ins_auto, $carga_hr, $lugar, $departamento, $estado, $f_hs_creacion, $usuario, $f_inicio_ins, $f_fin_ins, $f_fin, $b64, $form_mostrar, $form_url, $web_duracion, $web_obj, $web_dictado_x, $web_cursado, $web_destinat);
			
			if($add_curso){
				
				$id= $Cap->get_last_id(); // obtengo el id del curso recientemente agregado. para usarlo en la insercion de los horarios y los requisitos

				// Add Requisitos
				if ($t1_tit != ''){ $add_req= $Cap->add_requisitos_curso($id, $t1_tit);	}
				if ($t2_tit != ''){ $add_req= $Cap->add_requisitos_curso($id, $t2_tit);	}
				if ($t3_tit != ''){ $add_req= $Cap->add_requisitos_curso($id, $t3_tit);	}
				if ($t4_tit != ''){ $add_req= $Cap->add_requisitos_curso($id, $t4_tit);	}
				if ($t5_tit != ''){ $add_req= $Cap->add_requisitos_curso($id, $t5_tit);	}

				$_SESSION['var_retorno_']= 'curso_copia_ok';	$_SESSION['msj_retorno_']= 'La capacitacion se copio satisfactoriamente.';
			}else{
				$_SESSION['var_retorno_']= 'curso_copia_er';	$_SESSION['msj_retorno_']= 'No se pudo copiar la capacitacion. Intente nuevampente.';
			}
		break;

	case 'ok_ant': // INSERT NUEVO CURSO
		// calculo la fecha de finalizacion del curso en funcion a la duracion en dias y a la fecha de inicio del curso
		if($duracion == 1){
			$f_fin = $f_inicio;
		}else{
			$duracion_ = $duracion - 1;
			$f_fin     = date("Y-m-d",strtotime($f_inicio."+ ".$duracion_." days")); ;
		}

		$descripcion= ''; // no se usa 29/8
		$upd_curso= $Cap->upd_curso($id_curso, $fk_categorias, $nombre, $institucion, $descripcion, $f_inicio, $capacidad, $cupo_ins, $duracion, $cant_enc, $carga_hr, $lugar, $departamento, $f_inicio_ins, $f_fin_ins, $f_fin, $b64, $form_mostrar, $form_url, $web_duracion, $web_obj, $web_dictado_x, $web_cursado, $web_destinat);
		
        if($upd_curso){
            if ($t1_tit != '' and $idt1 != ''){ $mod_req = $Cap->upd_requisito($idt1, $t1_tit);}
            else{if ($t1_tit != '' and $idt1 == '' ){ $ins_requ= $Cap->add_requisitos_curso($id_curso, $t1_tit);} }

            if ($t2_tit != '' and $idt2 != ''){ $mod_req = $Cap->upd_requisito($idt2, $t2_tit);}
            else{if ($t2_tit != '' and $idt2 == '' ){ $ins_requ= $Cap->add_requisitos_curso($id_curso, $t2_tit);} }

            if ($t3_tit != '' and $idt3 != ''){ $mod_req = $Cap->upd_requisito($idt3, $t3_tit);}
            else{if ($t3_tit != '' and $idt3 == '' ){ $ins_requ= $Cap->add_requisitos_curso($id_curso, $t3_tit);} }

            if ($t4_tit != '' and $idt4 != ''){ $mod_req = $Cap->upd_requisito($idt4, $t4_tit);}
            else{if ($t4_tit != '' and $idt4 == '' ){ $ins_requ= $Cap->add_requisitos_curso($id_curso, $t4_tit);} }

            if ($t5_tit != '' and $idt5 != ''){ $mod_req = $Cap->upd_requisito($idt5, $t5_tit);}
            else{if ($t5_tit != '' and $idt5 == '' ){ $ins_requ= $Cap->add_requisitos_curso($id_curso, $t5_tit);} }

            // ELIMINO LOS REQUSITOS QUE VIENE TILDADOS
            if(count($check) > 0){
                for ($i=0; $i<count($check); $i++){
                    if ($check[$i] != '' ) {
                        $id_req = $check[$i];
                        $elim_requisto= $Cap->del_requisito_($id_req);
                    } 
                }
            }
            $_SESSION['var_retorno_']= 'curso_upd_ok';		$_SESSION['msj_retorno_']= 'El Curso se Actualizó Satisfactoriamente';           
        }else{
            $_SESSION['var_retorno_']= 'curso_upd_er';		$_SESSION['msj_retorno_']= 'Hubo un error en la Actualización';            
		}
	break;	
}
// retorno
?><script type="text/javascript"> window.location="../_admin_capacitaciones.php"; </script> 
