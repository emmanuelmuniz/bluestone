<?php

session_start();

if(!isset($_GET['idPb'])){
    header("Location: index.php");
} else{
    include "../conexion.php";

    $idPublicacion = $_GET['idPb'];

    $query = "SELECT * FROM publicacion WHERE idPublicacion = '$idPublicacion'";

    if (mysqli_query($conn, $query)) {
        $publicacion = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($publicacion) > 0){
            $fila = mysqli_fetch_array($publicacion);
            $titulo = $fila['titulo'];
            $descripcion = $fila['descripcion'];
            $categoria = $fila['categoria'];
            $idUsuario = $fila['idUsuario'];
            $cv = $fila['curriculum'];
        }
        else{
            header("Location: index.php");
        }
    } else {
    echo "Error updating record: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/publicaciones.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">

    <title></title>
</head>
<body>
<header>
        <div class="container-fluid">
            <div class="row menu" >
                <div class="logo col-12 col-md-4 enlaces">
                    <a class="marca "href="../index.php">BlueStone</a>
                </div>

                <div class="navegacion col-12 col-md-4 enlaces">
                    <a href="../index.php">Home</a>
                    <a href="index.php?do=borrarBusqueda">Publicaciones</a>
                    <a href="#">Contacto</a>
                </div>        
                
                <?php if(!isset($_SESSION['idUser'])):?>
                <div class="buttons col-12 col-md-4 enlaces">
                    <a href="../login.php">Iniciar sesión</a>
                    <a href="../registro.php">Registrarse</a>                    
                </div>

                <?php else: ?>
                <div class="menu-usuario col-12 col-md-4 enlaces">
                    <div class="nav-item dropdown nav-perfil">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['userName']?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="subida.php">Crear publicación</a>
                            <a class="dropdown-item" href="../logout.php">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <?php
                $query = "SELECT * FROM usuario WHERE idUsuario = $idUsuario";

                $result = mysqli_query($conn, $query);

                if (mysqli_query($conn, $query)) {
                    $publicacion = mysqli_query($conn, $query);
                    
                    if(mysqli_num_rows($publicacion) > 0){
                        $fila = mysqli_fetch_array($publicacion);
                        $nombre = $fila['nombre'];
                        $apellido = $fila['apellido'];
                    }
                    else{
                        header("Location: index.php");
                    }
                } else {
                echo "Error updating record: " . mysqli_error($conn);
                }
                ?>

                <a href="<?php echo $cv ?>" download="<?php echo $nombre . " " . $apellido?> - CV">Curriculum</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>