<?php

session_start();

if(isset($_SESSION['idUser']) && isset($_GET['id'])){

    if($_SESSION['rol'] == 'admin') {

        $idUsuarioEnSesion = $_SESSION['idUser'];
        $idUsuarioEliminar = $_GET['id'];

        $query = "DELETE FROM usuario WHERE idUsuario = '$idUsuarioEliminar'";
        
        include '../conexion.php';

        if (mysqli_query($conn, $query)) {
            $_SESSION['usuarioBorrado'] = true;
            mysqli_close($conn);

            if($idUsuarioEnSesion == $idUsuarioEliminar){
                header("Location: ../logout.php");
            }
            else {
                header("Location: index.php");
            }

        } else {
            $_SESSION['usuarioBorrado'] = false ;
            mysqli_close($conn);
            header("Location: index.php");
        }
    }
}

?>