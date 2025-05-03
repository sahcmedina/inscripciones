<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Argentina/San_Juan');

//-----------------------------   NOTA IMPORTANTE    --------------------------------
//  no verifico el checkbox de los terminos y condiciones.
//  no verifico la edad porque si los usuarios estan cargando se supone que ya conocen los requisitos y la edad de la persona
// Tampoco verifico se ha leido los termino y condiciones

include ('usuario.php');        $U  = new Usuario();
include ('capacitaciones.php'); $Cap= new capacitaciones();
include ('inscriptos.php');	    $Ins= new Inscriptos();

$usr      = $_POST['usuario'];

// determino cual es el boton que hizo clic
if (isset($_POST["btnInscI"]))  { $btninscI = $_POST["btnInscI"];  } else { $btninscI = ''; } // input que me indica que hay que insertar registros
if (isset($_POST["btnInscA"]))  { $btninscA = $_POST["btnInscA"];  } else { $btninscA = ''; } // input que me indica que hay que actualizar registros
if (isset($_POST["idCapacit"])) { $id_curso = $_POST["idCapacit"]; } else { $id_curso = ''; }

if (isset($_POST["tipo_ins"])) { $tipo_ins = $_POST["tipo_ins"]; } else { $tipo_ins = ''; } // no visto - titular - suplente

// RECIBO LOS DATOS PERSONALES
if (isset($_POST["dni"]))      { $dni              = $_POST["dni"];      } else { $dni              = ''; }
if (isset($_POST["apellido"])) { $apellido         = $_POST["apellido"]; } else { $apellido         = ''; }
if (isset($_POST["nombre"]))   { $nombre           = $_POST["nombre"];   } else { $nombre           = ''; }
if (isset($_POST["sexo"]))     { $sexo             = $_POST["sexo"];     } else { $sexo             = ''; }
if (isset($_POST["dpto"]))     { $fk_departamentos = $_POST["dpto"];     } else { $fk_departamentos = ''; }
if (isset($_POST["nro"]))      { $dir_nro          = $_POST["nro"];      } else { $dir_nro          = ''; }
if (isset($_POST["calle"]))    { $dir_calle        = $_POST["calle"];    } else { $dir_calle        = ''; }
if (isset($_POST["email"]))    { $correo           = $_POST["email"];    } else { $correo           = ''; }
if (isset($_POST["tel"]))      { $telefono         = $_POST["tel"];      } else { $telefono         = ''; }
if (isset($_POST["f_nac"]))    { $f_nacimiento     = $_POST["f_nac"];    } else { $f_nacimiento     = ''; }

// recibo los datos Educativos
if (isset($_POST["nivel_alcanzado"])) { $nivel_alcanzado = $_POST["nivel_alcanzado"]; } else { $nivel_alcanzado     = ''; }
if (isset($_POST["titulo"]))          { $titulo          = $_POST["titulo"];          } else { $titulo     = ''; }

// recibo los datos Laborales
if (isset($_POST["ocupacion"]))      { $ocupacion      = $_POST["ocupacion"];      } else { $ocupacion      = ''; }
if (isset($_POST["trabajo_actual"])) { $trabajo_actual = $_POST["trabajo_actual"]; } else { $trabajo_actual = ''; }
if (isset($_POST["hs_trabajo"]))     { $hs_trabajo     = $_POST["hs_trabajo"];     } else { $hs_trabajo     = ''; }

// capacitaciones previas
if (isset($_POST["posee_conocim_rubro"])) { $posee_conocim_rubro = $_POST["posee_conocim_rubro"]; } else { $posee_conocim_rubro = ''; }
if (isset($_POST["capacit_ant"]))         { $capacit_ant         = $_POST["capacit_ant"];         } else { $capacit_ant         = ''; }
if (isset($_POST["capacit_ant_cual"]))    { $capacit_ant_cual    = $_POST["capacit_ant_cual"];    } else { $capacit_ant_cual    = ''; }

// datos educacion
if (isset($_POST["nivel_alcanzado"]))   { $nivel= $_POST["nivel_alcanzado"];  		} else { $nivel= '';     	} // 1 a 8
if (isset($_POST["titulo"]))    		{ $titulo= $_POST["titulo"];         		} else { $titulo= '';     	}

// datos laborales
if (isset($_POST["ocupacion"]))    		{ $ocupacion= $_POST["ocupacion"];         	} else { $ocupacion= '';    }
if (isset($_POST["trabajo_actual"]))    { $trab_actual= $_POST["trabajo_actual"];   } else { $trab_actual= '';  } // desem indep depen 
if (isset($_POST["hs_trabajo"]))        { $hs_trabajo= $_POST["hs_trabajo"];      	} else { $hs_trabajo= '';   } 

// VALIDO LOS DATOS
$falta='';
if($dni == '')		        $falta.= 'Falta numero de dni, ';
if($apellido == '')	        $falta.= 'Falta Apellido, ';
if($nombre == '')	        $falta.= 'Falta Nombre, ';
if($sexo == '')	            $falta.= 'Falta seleccionar género, ';
if($fk_departamentos == '')	$falta.= 'Falta seleccionar un Departamento, ';
if($dir_nro == '')	        $falta.= 'Falta numero de la direccion, ';
if($dir_calle == '')        $falta.= 'Falta nombre de la calle, ';
if($correo == '')	        $falta.= 'Falta correo electrónico, ';
if($telefono == '')	        $falta.= 'Falta nro de Teléfono, ';
if($f_nacimiento == '')	    $falta.= 'Falta fecha de Nacimiento, ';
if($tipo_ins == '')	        $falta.= 'Falta seleccionar el tipo de Inscripcion, ';

$url         = $_FILES['url_certif_neg']['name'];
if($url == '') {
    $falta.= 'Falta la Certificacion Negativa, ';
}else{
    // Requisito: Constancia Negativa (opcion 1)
    $nom_archivo = new SplFileInfo($url); 				// guardo el nombre del archivo original para luego obtener la extension del archivo
    $extension   = $nom_archivo->getExtension(); 		// guardo la extension del archivo
    $nom_imagen  = 'certif_neg_.'.$dni.'.'.$extension; 	// nuevo nombre de la imagen
    $directorio  = "../up/".$nom_imagen; 				// guardo el nombre de la carpeta adonde la voy a subir
    move_uploaded_file($_FILES['url_certif_neg']['tmp_name'], $directorio);
    $dir         = $directorio;
};

if($nivel_alcanzado >= 5 and $titulo == '') $falta.= 'Falta titulo, '; 

if($ocupacion == '')	 $falta.= 'Falta ingresar ocupación, ';
if($trabajo_actual != 'desem' && $hs_trabajo == '') $falta.= 'Falta ingresar en que horas trabaja, ';

if($posee_conocim_rubro == '' ) $falta.= 'Falta ingresar si tiene conocimiento, ';
if($capacit_ant == '1' && $capacit_ant_cual == '') $falta.= 'Falta ingresar nombre capacitación, ';

$opcion= 'ok';
if($falta != '') $opcion= 'faltan_datos'; // mensaje de faltante de datos
//$op =0;
switch($opcion){
    case 'faltan_datos':
        $_SESSION['var_retorno_']= 'insc_er';	$_SESSION['msj_retorno_']= 'Por favor revise los datos. Faltan: '.$falta;			 break;
    break;
    case 'ok': // Actualizo datos. Esto es cuando una persona ya estuvo inscripta en algun curso
        if ($btninscA == 'actualizar'){
            // tabla Inscriptos
            $act_pers= $Ins->upd_datsPersonales_x_sistema($dni, $apellido, $nombre, $telefono, $sexo, $f_nacimiento, $fk_departamentos, $dir_calle, $dir_nro, $correo);
            // tabla Inscriptos Educacion
            $act_educ= $Ins->upd_datsEducacion_x_sistema($dni, $nivel_alcanzado, $titulo, $ocupacion, $trabajo_actual, $hs_trabajo, $posee_conocim_rubro, $capacit_ant, $capacit_ant_cual); 
            // tabla inscriptos_requisitos
            $bin = file_get_contents($dir); // Load file contents into variable
            $archivo_b64= base64_encode($bin);     // Encode contents to Base64
            unlink($directorio);
            $esta = $Ins->tf_inscripto_requisito($dni, $id_curso);
            if($esta){$add_req_CN = $Ins->upd_req_a_inscrip($dni, $id_curso, 'Certificacion Negativa', $archivo_b64, $extension);}else{
                $add_req_CN = $Ins->add_req_a_inscrip($dni, $id_curso, 'Certificacion Negativa', $archivo_b64, $extension);   }
            // Tabla Inscriptos Capacitacion
            $f_resuelto = date("Y-m-d H:i:s");
            $estado_capacitacion = 1;
            $ins_cap = $Ins->add_inscriptoACapacit_x_sistema($dni, $id_curso, $tipo_ins, $f_resuelto, $usr, $estado_capacitacion);
            
            $_SESSION['var_retorno_']= 'insc_ok';	$_SESSION['msj_retorno_']= 'La inscripcion se realizó satisfactoriamente';	break;
        }else{
            if ($btninscI == 'insertar'){  // Inserto un nuevo regsitro. Es la primera vez que se inscribe
                // tabla Inscriptos
                $insc_pers= $Ins->add_datsPersonales_x_sistema($dni, $apellido, $nombre, $telefono, $sexo, $f_nacimiento, $fk_departamentos, $dir_calle, $dir_nro, $correo);
                // tabla Inscriptos Educacion
                $insc_educ= $Ins->add_datsEducacion_x_sistema($dni, $nivel_alcanzado, $titulo, $ocupacion, $trabajo_actual, $hs_trabajo, $posee_conocim_rubro, $capacit_ant, $capacit_ant_cual);
                // tabla inscriptos_requisitos
                $bin        = file_get_contents($dir); // Load file contents into variable
                $archivo_b64= base64_encode($bin);     // Encode contents to Base64
                unlink($directorio);
                $esta = $Ins->tf_inscripto_requisito($dni, $id_curso);
                if($esta){$add_req_CN = $Ins->upd_req_a_inscrip($dni, $id_curso, 'Certificacion Negativa', $archivo_b64, $extension);}else{
                    $add_req_CN = $Ins->add_req_a_inscrip($dni, $id_curso, 'Certificacion Negativa', $archivo_b64, $extension);               
                }
                // Tabla Inscriptos Capacitacion
                $f_resuelto = date("Y-m-d H:i:s");
                $estado_capacitacion = 1;
                $ins_cap = $Ins->add_inscriptoACapacit_x_sistema($dni, $id_curso, $tipo_ins, $f_resuelto, $usr, $estado_capacitacion);
            
                $_SESSION['var_retorno_']= 'insc_ok';	$_SESSION['msj_retorno_']= 'La inscripcion se realizó satisfactoriamente';	break;
            }
        }
    break;
}

    // case '1': $_SESSION['var_retorno_']= 'insc_er';	$_SESSION['msj_retorno_']= 'No se pudieron actualizar los Datos Personales'; break;
    // case '2': $_SESSION['var_retorno_']= 'insc_er';	$_SESSION['msj_retorno_']= 'No se pudieron actualizar los Datos Educativos'; break;
    // case '3': $_SESSION['var_retorno_']= 'insc_er';	$_SESSION['msj_retorno_']= 'No se pudo dar de alta los Datos Personales'; break;
    // case '4': $_SESSION['var_retorno_']= 'insc_er';	$_SESSION['msj_retorno_']= 'No se pudo dar de alta los Datos Educativos'; break;
    // case '5': $_SESSION['var_retorno_']= 'insc_er';	$_SESSION['msj_retorno_']= 'No se pudo Guardar la Certificacion Negativa'; break;

// retorno 
?>
<script type="text/javascript">
    var p = "<?php echo $id_curso ?>";
    window.location="../_admin_inscriptos.php?p=" + p + ""; 
</script>
