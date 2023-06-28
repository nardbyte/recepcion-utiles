<?php
require 'config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo DESCRIPTION; ?>">
    <title><?php echo SITENAME; ?> - <?php echo DESCRIPTION; ?></title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png" sizes="32x32">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.21.4/dist/bootstrap-table.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="progress" style="height: 10px; border-radius: 0; background-color: #302878;">
        <div class="progress-bar" style="background: linear-gradient(#990000, 20%, #ff8181, 85%, #990000);" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container main mb-4">
        <nav class="navbar navbar-expand-lg navbar-light navega mb-4">
            <div class="container">
                <a class="navbar-brand mx-auto" href="<?php echo URL; ?>">
                    <img src="assets/images/logo.svg" alt="<?php echo SITENAME; ?>" width="210px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>">Recepción</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>registro_grados.php">Listado de Grados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>registro_utiles.php">Lista de útiles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL; ?>estudiantes.php">Estudiantes</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>