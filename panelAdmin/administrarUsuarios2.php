<?php
session_start();

if(!isset($_SESSION['idUser'])){
    header("Location: ../publicaciones/");
} else if(!$_SESSION['rol'] == 'admin'){
    header("Location: ../publicaciones/");
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!--Css-->
    <link rel="stylesheet" href="../css/publicaciones.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/main.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/publicacion.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../css/misPublicaciones.css?v=<?php echo time(); ?>">
    
    <title>Usuarios Registrados</title>
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
                                <a class="dropdown-item" href="misPublicaciones.php">Mis Publicaciones</a>
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
                <div class="tituloMisPublicaciones">
                    <h2>Usuarios registrados</h2>
                </div>
                <div class="misPublicaciones">
                    <?php 
                        include "../conexion.php";

                        $idUser = $_SESSION['idUser'];

                        $query = "SELECT * FROM usuario ORDER BY nombre ASC";

                        if(mysqli_query($conn, $query)){
                            $result = mysqli_query($conn, $query);
                                              
                            if(mysqli_num_rows($result) > 0){ ?>
                                <table class="table table-bordered table-responsive-lg">
                                    <thead>
                                        <tr>
                                            <th class="none">Nombre</th>
                                            <th class="none">Apellido</th>
                                            <th>Correo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            <?php 
                            $i = 0;
                            while($usuario = mysqli_fetch_assoc($result)): ?>                                                         
                                        <tr class="publicacion">
                                            <td class="none"><?php echo $usuario['nombre']; ?></td>
                                            <td class="none"><?php echo $usuario['apellido']; ?></td>
                                            <td><?php echo $usuario['email']?></td>
                                            <td class="acciones">
                                                <div class="iconos">
                                                    <a data-toggle="tooltip" title="Editar publicación" href="editarPublicacion.php?Pb=<?php echo $publicacion['idPublicacion']?>">
                                                        <i class="pencil"><img src="../img/iconos/pencil.png" alt=""></i>
                                                    </a>
                                                    <a data-toggle="tooltip" class="none" title="Ver publicación" href="publicacion.php?Pb=<?php echo $publicacion['idPublicacion']?>">
                                                        <i class=""><img src="../img/iconos/visibility.png" alt=""></i>
                                                    </a>
                                                    <a data-toggle="tooltip" title="Eliminar publicación" class="borrarPublicacion" href="borrarPublicacion.php?Pb=<?php echo $publicacion['idPublicacion']?>">
                                                        <i class="trash"><img src="../img/iconos/remove.png" alt=""></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                            <?php endwhile; ?>
                                    </table>
                                </tbody>
                        <?php }
                            else {
                                echo "<h3 class='sinPublicacion'>No tenes ninguna publicación creada</h3>";
                            }
                        ?>   
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/borrarPublicacion.js?v=<?php echo time(); ?>"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>