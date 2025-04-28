<?php

class Imagen {
	
/**
 * Convierte una imagen a formato PNG
 * 
 * @param string $imagen_origen Ruta al archivo de imagen original
 * @param string $imagen_destino Ruta donde guardar la imagen PNG (si es vacío, usa el mismo nombre con extensión .png)
 * @return bool Devuelve true si la conversión fue exitosa, false en caso contrario
 */
function convertirAPNG($imagen_origen, $imagen_destino = '') {
    if (!file_exists($imagen_origen)) {
        return false;
    }
    
    // Si no se especificó un destino, crear uno con el mismo nombre pero extensión .png
    if (empty($imagen_destino)) {
        $info = pathinfo($imagen_origen);
        $imagen_destino = $info['dirname'] . '/' . $info['filename'] . '.png';
    }
    
    // Obtener el tipo de imagen
    $info_imagen = getimagesize($imagen_origen);
    if ($info_imagen === false) {
        return false; // No es una imagen válida
    }
    
    // Crear una imagen basada en el tipo
    switch ($info_imagen[2]) {
        case IMAGETYPE_JPEG:
            $imagen = imagecreatefromjpeg($imagen_origen);
            break;
        case IMAGETYPE_GIF:
            $imagen = imagecreatefromgif($imagen_origen);
            break;
        case IMAGETYPE_PNG:
            // Ya es PNG, solo copiar el archivo
            if ($imagen_origen !== $imagen_destino) {
                return copy($imagen_origen, $imagen_destino);
            }
            return true;
        case IMAGETYPE_BMP:
            $imagen = imagecreatefrombmp($imagen_origen);
            break;
        case IMAGETYPE_WEBP:
            $imagen = imagecreatefromwebp($imagen_origen);
            break;
        default:
            return false; // Formato no soportado
    }
    
    // Verificar si la imagen se cargó correctamente
    if ($imagen === false) {
        return false;
    }
    
    // Preservar transparencia
    imagealphablending($imagen, true);
    imagesavealpha($imagen, true);
    
    // Guardar como PNG
    $resultado = imagepng($imagen, $imagen_destino, 9); // 9 es máxima compresión
    
    // Liberar memoria
    imagedestroy($imagen);
    
    return $resultado;
}

}
?>