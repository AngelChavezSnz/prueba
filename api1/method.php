<?php
require "config/Conexion.php";
$datos = json_decode(file_get_contents('php://input'), true);
//print_r($_SERVER['REQUEST_METHOD']);
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        // Consulta SQL para seleccionar datos de la tabla
        $sql = "SELECT id_mae, nombre, apodo, tel, foto, creado_en FROM maestrps";

        $query = $conexion->query($sql);

        if ($query->num_rows > 0) {
            $data = array();
            while ($row = $query->fetch_assoc()) {
                $data[] = $row;
            }
            // Devolver los resultados en formato JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            echo "No se encontraron registros en la tabla de maestros.";
        }

        $conexion->close();
        break;

    case 'POST':
            // Recibir los datos del formulario HTML
            $id_mae = $datos['id_mae'];
            $nombre = $datos['nombre'];
            $apodo = $datos['apodo'];
            $tel = $datos['tel'];
            $foto = $datos['foto'];

            // Insertar los datos en la tabla
            $sql = $conexion->prepare("INSERT INTO maestrps (id_mae, nombre, apodo, tel, foto) VALUES (?,?,?)");
            $sql->bind_param("sss", $id_mae, $nombre, $apodo, $tel, $foto);
            if($sql->execute()){
                echo "Datos insertados con exito";
            } else {
                echo "Error al insertar datos" . $sql->error;
            }
        $sql->close();
        break;

        case 'PATCH':
        $id_mae = $datos['id_mae'];
        $nombre = $datos['nombre'];
        $apodo = $datos['apodo'];
        $tel = $datos['tel'];
        $foto = $datos['foto'];
        
        $actualizaciones = array();
        if (!empty($nombre)) {
            $actualizaciones[] = "nombre = '$nombre'";
        }
        if (!empty($apodo)) {
            $actualizaciones[] = "apodo = '$apodo'";
        }
        if (!empty($tel)) {
            $actualizaciones[] = "tel = '$tel = '$tel'";
        }
        if (!empty($foto)) {
            $actualizaciones[] = "foto = '$foto = '$foto'";
        }
    
        $actualizaciones_str = implode(', ', $actualizaciones);
        $sql = "UPDATE maestrps SET $actualizaciones_str WHERE id_mae = $id_mae";
    
        if ($conexion->query($sql) === TRUE) {
            echo "Registro actualizado con éxito.";
        } else {
            echo "Error al actualizar registro: " . $conexion->error;
        }
        break;
    

        case 'PUT':
            $id_mae = $datos['id_mae'];
            $nombre = $datos['nombre'];
            $apodo = $datos['apodo'];
            $tel = $datos['tel'];
            $foto = $datos['foto'];
            $sql = "UPDATE maestrps SET nombre = '$nombre', apodo = '$apodo', tel = '$tel', foto = '$foto' WHERE id_mae = $id_mae";
    
            if ($conexion->query($sql) === TRUE) {
                echo "Registro actualizado con éxito.";
            } else {
                echo "Error al actualizar registro: " . $conexion->error;
            }
            break;
    

            case 'DELETE':
                $id_mae = $datos['id_mae'];
                
                $stmt = $conexion->prepare("DELETE FROM maestrps WHERE id_mae = ?");
                $stmt->bind_param("i", $id_mae);
                
                if ($stmt->execute()) {
                    echo "Registro eliminado con éxito.";
                } else {
                    echo "Error al eliminar registro: " . $stmt->error;
                }
                $stmt->close();
                break;
                    
            default:
                echo "Método de solicitud no válido.";
                break;
        }

?>