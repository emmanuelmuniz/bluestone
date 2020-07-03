<?php

session_start();
header("Content-Type:application/json");
header('Content-Type: text/html; charset=UTF-8');

if(isset($_SESSION['idUser'])){
    if($_SESSION['rol'] == 'admin'){
        include "../conexion.php";
        $con=mysqli_connect("127.0.0.1","root","");//conexión

        mysqli_set_charset($con, 'utf8'); //linea a colocar
        $query = "SELECT * FROM usuario ORDER BY nombre DESC";

        if(mysqli_query($conn, $query)){
            $usuarios = mysqli_query($conn, $query);
            
            while($usuario = mysqli_fetch_assoc($usuarios)){
                $arregloUsuauarios["data"][] = $usuario;
            }
            echo json_encode($arregloUsuauarios);
            mysqli_close($conn);
        }
    }
    else{
        header("Location: ../publicaciones/");
    }
}
else {
    header("Location: ../publicaciones/");
}
?>