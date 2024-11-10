<?php
require '../../config/config.php';
require '../../config/database.php';
require '../../config/session.php';


$sessionActual = Session::getInstance();
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM producto WHERE estado=1");
$sql->execute(); 
$producto = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $con->prepare("SELECT * FROM talla");
$sql->execute(); 
$tallas = $sql->fetchAll(PDO::FETCH_ASSOC);

$sql = $con->prepare("SELECT * FROM Color");
$sql->execute(); 
$colores = $sql->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda final</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../../css/estilos.css" rel="stylesheet">
    <link href="../../css/estilosProductoCarga.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-personalizado">
            <div class="container">
                <a class="navbar-brand" href="../../HomeAdmin.php">
                    <img src="../../img/logo.jpg" class="logo" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="../../form/Talla/formTalla.php" class="nav-link">Dias Accesibles</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Color/gestionColor.php" class="nav-link">Disponibilidad</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Categoria/gestionCategoria.php" class="nav-link">Categoria</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Producto/gestionProducto.php" class="nav-link">Producto</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Producto/gestionPublicado.php" class="nav-link">Publicar</a>
                        </li>
                    </ul>

                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link dropdown-toggle text-center text-light" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $sessionActual->getUsuario()['correo'] ?>
                        </a>
                        <ul class="dropdown-menu text-center bg-success">
                            <img src="../../img/Perfil.png" alt="">
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "Tipo: ". $sessionActual->getUsuario()['rol'] ?></a></li>
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "Cedula: ". $sessionActual->getUsuario()['cedula'] ?></a></li>
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "nombre: ". $sessionActual->getUsuario()['nombre'] ?></a></li>
                            <li><a class="dropdown-item text-center" href="../../config/cerrarSesion.php"><img
                                        src="../../img/candado.png" alt="">Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <form id="crearPublicadoForm" onsubmit="event.preventDefault(); agregarPublicado();">
                <div class="card m-5" style="width: 30rem;">
                    <div class="card-header">
                        Publicar Producto
                    </div>
                    <div class="p-3">
                        <div class="mb-3">
                            <label for="producto">Producto:</label>
                            <select class="form-control" id="producto" name="producto">
                                <option value="0" selected disabled hidden>Seleccionar</option>
                                <?php foreach($producto as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['id']."-".$row['nombre']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="talla">Dias Accesibles</label>
                                <select class="form-control" id="talla" name="talla">
                                    <option value="0" selected disabled hidden>Seleccionar</option>
                                    <?php foreach($tallas as $row) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="color">Disponibilidad</label>
                                <select class="form-control" id="color" name="color">
                                    <option value="0" selected disabled hidden>Seleccionar</option>
                                    <?php foreach($colores as $row) { 
                                        $rgb = "rgb: (" . $row['R'] . "," . $row['G'] . "," . $row['B'] . ")"; 
                                    ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo "Color: (" . $row['R'] . ", " . $row['G'] . ", " . $row['B'] . ")"; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="R" class="form-label">Unidad</label>
                            <input type="number" class="form-control" id="unidad" name="unidad" value="1" required
                                placeholder="cantidad de talla">
                        </div>
                        <button type="submit" class="btn btn-outline-info btn-lg">Publicar</button>
                    </div>
                </div>
            </form>


        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../../js/controladorPublicado.js"></script>
</body>

</html>