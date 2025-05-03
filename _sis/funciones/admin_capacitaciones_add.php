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

//------------------ RECIBO LOS DATOS ----------------------------
$opcion     = 'ok';
$falta      = '';
$cantidades ='';
$fechas     ='';

if (isset($_POST["usuario"]))      { $usuario       = $_POST["usuario"];      } else { $usuario      = ''; }

if (isset($_POST["categoria"]))    { $fk_categorias = $_POST["categoria"];    } else { $fk_categoria = ''; }
if (isset($_POST["add_categoria"])){ $nva_categoria = $_POST["add_categoria"];} else { $nva_categoria= ''; }

if (isset($_POST["form_mostrar"]))   { $form_mostrar    = $_POST["form_mostrar"];   } else { $form_mostrar   = ''; }
if (isset($_POST["dir_form_google"])){ $dir_form_google = $_POST["dir_form_google"];} else { $dir_form_google= ''; }

if (isset($_POST["nombre"]))       { $nombre        = $_POST["nombre"];       } else { $nombre       = ''; }
if (isset($_POST["institucion"]))  { $institucion   = $_POST["institucion"];  } else { $institucion  = ''; }
// if (isset($_POST["descripcion"]))  { $descripcion   = $_POST["descripcion"];  } else { $descripcion  = ''; }

if (isset($_POST["f_inicio"]))     { $f_inicio      = $_POST["f_inicio"];     } else { $f_inicio     = ''; }
if (isset($_POST["f_inicio_ins"])) { $f_inicio_ins  = $_POST["f_inicio_ins"]; } else { $f_inicio_ins = ''; }
if (isset($_POST["f_fin_ins"]))    { $f_fin_ins     = $_POST["f_fin_ins"];    } else { $f_fin_ins    = ''; }

if (isset($_POST["capacidad"]))    { $capacidad     = $_POST["capacidad"];    } else { $capacidad    = ''; }
if (isset($_POST["cupo_ins"]))     { $cupo_ins      = $_POST["cupo_ins"];     } else { $cupo_ins     = ''; }
if (isset($_POST["duracion"]))     { $duracion      = $_POST["duracion"];     } else { $duracion     = ''; }
if (isset($_POST["ins_auto"]))     { $ins_auto      = $_POST["ins_auto"];     } else { $ins_auto     = ''; }
if (isset($_POST["cant_enc"]))     { $cant_enc      = $_POST["cant_enc"];     } else { $cant_enc     = ''; }
if (isset($_POST["carga_hr"]))     { $carga_hr      = $_POST["carga_hr"];     } else { $carga_hr     = ''; }

if (isset($_POST["lugar"]))        { $lugar        = $_POST["lugar"];         } else { $lugar        = ''; }
if (isset($_POST["departamento"])) { $departamento = $_POST["departamento"];  } else { $departamento = ''; }

// recibo la imagen para mostrar en la web -----------------------------------------------
$url = $_FILES['url']['name'];
if ($url == ''){
	$b64 = '';
}else{
	$nom_archivo= new SplFileInfo($url); // guardo el nombre del archivo original para luego obtener la extension del archivo
	$extension  = $nom_archivo->getExtension(); //guardo la extension del archivo
	$nom_imagen = 'imagen_del_curso_nvo.'.$extension; // nuevo nombre de la imagen

	$directorio = "../web_cursos/".$nom_imagen; // guardo el nombre de la carpeta adonde la voy a subir
	move_uploaded_file($_FILES['url']['tmp_name'], $directorio);
	$dir        = $directorio;

	$bin        = file_get_contents($dir); // Load file contents into variable
	$b64        = base64_encode($bin);     // Encode contents to Base64
	unlink($directorio);	
}

// recibo descripcion y duracion para mostrar en la web -----------------------------------------------
if (isset($_POST["web_duracion"])) 	{ $web_duracion = $_POST["web_duracion"];  		} else { $web_duracion = ''; 	}
if (isset($_POST["web_obj"]))  		{ $web_obj  = $_POST["web_obj"];   				} else { $web_obj  = ''; 		}
if (isset($_POST["web_dictado_x"])) { $web_dictado_x  = $_POST["web_dictado_x"];   	} else { $web_dictado_x  = ''; 	}
if (isset($_POST["web_cursado"]))  	{ $web_cursado  = $_POST["web_cursado"];   		} else { $web_cursado  = ''; 	}
if (isset($_POST["web_destinat"]))  { $web_destinat  = $_POST["web_destinat"];   	} else { $web_destinat  = ''; 	}

// recibos los requisitos -----------------------------------------------
if (isset($_POST["tema_1_titulo"])) { $t1_tit = $_POST["tema_1_titulo"]; } else { $t1_tit = '';	} 
if (isset($_POST["tema_2_titulo"])) { $t2_tit = $_POST["tema_2_titulo"]; } else { $t2_tit = '';	}
if (isset($_POST["tema_3_titulo"])) { $t3_tit = $_POST["tema_3_titulo"]; } else { $t3_tit = '';	}
if (isset($_POST["tema_4_titulo"])) { $t4_tit = $_POST["tema_4_titulo"]; } else { $t4_tit = '';	}
if (isset($_POST["tema_5_titulo"])) { $t5_tit = $_POST["tema_5_titulo"]; } else { $t5_tit = '';	} 


//---------------------------- VERIFICO QUE VENGAN TODOS LOS DATOS OK-----------------------------------------

$nueva_cat_= 0; // si existe una nueva categoria para insertar cambia a 1
$f_fin     = '0000-00-00';

// analisis de obtencion de la categoria existente o de una nueva
if($fk_categorias == '' or $fk_categorias == '0' ){
	$falta.= 'Falta Categoria, ';
}else{
	if($fk_categorias == 'a'){      // significa que debreia venir una nueva categoria
		if($nva_categoria == ''){
			$falta.= 'Falta Categoria, ';
		}else{
			$nueva_cat_=1;
		}
	}
}

// datos de cual formulario utilizar
if($form_mostrar == 'form_web'){$form_url= '';}
else{
	if($form_mostrar == 'form_google' and $dir_form_google == '' ){ $falta.='Falta dir. google'; }
	else {$form_url= $dir_form_google;}
}
// fin de datos de cual formulario utilizar

if($nombre == '')		$falta.= 'Falta Nombre al Curso, ';
// if($descripcion == '')	$falta.= 'Descripción, ';
if($institucion == '')	$falta.= 'Falta Institución, ';

if($f_inicio == '')   	$falta.= 'Fecha inicial, ';
if($f_inicio_ins == '') $falta.= 'Falta inicio inscripción, ';
if($f_fin_ins == '') 	$falta.= 'Falta fin inscripción,';

if($capacidad == '')   	$falta.= 'Falta Capacidad, ';
if($cupo_ins == '')   	$falta.= 'Falta Cupo, ';
if($duracion == '')   	$falta.= 'Falta Duración en horas, ';
if($ins_auto == '')  	$falta.= 'Falta Inscripción Automática, ';
if($cant_enc == '')   	$falta.= 'Falta Cantidad de encuentros, ';
if($carga_hr == '')   	$falta.= 'Falta Carga horaria, ';

if($lugar == '') 		$falta.= 'Falta Lugar,';
if($departamento == '') $falta.= 'Falta Departamento, ';

if($capacidad <= 0) {$cantidades.= 'Capacidad no puede ser 0 o menor, ';}
if($cupo_ins <= 0)  {$cantidades.= 'Cupo no puede ser 0 o menor, ';}
if($duracion <= 0 ) {$cantidades.= 'Duracion no puede ser 0 o menor, ';}
if($cant_enc <= 0 ) {$cantidades.= 'Cantidad de Encuentros no puede ser 0 o menor, ';}
if($carga_hr <= 0)  {$cantidades.= 'Carga horaria no puede ser 0 o menor. ';}

// verifico que las fechas sean reales y que no tengan el formato 0000-00-00
$anio_actual     = date("Y");
$anio_inicio     = date("Y", strtotime($f_inicio));
$anio_inicio_ins = date("Y", strtotime($f_inicio_ins));
$anio_fin_ins    = date("Y", strtotime($f_fin_ins));
if($f_inicio     == '0000-00-00' OR !validar_fecha($f_inicio)     OR $anio_actual > $anio_inicio      ) {$fechas.= 'Fecha de Inicio no tiene formato valido, ';}
if($f_inicio_ins == '0000-00-00' OR !validar_fecha($f_inicio_ins) OR  $anio_actual > $anio_inicio_ins ) {$fechas.= 'Fecha Inicio Inscripcion no tiene formato valido, ';}
if($f_fin_ins    == '0000-00-00' OR !validar_fecha($f_fin_ins)    OR $anio_inicio_ins > $anio_fin_ins ) {$fechas.= 'Fecha Fin Inscripcion no tiene formato valido, ';}

if($f_inicio_ins > $f_fin_ins ) $fechas.= 'Inicio de Inscripcion no puede ser mayor al Fin de Inscripcion, '; // detectar que las fechas de inicio de inscripcion sean correctas
if($f_fin_ins >= $f_inicio)     $fechas.= 'Fin de Inscripcion no puede ser mayor al Inicio de la capacitacion, '; // detectar que no se superpongan las fechas.

/* Analizo los requisitos. Al menos que haya uno y los guardo en un arreglo */
$arr_req = array();
$fal_req = 0;
if ($t1_tit != ''){ $arr_req[] = $t1_tit;} else {$fal_req++ ;}
if ($t2_tit != ''){ $arr_req[] = $t2_tit;} else {$fal_req++ ;}
if ($t3_tit != ''){ $arr_req[] = $t3_tit;} else {$fal_req++ ;}
if ($t4_tit != ''){ $arr_req[] = $t4_tit;} else {$fal_req++ ;}
if ($t5_tit != ''){ $arr_req[] = $t5_tit;} else {$fal_req++ ;}  
	
//if ($fal_req == 0){ $opcion='faltan_req';}  Elimino la obligatoriedad de los requisitos.
if($falta != '')	  $opcion= 'faltan_datos'; 		// mensaje de faltante de datos
if($cantidades != '') $opcion= 'error_cantidades'; 	// mensaje de erro en cantidades
if($fechas != '')     $opcion= 'error_fechas'; 		// mensaje de error en fechas.
if($falta != '' AND $cantidades != '' AND $cantidades != '') {$opcion = 'revise_datos';}

switch($opcion){
	
	// case 'falta_imagen':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Por favor Debe Seleccionar una iamgen'; break;
	// case 'falta_dir_google':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Por favor Ingrese la direccion del formulario Google'; break;
	// case 'revise los datos':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Por favor revise los datos. Faltantes: '.$falta;			 break;
	case 'faltan_datos':
		$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Por favor revise los datos. Faltantes: '.$falta;			 break;
	case 'error_cantidades':
		$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Revise los siguientes datos: '.$cantidades;			 break;
	case 'error_fechas':
		$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Por favor revise las fechas: '.$fechas;			 break;
	case 'revise_datos':
		$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Revise los datos: '.$falta.' - '.$cantidades.' - '.$fechas; break;
	// case 'error_fechas_c':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'La Fecha Inicio del Curso debe ser MENOR a la Fecha final'; break;
	// case 'error_fechas_i':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'La Fecha Inicio de inscripción debe ser MENOR a la Fecha final'; break;	
	// case 'error_fechas_ci':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'La Fecha Inicio del curso debe ser MAYOR a la Fecha final de inscripción'; break;		
	// case 'faltan_req':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'falta al menos ingresar un requisito';			 break;
	// case 'faltan_datos_web':
	// 	$_SESSION['var_retorno_']= 'curso_add_er';	$_SESSION['msj_retorno_']= 'Faltan datos para mostrar en la página web';			 break;
	
	case 'ok': // INSERT NUEVO CURSO
		
		// calculo la fecha de finalizacion del curso en funcion a la duracion en dias y a la fecha de inicio del curso
		if($duracion == 1){
			$f_fin = $f_inicio;
		}else{
			$duracion_ = $duracion - 1;
			$f_fin     = date("Y-m-d",strtotime($f_inicio."+ ".$duracion_." days")); ;
		}

		//insetar nueva categoria
		if($nueva_cat_ == 1){
			$nva_categoria = strtoupper($nva_categoria);  // paso todo a mayusculas.
			$nva_cat = $Cap->add_categoria_nueva($nva_categoria); // inserto la nueva categoria
			if($nva_cat){
				$fk_categorias=$Cap->get_last_id_categoria(); // traigo el id de la categoria anterniormente agregada.
			}
		}
		
		$f_hs_creacion = date("Y-m-d H:i:s");
		$estado =1;
		
		$insert_curso= $Cap->add_curso($fk_categorias, $nombre, $institucion, $f_inicio, $capacidad, $cupo_ins, $duracion, $cant_enc, $ins_auto, $carga_hr, $lugar, $departamento, $estado, $f_hs_creacion, $usuario, $f_inicio_ins, $f_fin_ins, $f_fin, $b64, $form_mostrar, $form_url, $web_duracion, $web_obj, $web_dictado_x, $web_cursado, $web_destinat);
		// mensajes de confirmacion o no de la insercion
		if($insert_curso){
			// pregunto si existe algun requisito para cargar
			if (count($arr_req) > 0){
				$id= $Cap->get_last_id(); // obtengo el id del curso recientemente agregado. para usarolo en la insercion de los horarios y los requisitos
				for ($i=0; $i<count($arr_req); $i++){
			 		$requisito = $arr_req[$i];
			 		$insert_requisitos= $Cap->add_requisitos_curso($id, $requisito);
				}
			}
			$_SESSION['var_retorno_']= 'curso_add_ok';		$_SESSION['msj_retorno_']= 'El curso se Agrego Satisfactoriamente';
		}else{
		 	$_SESSION['var_retorno_']= 'curso_add_er_i';	$_SESSION['msj_retorno_']= 'No se pudo agregar el curso. intente mas tarde';
		}
	break;	
}
// retorno
?><script type="text/javascript"> window.location="../_admin_capacitaciones.php"; </script>