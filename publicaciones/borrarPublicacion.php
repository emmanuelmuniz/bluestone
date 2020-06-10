<?php
session_start();

if(isset($_SESSION['idUser']) && isset($_GET['id'])){
    
    $idPublicacion = $_GET['id'];

    // Valido que exista esa publicacion

    $query = "SELECT * FROM publicacion WHERE idPublicacion = '$idPublicacion'";

    include "../conexion.php";

    if(mysqli_query($conn, $query)) {
        $result = mysqli_query($conn, $query);     
        if(mysqli_num_rows($result) > 0) {
            $fila = mysqli_fetch_array($result);
            $idUsuario = $fila['idUsuario'];

            if(isset($_SESSION['idUser']) == $idUsuario) {
                $delete = "DELETE FROM publicacion WHERE idPublicacion = '$idPublicacion'";

                if (mysqli_query($conn, $delete)) {
                    $_SESSION['publicacionBorrada'] = "Publicacion borrada satisfactoriamente";
                } else {
                    $_SESSION['publicacionBorrada'] = "No se pudo borrar la publicación";

                    header("Location: publicacion.php?idPb=".$idPublicacion);
                }
            }

        }
    }
}

header("Location: index.php");

?>