<?php session_start(); 

if(isset($_SESSION['idUser']))
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
    <link rel="stylesheet" href="css/validation.css?v=<?php echo time(); ?>" title="registercss">
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">
    <title>Document</title>
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="marca "href="index.php">BlueStone</a>

                <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto linksMedio">
                        <li class="nav-item linkMedio">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item linkMedio">
                            <a class="nav-link" href="publicaciones">Publicaciones</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto acciones">
                        <?php if(!isset($_SESSION['idUser'])):?>
                            <li class="nav-item">
                                <a class="nav-link accion" href="login.php">Iniciar sesión</a>   
                            </li>     
                            <li class="nav-item">
                                <a class="nav-link accion" href="registro.php">Registrarse</a>   
                            </li>              
                        <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-user dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo $_SESSION['userName']?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="publicaciones/subida.php">Crear publicación</a>
                                <a class="dropdown-item" href="publicaciones/misPublicaciones.php">Mis Publicaciones</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                            </div>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container">
        <div  class="contenido-horizontal mx-auto" role="contenido">
            <div class="titulo col-sm-12">
                <h2>Te Haz Registrado Correctamente</h2>
            </div>
        </div> 
    </div>
</body>
</html>