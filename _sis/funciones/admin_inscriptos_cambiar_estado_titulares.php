<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Argentina/San_Juan');

include ('./usuario.php');        $U  = new Usuario();
include ('./capacitaciones.php'); $Cap= new Capacitaciones();
include ('./inscriptos.php');     $Ins= new Inscriptos();

if (isset($_POST["dni"]))             { $arr_datos= $_POST["dni"];          } else {  $arr_datos= '';   }
if (isset($_POST["seleccion_t"]))     { $seleccion= $_POST["seleccion_t"];  } else {  $seleccion= '';   }
if (isset($_POST["suplente_t"]))      { $suplentes= $_POST["suplente_t"];   } else {  $suplentes= '';   }
if (isset($_POST["baja_t"]))          { $baja= $_POST["baja_t"];            } else {  $baja= '';        }
if (isset($_POST["id_curso"]))        { $id_curso= $_POST["id_curso"];      } else {  $id_curso= '';    }
if (isset($_POST["usuario"]))         { $usr_= $_POST["usuario"];           } else {  $usr_= '';        }

$usr          = $U->get_id($usr_);
$suma_error_ln= 0;

for($m=0 ; $m<count($arr_datos) and is_array($arr_datos) ; $m++){
    // formateo datos
    $arr[$m]["dni"] = $arr_datos[$m];
    $estado         = $arr_datos[$m];
    $correo         = $arr_datos[$m];

    if (isset($_POST['tipo'.$estado]))   $arr[$m]["estado"]=$_POST['tipo'.$estado];   else $arr[$m]["estado"]='0';
    if (isset($_POST['correo'.$correo])) $arr[$m]["correo"]=$_POST['correo'.$correo]; else $arr[$m]["correo"]='0';
}

// Btn: Según la selección
if ($seleccion == 'seleccion_t'){
    for($i=0; $i<count($arr); $i++){
        if($arr[$i]['estado'] > 0){
            $dni= $arr[$i]['dni'];
            switch ($arr[$i]['estado']){
                case '2': $estado = 's' ; break;
                case '3': $estado = 'b' ; break;
                case '4': $estado = 'ln'; break;
            }
            $f_resuelto= date("Y-m-d H:i:s");
            $act       = $Cap->upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr);
            if($estado == 'ln') {
                $f_hoy = date("Y-m-d H:i:s");
                $f_fin = date("Y-m-d H:i:s", strtotime($f_hoy . "+ 1 year"));
                $add_ln= $Ins->add_listaNegra($dni, $id_curso, $f_hoy, $f_fin, $usr);
                if(!$add_ln)    $suma_error_ln++;
            }  
        }
    }
}else{
    // Btn: Todos a Baja
    if ($baja == 'baja_t'){
        for($i=0; $i<count($arr); $i++){
            $dni       = $arr[$i]['dni'];
            $estado    = 'b';
            $f_resuelto= date("Y-m-d H:i:s");
            $act       = $Cap->upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr);
            // ---------- enviar el mail si $act es true. -----------------------------------------
        }
    }else{
        // Btn: Todos a Suplente
        for($i=0; $i<count($arr); $i++){
            $dni       = $arr[$i]['dni'];
            $estado    = 's';
            $f_resuelto= date("Y-m-d H:i:s");
            $act       = $Cap->upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr);
            // ---------- enviar el mail si $act es true. -----------------------------------------
        }
    }
}

// Mensajes a mostrar
$errores= '';
if($suma_error_ln >0)   $errores= ' Hubieron: '.$suma_error_ln.' errores al pasar a Lista Negra.';

if ($act){    
    $_SESSION['var_retorno_']= 'upd_estado_curso_ok';		$_SESSION['msj_retorno_']= 'Se actualizaron los estados Satisfactoriamente.'.$errores;
}else{
    $_SESSION['var_retorno_']= 'upd_estado_curso_er';		$_SESSION['msj_retorno_']= 'No se pudieron actualizar los datos.'.$errores;
}

// Retorno
?>
<script type="text/javascript">
    var p = "<?php echo $id_curso ?>";
    window.location="../_admin_inscriptos.php?p=" + p + ""; 
</script>