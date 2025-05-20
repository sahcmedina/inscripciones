<?php
include('conexion_pdo.php');

if (!$con) {
    // Si hay error, devolver un JSON con mensaje de error
    header('Content-Type: application/json');
    echo json_encode(["error" => "Error de conexión a la base de datos"]);
    exit();
}

// Añadimos un parámetro 'action' para determinar la acción a realizar
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'search';

// Acción para búsqueda
if ($action === 'search') {
    // Verificar si se recibió un parámetro de búsqueda
    if (isset($_GET['q'])) {
        // Sanitizar la entrada - usando prepare statements si es posible
        $busqueda= $_GET['q'];        
        $sql     = "SELECT id, nombre, descripcion, concat('../_sis/',url) as url FROM usuario_funcion 
                    WHERE nombre LIKE :busqueda OR descripcion LIKE :busqueda 
                        AND estado= 1
                    ORDER BY nombre";
        $stmt    = $con->prepare($sql);
        $param   = '%' . $busqueda . '%';
        $stmt->bindParam(':busqueda', $param);
        $stmt->execute();
        $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($result) > 0) {
            $datos = array();
            foreach ($result as $row) {
                $datos[] = "(función) ".$row['nombre'] . " - " . substr($row['descripcion'], 0, 70) . "... (ID: " . $row['id'] . ")";
            }
            
            // Devolver los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($datos);
        } else {
            // No hay resultados
            header('Content-Type: application/json');
            echo json_encode([]);
        }
    } else {
        // Sin parámetro de búsqueda, obtener todos los registros
        $sql    = "SELECT id, nombre, descripcion, concat('../_sis/',url) as url FROM usuario_funcion WHERE estado=1 ORDER BY nombre";
        $stmt   = $con->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($result) > 0) {
            $datos = array();
            foreach ($result as $row) {
                $datos[] = "(función) ".$row['nombre'] . " - " . substr($row['descripcion'], 0, 70) . "... (ID: " . $row['id'] . ")";
            }
            
            // Devolver los datos en formato JSON
            header('Content-Type: application/json');
            echo json_encode($datos);
        } else {
            // No hay resultados
            header('Content-Type: application/json');
            echo json_encode([]);
        }    
    }
}
// Acción para obtener detalles 
else if ($action === 'details') {
    // Verificar si se recibió el parámetro función
    if (isset($_POST['funcion'])) {
        $funcion = $_POST['funcion'];
        
        // Extraer el ID del texto de la selección
        preg_match('/\(ID: (\d+)\)$/', $funcion, $matches);
        
        if (isset($matches[1])) {
            $id   = $matches[1]; // El ID extraído                    
            $sql  = "SELECT id, nombre, descripcion, concat('../_sis/',url) as url FROM usuario_funcion WHERE id = :id";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $datos= $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($datos) {
                // Asegurarse de que la URL sea válida o tenga un valor predeterminado
                if (empty($datos['url'])) {
                    $datos['url'] = '#'; // o podrías usar una URL por defecto
                }
                
                // Devolver los datos en formato JSON
                header('Content-Type: application/json');
                echo json_encode($datos);
            } else {
                // No se encontró la función
                header('Content-Type: application/json');
                echo json_encode([
                    "error" => "No se encontró la función con ID: $id",
                    "url"   => "#"
                ]);
            }
        } else {
            // No se pudo extraer el ID
            header('Content-Type: application/json');
            echo json_encode([
                "error" => "Formato de selección inválido",
                "url"   => "#"
            ]);
        }
    } else {
        // No se recibió el parámetro función
        header('Content-Type: application/json');
        echo json_encode([
            "error" => "Parámetro 'funcion' no proporcionado",
            "url"   => "#"
        ]);
    }
} else {
    // Acción no reconocida
    header('Content-Type: application/json');
    echo json_encode([
        "error" => "Acción no reconocida",
        "url"   => "#"
    ]);
}