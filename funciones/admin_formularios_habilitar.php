<?php 
session_start();
date_default_timezone_set('America/Argentina/San_Juan');
include('formularios.php');	$Form = new Formularios();

// id usuario estado_act  f_cambio radio_hab fecha
if (isset($_POST["id"]))         { $id         = $_POST["id"];         } else { $id         = ''; }
if (isset($_POST["usuario"]))    { $usuario    = $_POST["usuario"];    } else { $usuario    = ''; }
if (isset($_POST["estado_act"])) { $estado_act = $_POST["estado_act"]; } else { $estado_act = ''; }
if (isset($_POST["estado_fut"])) { $estado_fut = $_POST["estado_fut"]; } else { $estado_fut   = ''; }
if (isset($_POST["radio_hab"]))  { $radio_hab  = $_POST["radio_hab"];  } else { $radio_hab  = ''; }
if (isset($_POST["radio_cam"]))  { $radio_cam  = $_POST["radio_cam"];  } else { $radio_cam  = ''; }
if (isset($_POST["fecha"]))      { $fecha      = $_POST["fecha"];      } else { $fecha      = ''; }

$op=1;
if($radio_hab == 'no'){
    if($radio_cam == '' OR $fecha == '' ){
        $op=0;
    }
}

switch ($op){
    case 0:
        $_SESSION['var_retorno_']= 'form_upd_er'; $_SESSION['msj_retorno_']= 'Faltaron datos. Intente de nuevo.';
    break;
    case 1:
        $fecha_actual = date("Y-m-d");
        $f_ultima_mdf = date("Y-m-d H:i:s");
        switch ($estado_act){
            case 0: $estado_nuevo = 1; break;
            case 1: $estado_nuevo = 0; break;
        }

        if($radio_hab == 'si'){ // cambio inmediato
            $estado_act = $estado_nuevo;
            $estado_fut = $estado_nuevo;
            $f_cambio   = $fecha_actual;
            $proceso_realizado = 1; // significa que el proceso de cambio de estado ya se realizó
        }else{
            $f_cambio = $fecha;
            if($radio_cam == 'si'){ // cambio tardio de estado necesito fecha y el estado futuro
                $estado_fut = $estado_nuevo;
                $proceso_realizado = 0; // significa que el proceso de cambio de estado se va a realizar el dia $f_cambio
            } //sino se mantiene los estado actuales y el futuro y solamente cambia la fecha
        }

        $mdf = $Form->upd_estado($id, $estado_act, $estado_fut, $f_cambio, $f_ultima_mdf, $proceso_realizado, $usuario);

        if($mdf){
            $_SESSION['var_retorno_']= 'form_upd_ok'; $_SESSION['msj_retorno_']= 'Se actualizó el Estado del Formulario';  
        }else{
            $_SESSION['var_retorno_']= 'form_upd_er'; $_SESSION['msj_retorno_']= 'No se pudo grabar la actualización. Intente de nuevo.';
        }
    break;
}

?><script type="text/javascript"> window.location="../_admin_formularios_habilitacion.php"; </script>

