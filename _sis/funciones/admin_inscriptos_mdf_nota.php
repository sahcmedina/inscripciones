<?php 
session_start();
error_reporting(E_ALL ^ E_NOTICE);
date_default_timezone_set('America/Argentina/San_Juan');

if (isset($_POST["dni"]))      { $dni  = $_POST["dni"];      } else { $dni = '';  }
if (isset($_POST["nota_new"])) { $nota = $_POST["nota_new"]; } else { $nota= '';  }
if (isset($_POST["curso"]))    { $curso = $_POST["curso"];   } else { $curso= ''; }

include ('inscriptos.php');	    $Ins= new Inscriptos();

                                            $opc = '1';
if($dni=='' OR $nota=='' OR $curso=='')     $opc = '0';

switch($opc){

    case '1':
            $upd = $Ins->upd_nota($dni, $curso, $nota);  
            if($upd){     $_SESSION['var_retorno_']= 'nota_upd_ok';        $_SESSION['msj_retorno_']= '';                                                            } 
            else {        $_SESSION['var_retorno_']= 'nota_upd_er';        $_SESSION['msj_retorno_']= 'Ocurrio un error al actualizar nota, intente de nuevo.';      }  
            break;

    case '0':
            $_SESSION['var_retorno_']= 'nota_upd_er';        
            $_SESSION['msj_retorno_']= 'Faltaron datos, intente de nuevo.';      
            break;
}

// retorno
?>
<script type="text/javascript">
    var p = "<?php echo $curso ?>";
    window.location="../_admin_inscriptos.php?p=" + p + ""; 
</script>