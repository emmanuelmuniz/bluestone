<?php 
session_start();

if(isset($_SESSION['message']) || isset($_SESSION['messageSignup']))
    unset($_SESSION['message'], $_SESSION['messageSignup']);


include 'conexion.php';

$query = "SELECT * FROM publicacion";
$publicaciones = mysqli_query($conn, $query);

$cantPublicaciones = mysqli_num_rows($publicaciones);
$publicacionesPorPagina = 1;

$paginas = $cantPublicaciones/1;
$paginas = ceil($paginas);

$paginaActual = $_GET['page'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css?v=<?php echo time(); ?>">

    <title>BlueStone</title>
</head>
<body>
    <!-- Menú -->
    <header>
        <div class="container-fluid">
            <div class="row menu" >
                <div class="logo col-12 col-md-4">
                    <a class="marca "href="index.php">BlueStone</a>
                </div>

                <div class="navegacion col-12 col-md-4">
                    <a href="index.php">Home</a>
                    <a href="#">Acerca de</a>
                    <a href="#">Contacto</a>
                </div>        
                
                <?php if(!isset($_SESSION['idUser'])):?>
                <div class="buttons col-12 col-md-4">
                    <a href="login.php">Iniciar sesión</a>
                    <a href="registro.php">Registrarse</a>                    
                </div>

                <?php else: ?>
                <div class="menu-usuario col-12 col-md-4">
                    <div class="nav-item dropdown nav-perfil">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['userName']?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="">Perfil</a>
                            <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Publicaciones -->
    <section class="publicaciones">
        <h1>Publicaciones</h1>
        
        <?php       
            if(!$_GET){
                header("Location: panel.php?page=0");
            }

            if (mysqli_num_rows($publicaciones) > 0){

                $desde = $paginaActual*$publicacionesPorPagina;
                $desde = (string)$desde;

                $publicacionesPorPagina = (string)$publicacionesPorPagina;

                $publiPaginaActual = "SELECT idPublicacion, titulo, SUBSTRING(descripcion, 1, 50) AS descripcion, categoria FROM publicacion LIMIT $desde, $publicacionesPorPagina";

                $result = mysqli_query($conn, $publiPaginaActual);

                while($publicacion = mysqli_fetch_assoc($result)): ?>
                    <a href="publicacion.php">
                        <div style="cursor: pointer;" onclick="publicacion.php">
                            <?php echo $publicacion['titulo']. "<br>"; ?>
                            <?php echo $publicacion['descripcion']. "...<br>"; ?>
                            <?php echo $publicacion['categoria']. "<br>"; ?>
                        </div>
                    </a>
                    <hr>
                <?php endwhile; ?>

                <nav aria-label='Page navigation example'>
                    <ul class="pagination">
                        <li class="page-item <?php echo $paginaActual==0 ? ' disabled' : '' ?>"><a class="page-link" href="panel.php?page= <?php echo ($paginaActual-1)?>">Anterior</a></li>

                        <?php for($i=0; $i<$paginas; $i++): ?>
                        <li class="page-item 
                        <?php echo $i == $paginaActual ? ' active' : ''?>">
                            <a class="page-link" href="panel.php?page=<?php echo $i ?>"><?php echo ($i+1)?></a>
                        </li>
                        <?php endfor; ?>
                
                        <li class="page-item <?php echo $paginaActual==$paginas-1 ? ' disabled' : '' ?>"><a class="page-link" href="panel.php?page= <?php echo ($paginaActual+1)?>">Siguiente</a></li>
                    </ul>
                </nav>
            <?php } ?>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>