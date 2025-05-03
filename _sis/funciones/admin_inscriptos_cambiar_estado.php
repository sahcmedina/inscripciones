<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Argentina/San_Juan');

include ('./usuario.php');        $U  = new Usuario();
include ('./capacitaciones.php'); $Cap= new capacitaciones();

$seleccion = $_POST['seleccion_n'];
$titulares = $_POST['titulares_n'];
$suplentes = $_POST['suplentes_n'];
$baja      = $_POST['baja_n'];
$id_curso  = $_POST['id_curso'];
$usr_      = $_POST['usuario'];
$usr       = $U->get_id($usr_);

if (isset($_POST["dni"]))          { $arr_datos= $_POST["dni"];            } else {  $arr_datos= '';  }

for($m=0 ; $m<count($arr_datos) and is_array($arr_datos) ; $m++){
    // formateo datos
    $arr[$m]["dni"] = $arr_datos[$m];
    $estado         = $arr_datos[$m];
    $correo         = $arr_datos[$m];
    if (isset($_POST['tipo'.$estado]))   $arr[$m]["estado"]=$_POST['tipo'.$estado];   else $arr[$m]["estado"]='0';
    if (isset($_POST['correo'.$correo])) $arr[$m]["correo"]=$_POST['correo'.$correo]; else $arr[$m]["correo"]='0';
}
// el arreglo de todos los datos es arr
if ($seleccion == 'seleccion_n'){
    for($i=0; $i<count($arr); $i++){
        if($arr[$i]['estado'] > 0){
            $dni= $arr[$i]['dni'];
            switch ($arr[$i]['estado']){
                case '1': $estado = 't'; break;
                case '2': $estado = 's'; break;
                case '3': $estado = 'b'; break;
            }
            $f_resuelto= date("Y-m-d H:i:s");
            $act       = $Cap->upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr);
            if($estado == 't'){ 
                // debo cambiar el estado a las otra pre inscripciones vigentes para esa persona (todas a "b")
                $upd = $Cap->upd_estado_restoPreInscripc($dni, $id_curso);
            }  
        }
    }
}else{
    if ($titulares == 'titulares_n'){
        for($i=0; $i<count($arr); $i++){
            $dni       = $arr[$i]['dni'];
            $estado    = 't';
            $f_resuelto= date("Y-m-d H:i:s");
            $act       = $Cap->upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr);
            if($estado == 't'){ 
                // debo cambiar el estado a las otra pre inscripciones vigentes para esa persona (todas a "b")
                $upd = $Cap->upd_estado_restoPreInscripc($dni, $id_curso);
            } 
        }
    }else{
        if ($suplentes == 'suplentes_n'){
            for($i=0; $i<count($arr); $i++){
                $dni       = $arr[$i]['dni'];
                $estado    = 's';
                $f_resuelto= date("Y-m-d H:i:s");
                $act       = $Cap->upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr);
            }
        }else{
            for($i=0; $i<count($arr); $i++){
                $dni       = $arr[$i]['dni'];
                $estado    = 'b';
                $f_resuelto= date("Y-m-d H:i:s");
                $act       = $Cap->upd_estado_inscripto_capacitacion($dni, $id_curso, $estado, $f_resuelto, $usr);
            }
        }
    }
}
if ($act){
    $_SESSION['var_retorno_']= 'upd_estado_curso_ok';		$_SESSION['msj_retorno_']= 'Se actualizaron los estados Satisfactoriamente';
}else{
    $_SESSION['var_retorno_']= 'upd_estado_curso_er';		$_SESSION['msj_retorno_']= 'No se pudieron actualizar los datos';
}

// retorno
?>
<script type="text/javascript">
    var p = "<?php echo $id_curso ?>";
    window.location="../_admin_inscriptos.php?p=" + p + ""; 
</script>