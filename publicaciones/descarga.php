<?php
if(!isset($_GET['id'])){
    header("Location: index.php");
} else{
    include "../conexion.php";

    $idPublicacion = $_GET['id'];

    $query = "SELECT * FROM publicacion WHERE idPublicacion = '$idPublicacion'";

    if (mysqli_query($conn, $query)) {
        $publicacion = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($publicacion) > 0){
            while($row = mysqli_fetch_assoc($publicacion)){
                $filepath = 'publicaciones/' . basename($row['curriculum']);

                if (file_exists($filepath)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename=' . $filepath);
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate');
                    header('Pragma: public');
                    header('Content-Length: ' . $filepath);
                    readfile($filepath);
        
                }

                $rutaCV = $row['curriculum'];
                $nombreArchivo = basename($rutaCV); // Con la ruta extraemos el nombre del archivo

                echo $nombreArchivo;
            }
        }
        else{
            header("Location: index.php");
        }
    } else {
    echo "Error updating record: " . mysqli_error($conn);
    }
}

?>