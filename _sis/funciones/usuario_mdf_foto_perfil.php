<?php 

session_start();
include('comunes_imagen.php');	$Imagen = new Imagen();

if (isset($_FILES['url_']) && $_FILES['url_']['error'] == 0) {
    
	$archivo_temporal = $_FILES['url_']['tmp_name'];
    $img_perfil       = $_SESSION['img_perfil'];
    $ruta_png         = "../foto_perfil/{$img_perfil}.png";
    
    // Eliminar imagen anterior si existe
    $img_actual_ = "../foto_perfil/{$img_perfil}.png";
    if (file_exists($img_actual_)) {
        unlink($img_actual_);
    }
    
    // Convertir y guardar como PNG
    if ($Imagen->convertirAPNG($archivo_temporal, $ruta_png)) {
        $a_tit = "Foto actualizada";        		$a_sub = "";        $a_ico = "success";
    } else {
        $a_tit = "Error al convertir la imagen";   	$a_sub = "";        $a_ico = "error";
    }
} else {
    $a_tit = "No se seleccionó ninguna imagen";     $a_sub = "";	    $a_ico = "error";
}

$_SESSION['alert_tit']= $a_tit;	$_SESSION['alert_sub']= $a_sub;	$_SESSION['alert_ico']= $a_ico;
?><script type="text/javascript"> window.location="../principal.php";  </script> 