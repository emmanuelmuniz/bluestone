<?php

session_start();

if(!isset($_GET['Pb'])){
    header("Location: index.php");
} else{
    include "../conexion.php";

    $idPublicacion = $_GET['Pb'];
    $_SESSION['idPublicacion'] = $_GET['Pb'];

    setcookie('UltimoVisitado', $idPublicacion, time()+(3600*24*7));

    $query = "SELECT * FROM publicacion WHERE idPublicacion = '$idPublicacion'";

    if (mysqli_query($conn, $query)) {
        $publicacion = mysqli_query($conn, $query);
        
        if(mysqli_num_rows($publicacion) > 0){
            $fila = mysqli_fetch_array($publicacion);
            $titulo = $fila['titulo'];
            $descripcion = $fila['descripcion'];
            $categoria = $fila['categoria'];
            $idUsuario = $fila['idUsuario'];
            $fecha = $fila['fechaPublicacion'];
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
    <link rel="stylesheet" href="../css/publicacion.css?v=<?php echo time(); ?>">

    <title>Publicación Candidato - BlueStone</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="marca "href="../index.php">BlueStone</a>

                <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto linksMedio">
                        <li class="nav-item linkMedio">
                            <a class="nav-link" href="../index.php">Home</a>
                        </li>
                        <li class="nav-item linkMedio">
                            <a class="nav-link" href="index.php">Publicaciones</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto acciones">
                        <?php if(!isset($_SESSION['idUser'])):?>
                            <li class="nav-item">
                                <a class="nav-link accion" href="../login.php">Iniciar sesión</a>   
                            </li>     
                            <li class="nav-item">
                                <a class="nav-link accion" href="../registro.php">Registrarse</a>   
                            </li>              
                        <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-user dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['userName']?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="subida.php">Crear publicación</a>
                                <a class="dropdown-item" href="misPublicaciones.php">Mis publicaciones</a>
                                <?php
                                    if($_SESSION['rol'] == "admin"){
                                        echo "<a class='dropdown-item' href='../panelAdmin/index.php'>Ver usuarios</a>";
                                    }
                                ?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../logout.php">Cerrar sesión</a>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(isset($_SESSION['publicacionBorrada'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error:</strong> <?php echo $_SESSION['publicacionBorrada']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php 
                unset($_SESSION['publicacionBorrada']);
                endif; 
                ?>

                <?php if(isset($_SESSION['publicacionCreada'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Perfecto!</strong> <?php echo $_SESSION['publicacionCreada']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php 
                unset($_SESSION['publicacionCreada']);
                endif; 
                ?>

                <?php if(isset($_SESSION['publicacionGuardada'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['publicacionGuardada']; ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php 
                unset($_SESSION['publicacionGuardada']);
                endif; 
                ?>

                <div class="publicacion">
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
                <div class="textos">
                    <div class="titulo">
                        <h1><?php echo $titulo; ?></h1>
                    </div>

                    
                    <?php 
                    if(isset($_SESSION['idUser'])):
                    if($_SESSION['idUser'] == $idUsuario  || $_SESSION['rol'] == 'admin'): ?>
                    <div class="btn-group actions">
                        <button type="button" class="btn btn-success btn-acciones">Acciones</button>
                        <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu">
                            <?php if($_SESSION['idUser'] == $idUsuario ): ?>
                            <a class="dropdown-item" href="editarPublicacion.php?Pb=<?php echo $idPublicacion ?>">Editar Publicación</a>
                            <?php endif; ?>
                            <a class="dropdown-item borrarPublicacion" href="borrarPublicacion.php?Pb=<?php echo $idPublicacion ?>">Borrar Publicación</a>
                        </div>
                    </div>
                    <?php endif; 
                    endif;  
                    ?>
                    <div class="descripcion">
                        <h4>Descripción</h4>
                        <p><?php echo $descripcion; ?></p>
                        <p id="candidato">Candidato: <?php echo $nombre." ".$apellido;?></p>
                        <p class="categoria">Categoría: <?php echo $categoria ?></p>
                        <br>
                        <p id="fecha">Fecha de publicacion: <?php echo $fecha?></p>
                        <a class="btn btn-primary" href="<?php echo $cv ?>" download="<?php echo $nombre . " " . $apellido?> - CV">Descargar curriculum</a><br>
                    </div>
                </div>
                <!-- <a href="cv.php?nombre=<?php echo $cv ?>">Ver curriculum</a> -->
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="js/borrarPublicacion.js?v=<?php echo time(); ?>"></script>

</body>
</html>