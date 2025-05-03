<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Argentina/San_Juan');

include ('./usuario.php');          $U  = new Usuario();
include ('./capacitaciones.php');   $Cap= new capacitaciones();
include ('./email.php');            $Email= new Email();

if (isset($_POST["estado"]))    { $estado    = $_POST["estado"];      } else { $estado= '';  }
if (isset($_POST["titulo"]))    { $titulo    = $_POST["titulo"];      } else { $titulo= '';  }
if (isset($_POST["user"]))      { $user      = $_POST["user"];        } else { $user= '';    }
if (isset($_POST["capacit"]))   { $capacit   = $_POST["capacit"];     } else { $capacit= ''; }
if (isset($_POST["msj_"]))      { $msj_      = $_POST["msj_"];        } else { $msj_ = '';   }
// if (isset($_POST["msj_pie"]))   { $msj_pie   = $_POST["msj_pie"];     } else { $msj_pie= ''; }

$id_usr    = $U->get_id($user);
$sum_total = 0;

// busco los email para enviar
$arr_email_lote= array();
$arr_email     = array();
$arr_email     = $Cap->gets_email_segun_estado($capacit, $estado);
$cant_enviar   = count($arr_email);
$cant_enviados = 0;
$res_          = 0;

// grabo lote
$id_lote = $Cap->add_lote_emailEnviados($capacit, $msj_, $estado, $id_usr, $cant_enviar);
$cortar  = 0;

if($id_lote > 0){
    for($i=0 ; $i<count($arr_email) && $cortar==0 ; $i++){

        for($j=0 ; $j<20; $j++){ // lote de 20 email
            if ($cant_enviados < $cant_enviar ){
                $arr_email_lote[$j]['email']= $arr_email[$cant_enviados]['email'];
                $arr_email_lote[$j]['dni']  = $arr_email[$cant_enviados]['dni'];
                $cant_enviados++;
            }      
        }
        $knt_lote_ = count($arr_email_lote);
        if($knt_lote_ >0){
            
            // envio el email
            $res        = $Email->enviar_correo($arr_email_lote, $titulo, $msj_);
            if($res == ''){    $sum_total += 0;  $res_ = 0;}  // 0:ok 
            else{              $sum_total += 1;  $res_ = 1;}  // 1:er            
                    
            // grabo cuerpo del lote con su respectivo estado del envio (cada @ enviado)
            $knt_lote_ = count($arr_email_lote);
            for($k=0 ; $k<$knt_lote_; $k++){
                $add = $Cap->add_cuerpo_emailEnviados($id_lote, $res_, $arr_email_lote[$k]['dni'], $arr_email_lote[$k]['email']);
            }
            
            unset($arr_email_lote);
        }else{
            $cortar=1 ;
        }        
    }

    if($sum_total==0){
        $_SESSION['var_retorno_']= 'envio_email_ok';	$_SESSION['msj_retorno_']= '';
    }else{
        $_SESSION['var_retorno_']= 'envio_email_er';	$_SESSION['msj_retorno_']= 'Ocurrieron errores en '.$sum_total.' lotes. Por favor revise.';
    }

}else{

    $_SESSION['var_retorno_']= 'envio_email_er';		$_SESSION['msj_retorno_']= 'Error al grabar el lote en DB, por favor intente de nuevo.';
}

// retorno
$_SESSION['pestaña_activa']= 5;
?>
<script type="text/javascript">
		var p = "<?php echo $capacit ?>";
 		window.location="../_admin_inscriptos.php?p=" + p + ""; 
   </script>