<?php
session_start();

if(!isset($_SESSION['idUser']))
    header("Location: ../index.php");


if(isset($_GET['idPb'])){

    $idPublicacion = $_GET['idPb'];

    // Valido que exista esa publicacion

    $query = "SELECT * FROM publicacion WHERE idPublicacion = '$idPublicacion'";

    include "../conexion.php";

    if(mysqli_query($conn, $query)) {
        $result = mysqli_query($conn, $query);     
        if(mysqli_num_rows($result) > 0) {
            $fila = mysqli_fetch_array($result);
            $idUsuario = $fila['idUsuario'];

            if($_SESSION['idUser'] != $idUsuario) {

                header("Location: publicacion.php?idPb=".$idPublicacion);
            }
            else {
                $titulo = $fila['titulo'];
                $descripcion = $fila['descripcion'];
                $categoria = $fila['categoria'];
                $curriculum = $fila['curriculum'];

                mysqli_close($conn);
            }

        }
        else
            header("Location: publicacion.php?idPb=".$idPublicacion);
    }
    else
        header("Location: publicacion.php?idPb=".$idPublicacion);
}
else
    header("Location: index.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!--Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Piedra&display=swap" rel="stylesheet"> 
    <!--Css-->
    <link rel="stylesheet" href="../css/register-login.css?v=<?php echo time(); ?>" title="registercss">
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
<header>
        <div class="container-fluid">
            <div class="row menu" >
                <div class="logo col-12 col-lg-4">
                    <a class="marca "href="index.php">BlueStone</a>
                </div>

                <div class="navegacion col-12 col-lg-4">
                    <a href="index.php">Home</a>
                    <a href="index.php?do=borrarBusqueda">Publicaciones</a>
                    <a href="#">Contacto</a>
                </div>        
                
                <?php if(!isset($_SESSION['idUser'])):?>
                <div class="buttons col-12 col-lg-4">
                    <a href="login.php">Iniciar sesión</a>
                    <a href="registro.php">Registrarse</a>                    
                </div>

                <?php else: ?>
                <div class="menu-usuario col-12 col-lg-4">
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
        
    </div> <!-- ./container -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>